<?php

/**
 * Created by IntelliJ IDEA.
 * User: banga
 * Date: 10/09/15
 * Time: 13:53
 */
class Development_partners_model extends CI_Model
{

    public function agency_list()
    {
        $agencies = $this->db->get_where("attribution_hierarchy", array("parentid" => $this->session->userdata('group_uid'), "level" => 3));
        if (sizeof($agencies->result()) >= 1) {
            return $agencies->result();
        }
        return "";
    }

//    Programs Assigned to the development Partner
    public function get_programs_assigned_devp()
    {

        $usergroupid = $this->session->userdata('group_uid');
//		echo "string   $usergroupid";
//		$query = $this->db->get_where("attribution_hierarchy", array("uid" => $usergroupid));
//        if (sizeof($query->result())==0) {
//            return false;
//        }

//        $parentid = $query->row()->parentid;
        //Get list of programs under the parent uid

        if (!$query2 = $this->db->get_where("attribution_hierarchy_programs", array("hierarchy_uid" => $usergroupid))) {
            return false;
        }
        return $query2->result();


    }

    public function save_agency()
    {
        $userid=$this->session->userdata('userid');

        $name = $this->input->post('name');
        $shortname = $this->input->post('sname');
        $code = $this->input->post('code');
        $programs = $dataelements = $this->input->post("programs");
        $length = 11;

        $timestamp = time();
        $shuffle = $timestamp . "" . "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $agency_uid = substr(hash("md5", str_shuffle($shuffle)), 0, $length);

        //Step1 Check if Development Partner exists
        $check = $this->db->get_where("attribution_hierarchy", array("name" => $name))->result();
        if (sizeof($check) == 0) {
            //step2 Check If There's A usergroup with same name
            $check = $this->db->get_where("usergroup", array("name" => $name))->result();
            if (sizeof($check) == 0) {
                //Step3 Create UserGroup
                $this->db->select_max('usergroupid');
                $group_query = $this->db->get('usergroup');
                $usergroup_id = 1 + (integer)$group_query->row()->usergroupid;
                $usergroup = array(
                    "usergroupid" => $usergroup_id,
                    "uid" => $agency_uid,
                    "code" => $agency_uid,
                    "name" => $name,
                    "userid" => $userid,
                    "publicaccess" => "rw------",
                    'created' => date("Y-m-d"),
                    'lastupdated' => date("Y-m-d"),
                    'attributionroleid' => 4    //Agency
                );
                $this->db->insert("usergroup", $usergroup); //creating the usergroup

                //Step4
                //Check if Categoryoptiongroup exists else create a categoryoptiongroup
                $check_categoryoptgroup = $this->db->get_where("categoryoptiongroup", array("name" => $name));

                if (sizeof($check_categoryoptgroup->result()) == 0) {
                    //Create CategoryOptionGroup
                    $this->db->select_max('categoryoptiongroupid');
                    $option_query = $this->db->get('categoryoptiongroup');
                    $categoryoption_id = 1 + (integer)$option_query->row()->categoryoptiongroupid;

                    $categoryoptiongroup = array(
                        "categoryoptiongroupid" => $categoryoption_id,
                        "uid" => $agency_uid,
                        "code" => $agency_uid,
                        "name" => $name,
                        "shortname" => $shortname,
                        "code" => $code,
                        "userid" => $userid,
                        "publicaccess" => "--------",
                        'created' => date("Y-m-d"),
                        'lastupdated' => date("Y-m-d"),
                        'datadimensiontype' => "DISAGGREGATION"
                    );

                    $this->db->insert("categoryoptiongroup", $categoryoptiongroup); //creating the categoryoptiongroup

                }


                //Step5 Share Category Option Group with User Group
                $access = $this->db->get_where("usergroupaccess", array("usergroupid" => $usergroup_id));
                //If usergroup has no usergroupaccessid in usergroupaccess table
                if (sizeof($access->result()) == 0) {
                    $this->db->select_max('usergroupaccessid');
                    $accessid = $this->db->get('usergroupaccess');
                    $new_accessid = 1 + (integer)$accessid->row()->usergroupaccessid;
                    $groupaccess = array(
                        "usergroupaccessid" => $new_accessid,
                        "access" => "r-------",
                        "usergroupid" => $usergroup_id
                    );

                    $this->db->insert("usergroupaccess", $groupaccess);
                    $catoptgroupshare = array(
                        "categoryoptiongroupid" => $categoryoption_id,
                        "usergroupaccessid" => $new_accessid
                    );
                    $this->db->insert("categoryoptiongroupusergroupaccesses", $catoptgroupshare);


                    //If usergroup has an existing usergroupaccessid in usergroupaccess table
                } else {
                    $access_id=$access->row()->usergroupaccessid;
                    $catoptgroupshare = array(
                        "categoryoptiongroupid" => $categoryoption_id,
                        "usergroupaccessid" => $access_id
                    );

                    $this->db->insert("categoryoptiongroupusergroupaccesses", $catoptgroupshare);
                }

                //Step6 Share Category Option Group with Parent User Group
                $parent_usergroup_id=$this->session->userdata('groupid');

                $access = $this->db->get_where("usergroupaccess", array("usergroupid" => $parent_usergroup_id));
                //If usergroup has no usergroupaccessid in usergroupaccess table
                if (sizeof($access->result()) == 0) {
                    $this->db->select_max('usergroupaccessid');
                    $parent_access = $this->db->get('usergroupaccess');
                    $parent_accessid = 1 + (integer)$parent_access->row()->usergroupaccessid;
                    $groupaccess = array(
                        "usergroupaccessid" => $parent_accessid,
                        "access" => "r-------",
                        "usergroupid" => $parent_usergroup_id
                    );

                    $this->db->insert("usergroupaccess", $groupaccess);
                    $catoptgroupshare = array(
                        "categoryoptiongroupid" => $categoryoption_id,
                        "usergroupaccessid" => $parent_accessid
                    );
                    $this->db->insert("categoryoptiongroupusergroupaccesses", $catoptgroupshare);


                    //If usergroup has an existing usergroupaccessid in usergroupaccess table
                } else {
                    $access_id=$access->row()->usergroupaccessid;
                    $catoptgroupshare = array(
                        "categoryoptiongroupid" => $categoryoption_id,
                        "usergroupaccessid" => $access_id
                    );

                    $this->db->insert("categoryoptiongroupusergroupaccesses", $catoptgroupshare);
                }

                //Step 7 add option group to cat option group set groupset
                $agency_set = $this->db->get_where("categoryoptiongroupset", array("name" => "Funding Agencies"));
                if (sizeof($agency_set->result()) > 0) {

                    $this->db->select_max('sort_order');
                    $sortid = 1 + (integer)$this->db->get_where('categoryoptiongroupsetmembers', array("categoryoptiongroupsetid" => $agency_set->row()->categoryoptiongroupsetid))->row()->sort_order;
                    $setmember = array(
                        "categoryoptiongroupid" => $categoryoption_id,
                        "sort_order" => $sortid,
                        "categoryoptiongroupsetid" => $agency_set->row()->categoryoptiongroupsetid
                    );
                    $this->db->insert("categoryoptiongroupsetmembers", $setmember);

                } else {

                    $this->db->select_max('categoryoptiongroupsetid');
                    $newsetid = 1 + (integer)$this->db->get('categoryoptiongroupset')->row()->categoryoptiongroupsetid;
                    $new_agency_set = array(
                        "categoryoptiongroupsetid" => $newsetid,
                        "name" => "Funding Agencies",
                        "uid" => $agency_uid,
                        "publicaccess" => "--------",
                        "datadimension" => "TRUE",
                        "userid" => $userid,
                        "description" => "Funding Agencies",
                        'datadimensiontype' => "ATTRIBUTE"
                    );
                    $this->db->insert("categoryoptiongroupset", $new_agency_set);

                    $this->db->select_max('sort_order');
                    $sortid = 1 + (integer)$this->db->get_where('categoryoptiongroupsetmembers', array("categoryoptiongroupsetid" => $newsetid))->row()->sort_order;
                    $setmember = array(
                        "categoryoptiongroupid" => $categoryoption_id,
                        "sort_order" => $sortid,
                        "categoryoptiongroupsetid" => $newsetid
                    );

                    $this->db->insert("categoryoptiongroupsetmembers", $setmember);

                }


                //Step5 Insert Into attribution_hierarchy table
                $hierarchy = array(
                    "uid" => $agency_uid,
                    "code" => $code,
                    "name" => $name,
                    "shortname" => $shortname,
                    "level" => "3",
                    "parentid" => $this->session->userdata('group_uid'),
                    "usergroup_id"=>$usergroup_id,
                    "categorycombo_id" => 0,
                    "categoryoption_id" => 0
                );

                $this->db->insert("attribution_hierarchy", $hierarchy);
                //Step6 Insert Programs to attribution_hierarchy_programs
                foreach ($this->input->post("programs") as $row) {
                    $programinfo = $this->db->get_where("attribution_programs", array("program_id" => $row));
                    $dets = $programinfo->row();
                    $hierarchy_programs = array(
                        "program_name" => $dets->program_name,
                        "program_id" => $dets->program_id,
                        "hierarchy_uid" => $agency_uid,
                        "created_by" => $this->session->userdata('name')
                    );

                    if ($this->db->insert("attribution_hierarchy_programs", $hierarchy_programs)) {

                    } else {
                        return "An Error Occured During The Creation Of Development Partners";
                    }

                }

                //Create default Admin User

                $default_password='$2a$10$pcz7WFfL6bSw7nrMadpHYu69gSN/sA6jwKUR7WYN4kTm4Z7LpdkWO';
                $username=$this->input->post('username');
                $firstname=$this->input->post('firstname');
                $lastname=$this->input->post('lastname');
                $email=$this->input->post('email');
                $phonenumber=$this->input->post('phonenumber');

                //Creating the userid
                $this->db->select_max('userinfoid');
                $userid = 1 + (integer)$this->db->get('userinfo')->row()->userinfoid;
                //Creating an uid
                $length = 11;
                $random_str = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
                $time = time();
                $user_uid = substr(hash('md5', $time . '' . $random_str), 0, $length);

                //Orgunit Kenya Level
                $national_level=52;
                $orgunit = $this->db->get_where("organisationunit", array("name" => "Kenya"));
                if(sizeof($orgunit->result())>0){
                    $national_level=$orgunit->row()->organisationunitid;

                }

                //DHIS2 Role ID
                $user_role_id=0;
                $role = $this->db->get_where("userrole", array("name" => "Agency Admin"));
                if(sizeof($orgunit->result())>0){
                    $user_role_id=$role->row()->userroleid;

                }

                //Dimension Analysis dataelementcategoryid
                $dataelementcategoryid=0;
                $dimension = $this->db->get_where("dataelementcategory", array("name" => "Mechanisms"));
                if(sizeof($dimension->result())>0){
                    $dataelementcategoryid=$dimension->row()->categoryid;

                }

                $userinfo=array(
                    'userinfoid'=>$userid,
                    'uid'=>$user_uid,
                    'surname'=>$lastname,
                    'firstname'=>$firstname,
                    'email'=>$email,
                    'phonenumber'=>$phonenumber,
                    'created'=>date('Y-m-d H:m:s'),
                    'lastupdated'=>date('Y-m-d H:m:s')
                );

                //Create the user in userinfo then in users
                if($this->db->insert("userinfo", $userinfo)){

                    $users=array(
                        'userid'=>$userid,
                        'username'=>$username,
                        'password'=>$default_password,
                        'passwordlastupdated'=>date('Y-m-d H:m:s'),
                        'created'=>date('Y-m-d H:m:s'),
                        'invitation'=>"False",
                        'selfregistered'=>"False",
                        'disabled'=>"False"
                    );

                    if($this->db->insert('users',$users))
                    {
                        //Usergroup assignment
                        $usergroupmembers=array(
                            'userid'=>$userid,
                            'usergroupid'=>$usergroup_id
                        );

                        //Data entry orgunit
                        $usermembership=array(
                            'userinfoid'=>$userid,
                            'organisationunitid'=>$national_level
                        );

                        //Data view Orgunit
                        $userdatavieworgunits=array(
                            'userinfoid'=>$userid,
                            'organisationunitid'=>$national_level
                        );

                        //DHIS2 user role
                        $userrolemembers=array(
                            'userid'=>$userid,
                            'userroleid'=>$user_role_id
                        );

                        //Dimension Analysis-(mechanisms)
                        $users_catdimensionconstraints=array(
                            'userid'=>$userid,
                            'dataelementcategoryid'=>$dataelementcategoryid
                        );



                        //Updating the assignments
                        $this->db->insert('usergroupmembers', $usergroupmembers);
                        $this->db->insert('usermembership', $usermembership);
                        $this->db->insert('userdatavieworgunits',$userdatavieworgunits);
                        $this->db->insert('userrolemembers', $userrolemembers);
                        $this->db->insert('users_catdimensionconstraints', $users_catdimensionconstraints);
                    }

                }


                return TRUE;

            } else {
                return " A User Group With Same Name Exists Kindly Contact Admin Or Try Again With A Different Name";
            }

        } else {
            return "Development Partner Exists In Database. Kindly Try Again With A Different Name";
        }


    }

    public function agency_programs_list($agency_id)
    {
        $list = $this->db->get_where("attribution_hierarchy_programs", array("hierarchy_uid" => $agency_id));
        if (sizeof($list->result()) >= 1) {
            return $list->result();
        }
        return "";
    }

    public function agency_programs_list_update($agency_id)
    {
        $usergroupid = $this->session->userdata('group_uid');
        $query = "  SELECT * FROM  attribution_hierarchy_programs ahp WHERE  NOT EXISTS
  (SELECT * FROM   attribution_hierarchy_programs ahpa WHERE  ahpa.hierarchy_uid='$agency_id' and ahp.program_id = ahpa.program_id) and  ahp.hierarchy_uid='$usergroupid'";
        $list = $this->db->query($query);
        if (sizeof($list->result()) >= 1) {
            return $list->result();
        }
        return "";
    }


    public function agency_details($agency_id)
    {
        $list = $this->db->get_where("attribution_hierarchy", array("uid" => $agency_id));
        if (sizeof($list->result()) >= 1) {
            return $list->row();
        }
        return "";
    }

    public function agency_mechanisms($agency_id)
    {
        $list = $this->db->get_where("attribution_hierarchy", array("level" => 4, "parentid" => $agency_id));
        if (sizeof($list->result()) >= 1) {
            return $list->result();
        }
        return "";
    }

    public function save_agency_update()
    {
        $name = $this->input->post('name');
        $agency_uid = $this->input->post('agency_uid');
        $shortname = $this->input->post('sname');
        $code = $this->input->post('code');
        $programs = $this->input->post("programs");
        //var_dump($programs);
        $length = 11;

//        //Step1 Check if Development Partner exists
//        $check = $this->db->get_where("attribution_hierarchy", array("name" => $name))->result();
//        if (sizeof($check) === 0) {
        //step2 -Update agency details in the usergroup
        $usergroup = array(
            "name" => $name,
            'lastupdated' => date("Y-m-d")
        );

        $this->db->where('uid', $agency_uid);
        if (!$this->db->update("usergroup", $usergroup)) {
            return "Error Updating user group";
        }

        //Step3-Update agency details in the category option
        $categoryoption = array(
            "name" => $name,
            "shortname" => substr($shortname, 0, 30),
            'lastupdated' => date("Y-m-d")
        );

        $this->db->where('uid', $agency_uid);
        if (!$this->db->update("dataelementcategoryoption", $categoryoption)) {
            return "Error Updating Category Option";
        }

        //Step4  Update attribution_hierarchy table
        $hierarchy = array(
            "code" => $code,
            "name" => $name,
            "shortname" => $shortname
        );

        $this->db->where('uid', $agency_uid);
        if (!$this->db->update("attribution_hierarchy", $hierarchy)) {
            return "Error Updating Attribution Hierarchy";
        }

        //Step5 Insert Programs to attribution_hierarchy_programs
        $this->db->delete("attribution_hierarchy_programs", array('hierarchy_uid' => $agency_uid));
        foreach ($programs as $row) {
            if (!$programinfo = $this->db->get_where("attribution_programs", array("program_id" => $row))) {
                echo "Error Updating Details at program info";
            }

            $dets = $programinfo->row();

            $hierarchy_programs = array(
                "program_name" => $dets->program_name,
                "program_id" => $dets->program_id,
                "hierarchy_uid" => $agency_uid
            );


            if ($this->db->insert("attribution_hierarchy_programs", $hierarchy_programs)) {

            } else {
                return "An Error Occured During The C";
            }


        }

        return TRUE;

//


    }

    //Check username uniqueness
    public function check_username_uniqueness(){
        $username=$this->input->post('username');
        $query = $this->db->get_where("users", array("username" => $username));
        if(sizeof($query->result())>0){
            return 1;
        }

        return 0;
    }


}