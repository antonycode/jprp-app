<?php
/**
 * Created by IntelliJ IDEA.
 * User: banga
 * Date: 13/09/15
 * Time: 17:01
 */

 class Agency_mechanism_model extends CI_Model{

     public function agency_mechanism_list()
     {
         $agencies = $this->db->get_where("attribution_hierarchy", array("parentid" => $this->session->userdata('group_uid'), "level" => 4));
         if (sizeof($agencies->result()) >= 1) {
             return $agencies->result();
         }
         return "";
     }

//    Programs Assigned to the Agency
    public function get_programs_assigned_agency()
    {

        $usergroupid = $this->session->userdata('group_uid');
        if (!$query = $this->db->get_where("attribution_hierarchy_programs", array("hierarchy_uid" => $usergroupid))) {
            return false;
        }
        return $query->result();


    }

    public function save_mechanism()
    {

        $mechanism_name = $this->input->post('mechanism_name');
        $partner_name = $this->input->post('partner_name');
        $datim_id = $this->input->post('datim_id');
        $kepms_id = $this->input->post('kepms_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('start_date');
        $programs=$this->input->post('programs');

        if($kepms_id==="")
        {
            $kepms_id=0;
        }

        $length = 11;
        $mechanism_uid = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        //Step1 Check if Development Partner exists
        $check = $this->db->get_where("attribution_hierarchy", array("name" => $mechanism_name))->result();
        if (sizeof($check) == 0) {
            //step2 Check If There's A usergroup with same name
            $check = $this->db->get_where("usergroup", array("name" => $mechanism_name))->result();
            if (sizeof($check) == 0) {
                //Step3 Create UserGroup and CategoryOption
                $this->db->select_max('usergroupid');
                $group_query = $this->db->get('usergroup');
                $usergroup_id = 1 + (integer)$group_query->row()->usergroupid;
                $usergroup = array(
                    "usergroupid" => $usergroup_id,
                    "uid" => $mechanism_uid,
                    "code" => $mechanism_uid,
                    "name" => $mechanism_name,
                    'created' => date("Y-m-d"),
                    'lastupdated' => date("Y-m-d")
                );
                $this->db->insert("usergroup", $usergroup);
                //Create Category Option
                $this->db->select_max('categoryoptionid');
                $option_query = $this->db->get('dataelementcategoryoption');
                $categoryoption_id = 1 + (integer)$option_query->row()->categoryoptionid;
                $categoryoption = array(
                    "categoryoptionid" => $categoryoption_id,
                    "uid" => $mechanism_uid,
                    "code" => $mechanism_uid,
                    "name" => $mechanism_name,
                    "shortname" => substr($mechanism_name, 0, 30),
                    'lastupdated' => date("Y-m-d")
                );

                $this->db->insert("dataelementcategoryoption", $categoryoption);
                //Step3 Insert Into attribution_hierarchy table
                $hierarchy = array(
                    "uid" => $mechanism_uid,
                    "code" => $datim_id,
                    "name" => $mechanism_name,
                    "shortname" => $partner_name,
                    "level" => 4,
                    "parentid" => $this->session->userdata('group_uid')
                );

                $this->db->insert("attribution_hierarchy", $hierarchy);
                //Step4 Insert Programs to attribution_hierarchy_programs
                foreach ($this->input->post("programs") as $row) {
                    $programinfo = $this->db->get_where("attribution_programs", array("program_id" => $row));
                    $dets = $programinfo->row();
                    $hierarchy_programs = array(
                        "program_name" => $dets->program_name,
                        "program_id" => $dets->program_id,
                        "hierarchy_uid" => $mechanism_uid,
                        "created_by" => $this->session->userdata('useruid')
                    );

                    if ($this->db->insert("attribution_hierarchy_programs", $hierarchy_programs)) {

                    } else {
                        return "An Error Occured During The Creation Of Development Partners";
                    }

                }


                //Step 3 Add Option To Category
                $categoryid=$this->db->get_where('dataelementcategory',array('name'=>'Mechanisms'))->row()->categoryid;
                $maxorder= $this->db->query("SELECT MAX(sort_order) as max FROM categories_categoryoptions WHERE categoryid=$categoryid ")->row()->max;
                $this->db->insert('categories_categoryoptions',array('categoryoptionid'=>$categoryoption_id,'categoryid'=>$categoryid,'sort_order'=>$maxorder+1));

                //Step 4 create CategoryOptionCombo : Attribution Key(new generated categoryoptioncomboid)
                $optioncombo_uid=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
                $categoryoptioncomboid=$this->db->query('Select max(categoryoptioncomboid) as maxs from categoryoptioncombo')->row()->maxs+1;
                $combo=array(
                    'categoryoptioncomboid'=>$categoryoptioncomboid,
                    'uid'=>substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length),
                    'created'=>date("Y-m-d"),
                    'lastupdated'=>date("Y-m-d")
                );
                $this->db->insert('categoryoptioncombo',$combo);

                //Step5 Add categoryoptionid and categoryoptioncomboid to categoryoptioncombos_categoryoptions
                $categoryoptioncombos_categoryoptions=array(
                    'categoryoptionid'=>$categoryoption_id,
                    'categoryoptioncomboid'=>$categoryoptioncomboid
                );
                $this->db->insert('categoryoptioncombos_categoryoptions',$categoryoptioncombos_categoryoptions);

                //Step 6 Add Categoryoptioncombo and categorycomboid to categorycombos_optioncombos
                $categorycomboid=$this->db->get_where("categorycombo",array("name"=>"Mechanisms Combo"))->row()->categorycomboid;
                $categorycombos_optioncombos=array(
                    'categorycomboid'=>$categorycomboid,
                    'categoryoptioncomboid'=>$categoryoptioncomboid
                );
                $this->db->insert('categorycombos_optioncombos',$categorycombos_optioncombos);

                //Step 7 Update  attribution_keys
                $attribution_keys=array(
                    'datim_id'=>$datim_id,
                    'mechanism_id'=>$kepms_id,
                    'mechanism_name'=>$mechanism_name,
                    'mechanism_uid'=>$mechanism_uid,
                    'usergroup_id'=>$usergroup_id,
                    'categorycombo_id'=>$categoryoptioncomboid,
                    'categoryoption_id'=>$categoryoption_id,
                    'mechanism_status'=>"active",
                    "start_date"=>$start_date,
                    "end_date"=>$end_date
                );
                $this->db->insert("attribution_keys",$attribution_keys);

                //Step 8 : Insert Data to attribution_mechanisms
                $mechanisms=array(
                    "mechanism_name"=>$mechanism_name,
                    "datim_id"=>$datim_id,
                    "mechanism_id"=>$kepms_id,
                    "mechanism_uid"=>$mechanism_uid,
                    "attribution_key"=>$categoryoptioncomboid,
                    "partner_name"=>$partner_name,
                    'mechanism_status'=>"active",
                    "date_created"=>date("Y-m-d"),
                    "start_date"=>$start_date,
                    "end_date"=>$end_date,
                    "created_by"=>$this->session->userdata('user')
                );

                $this->db->insert("attribution_mechanisms",$mechanisms);


                return TRUE;

            } else {
                return " A User Group With Same Name Exists Kindly Contact Admin Or Try Again With A Different Name";
            }

        } else {
            return "Mechanism Name Exists In Database. Kindly Try Again With A Different Name";
        }


    }


    public function mechanism_programs_list($mechanism_id)
    {
        $list = $this->db->get_where("attribution_hierarchy_programs", array("hierarchy_uid" => $mechanism_id));
        if (sizeof($list->result()) >= 1) {
            return $list->result();
        }
        return "";
    }

    //Support list
    public function mechanism_support_list($mech_uid){
    	$datimid=$this->db->get_where("attribution_keys",array("mechanism_uid"=>$mech_uid));
		if (sizeof($datimid->result())==1) {
			$datim_id=$datimid->row()->datim_id;
	        //$support=$this->db->get_where("attribution_mechanisms_programs",array("status"=>'active',"hierarchy_uid"=>$hierarchy_uid))->result();
	        $support=$this->db->get_where("attribution_mechanisms_programs",array("datim_id"=>$datim_id));
	        if (sizeof($support->result())>=1) {
	            return $support->result();
	        }			
		} 
        return "";
    }


    public function mechanism_programs_list_update($mechanism_uid)
    {
        $usergroupid = $this->session->userdata('group_uid');
        $query = "  SELECT * FROM  attribution_hierarchy_programs ahp WHERE  NOT EXISTS
  (SELECT * FROM   attribution_hierarchy_programs ahpa WHERE  ahpa.hierarchy_uid='$mechanism_uid' and ahp.program_id = ahpa.program_id) and  ahp.hierarchy_uid='$usergroupid'";
        $list = $this->db->query($query);
        if (sizeof($list->result()) >= 1) {
            return $list->result();
        }
        return "";
    }


    public function mechanism_details($mechanism_uid)
    {
        $list = $this->db->get_where("attribution_hierarchy", array("uid" => $mechanism_uid));
        if (sizeof($list->result()) >= 1) {
            return $list->row();
        }
        return "";
    }

    public function mechanism_update_details($mechanism_uid)
    {

        $list = $this->db->get_where("attribution_mechanisms", array("mechanism_uid" => $mechanism_uid));
        if (sizeof($list->result()) >= 1) {
            return $list->row();
        }
        return "";
    }

    public function save_mechanism_update(){

        $mechanism_name = $this->input->post('mechanism_name');
        $mechanism_uid = $this->input->post('mechanism_uid');
        $partner_name = $this->input->post('partner_name');
        $datim_id = $this->input->post('datim_id');
        $kepms_id = $this->input->post('kepms_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $programs=$this->input->post('programs');

        if($kepms_id==="")
        {
            $kepms_id=0;
        }

        if(!$mechanism_uid){
            return "Invalid Mechanism UID";
        }

        // Update attribution mechanisms table
        $mechanisms=array(
            "mechanism_name"=>$mechanism_name,
            "mechanism_id"=>$kepms_id,
            "partner_name"=>$partner_name,
            'start_date'=>$start_date,
            'end_date'=>$end_date);

        $this->db->where('datim_id', $datim_id);
        if (!$this->db->update("attribution_mechanisms",$mechanisms)) {
            return "Attribution Update";
        }

        // Update attribution keys table
        $attribution_keys=array(
            "mechanism_name"=>$partner_name,
            "mechanism_id"=>$kepms_id,
            'start_date'=>$start_date,
            'end_date'=>$end_date);

        $this->db->where('datim_id', $datim_id);
        if(!$this->db->update("attribution_keys",$attribution_keys)) {
            return "Attribution Update";
        }

        // Update category option
        $categoryoption=array(
            "name"=>$partner_name,
            "shortname"=>substr($partner_name,0,30),
            'lastupdated'=>date("Y-m-d"));

        $this->db->where('uid', $mechanism_uid);
        if (!$this->db->update("dataelementcategoryoption",$categoryoption)) {
            return "Attribution Update";
        }


        // Update user group
        $usergroup=array(
            "name"=>$mechanism_name,
            'lastupdated'=>date("Y-m-d"));

        $this->db->where('uid', $mechanism_uid);
        if (!$this->db->update("usergroup",$usergroup)) {
            return "Attribution Update";
        }

//        Update attribution_hierarchy table
        $hierarchy = array(
            "code" => $datim_id,
            "name" => $mechanism_name,
            "shortname" => $partner_name
        );

        $this->db->where('uid', $mechanism_uid);
        if (!$this->db->update("attribution_hierarchy", $hierarchy)) {
            return "Error Updating Attribution Hierarchy";
        }

        //Step5 Insert Programs to attribution_hierarchy_programs
        $this->db->delete("attribution_hierarchy_programs", array('hierarchy_uid' => $mechanism_uid));
        foreach ($programs as $row) {
            if (!$programinfo = $this->db->get_where("attribution_programs", array("program_id" => $row))) {
                echo "Error Updating Details at program info";
            }

            $dets = $programinfo->row();

            $hierarchy_programs = array(
                "program_name" => $dets->program_name,
                "program_id" => $dets->program_id,
                "hierarchy_uid" => $mechanism_uid
            );


            if (!$this->db->insert("attribution_hierarchy_programs", $hierarchy_programs)) {
                return "An Error Occured-In the process of Updating Mechanisms";
            }

        }


        return true;
    }

    // fetches details of a mechanism
    public function show_mechanism_details($mechanism_uid)
    {

        $start_date = "";
        $end_date = "";
        $created_by = "";
        $number_of_facilities = "";
        $number_facilities_dsd="";
        $number_facilities_ta="";
        $mechanism_name = "";
        $partner_name = "";
        $name="";

        // Mechanism info
        if ($query = $this->db->get_where('attribution_mechanisms', array('mechanism_uid' => $mechanism_uid))) {
            $row = $query->row();
            $mechanism_name = $row->mechanism_name;
            $start_date = $row->start_date;
            $end_date = $row->end_date;
            $created_by=$row->created_by;
        }

//        // Number of DSD facilities
//        $this->db->select('count(datim_id)');
//        if ($query = $this->db->get_where('attribution_mechanisms_programs', array('datim_id' => $mechanism_uid,
//            'support_type'=>'DSD'))) {
//            $number_facilities_dsd = $query->row()->count;
//        }
//
//        // Number of TA facilities
//        $this->db->select('count(datim_id)');
//        if ($query = $this->db->get_where('attribution_mechanisms_programs', array('datim_id' =>  $mechanism_uid,
//            'support_type'=>'TA'))) {
//            $number_facilities_ta = $query->row()->count;
//        }

        // Created by info
        if($created_by!="")
        {
            $created_by_query = $this->db->get_where('userinfo', array('uid' => $created_by));
            if (sizeof($created_by_query->result())==1) {
                $row = $created_by_query->row();
                $name = $row->firstname." ".$row->surname;
            }
        }

        $data = array(
            'mechanism_name' => $mechanism_name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'created_by'=>$name,
            'facilities_ta'=>$number_facilities_ta,
            'facilities_dsd'=>$number_facilities_dsd);

        return $data;
    }

}