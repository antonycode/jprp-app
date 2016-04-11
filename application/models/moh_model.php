<?php

/**
 *
 */
class Moh_model extends CI_Model
{

    public function development_list()
    {
        $list = $this->db->get_where("attribution_hierarchy", array("level" => 2, "parentid" => $this->session->userdata('group_uid')));
        if (sizeof($list->result()) >= 1) {
            return $list->result();
        }
        return "";
    }

    public function devpartner_programs_list($devuid)
    {
        $list = $this->db->get_where("attribution_hierarchy_programs", array("hierarchy_uid" => $devuid));
        if (sizeof($list->result()) >= 1) {
            return $list->result();
        }
        return "";
    }

    public function devpartner_programs_update($devuid)
    {
        $query = "  SELECT ap.* FROM   attribution_programs ap WHERE  NOT EXISTS
		 (SELECT * FROM   attribution_hierarchy_programs ahp WHERE  ahp.hierarchy_uid='$devuid' and ap.program_id = ahp.program_id)";
        $list = $this->db->query($query);
        if (sizeof($list->result()) >= 1) {
            return $list->result();
        }
        return "";
    }

    public function devpartner_details($devuid)
    {
        $list = $this->db->get_where("attribution_hierarchy", array("uid" => $devuid));
        if (sizeof($list->result()) >= 1) {
            return $list->row();
        }
        return "";
    }

    public function devpartner_agencies($devuid)
    {
        $list = $this->db->get_where("attribution_hierarchy", array("level" => 3, "parentid" => $devuid));
        if (sizeof($list->result()) >= 1) {
            return $list->result();
        }
        return "";
    }

    /*
    public function addnewdevp(){
        $name= $this->input->post('name');
        $shortname= $this->input->post('sname');
        $code= $this->input->post('code');
        $programs=$dataelements = $this->input->post("programs");
        $length=11;
        $devp_uid = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        //Step1 Check if Development Partner exists
        $check=$this->db->get_where("attribution_hierarchy",array("name"=>$name));
        if (sizeof($check->result())==0) {
            //step2 Check If There's A usergroup with same name
            $check=$this->db->get_where("usergroup",array("name"=>$name));
            if (sizeof($check->result())==0) {
                //Step3 Create UserGroup and CategoryOption
                $this->db->select_max('usergroupid');
                $group_query = $this->db->get('usergroup');
                $usergroup_id= 1+(integer)$group_query->row()->usergroupid;
                $usergroup=array(
                    "usergroupid"=>$usergroup_id,
                    "uid"=>$devp_uid,
                    "code"=>$devp_uid,
                    "name"=>$name,
                    'created'=>date("Y-m-d"),
                    'lastupdated'=>date("Y-m-d"),
                    'attributionroleid'=>3
                );
                $this->db->insert("usergroup",$usergroup);
                //Create Category Option
                $this->db->select_max('categoryoptionid');
                $option_query = $this->db->get('dataelementcategoryoption');
                $categoryoption_id= 1+(integer)$option_query->row()->categoryoptionid;
                $categoryoption=array(
                    "categoryoptionid"=>$categoryoption_id,
                    "uid"=>$devp_uid,
                    "code"=>$devp_uid,
                    "name"=>$name,
                    "shortname"=>substr($shortname,0,30),
                    'lastupdated'=>date("Y-m-d")
                );
                $this->db->insert("dataelementcategoryoption",$categoryoption);
                //Step3 Insert Into attribution_hierarchy table
                $hierarchy=array(
                    "uid"=>$devp_uid,
                    "code"=>$code,
                    "name"=>$name,
                    "shortname"=>$shortname,
                    "level"=>2,
                    "parentid"=>$this->session->userdata('group_uid')
                );
                $this->db->insert("attribution_hierarchy",$hierarchy);
                //Step4 Insert Programs to attribution_hierarchy_programs
                foreach ($this->input->post("programs") as $row) {
                    $programinfo=$this->db->get_where("attribution_programs",array("program_id"=>$row));
                    $dets=$programinfo->row();
                    $hierarchy_programs=array(
                        "program_name"=>$dets->program_name,
                        "program_id"=>$dets->program_id,
                        "program_description"=>$dets->program_description,
                        "hierarchy_uid"=>$devp_uid,
                        "created_by"=>$this->session->userdata("name")
                    );
                    if ($this->db->insert("attribution_hierarchy_programs",$hierarchy_programs)) {

                    }else{
                        return "An Error Occured During Development Partner Program Creation";
                    }

                }
                return true;

            } else {
                return " A User Group With Same Name Exists Kindly Contact Admin Or Try Again With A Different Name";
            }

        } else {
            return "Development Partner Exists In Database. Kindly Try Again With A Different Name";
        }


    }*/


    public function addnewdevp()
    {
        $name = $this->input->post('name');
        $shortname = $this->input->post('sname');
        $code = $this->input->post('code');
        $programs = $dataelements = $this->input->post("programs");
        $length = 11;
        $str = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        $t = time();
        $devp_uid = substr(hash('md5', time() . '' . $str), 0, $length);
        //Step1 Check if Development Partner exists
        $check = $this->db->get_where("attribution_hierarchy", array("name" => $name));
        if (sizeof($check->result()) == 0) {
            //step2 Check If There's A usergroup with same name
            $check = $this->db->get_where("usergroup", array("name" => $name));
            $usergroup_id = 1;
            if (sizeof($check->result()) == 0) {
                //Step3 Create UserGroup
                $this->db->select_max('usergroupid');
                $group_query = $this->db->get('usergroup');
                $usergroup_id = 1 + (integer)$group_query->row()->usergroupid;
                $usergroup = array(
                    "usergroupid" => $usergroup_id,
                    "uid" => $devp_uid,
                    "code" => $devp_uid,
                    "name" => $name,
                    "userid" => $this->session->userdata("userid"),
                    'created' => date("Y-m-d"),
                    'lastupdated' => date("Y-m-d"),
                    "publicaccess" => "rw------",
                    'attributionroleid' => 3
                );
                $this->db->insert("usergroup", $usergroup);
                //Step4 Create Category Option Group
                $check = $this->db->get_where("categoryoptiongroup", array("name" => $name));
                //Check If Category Option Group Exists
                $categoryoption_id = 1;
                if (sizeof($check->result()) == 0) {
                    $this->db->select_max('categoryoptiongroupid');
                    $option_query = $this->db->get('categoryoptiongroup');
                    $categoryoption_id = 1 + (integer)$option_query->row()->categoryoptiongroupid;
                    $categoryoption = array(
                        "categoryoptiongroupid" => $categoryoption_id,
                        "uid" => $devp_uid,
                        "code" => $code,
                        "name" => $name,
                        "shortname" => substr($shortname, 0, 30),
                        "userid" => $this->session->userdata("userid"),
                        "datadimensiontype" => "DISAGGREGATION",
                        "publicaccess" => "--------",
                        'lastupdated' => date("Y-m-d")
                    );
                    $this->db->insert("categoryoptiongroup", $categoryoption);
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
                    $catoptgroupshare = array(
                        "categoryoptiongroupid" => $categoryoption_id,
                        "usergroupaccessid" => $access->row()->usergroupaccessid
                    );
                    $this->db->insert("categoryoptiongroupusergroupaccesses", $catoptgroupshare);
                }
                //Step 6 add option group to cat option group set donors
                $donor_set = $this->db->get_where("categoryoptiongroupset", array("name" => "Donors"));
                if (sizeof($donor_set->result()) > 0) {

                    $this->db->select_max('sort_order');
                    $sortid = 1 + (integer)$this->db->get_where('categoryoptiongroupsetmembers', array("categoryoptiongroupsetid" => $donor_set->row()->categoryoptiongroupsetid))->row()->sort_order;
                    $setmember = array(
                        "categoryoptiongroupid" => $categoryoption_id,
                        "sort_order" => $sortid,
                        "categoryoptiongroupsetid" => $donor_set->row()->categoryoptiongroupsetid
                    );
                    $this->db->insert("categoryoptiongroupsetmembers", $setmember);
                } else {
                    $this->db->select_max('categoryoptiongroupsetid');
                    $newsetid = 1 + (integer)$this->db->get('categoryoptiongroupset')->row()->categoryoptiongroupsetid;
                    $newdonorset = array(
                        "categoryoptiongroupsetid" => $newsetid,
                        "name" => "Donors",
                        "uid" => $devp_uid,
                        "publicaccess" => "--------",
                        "datadimension" => "TRUE",
                        "userid" => $this->session->userdata("userid"),
                        "description" => "Donors",
                        'datadimensiontype' => "ATTRIBUTE"
                    );
                    $this->db->insert("categoryoptiongroupset", $newdonorset);
                    $this->db->select_max('sort_order');
                    $sortid = 1 + (integer)$this->db->get_where('categoryoptiongroupsetmembers', array("categoryoptiongroupsetid" => $newsetid))->row()->sort_order;
                    $setmember = array(
                        "categoryoptiongroupid" => $categoryoption_id,
                        "sort_order" => $sortid,
                        "categoryoptiongroupsetid" => $donor_set->row()->$newsetid
                    );
                    $this->db->insert("categoryoptiongroupsetmembers", $setmember);
                }
                //Step7 Insert Into attribution_hierarchy table
                $hierarchy = array(
                    "uid" => $devp_uid,
                    "code" => $code,
                    "name" => $name,
                    "shortname" => $shortname,
                    "level" => 2,
                    "parentid" => $this->session->userdata('group_uid'),
                    "usergroup_id" => $usergroup_id,
                    "categorycombo_id" => 0,
                    "categoryoption_id" => 0

                );
                $this->db->insert("attribution_hierarchy", $hierarchy);
                //Step8 Insert Programs to attribution_hierarchy_programs
                foreach ($this->input->post("programs") as $row) {
                    $programinfo = $this->db->get_where("attribution_programs", array("program_id" => $row));
                    $dets = $programinfo->row();
                    $hierarchy_programs = array(
                        "program_name" => $dets->program_name,
                        "program_id" => $dets->program_id,
                        "program_description" => $dets->program_description,
                        "hierarchy_uid" => $devp_uid,
                        "created_by" => $this->session->userdata("name")
                    );
                    if ($this->db->insert("attribution_hierarchy_programs", $hierarchy_programs)) {

                    } else {
                        return "An Error Occured During Development Partner Program Creation";
                    }

                }


                //Create default Admin User

                $default_password='$2a$10$pcz7WFfL6bSw7nrMadpHYu69gSN/sA6jwKUR7WYN4kTm4Z7LpdkWO';
                $username=$this->input->post('username');
                $firstname=$this->input->post('firstname');
                $lastname=$this->input->post('lastname');
                $email=$this->input->post('email');
                $phonenumber=$this->input->post('phonenumber');

                //check if the username exists
                $query = $this->db->get_where("users", array("username" => $username));
                if(sizeof($query->result())==0) {
                    //Creating the userid
                    $this->db->select_max('userinfoid');
                    $userid = 1 + (integer)$this->db->get('userinfo')->row()->userinfoid;
                    //Creating an uid
                    $length = 11;
                    $random_str = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
                    $time = time();
                    $user_uid = substr(hash('md5', $time . '' . $random_str), 0, $length);

                    //Orgunit Kenya Level
                    $national_level = 52;
                    $orgunit = $this->db->get_where("organisationunit", array("name" => "Kenya"));
                    if (sizeof($orgunit->result()) > 0) {
                        $national_level = $orgunit->row()->organisationunitid;

                    }

                    //DHIS2 Role ID
                    $user_role_id = 0;
                    $role = $this->db->get_where("userrole", array("name" => "Donor Admin"));
                    if (sizeof($orgunit->result()) > 0) {
                        $user_role_id = $role->row()->userroleid;

                    }

                    //Dimension Analysis dataelementcategoryid
                    $dataelementcategoryid = 0;
                    $dimension = $this->db->get_where("dataelementcategory", array("name" => "Mechanisms"));
                    if (sizeof($dimension->result()) > 0) {
                        $dataelementcategoryid = $dimension->row()->categoryid;

                    }

                    $userinfo = array(
                        'userinfoid' => $userid,
                        'uid' => $user_uid,
                        'surname' => $lastname,
                        'firstname' => $firstname,
                        'email' => $email,
                        'phonenumber' => $phonenumber,
                        'created' => date('Y-m-d H:m:s'),
                        'lastupdated' => date('Y-m-d H:m:s')
                    );

                    //Create the user in userinfo then in users
                    if ($this->db->insert("userinfo", $userinfo)) {

                        $users = array(
                            'userid' => $userid,
                            'username' => $username,
                            'password' => $default_password,
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
                                'usergroupid' => $usergroup_id
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
                                'userroleid' => $user_role_id
                            );

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
                }


                return true;

            } else {
                return " A User Group With Same Name Exists Kindly Contact Admin Or Try Again With A Different Name";
            }

        } else {
            return "Development Partner Exists In Database. Kindly Try Again With A Different Name";
        }


    }

    public function save_devp_update()
    {
        $name = $this->input->post('name');
        $devp_uid = $this->input->post('devp_uid');
        $shortname = $this->input->post('sname');
        $code = $this->input->post('code');
        $programs = $this->input->post("programs");

        $length = 11;


        $usergroup = array(
            "name" => $name,
            'lastupdated' => date("Y-m-d")
        );

        $this->db->where('uid', $devp_uid);
        if (!$this->db->update("usergroup", $usergroup)) {
            return "Error Updating user group";
        }

        //Step3-Update agency details in the category option
        $categoryoptiongroup = array(
            "name" => $name,
            "shortname" => substr($shortname, 0, 30),
            'lastupdated' => date("Y-m-d")
        );

        $this->db->where('uid', $devp_uid);
        if (!$this->db->update("categoryoptiongroup", $categoryoptiongroup)) {
            return "Error Updating Category Option group";
        }

        //Step4  Update attribution_hierarchy table
        $hierarchy = array(
            "code" => $code,
            "name" => $name,
            "shortname" => $shortname
        );

        $this->db->where('uid', $devp_uid);
        if (!$this->db->update("attribution_hierarchy", $hierarchy)) {
            return "Error Updating Attribution Hierarchy";
        }

        //Step5 Insert Programs to attribution_hierarchy_programs
        $this->db->delete("attribution_hierarchy_programs", array('hierarchy_uid' => $devp_uid));
        foreach ($programs as $row) {
            if (!$programinfo = $this->db->get_where("attribution_programs", array("program_id" => $row))) {
                echo "Error Updating Details at program info";
            }

            $dets = $programinfo->row();

            $hierarchy_programs = array(
                "program_name" => $dets->program_name,
                "program_id" => $dets->program_id,
                "hierarchy_uid" => $devp_uid
            );


            if ($this->db->insert("attribution_hierarchy_programs", $hierarchy_programs)) {

            } else {
                return "An Error occurred During Development Partner Update ";
            }


        }

        return TRUE;

    }

    //Check username uniqueness
    public function check_username_uniqueness(){
        $username=$this->input->post('username');
        $query = $this->db->get_where("users", array("lower(username)" => strtolower($username)));
        if(sizeof($query->result())>0){
            return 1;
        }

        return 0;
    }

    //Check devpartner name's uniqueness
    public function check_devpartner_uniqueness(){

        $devpartner=$this->input->post('devpartner');
        $query = $this->db->get_where("attribution_hierarchy", array("lower(name)" => strtolower($devpartner)));
        if(sizeof($query->result())>0){
            return 1;
        }

        return 0;
    }

    //Check devpartner code uniqueness
    public function check_devpartner_code_uniqueness(){

        $devpartner_code=$this->input->post('devpartner_code');
        $query = $this->db->get_where("attribution_hierarchy", array("code" => (string)$devpartner_code));
        if(sizeof($query->result())>0){
            return 1;
        }

        return 0;
    }

}
