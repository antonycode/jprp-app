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

    public function get_all_authorities(){
        $authorities = $this->db->get('attributionauthorities');
        if (sizeof($authorities->result())>0) {
            return $authorities->result();
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
	
	public function org_new_im_user(){
		$username=$this->input->post('username');
		$firstname=$this->input->post('username');
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
            }

        }
		return "User Has Been Successfully Created";
	}
	
	public function org_new_donoragancy_user(){
		$username=$this->input->post('username');
		$firstname=$this->input->post('username');
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
		$firstname=$this->input->post('username');
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
		$firstname=$this->input->post('username');
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

}

