<?php

/**
 * 
 */
class Usermanagement_model extends CI_Model {

	
	public function get_global_users(){
		$query="SELECT
 users.userinfoid as userid, users.surname as surname, users.firstname as firstname,groups.name as orgname, roles.rolename as rolename
FROM userinfo users, usergroup groups,usergroupmembers members,attribution_roles roles
where users.userinfoid=members.userid and groups.usergroupid=members.usergroupid and roles.attributionroleid=CASE 
            WHEN users.attributionroleid is not null
               THEN users.attributionroleid
               ELSE groups.attributionroleid
       END  
 
 ";		
		$users=$this->db->query($query);
		if (sizeof($users->result())>0) {
			return $users->result();
		} else {
			return "";
		}
	}
	
	public function get_org_users($group_id){
		$query="SELECT
 users.userinfoid as userid, users.surname as surname, users.firstname as firstname,groups.name as orgname, roles.rolename as rolename
FROM userinfo users, usergroup groups,usergroupmembers members,attribution_roles roles
where groups.usergroupid=$group_id and groups.usergroupid=members.usergroupid and  users.userinfoid=members.userid and roles.attributionroleid=CASE 
            WHEN users.attributionroleid is not null
               THEN users.attributionroleid
               ELSE groups.attributionroleid
       END  
 
 ";	
 	$users=$this->db->query($query);
		if (sizeof($users->result())>0) {
			return $users->result();
		} else {
			return "";
		}		
	}
	
	public function get_group_level($name){
		$levels=$this->db->get_where('attribution_hierarchy',array('name'=>$name));
		if (sizeof($levels->result())==1) {
			return $levels->row()->level;
		} else {
			return "";
		}		
	}
	
	
	public function get_global_groups(){
        $this->db->select('*');
        $this->db->from('usergroup');
        $this->db->join('attribution_roles', 'attribution_roles.attributionroleid=usergroup.attributionroleid');
        $this->db->join('attribution_hierarchy', 'attribution_hierarchy.uid=usergroup.uid');
        $this->db->join('attribution_hierarchy_levels', 'attribution_hierarchy_levels.level_id=attribution_hierarchy.level');
        $groups = $this->db->get();
		if (sizeof($groups->result())>0) {
			return $groups->result();
		} else {
			return "";
		}		
	}
	
	public function get_devuid($group_id){
		return $this->db->get_where("usergroups",array("usergroupid"=>$group_id))->row()->uid;
	}
    public function get_all_roles(){
        $roles = $this->db->get('attribution_roles');
		if (sizeof($roles->result())>0) {
			return $roles->result();
		} else {
			return "";
		}        
    }	
    public function get_dhisroles($level){
        $roles = $this->db->get_where('userrole',array('hierarchy_level_id'=>$level));
		if (sizeof($roles->result())>0) {
			return $roles->result();
		} else {
			return "";
		}        
    }		
	public function update_group($groupId, $roleId){	
	        $this->db->where('usergroupid', $groupId);
	        $this->db->update('usergroup', array("attributionroleid"=>$roleId));
	}
	public function get_donoragency_groups(){
		$groups=$this->db->query('select groups.usergroupid as gid, groups.name as gname from usergroup groups, attribution_hierarchy hierarchy where hierarchy.uid=groups.uid  and (hierarchy.level=2 or hierarchy.level=3)');
		if (sizeof($groups->result())>0) {
			return $groups->result();
		} else {
			return "";
		}  		
	}
	public function get_im_groups(){
		$groups=$this->db->query('select groups.usergroupid as gid, groups.name as gname from usergroup groups, attribution_hierarchy hierarchy where hierarchy.uid=groups.uid  and hierarchy.level=4');
		if (sizeof($groups->result())>0) {
			return $groups->result();
		} else {
			return "";
		}  		
	}	
	public function get_jprp_roles(){
		$roles=$this->db->get('attribution_roles');
		if (sizeof($roles->result())>0) {
			return $roles->result();
		} else {
			return "";
		}  		
	}
	public function get_org_jprp_roles(){
		$roles=$this->db->get_where('attribution_roles',array("usergroupid"=>$this->session->userdata('groupid')));
		if (sizeof($roles->result())>0) {
			return $roles->result();
		} else {
			return "";
		}  		
	}	
	public function org_new_im_user(){
		$username=$this->input->post('username');
		$firstname=$this->input->post('firstname');
		$surname=$this->input->post('surname');
		$email=$this->input->post('email');
		$phone=$this->input->post('phonenumber');
		$dhis=$this->input->post('dhisrole');
		$jhes=$this->input->post('jphesrole');
		$orgunits=$this->input->post('orgunits');
		$password='$2a$10$pcz7WFfL6bSw7nrMadpHYu69gSN/sA6jwKUR7WYN4kTm4Z7LpdkWO';
		//Add User To User Info and User Tabel
        //Orgunit Kenya Level
        $national_level = 52;
        $orgunit = $this->db->get_where("organisationunit", array("name" => "Kenya"));
        if (sizeof($orgunit->result()) > 0) {
            $national_level = $orgunit->row()->organisationunitid;

        }		
		$length = 11;
        $random_str = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        $time = time();
        $user_uid = substr(hash('md5', $time . '' . $random_str), 0, $length);		
        $this->db->select_max('userinfoid');
        $userid = 1 + (integer)$this->db->get('userinfo')->row()->userinfoid;
        $userinfo = array(
            'userinfoid' => $userid,
            'uid' => $user_uid,
            'surname' => $surname,
            'firstname' => $firstname,
            'email' => $email,
            'phonenumber' => $phone,
            'created' => date('Y-m-d H:m:s'),
            'lastupdated' => date('Y-m-d H:m:s'),
            'attributionroleid'=>$jhes
        );
        //Create the user in userinfo then in users
        if ($this->db->insert("userinfo", $userinfo)) {

            $users = array(
                'userid' => $userid,
                'username' => $username,
                'password' => $password,
                'passwordlastupdated' => date('Y-m-d H:m:s'),
                'created' => date('Y-m-d H:m:s'),
                'invitation' => "False",
                'selfregistered' => "False",
                'disabled' => "False"
            );

            if ($this->db->insert('users', $users)) {
                //Usergroup assignment
                $usergroupmembers = array(
                    'userid' => $userid,
                    'usergroupid' => $this->session->userdata('groupid')
                );

                //Data entry orgunit
                $usermembership = array(
                    'userinfoid' => $userid,
                    'organisationunitid' => $national_level
                );

                //Data view Orgunit
                $userdatavieworgunits = array(
                    'userinfoid' => $userid,
                    'organisationunitid' => $national_level
                );

                //DHIS2 user role
                $userrolemembers = array(
                    'userid' => $userid,
                    'userroleid' => $dhis
                );

                //Dimension Analysis dataelementcategoryid
                $dataelementcategoryid = 0;
                $dimension = $this->db->get_where("dataelementcategory", array("name" => "Mechanisms"));
                if (sizeof($dimension->result()) > 0) {
                    $dataelementcategoryid = $dimension->row()->categoryid;

                }
                //Dimension Analysis-(mechanisms)
                $users_catdimensionconstraints = array(
                    'userid' => $userid,
                    'dataelementcategoryid' => $dataelementcategoryid
                );


                //Updating the assignments
                $this->db->insert('usergroupmembers', $usergroupmembers);
                $this->db->insert('usermembership', $usermembership);
                $this->db->insert('userdatavieworgunits', $userdatavieworgunits);
                $this->db->insert('userrolemembers', $userrolemembers);
                $this->db->insert('users_catdimensionconstraints', $users_catdimensionconstraints);
				$this->useripsl();
            }

        }
		
		return "User Has Been Successfully Created";
	}
	
	
	public function useripsl(){
		//echo "okboss";
		$deletequery="
DELETE FROM usermembership 
WHERE userinfoid in
(select groupmem.userid from usergroupmembers as groupmem,attribution_hierarchy as ath 
where groupmem.usergroupid=ath.usergroup_id and ath.level=4);		
		";
		$this->db->query($deletequery);
		$updatequery="INSERT INTO usermembership (organisationunitid,userinfoid)
select orgs.organisationunitid, groupmem.userid from usergroupmembers as groupmem, organisationunit as orgs,attribution_hierarchy as ath, ipsl as ipsl, userinfo as users
WHERE ath.code=ipsl.datimid  and orgs.code=ipsl.mflcode and groupmem.usergroupid=ath.usergroup_id and users.userinfoid=groupmem.userid";
	$this->db->query($updatequery);		
	$query="
SELECT umem.userinfoid as userinfoid ,umem.organisationunitid as organisationunitid
  FROM attribution_hierarchy as ath, usergroupmembers as gmem, usermembership as umem 
  where gmem.usergroupid=ath.usergroup_id and 
umem.userinfoid=gmem.userid and ath.level=4	
	";
	
	$umem=$this->db->query($query);
	foreach ($umem->result() as $row) {
		$parentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$row->organisationunitid));
		if ($parentid->row()->parentid!='') {
			if (sizeof($this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$parentid->row()->parentid)))<1) {
				$data=array(
					"userinfoid"=>$row->userinfoid,
					"organisationunitid"=>$parentid->row()->parentid
				);
				$this->db->insert("usermembership", $data); 
				echo "damm";
				//Grandparent
				$grandparentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$parentid->row()->parentid));
				if ($grandparentid->row()->parentid!='') {
					echo "shiet </br>";
					if (sizeof($this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$grandparentid->row()->parentid)))<1) {
						$data=array(
							"userinfoid"=>$row->userinfoid,
							"organisationunitid"=>$grandparentid->row()->parentid
						);
						//$this->db->insert("usermembership", $data); 						
					}
				}
			}						
		}

	}

	
	
	
	/*
	while ($i <= 3) {
		echo "cllla";
		$heirachyquery="
select mem.*,org.name, org.parentid from 
usermembership as mem, organisationunit as org
where org.organisationunitid=mem.organisationunitid and org.parentid not in (select mems.organisationunitid from usermembership as mems where mems.userinfoid=mem.userinfoid)				
		";
		$this->db->query($heirachyquery);
		$i=$i+1;
	}*/
	
	$querys="
SELECT umem.userinfoid as userinfoid ,umem.organisationunitid as organisationunitid
  FROM attribution_hierarchy as ath, usergroupmembers as gmem, usermembership as umem 
  where gmem.usergroupid=ath.usergroup_id and 
umem.userinfoid=gmem.userid and ath.level=4	
	";		
		$umem=$this->db->query($querys);
		foreach ($umem->result() as $row) {
			$parentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$row->organisationunitid));
			//echo "wat".$parentid->row()->parentid;
			if (is_numeric ($parentid->row()->parentid)) {
				$dbq=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$parentid->row()->parentid));
				if ($dbq->num_rows() == 0) {
					//echo "my nigga";		
					$data=array(
						"userinfoid"=>$row->userinfoid,
						"organisationunitid"=>$parentid->row()->parentid
					);
					$this->db->insert("usermembership", $data); 
					//Grandparent
					$grandparentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$parentid->row()->parentid));
					if (is_numeric ($grandparentid->row()->parentid)) {
						//echo "shiet </br>";
						$grand=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$grandparentid->row()->parentid));
						if ($grand->num_rows() == 0) {
							//echo "yes </br>";
							$data=array(
								"userinfoid"=>$row->userinfoid,
								"organisationunitid"=>$grandparentid->row()->parentid
							);
							$this->db->insert("usermembership", $data); 	
							
							//Grandparent
							$greatparentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$grandparentid->row()->parentid));
							if (is_numeric ($greatparentid->row()->parentid)) {
								//echo "shiet </br>";
								$great=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$greatparentid->row()->parentid));
								if ($great->num_rows() == 0) {
									//echo "iko boss </br>";
									$data=array(
										"userinfoid"=>$row->userinfoid,
										"organisationunitid"=>$greatparentid->row()->parentid
									);
									$this->db->insert("usermembership", $data); 							
								}
							}								
													
						}
					}					
				}					
			}
	
		}		
	}	
	
	
	public function org_new_donoragancy_user(){
		$username=$this->input->post('username');
		$firstname=$this->input->post('firstname');
		$surname=$this->input->post('surname');
		$email=$this->input->post('email');
		$phone=$this->input->post('phonenumber');
		$jhes=$this->input->post('jphesrole');
		$password='$2a$10$pcz7WFfL6bSw7nrMadpHYu69gSN/sA6jwKUR7WYN4kTm4Z7LpdkWO';
		//Add User To User Info and User Tabel
        //Orgunit Kenya Level
        $national_level = 52;
        $orgunit = $this->db->get_where("organisationunit", array("name" => "Kenya"));
        if (sizeof($orgunit->result()) > 0) {
            $national_level = $orgunit->row()->organisationunitid;

        }		
		$length = 11;
        $random_str = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        $time = time();
        $user_uid = substr(hash('md5', $time . '' . $random_str), 0, $length);		
        $this->db->select_max('userinfoid');
        $userid = 1 + (integer)$this->db->get('userinfo')->row()->userinfoid;
        $userinfo = array(
            'userinfoid' => $userid,
            'uid' => $user_uid,
            'surname' => $surname,
            'firstname' => $firstname,
            'email' => $email,
            'phonenumber' => $phone,
            'created' => date('Y-m-d H:m:s'),
            'lastupdated' => date('Y-m-d H:m:s'),
            'attributionroleid'=>$jhes
        );
        //Create the user in userinfo then in users
        if ($this->db->insert("userinfo", $userinfo)) {

            $users = array(
                'userid' => $userid,
                'username' => $username,
                'password' => $password,
                'passwordlastupdated' => date('Y-m-d H:m:s'),
                'created' => date('Y-m-d H:m:s'),
                'invitation' => "False",
                'selfregistered' => "False",
                'disabled' => "False"
            );

            if ($this->db->insert('users', $users)) {
                //Usergroup assignment
                $usergroupmembers = array(
                    'userid' => $userid,
                    'usergroupid' => $this->session->userdata('groupid')
                );

                //Data entry orgunit
                $usermembership = array(
                    'userinfoid' => $userid,
                    'organisationunitid' => $national_level
                );

                //Data view Orgunit
                $userdatavieworgunits = array(
                    'userinfoid' => $userid,
                    'organisationunitid' => $national_level
                );
                //DHIS2 Role ID
                $user_role_id = 0;
                $role = $this->db->get_where("userrole", array("name" => "Donor Admin"));
                if (sizeof($orgunit->result()) > 0) {
                    $user_role_id = $role->row()->userroleid;

                }
                //DHIS2 user role
                $userrolemembers = array(
                    'userid' => $userid,
                    'userroleid' => $user_role_id
                );

                //Dimension Analysis dataelementcategoryid
                $dataelementcategoryid = 0;
                $dimension = $this->db->get_where("dataelementcategory", array("name" => "Mechanisms"));
                if (sizeof($dimension->result()) > 0) {
                    $dataelementcategoryid = $dimension->row()->categoryid;

                }
                //Dimension Analysis-(mechanisms)
                $users_catdimensionconstraints = array(
                    'userid' => $userid,
                    'dataelementcategoryid' => $dataelementcategoryid
                );


                //Updating the assignments
                $this->db->insert('usergroupmembers', $usergroupmembers);
                $this->db->insert('usermembership', $usermembership);
                $this->db->insert('userdatavieworgunits', $userdatavieworgunits);
                $this->db->insert('userrolemembers', $userrolemembers);
                $this->db->insert('users_catdimensionconstraints', $users_catdimensionconstraints);
            }

        }
		return "User Has Been Successfully Created";
	}	

	public function global_new_donoragancy_user(){
		$username=$this->input->post('username');
		$firstname=$this->input->post('firstname');
		$surname=$this->input->post('surname');
		$email=$this->input->post('email');
		$phone=$this->input->post('phonenumber');
		$jhes=$this->input->post('jphesrole');
		$groupid=$this->input->post('associate');
		$password='$2a$10$pcz7WFfL6bSw7nrMadpHYu69gSN/sA6jwKUR7WYN4kTm4Z7LpdkWO';
		//Add User To User Info and User Tabel
        //Orgunit Kenya Level
        $national_level = 52;
        $orgunit = $this->db->get_where("organisationunit", array("name" => "Kenya"));
        if (sizeof($orgunit->result()) > 0) {
            $national_level = $orgunit->row()->organisationunitid;

        }		
		$length = 11;
        $random_str = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        $time = time();
        $user_uid = substr(hash('md5', $time . '' . $random_str), 0, $length);		
        $this->db->select_max('userinfoid');
        $userid = 1 + (integer)$this->db->get('userinfo')->row()->userinfoid;
        $userinfo = array(
            'userinfoid' => $userid,
            'uid' => $user_uid,
            'surname' => $surname,
            'firstname' => $firstname,
            'email' => $email,
            'phonenumber' => $phone,
            'created' => date('Y-m-d H:m:s'),
            'lastupdated' => date('Y-m-d H:m:s'),
            'attributionroleid'=>$jhes
        );
        //Create the user in userinfo then in users
        if ($this->db->insert("userinfo", $userinfo)) {

            $users = array(
                'userid' => $userid,
                'username' => $username,
                'password' => $password,
                'passwordlastupdated' => date('Y-m-d H:m:s'),
                'created' => date('Y-m-d H:m:s'),
                'invitation' => "False",
                'selfregistered' => "False",
                'disabled' => "False"
            );

            if ($this->db->insert('users', $users)) {
                //Usergroup assignment
                $usergroupmembers = array(
                    'userid' => $userid,
                    'usergroupid' => $groupid
                );

                //Data entry orgunit
                $usermembership = array(
                    'userinfoid' => $userid,
                    'organisationunitid' => $national_level
                );

                //Data view Orgunit
                $userdatavieworgunits = array(
                    'userinfoid' => $userid,
                    'organisationunitid' => $national_level
                );
                //DHIS2 Role ID
                $user_role_id = 0;
                $role = $this->db->get_where("userrole", array("name" => "Donor Admin"));
                if (sizeof($orgunit->result()) > 0) {
                    $user_role_id = $role->row()->userroleid;

                }
                //DHIS2 user role
                $userrolemembers = array(
                    'userid' => $userid,
                    'userroleid' => $user_role_id
                );

                //Dimension Analysis dataelementcategoryid
                $dataelementcategoryid = 0;
                $dimension = $this->db->get_where("dataelementcategory", array("name" => "Mechanisms"));
                if (sizeof($dimension->result()) > 0) {
                    $dataelementcategoryid = $dimension->row()->categoryid;

                }
                //Dimension Analysis-(mechanisms)
                $users_catdimensionconstraints = array(
                    'userid' => $userid,
                    'dataelementcategoryid' => $dataelementcategoryid
                );


                //Updating the assignments
                $this->db->insert('usergroupmembers', $usergroupmembers);
                $this->db->insert('usermembership', $usermembership);
                $this->db->insert('userdatavieworgunits', $userdatavieworgunits);
                $this->db->insert('userrolemembers', $userrolemembers);
                $this->db->insert('users_catdimensionconstraints', $users_catdimensionconstraints);
            }

        }
		return "User Has Been Successfully Created";		
	}

	public function global_new_im_user(){
		$username=$this->input->post('username');
		$firstname=$this->input->post('firstname');
		$surname=$this->input->post('surname');
		$email=$this->input->post('email');
		$phone=$this->input->post('phonenumber');
		$dhis=$this->input->post('dhisrole');
		$jhes=$this->input->post('jphesrole');
		$orgunits=$this->input->post('orgunits');
		$password='$2a$10$pcz7WFfL6bSw7nrMadpHYu69gSN/sA6jwKUR7WYN4kTm4Z7LpdkWO';
		$groupid=$this->input->post('associate');
		//Add User To User Info and User Tabel
        //Orgunit Kenya Level
        $national_level = 52;
        $orgunit = $this->db->get_where("organisationunit", array("name" => "Kenya"));
        if (sizeof($orgunit->result()) > 0) {
            $national_level = $orgunit->row()->organisationunitid;

        }		
		$length = 11;
        $random_str = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        $time = time();
        $user_uid = substr(hash('md5', $time . '' . $random_str), 0, $length);		
        $this->db->select_max('userinfoid');
        $userid = 1 + (integer)$this->db->get('userinfo')->row()->userinfoid;
        $userinfo = array(
            'userinfoid' => $userid,
            'uid' => $user_uid,
            'surname' => $surname,
            'firstname' => $firstname,
            'email' => $email,
            'phonenumber' => $phone,
            'created' => date('Y-m-d H:m:s'),
            'lastupdated' => date('Y-m-d H:m:s'),
            'attributionroleid'=>$jhes
        );
        //Create the user in userinfo then in users
        if ($this->db->insert("userinfo", $userinfo)) {

            $users = array(
                'userid' => $userid,
                'username' => $username,
                'password' => $password,
                'passwordlastupdated' => date('Y-m-d H:m:s'),
                'created' => date('Y-m-d H:m:s'),
                'invitation' => "False",
                'selfregistered' => "False",
                'disabled' => "False"
            );

            if ($this->db->insert('users', $users)) {
                //Usergroup assignment
                $usergroupmembers = array(
                    'userid' => $userid,
                    'usergroupid' => $groupid
                );

                //Data entry orgunit
                $usermembership = array(
                    'userinfoid' => $userid,
                    'organisationunitid' => $national_level
                );

                //Data view Orgunit
                $userdatavieworgunits = array(
                    'userinfoid' => $userid,
                    'organisationunitid' => $national_level
                );

                //DHIS2 user role
                $userrolemembers = array(
                    'userid' => $userid,
                    'userroleid' => $dhis
                );

                //Dimension Analysis dataelementcategoryid
                $dataelementcategoryid = 0;
                $dimension = $this->db->get_where("dataelementcategory", array("name" => "Mechanisms"));
                if (sizeof($dimension->result()) > 0) {
                    $dataelementcategoryid = $dimension->row()->categoryid;

                }
                //Dimension Analysis-(mechanisms)
                $users_catdimensionconstraints = array(
                    'userid' => $userid,
                    'dataelementcategoryid' => $dataelementcategoryid
                );


                //Updating the assignments
                $this->db->insert('usergroupmembers', $usergroupmembers);
                $this->db->insert('usermembership', $usermembership);
                $this->db->insert('userdatavieworgunits', $userdatavieworgunits);
                $this->db->insert('userrolemembers', $userrolemembers);
                $this->db->insert('users_catdimensionconstraints', $users_catdimensionconstraints);
            }

        }
		$this->useripsl();
		return "User Has Been Successfully Created";
	}
	
	
	public function get_user_level($userid){
		$query="SELECT attribution_hierarchy.level as level FROM usergroupmembers, attribution_hierarchy where usergroupmembers.userid=$userid and attribution_hierarchy.usergroup_id= usergroupmembers.usergroupid";
		$level=$this->db->query($query);
		if (sizeof($level->result())==1) {
			return $level->row()->level;
		}
		return "";	
	}
	
	public function get_user_info($userid){
		$query="SELECT users.username as username, info.userinfoid as userid, info.surname as surname, info.firstname as fname,info.email as email, info.phonenumber as phone FROM userinfo info, users users where info.userinfoid=$userid and users.userid=info.userinfoid";
		$info=$this->db->query($query);
		if (sizeof($info->result())==1) {
			return $info->row();
		}
		return "";	
	}
	
	public function im_update($userid){
		$userinfo=array(
			"firstname"=>$this->input->post('firstname'),
			"surname"=>$this->input->post('surname'),
			"email"=>$this->input->post('email'),
			"phonenumber"=>$this->input->post('phonenumber'),
			"attributionroleid"=>$this->input->post('jphesrole')
		);
		$this->db->where('userinfoid', $userid);
		
		if ($this->db->update('userinfo', $userinfo)) {
			$dhis=array(
				"userroleid"=>$this->input->post('dhisrole')
			);
			$this->db->where('userid', $userid);
			if ($this->db->update('userrolemembers', $dhis)) {
				return "User Has Successfully Been Updated";
			} else {
				return " Error Occurred During Userrole Update";
			}
						
		}
		return " Error Occurred During Userinfo Update";		
	}
	
	public function agencydonor_update($userid){
		$userinfo=array(
			"firstname"=>$this->input->post('firstname'),
			"surname"=>$this->input->post('surname'),
			"email"=>$this->input->post('email'),
			"phonenumber"=>$this->input->post('phonenumber'),
			"attributionroleid"=>$this->input->post('jphesrole')
		);
		$this->db->where('userinfoid', $userid);
		if ($this->db->update('userinfo', $userinfo)) {
			return "User Has Successfully Been Updated";	
		}else{
			return " Error Occurred During Userinfo Update";
		}
				
	}


//Attribution Role -Fetch Authorities

    public function get_associate_authorities(){

        $usergroupid=$this->session->userdata('groupid');
        $attributionroleid="";
        $query = $this->db->get_where('usergroup', array('usergroupid'=>$usergroupid));
        if (sizeof($query->result())>0) {
            $attributionroleid=$query->row()->attributionroleid;
        }

        if($attributionroleid!=""){

            $query="select * from attributionauthorities where attributionauthoritiesid in
              (select distinct atributionauthoritesid
              from attribution_roles_members where attributionroleid='$attributionroleid')";
            $info=$this->db->query($query);
            if(sizeof($info->result())>0){

                return $info->result();
            }
            else{

                return "";
            }

        }
        else{
            return "";
        }
    }

    public function save_attribution_role(){

        $role_name=$this->input->post('role_name');
        $authorities=$this->input->post('authorities');

        $usergroupid=$this->session->userdata('groupid');

        $info=$this->db->get_where('attribution_roles', array('rolename'=>$role_name, 'usergroupid'=>$usergroupid));

        if(sizeof($info->result())==0){

            $roleid=0;
            $this->db->select_max('attributionroleid');
            $role = $this->db->get('attribution_roles');
            $roleid = 1 + (integer)$role->row()->attributionroleid;

            $attribution_role=array(
                'rolename'=>$role_name,
                'attributionroleid'=>$roleid,
                'usergroupid'=>$usergroupid
            );

            if($this->db->insert('attribution_roles', $attribution_role)){

                if($authorities!=null){

                    //Step4
                    foreach ($authorities as $id) {

                        $role_authorities = array(
                            "attributionroleid" => $roleid,
                            "atributionauthoritesid" => $id,
                        );

                        if ($this->db->insert("attribution_roles_members", $role_authorities)) {

                        } else {
                            return "An Error Occurred During The user role";
                        }

                    }

                }

            }
            else{
                return "Error Adding Authorities";
            }
        }
        else{
            return "User Role Name Exists";
        }

        return 1;

    }

    public function get_level_roles(){

        $usergroupid=$this->session->userdata('groupid');
        $info=$this->db->get_where('attribution_roles', array('usergroupid'=>$usergroupid));
        if (sizeof($info->result())>0) {
            return $info->result();
        } else {
            return "";
        }
    }

    public function get_role($roleid){

        $usergroupid=$this->session->userdata('groupid');
        $info=$this->db->get_where('attribution_roles', array('attributionroleid'=>$roleid));
        if (sizeof($info->result())>0) {
            return $info->row();
        } else {
            return "";
        }
    }

    public function get_selected_authorities($roleid){

        $query="select * from attributionauthorities where attributionauthoritiesid in
              (select distinct atributionauthoritesid
              from attribution_roles_members where attributionroleid='$roleid')";
        $info=$this->db->query($query);
        if(sizeof($info->result())>0){

            return $info->result();
        }
        else{

            return "";
        }
    }

    public function get_unselected_authorities($roleid){

        $usergroupid=$this->session->userdata('groupid');
        $attributionroleid="";
        $query = $this->db->get_where('usergroup', array('usergroupid'=>$usergroupid));
        if (sizeof($query->result())>0) {
            $attributionroleid=$query->row()->attributionroleid;
        }

        if($attributionroleid!=""){

            $query="select * from attributionauthorities where attributionauthoritiesid in
              (select distinct atributionauthoritesid
              from attribution_roles_members where attributionroleid='$attributionroleid')
              and attributionauthoritiesid NOT IN (
              select attributionauthoritiesid from attributionauthorities where attributionauthoritiesid in
              (select distinct atributionauthoritesid
              from attribution_roles_members where attributionroleid='$roleid')
              )";
            $info=$this->db->query($query);
            if(sizeof($info->result())>0){

                return $info->result();
            }
            else{

                return "";
            }

        }
        else{
            return "";
        }
    }



    public function update_attribution_role(){

        $role_name=$this->input->post('role_name');
        $roleid=$this->input->post('roleid');
        $authorities=$this->input->post('authorities');

        $usergroupid=$this->session->userdata('groupid');


        if($role_name!=""){


            $attribution_role=array(
                'rolename'=>$role_name,
                'usergroupid'=>$usergroupid
            );

            $this->db->where('attributionroleid', $roleid);

            if($this->db->update('attribution_roles', $attribution_role)){

                if($authorities!=null){

                    if(!$this->db->delete("attribution_roles_members", array( "attributionroleid" => $roleid))){
                        return "Error updating the Role";
                    }

                    foreach ($authorities as $id) {

                        $role_authorities = array(
                            "attributionroleid" => $roleid,
                            "atributionauthoritesid" => $id,
                        );

                        if ($this->db->insert("attribution_roles_members", $role_authorities)) {

                        } else {
                            return "An Error Occurred During The user role";
                        }

                    }

                }

            }
            else{
                return "Error Adding Authorities";
            }
        }
        else{
            return "User Role Name Exists";
        }

        return 1;

    }



		public function ipsl_user_links($userinfoid, $usergroup){
				$updateorgs="INSERT INTO usermembership (organisationunitid,userinfoid)
				select orgs.organisationunitid, users.userinfoid from usergroupmembers as groupmem, organisationunit as orgs,attribution_hierarchy as ath, ipsl as ipsl, userinfo as users
				WHERE ath.code=ipsl.datimid  and orgs.code=ipsl.mflcode and ath.usergroup_id=$usergroup and users.userinfoid=$userinfoid ";
					$this->db->query($updateorgs);
			
			$querys="
			SELECT umem.userinfoid as userinfoid ,umem.organisationunitid as organisationunitid
			  FROM attribution_hierarchy as ath, usergroupmembers as gmem, usermembership as umem 
			  where gmem.usergroupid=ath.usergroup_id and 
			umem.userinfoid=$userinfoid and ath.level=4	
				";		
		$umem=$this->db->query($querys);
		foreach ($umem->result() as $row) {
			$parentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$row->organisationunitid));
			//echo "wat".$parentid->row()->parentid;
			if (is_numeric ($parentid->row()->parentid)) {
				$dbq=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$parentid->row()->parentid));
				if ($dbq->num_rows() == 0) {
					//echo "my nigga";		
					$data=array(
						"userinfoid"=>$row->userinfoid,
						"organisationunitid"=>$parentid->row()->parentid
					);
					$this->db->insert("usermembership", $data); 
					//Grandparent
					$grandparentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$parentid->row()->parentid));
					if (is_numeric ($grandparentid->row()->parentid)) {
						//echo "shiet </br>";
						$grand=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$grandparentid->row()->parentid));
						if ($grand->num_rows() == 0) {
							//echo "yes </br>";
							$data=array(
								"userinfoid"=>$row->userinfoid,
								"organisationunitid"=>$grandparentid->row()->parentid
							);
							$this->db->insert("usermembership", $data); 	
							
							//Grandparent
							$greatparentid=$this->db->get_where("organisationunit",array("organisationunitid"=>$grandparentid->row()->parentid));
							if (is_numeric ($greatparentid->row()->parentid)) {
								//echo "shiet </br>";
								$great=$this->db->get_where("usermembership",array("userinfoid"=>$row->userinfoid,"organisationunitid"=>$greatparentid->row()->parentid));
								if ($great->num_rows() == 0) {
									echo "iko boss </br>";
									$data=array(
										"userinfoid"=>$row->userinfoid,
										"organisationunitid"=>$greatparentid->row()->parentid
									);
									$this->db->insert("usermembership", $data); 							
								}
							}								
													
						}
					}					
				}					
			}
	
		}		
	}
	


	
}

