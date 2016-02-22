<?php

/**
 * 
 */
class Mechanisms_model extends CI_Model {

    public function empty_attribution_mechanisms(){
        $this->db->truncate('attribution_mechanisms'); 
    }
	public function empty_mechanisms_support_errors(){
		$this->db->truncate('attribution_support_import_errors');
	}
	public function mechanisms_support_errors(){
		$errors=$this->db->get_where("attribution_support_import_errors");
		if (sizeof($errors->result())>=1) {
			return $errors->result();
		}
		return "";
	}
	public function mechanisms_list(){
		$mechanisms=$this->db->get_where("attribution_keys",array("mechanism_status"=>"active"));
		if (sizeof($mechanisms->result())>=1) {
			return $mechanisms->result();
		}
		return "";
	}
	
	public function mechanism_info($id){
		$info=$this->db->get_where("attribution_mechanisms",array("datim_id"=>$id));
		if (sizeof($info->result())==1) {
			return $info->row();
		}
		return false;
	}
	
	public function get_mech_programs($id){
		$programs=$this->db->get_where("attribution_mechanisms_programs",array("datim_id"=>$id));
		if (sizeof($programs->result())>=1) {
			return $programs->result();
		}
		return "";		
	}
	public function supportupdate($info_array,$id){
		$this->db->where('id', $id);
		if ($this->db->update("attribution_mechanisms_programs",$info_array)) {
			return true;
		}	
		return false;
	}
	
	
	/*public function excel_import($mechanisms_name, $mechanisms_id,$mechanisms_uid, $attribution_key){
			$mechanisms=array(
				"mechanism_name"=>$mechanisms_name,
				"mechanism_id"=>$mechanisms_id,
				"mechanism_uid"=>$mechanisms_uid,
				"attribution_key"=>$attribution_key
			);
			if (!$this->db->insert("attribution_mechanisms",$mechanisms)) {
				return "Program Members Update";
			}		
	}*/
	
	public function mechanisms_excel_import($mechanisms_name,$datim_id, $partner_name, $kepms_id){
		//echo $datim_id;
		//Check If The Mechanism Has An Attribution Key
		$control=sizeof($this->db->get_where("attribution_keys",array("datim_id"=>$datim_id))->result());
		if ($control==1) {
			//Update Mechanisms Table
			if (sizeof($this->db->get_where("attribution_mechanisms",array("datim_id"=>$datim_id))->result())==0) {
				//echo "id id </br>";
				$existing_mech=$this->db->get_where("attribution_keys",array("datim_id"=>$datim_id))->row();	
				$stored_mechanisms=array(
					"mechanism_name"=>$existing_mech->mechanism_name,
					"datim_id"=>$existing_mech->datim_id,
					"mechanism_uid"=>$existing_mech->mechanism_uid,
					"mechanism_id"=>$kepms_id,
					"attribution_key"=>$existing_mech->categorycombo_id,
					"partner_name"=>$partner_name,
					'mechanism_status'=>$existing_mech->mechanism_status
				);
				$this->db->insert("attribution_mechanisms",$stored_mechanisms);				
			}

		}elseif($control==0) {//Generate Attribution Key If Key Doesn't Exist 
			//Step1 Generate User Group
			$length=11;//Length Of UID String Generator
						
			$this->db->select_max('usergroupid');
			$group_query = $this->db->get('usergroup');
			$usergroup_id= 1+(integer)$group_query->row()->usergroupid;
		    $usergroup_uid = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
			$mechanisms_uid=$usergroup_uid;
			$usergroup=array(
				"usergroupid"=>$usergroup_id,
				"uid"=>$usergroup_uid,
				"code"=>$datim_id,
				"name"=>$partner_name,
                'created'=>date("Y-m-d"),
                'lastupdated'=>date("Y-m-d"),
                'attributionroleid'=>5				
			);
			$this->db->insert("usergroup",$usergroup);

			//Step 1b Generate Usergroup Access rights
			$this->db->select_max('usergroupaccessid');
			$groupaccess_query = $this->db->get('usergroupaccess');
			$usergroupaccess_id= 1+(integer)$groupaccess_query->row()->usergroupaccessid;			
			$usergroupaccess=array(
				"usergroupaccessid"=>$usergroupaccess_id,
				"access"=>"r-------",
				"usergroupid"=>$usergroup_id			
			);			
			$this->db->insert("usergroupaccess",$usergroupaccess);

			//Step 2 Create Option Group For The User Group
		    $categoryoption_uid = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);	
			$this->db->select_max('categoryoptionid');
			$option_query = $this->db->get('dataelementcategoryoption');
			$categoryoption_id= 1+(integer)$option_query->row()->categoryoptionid;			
			$categoryoption=array(
				"categoryoptionid"=>$categoryoption_id,
				"uid"=>$categoryoption_uid,
				"code"=>$datim_id,
				"name"=>$partner_name,
				"shortname"=>substr($partner_name,0,30),
                'created'=>date("Y-m-d"),
                'lastupdated'=>date("Y-m-d")				
			);
			$this->db->insert("dataelementcategoryoption",$categoryoption);
			//echo $this->db->last_query();

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
			echo "string";
			//Step 7 Update  attribution_keys 
			$attribution_keys=array(
				'datim_id'=>$datim_id,
				'mechanism_id'=>$kepms_id,
				'mechanism_name'=>$partner_name,
				'mechanism_uid'=>$usergroup_uid,
				'usergroup_id'=>$usergroup_id,
				'categorycombo_id'=>$categoryoptioncomboid,
				'categoryoption_id'=>$categoryoption_id,
				'mechanism_status'=>"active"
			);	
			$this->db->insert("attribution_keys",$attribution_keys);

			//Step 8 : Insert Data to attribution_mechanisms	
			$mechanisms=array(
				"mechanism_name"=>$mechanisms_name,
				"datim_id"=>$datim_id,
				"mechanism_id"=>$kepms_id,
				"mechanism_uid"=>$mechanisms_uid,
				"attribution_key"=>$categoryoptioncomboid,
				"partner_name"=>$partner_name,
				'mechanism_status'=>"active"
			);
			$this->db->insert("attribution_mechanisms",$mechanisms);
		}
		
	}
	
	
	public function get_all_orgunits(){
		$this->db->select('uid, name');
		$orgunits=$this->db->get("organisationunit");
		if (sizeof($orgunits->result())>=1) {
			return $orgunits->result();
		}
		return "";
	}
	public function deletemechanism($datim_id){
		$details=array(
			"mechanism_status"=>"dropped",
		);

		$this->db->where('datim_id', $datim_id);	
		 	
		if (!$this->db->update("attribution_mechanisms", $details) &&!$this->db->update("attribution_keys", $details) ) {
			return false;
		}	

		return true;					 
	 }	
	 
	 
	 public function support_excel_import($orgunit_name,$mechanism_name,$datim_id,$program_name,$support_name,$period,$datim_id,$mfl_code,$ownership,$typeofsite,$othertypeofsite,$level,$county,$subcounty){
	 		//echo "here";
	 	//Step 1 Check If Program Exists
	 	$orgunit=$this->db->get_where("organisationunit",array("name"=>$orgunit_name))->row();
		if (sizeof($orgunit)==1) {
		 	$program=$this->db->get_where("attribution_programs",array("program_name"=>$program_name))->row();
		 	if (sizeof($program)==1) {
				 //Check If Support Type Exists
				 $support=$this->db->get_where("attribution_support_types",array("support_name"=>$support_name))->result();
				 if (sizeof($support)==1) {
					 //Check If Record Exists
					 $record=array(
					 	"organization_name"=>$orgunit_name,
					 	"datim_id"=>$datim_id,
					 	"program_name"=>$program_name,
					 	"support_type"=>$support_name,
					 	"period"=>$period
					 );				 
					 if (sizeof($this->db->get_where("attribution_mechanisms_programs",$record)->result())==0) { 
						 //Check For Date Overlaps prevent same support type on same facility same period
						 $overlapquery="SELECT * FROM attribution_mechanisms_programs where organization_name='$orgunit_name' AND program_name='$program_name' AND support_type='$support_name' AND period = '$period' ";						 
						 if (sizeof($this->db->query($overlapquery)->result())==0) {
							 $new_support=array(
							 	"organization_name"=>$orgunit_name,
							 	"organization_id"=>$orgunit->organisationunitid,
							 	"datim_id"=>$datim_id,
							 	"mechanism_name"=>$mechanism_name,
							 	"program_name"=>$program_name,
							 	"program_id"=>$program->program_id,
							 	"support_type"=>$support_name,
							 	"period"=>$period,
							 	"status"=>"active"					 
							 );
							 $this->db->insert("attribution_mechanisms_programs",$new_support);
							 return true;
						 } else {
							 return "Overlap Support For The Same Program and Support Type";
						 }
						 
					 } else {
						 return  "Support Exists In Database";
					 }
				 } else {
					 return "Support Not Found";
				 }
				 
			 }else{
			 	return  "Program Doesnot Exist";
			 }		
		}else{
			return  "Organization Unit Not Found";
		}
 
	 }
	 public function support_import_errors($organization_name,$mechanism_name,$datim_id,$program_name,$support_type,$period,$update,$period,$datim_id,$mfl_code,$ownership,$typeofsite,$othertypeofsite,$level,$county,$subcounty) {
		 $support_fail=array(
		 	"organization_name"=>$organization_name,
		 	"mechanism_name"=>$mechanism_name,
		 	"datim_id"=>$datim_id,
		 	"program_name"=>$program_name,
		 	"support_type"=>$support_type,
		 	"period"=>$period,
		 	"import_error"=>$update
		 );
		 $this->db->insert("attribution_support_import_errors",$support_fail);
	 }
	 public function mechanisms_support(){
		 $support=$this->db->get_where("attribution_mechanisms_programs",array("status"=>'active'))->result();
		 if (sizeof($support)>=1) {
			 return $support;
		 }
		 return "";
	 }
	 public function drop_mechanism_support($id){
		$details=array(
			"status"=>"dropped",
		);

		$this->db->where('id', $id);	
		 	
		if (!$this->db->update("attribution_mechanisms_programs", $details)) {
			return false;
		}	

		return true;		 
	 }
	 public function addnewmechanism(){

	 	$kepms_id= $this->input->post('kepms_id');
 		$datim_id= $this->input->post('datim_id');
 		$mechanisms_name = $this->input->post('mechanism_name');
 		$partner_name = $this->input->post('partner_name');
 		$end_date = $this->input->post('end_date');
 		$start_date = $this->input->post('start_date');

		//Check If The Mechanism Has An Attribution Key
		$control=sizeof($this->db->get_where("attribution_keys",array("datim_id"=>$datim_id))->result());
		if ($control==1) {

			return "Datim ID Exists";

		}elseif($control==0) {//Generate Attribution Key If Key Doesn't Exist 
			//Step1 Generate User Group
			$length=11;//Length Of UID String Generator
						
			$this->db->select_max('usergroupid');
			$group_query = $this->db->get('usergroup');
			$usergroup_id= 1+(integer)$group_query->row()->usergroupid;
		    $usergroup_uid = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
			$mechanisms_uid=$usergroup_uid;
			$usergroup=array(
				"usergroupid"=>$usergroup_id,
				"uid"=>$usergroup_uid,
				"code"=>$datim_id,
				"name"=>$partner_name,
                'created'=>date("Y-m-d"),
                'lastupdated'=>date("Y-m-d")				
			);

			if(!$this->db->insert("usergroup",$usergroup))
			{
				return "User Group";
			}

			//Step 1b Generate Usergroup Access rights
			$this->db->select_max('usergroupaccessid');
			$groupaccess_query = $this->db->get('usergroupaccess');
			$usergroupaccess_id= 1+(integer)$groupaccess_query->row()->usergroupaccessid;			
			$usergroupaccess=array(
				"usergroupaccessid"=>$usergroupaccess_id,
				"access"=>"r-------",
				"usergroupid"=>$usergroup_id			
			);			
			if(!$this->db->insert("usergroupaccess",$usergroupaccess)){
				return "User Group Access";
			}

			//Step 2 Create Option Group For The User Group
		    $categoryoption_uid = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);	
			$this->db->select_max('categoryoptionid');
			$option_query = $this->db->get('dataelementcategoryoption');
			$categoryoption_id= 1+(integer)$option_query->row()->categoryoptionid;			
			$categoryoption=array(
				"categoryoptionid"=>$categoryoption_id,
				"uid"=>$categoryoption_uid,
				"code"=>$datim_id,
				"name"=>$partner_name,
				"shortname"=>substr($partner_name,0,30),
                'created'=>date("Y-m-d"),
                'lastupdated'=>date("Y-m-d")				
			);

			if(!$this->db->insert("dataelementcategoryoption",$categoryoption)){
				return "Data Element Category Option";
			}
			//echo $this->db->last_query();

			//Step 3 Add Option To Category
			$categoryid=$this->db->get_where('dataelementcategory',array('name'=>'Mechanisms'))->row()->categoryid;
            $maxorder_results= $this->db->query("SELECT MAX(sort_order) as max FROM categories_categoryoptions WHERE categoryid=$categoryid ");
            $maxorder=$maxorder_results->row()->max;
            if(!$this->db->insert('categories_categoryoptions',array('categoryoptionid'=>$categoryoption_id,'categoryid'=>$categoryid,'sort_order'=>$maxorder+1))){
            	return "category options";
            }			

			//Step 4 create CategoryOptionCombo : Attribution Key(new generated categoryoptioncomboid)
			$optioncombo_uid=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);   
			$categoryoptioncomboid=$this->db->query('Select max(categoryoptioncomboid) as maxs from categoryoptioncombo')->row()->maxs+1;
			$combo=array(
				'categoryoptioncomboid'=>$categoryoptioncomboid,
				'uid'=>substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length),
				'created'=>date("Y-m-d"),
				'lastupdated'=>date("Y-m-d")
			);
			
			if(!$this->db->insert('categoryoptioncombo',$combo)){
				return "categoryoptioncombo";
			}

			//Step5 Add categoryoptionid and categoryoptioncomboid to categoryoptioncombos_categoryoptions
			$categoryoptioncombos_categoryoptions=array(
				'categoryoptionid'=>$categoryoption_id,
				'categoryoptioncomboid'=>$categoryoptioncomboid
			);
			if(!$this->db->insert('categoryoptioncombos_categoryoptions',$categoryoptioncombos_categoryoptions)){
				return "categoryoptioncombos_categoryoptions";
			}	

			//Step 6 Add Categoryoptioncombo and categorycomboid to categorycombos_optioncombos
			$categorycomboid=$this->db->get_where("categorycombo",array("name"=>"Mechanisms Combo"))->row()->categorycomboid;
			$categorycombos_optioncombos=array(
				'categorycomboid'=>$categorycomboid,
				'categoryoptioncomboid'=>$categoryoptioncomboid
			);
			if(!$this->db->insert('categorycombos_optioncombos',$categorycombos_optioncombos)){
				return "categorycombos_optioncombos";
			}	
		
			//Step 7 Update  attribution_keys 
			$attribution_keys=array(
				'datim_id'=>$datim_id,
				'mechanism_id'=>$kepms_id,
				'mechanism_name'=>$partner_name,
				'mechanism_uid'=>$usergroup_uid,
				'usergroup_id'=>$usergroup_id,
				'categorycombo_id'=>$categoryoptioncomboid,
				'categoryoption_id'=>$categoryoption_id,
				'mechanism_status'=>"active",
				'start_date'=>$start_date,
				'end_date'=>$end_date);	

			if(!$this->db->insert("attribution_keys",$attribution_keys)){
				return "attribution_keys";
			}

			//Step 8 : Insert Data to attribution_mechanisms	
			$mechanisms=array(
				"mechanism_name"=>$mechanisms_name,
				"datim_id"=>$datim_id,
				"mechanism_id"=>$kepms_id,
				"mechanism_uid"=>$mechanisms_uid,
				"attribution_key"=>$categoryoptioncomboid,
				"partner_name"=>$partner_name,
				'mechanism_status'=>"active",
				'start_date'=>$start_date,
				'end_date'=>$end_date,
				"created_by"=>$this->session->userdata('useruid'),
            	"date_created"=>date("d-m-Y H:m:s"));

			if(!$this->db->insert("attribution_mechanisms",$mechanisms)){
				return "attribution_mechanisms";
			}
		}

		return true;
	}

	public function update_mechanism()
	{
		$kepms_id= $this->input->post('kepms_id');
 		$datim_id= $this->input->post('datim_id');
 		$mechanism_name = $this->input->post('mechanism_name');
 		$partner_name = $this->input->post('partner_name');
 		$end_date = $this->input->post('end_date');
 		$start_date = $this->input->post('start_date');

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

		$this->db->where('code', $datim_id);	
		if (!$this->db->update("dataelementcategoryoption",$categoryoption)) {
			return "Attribution Update";
		}


		// Update user group
 		$usergroup=array(
				"name"=>$partner_name,
				'lastupdated'=>date("Y-m-d"));

		$this->db->where('code', $datim_id);	
		if (!$this->db->update("usergroup",$usergroup)) {
			return "Attribution Update";
		}

		return true;
	}

	 // fetches details of a mechanism
    public function show_mechanism_details($datim_id)
    {
       
        $start_date = "";
        $end_date = "";
        $created_by = "";
        $number_of_facilities = "";
        $number_of_facilities_dsd="";
        $number_of_facilities_ta="";
        $mechanism_name = "";
        $partner_name = "";
        $name="";

        // Mechanism info
        if ($query = $this->db->get_where('attribution_mechanisms', array('datim_id' => $datim_id))) {
            $row = $query->row();
            $mechanism_name = $row->mechanism_name;
            $start_date = $row->start_date;
            $end_date = $row->end_date;
            $created_by=$row->created_by;
        }

        // Number of DSD facilities
        $this->db->select('count(datim_id)');
        if ($query = $this->db->get_where('attribution_mechanisms_programs', array('datim_id' => $datim_id, 
        		'support_type'=>'DSD'))) {
            $number_facilities_dsd = $query->row()->count;
        }

         // Number of TA facilities
        $this->db->select('count(datim_id)');
        if ($query = $this->db->get_where('attribution_mechanisms_programs', array('datim_id' => $datim_id, 
        		'support_type'=>'TA'))) {
            $number_facilities_ta = $query->row()->count;
        }
   
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
