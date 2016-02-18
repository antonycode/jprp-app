<?php


/**
 * 
 */
 
 /**
  * 
  */
 class Programs_model extends CI_Model {
     
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
    }  
	
	public function all_programs_list(){
		$programs=$this->db->get_where("attribution_programs",array("program_status"=>"active"));
		if (sizeof($programs->result())>=1) {
			return $programs->result();
		} else {
			return "";
		}
		
	}
	
	public function program_info($programid){
		$info=$this->db->get_where("attribution_programs",array("program_id"=>$programid));
		if (sizeof($info->result())==1) {
			return $info->row();
		} else {
			return "";
		}
	}
	public function get_program_dataelements($programid){
		$members=$this->db->get_where("attribution_programs_dataelements",array("program_id"=>$programid));
		if (sizeof($members->result())>=1) {
			return $members->result();
		} else {
			return "";
		}
	}	
	
	public function get_available_elements($programid){
		$query="SELECT dataelementid, uid, name, shortname, description FROM   dataelement WHERE  uid NOT IN (SELECT dataelement_uid FROM attribution_programs_dataelements where program_id=$programid)";
		$available=$this->db->query($query);
		if (sizeof($available->result())>=1) {
			return $available->result();
		} else {
			return "";
		}		
	}
	
	public function get_dataelements(){
		$this->db->select('dataelementid, uid, name, shortname, description');
		$this->db->from('dataelement');
		$query=$this->db->get();
		if (sizeof($query->result())>=1) {
			return $query->result();
		} else {
			return "";
		}
		
	}


	
	
	public function newprogram(){
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $program_uid = '';
	    for ($i = 0; $i < 14; $i++) {
	        $program_uid .= $characters[rand(0, $charactersLength - 1)];
		};
		$details=array(
			"uid"=>$program_uid,
			"program_name"=>$this->input->post("pname"),
			"program_shortname"=>$this->input->post("sname"),
			"program_description"=>$this->input->post("pdescription"),
			"program_status"=>"active",
            "created_by"=>$this->session->userdata('useruid'),
            "date_created"=>date("d-m-Y H:m:s")
		);
		if (!$this->db->insert("attribution_programs",$details)) {
			return "program Creation";
		}		
		$programid=$this->db->get_where("attribution_programs",array('uid'=>$program_uid))->row()->program_id;
		foreach ($this->input->post("dataelements") as $datauid) {
			$elementinfo=$this->db->get_where("dataelement",array("uid"=>$datauid));
			$element=$elementinfo->row();
			$elementdets=array(
				"program_id"=>$programid,
				"dataelement_name"=>$element->name,
				"dataelement_uid"=>$datauid,
				"dataelement_id"=>$element->dataelementid,
				"dataelement_description"=>$element->description,
				"dataelement_code"=>$element->code
			);
			if (!$this->db->insert("attribution_programs_dataelements",$elementdets)) {
				return "Program Members Update";
			}
			
		}		
		return true;
	}
	
	public function update_program($program_id){

		$details=array(
			"program_name"=>$this->input->post("pname"),
			"program_shortname"=>$this->input->post("sname"),
			"program_description"=>$this->input->post("pdescription")
		);


		$this->db->where('program_id', $program_id);	
		if (!$this->db->update("attribution_programs",$details)) {
			return "Program Update";
		}


        $dataelements=$this->input->post("dataelements");

        if($dataelements!=false){

            if (!$this->db->delete('attribution_programs_dataelements', array('program_id' => $program_id))) {
                return "Deleting Program Members";
            }

            foreach ($dataelements as $datauid) {
                $elementinfo=$this->db->get_where("dataelement",array("uid"=>$datauid));
                $element=$elementinfo->row();
                $elementdets=array(
                    "program_id"=>$program_id,
                    "dataelement_name"=>$element->name,
                    "dataelement_uid"=>$datauid,
                    "dataelement_id"=>$element->dataelementid,
                    "dataelement_description"=>$element->description,
                    "dataelement_code"=>$element->code,
                    "created_by"=>$this->session->userdata('useruid'),
                    "date_created"=>date("d-m-Y H:m:s")
                );
                if (!$this->db->insert("attribution_programs_dataelements",$elementdets)) {
                    return "Program Members Update";
                }

            }
        }
        else{
            return "No Dataelements supplied";
        }


		return true;
	}


    public function create_program_dataelements_archive($program_id)
    {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $archive_id = '';
        for ($i = 0; $i < 14; $i++) {
            $archive_id .= $characters[rand(0, $charactersLength - 1)];
        };

        $details = array(
            "program_name" => $this->input->post("pname"),
            "program_shortname" => $this->input->post("sname"),
            "program_description" => $this->input->post("pdescription"),
        );

        if($details['program_name']!="" && $details['program_shortname']!="")
        {
            $this->db->where('program_id', $program_id);
            if (!$this->db->update("attribution_programs", $details)) {
                return "Program Update";
            }
        }
        else{

            return "Program Name and Shortname Can't be Null";
        }

        // Calculating start date and end date of the archive
        $start_date = false;
        if ($this->input->post("start_date")) {
            $start_date = $this->input->post("start_date");

        }

        if ($start_date === false) {
            $this->db->order_by('archive_start_date', 'desc');
            $query = $this->db->get_where('attribution_programs_dataelements_archive', array('program_id' => $program_id));

            if ($query->num_rows() > 0) {
                $row = $query->row();
                $start_date = $row->archive_end_date;
            }

        }

        $end_date = date("Y-m-d");

        $dataelements = $this->input->post("dataelements");

        if ($dataelements != false) {

            $program_dataelements = null;
            $members = $this->db->get_where("attribution_programs_dataelements", array("program_id" => $program_id));
            if (sizeof($members->result()) >= 1) {
                $program_dataelements = $members->result();

                foreach ($program_dataelements as $archive_element) {

                    $elementdets = array(
                        "program_id" => $program_id,
                        "dataelement_name" => $archive_element->dataelement_name,
                        "dataelement_uid" => $archive_element->dataelement_uid,
                        "dataelement_description" => $archive_element->dataelement_description,
                        "dataelement_code"=>$archive_element->dataelement_code,
                        "dataelement_id"=>$element->dataelementid,
                        "archive_id" => $archive_id,
                        "archive_start_date" => $start_date,
                        "archive_end_date" => $end_date,
                        "created_by"=>$this->session->userdata('useruid'),
                        "date_created"=>date("d-m-Y H:m:s")

                    );

                    if (!$this->db->insert("attribution_programs_dataelements_archive", $elementdets)) {
                        return "Program datalements archived";
                    }
                }


            }

            if (!$this->db->delete('attribution_programs_dataelements', array('program_id' => $program_id))) {
                return "Deleting program Data Elements";
            }

            foreach ($dataelements as $datauid) {

                $elementinfo = $this->db->get_where("dataelement", array("uid" => $datauid));
                $element = $elementinfo->row();
                $elementdets = array(
                    "program_id" => $program_id,
                    "dataelement_name" => $element->name,
                    "dataelement_uid" => $datauid,
                    "dataelement_description" => $element->description,
                    "dataelement_code"=>$element->code
                );

                if (!$this->db->insert("attribution_programs_dataelements", $elementdets)) {
                    return "Program Members Update";
                }

            }

        
        }else {
            return "No Dataelements supplied";
        }

        return true;
    }

    public function check_change_in_program_dataelements($program_id)
    {
        $program_dataelements = null;
        $members = $this->db->get_where("attribution_programs_dataelements", array("program_id" => $program_id));
        if (sizeof($members->result()) >= 1) {
            $program_dataelements = $members->result_array();
        } else {
            return TRUE;
        }

        $dataelements = $this->input->post("dataelements");

        if ($dataelements != false) {

            foreach ($dataelements as $datauid) {

                $key = array_search($datauid, array_column($program_dataelements, 'dataelement_uid'), true);

                if ($key === FALSE) {
                    return FALSE;
                    break;
                }
            }

            foreach ($program_dataelements as $dataelement_row) {

                $key = array_search($dataelement_row['dataelement_uid'], $dataelements, true);

                if ($key === FALSE) {

                    return FALSE;
                    break;
                }
            }
        }
        return true;
    }

    public function check_program_exists_archive($program_id)
    {

        $members = $this->db->get_where("attribution_programs_dataelements_archive", array("program_id" => $program_id));
        if (sizeof($members->result()) >= 1) {
            return true;
        } else {
            return false;
        }

    }



    // fetches details of a program
    public function show_program_details($program_id)
    {
        $number_dataelements = 0;
        $number_archives = 0;
        $program_startdate = "";
        $program_created_by = "";
        $program_name = "";
        $program_shortname = "";
        $program_description = "";

        // Number of archives
        $this->db->select('count(DISTINCT archive_id)');
        $query = $this->db->get_where('attribution_programs_dataelements_archive', array('program_id' => $program_id));

        if ($query) {
            $number_archives = $query->row()->count;
        }

        // Number of Data Elements
        $this->db->select('count(program_id)');
        $query = $this->db->get_where('attribution_programs_dataelements', array('program_id' => $program_id));

        if ($query) {
            $number_dataelements = $query->row()->count;
        }

        // Program Name, Description and Shortname
        $this->db->select('program_shortname, program_name, program_description');
        $query = $this->db->get_where('attribution_programs', array('program_id' => $program_id));
        if ($query) {
            $row = $query->row();
            $program_name = $row->program_name;
            $program_shortname = $row->program_shortname;
            $program_description = $row->program_description;
        }


        $data = array('number_dataelements' => $number_dataelements,
            'number_archives' => $number_archives,
            'program_name' => $program_name,
            'program_shortname' => $program_shortname,
            'program_description' => $program_description);

        return $data;
    }
	 
	 public function deleteprogram($program_id){
		$details=array(
			"program_status"=>"dropped",
		);
		$this->db->where('program_id', $program_id);	
		 	
		if (!$this->db->update("attribution_programs",$details)) {
			return false;
		}	

		return true;					 
	 }
	 
	 
// Steve: Function to ge the datasets & datasetmembers
     public function get_datasets(){
         $this->db->select('datasetid, name');
         $this->db->from('dataset');
         $query=$this->db->get();
         if (sizeof($query->result())>=1) {
             return $query->result();
         } else {
             return "";
         }

     }

    public function get_datasetmembers(){
        $this->db->select('dataelementid, datasetid');
        $this->db->from('datasetmembers');
        $query=$this->db->get();
        if (sizeof($query->result())>=1) {
            return $query->result();
        } else {
            return "";
        }

    }	 
	 
	 
	 
	 
	 
    //Get User Group Name 
    public function usergroupname($groupid){
            return $this->db->get_where('usergroup',array('usergroupid'=>$groupid))->row()->name;
    }
    
    
    //Get Users User Group
    public function getusergroup($id){
        //Get Which Group A Partner Has Been Assigned To
        $member=$this->db->get_where('usergroupmembers',array('userid'=>$id));
        if ($member->num_rows()==0) {
            echo "Kindly Contact The Portal Administrator To Allocate You To A User Group";
        } elseif ($member->num_rows()>1) {
            $temp="";
            foreach ($member->result() as $row) {
                $temp=$temp.','.$this->getusergroupname($row->usergroupid).'&nbsp';
            }
            return "You Have Been Alocate More Than One User Group. The Groups Are $temp. Kindly Contact The Portal Administrator To Resolve This Issue";
        }elseif($member->num_rows()==1){
            return $member->row()->usergroupid;
        }else{
            return false;
        }
    }    
    
    
    public function sectionorgunits($id) {
        $data='';
        $units=$this->db->get_where('sectionattribution',array('sectionid'=>$id));
        if ($units->num_rows() > 0) {
            foreach ($units->result() as $row) {
                $data[]=$row;            
            }                 
        }
       return $data;
    }
    
    public function availableorgunits($secid){
        //Get all Orgunits where Section Has Been Implemented
        $attributedorgunits=$this->db->get_where('sectionattribution',array('sectionid'=>$secid));
        $attorgs=array();
        foreach ($attributedorgunits->result() as $row ) {
            $attorgs[]=$row->sourceid;
        }
        //Get All Orgunits In Dhis2. Skip Root Parent 
        $dhisparent='';
        $dhisid='';
        foreach ($this->db->get('organisationunit')->result() as $row) {
            $dhisid[]=$row->organisationunitid;
            $dhisparent[]=$row->parentid;
        } 
        
        //dhis2 orgunits
        $dhisarray=array_diff($dhisid, $dhisparent);
        
        //Available Orgunits for implementation of the section
        $av_orgs=array_diff($dhisarray,$attorgs);
        $available='';
        foreach ($av_orgs as $av) {
           $orgname=$this->db->get_where('organisationunit',array('organisationunitid'=>$av))->row()->name;
            $available[]=(object)array('orgunitid'=>$av,'name'=>$orgname);
        }
        return $available;
    }


    //$ipid:- Implementing GroupID:$groupid:user group id
    public function ipsectionorgunits($sectionid,$groupid){
            $iporgs='';
            //Get all facilities where implementing partner implements the section
            $orgs=$this->db->get_where('sectionattribution',array('sectionid'=>$sectionid,'partnergroupid'=>$groupid));
            foreach ($orgs->result() as $row) {
                $iporgs[]=$row;
            }
            return $iporgs;            
    }
    
    public function getfacility($orgid){
        $facility=$this->db->get_where('organisationunit',array('organisationunitid'=>$orgid))->row()->name;
        return $facility;
    }
    
    
    //Enter new support facility to the sectionattributtion table: $groupid: partner ID
    public function newfacility($id,$secid,$start,$end,$groupid) {
            $groupname=$this->usergroupname($groupid);
            $faciltyname=$this->getfacility($id);
            $array=array('sourceid'=>$id,'sectionid'=>$secid,'startdate'=>$start,'enddate'=>$end,'ipname'=>$groupname,'partnergroupid'=>$groupid,'sourcename'=>$faciltyname);
            return $this->db->insert('sectionattribution',$array);            
    }
    // updatefacility function to update sectionattribution 
    public function updatefacility($fid,$groupid,$scid,$supportstart,$supportend){
        $array=array('startdate'=>$supportstart,'enddate'=>$supportend);
        $wherearray = array(
            'sourceid'=>$fid,
            'sectionid'=>$scid,
            'partnergroupid'=>$groupid
        ); 
        $this->db->where($wherearray); 
        return $this->db->update('sectionattribution',$array);
    }

    // Drop IP Facility 
    public function dropfacility($orgid, $sid, $groupid){
         $wherearray = array(
            'sourceid'=>$orgid,
            'sectionid'=>$sid,
            'partnergroupid'=>$groupid
        ); 
        $this->db->where($wherearray);
        return $this->db->delete('sectionattribution');
    }
    
    //Get section Attribution Data
    public function getsecattribution($orgid,$secid){
        $dates='';
        $data=$this->db->get_where('sectionattribution',array('sourceid'=>$orgid,'sectionid'=>$secid));
        foreach ($data->result() as $row) {
            $dates['start']=$row->startdate;
            $dates['end']=$row->enddate;
        }
        return $dates;
    }
    

    //New Attribution Info Function
    public function attributioninfo($sourceidarray,$secid){
        //step 1: get facilities array => $sourceidarray
        //step 2: get usergroupid
        if ($secid!=""&&sizeof($sourceidarray)!=0) {
            $usergroupid = $this->db->get_where('usergroup',array('usergroupid'=>$this->session->userdata('groupid')))->row()->usergroupid;
            $usergroupname = $this->db->get_where('usergroup',array('usergroupid'=>$this->session->userdata('groupid')))->row()->name;
            $key=1+$this->db->query('Select max(attributionkey) as maxs from sectionattribution')->row()->maxs;
            
            foreach ($sourceidarray as $row) {
                $sourcename=$this->db->get_where('organisationunit',array('organisationunitid'=>$row['orguid']))->row()->name;
                $data=array(
                    'sourceid'=>$row['orguid'],
                    'sectionid'=>$secid,
                    'partnergroupid'=>$usergroupid,
                    'ipname'=>$usergroupname,
                    'startdate'=>str_replace('/', '-', $row['start']),
                    'enddate'=>str_replace('/', '-', $row['end']),
                    'sourcename'=>$sourcename,
                    'attributionkey'=>$key
                    );
                $this->db->insert("sectionattribution",$data);
            }
            return $key;          
        } else {
            return false;
        }
    }

    
    /*
    public function attributioninfo($sourceidarray,$secid,$supportstart,$supportend){
        //step 1: get facilities array => $sourceidarray
        //step 2: get usergroupid
        if ($secid!=""&&$supportstart!=''&&$supportend!=''&&sizeof($sourceidarray)!=0) {
            $usergroupid = $this->db->get_where('usergroup',array('usergroupid'=>$this->session->userdata('groupid')))->row()->usergroupid;
            $usergroupname = $this->db->get_where('usergroup',array('usergroupid'=>$this->session->userdata('groupid')))->row()->name;
            $key=1+$this->db->query('Select max(attributionkey) as maxs from sectionattribution')->row()->maxs;
            foreach ($sourceidarray as $row) {
                $sourcename=$this->db->get_where('organisationunit',array('organisationunitid'=>$row))->row()->name;
                $data=array(
                    'sourceid'=>$row,
                    'sectionid'=>$secid,
                    'partnergroupid'=>$usergroupid,
                    'ipname'=>$usergroupname,
                    'startdate'=>$supportstart,
                    'enddate'=>$supportend,
                    'sourcename'=>$sourcename,
                    'attributionkey'=>$key
                    );
                $this->db->insert("sectionattribution",$data);
            }
            return $key;          
        } else {
            return false;
        }
    }*/



    public function dataattribution($groupid,$key){
        $attinfo=$this->db->get_where('sectionattribution',array('partnergroupid'=>$groupid,'attributionkey'=>$key));
        if ($attinfo->num_rows()>=1) {
            $attributeoptionid = $this->db->get_where('partneroptionattribution',array('partnergroupid'=>$groupid))->row()->categoryoptioncomboid;
            $secid=$attinfo->row()->sectionid;
            foreach ($attinfo->result() as $row) {
                $orgunits[]=$row->sourceid;
            }
			$monthly=$this->db->get_where('periodtype',array('name'=>'Monthly'))->row()->periodtypeid;
            $dates = array('startdate >=' => $attinfo->row()->startdate, 'enddate <=' => $attinfo->row()->enddate,'periodtypeid'=>$monthly);
            $query = $this->db->get_where('period', $dates); 
            $periodid = '';
            if ($query->num_rows()>0) {
                foreach ($query->result() as $row) {
                    $periodid[] = $row->periodid; 
                }             
            } else {
              //$periodid = 'empty';  
              return "An Error Occurred During The Data Attribution Process. No Valid Period Was Identfied Kindly Contact The Admin";
            }   
			print_r($periodid);
			echo "</br> start ".$attinfo->row()->startdate." </br>";
			echo "</br> start ".$attinfo->row()->enddate." $attributeoptionid </br>";
            $query="Select a.dataelementid as dateid from dataelement a, sectiondataelements b where b.sectionid=$secid and a.dataelementid=b.dataelementid";
            $elements=$this->db->query($query);           
            //loop on dataelements
            foreach ($elements->result() as $row) {
                //loop on facilities
                foreach ($orgunits as $value){
                    //loop on periods
                    if ($periodid!='empty') {
                        foreach ($periodid as $value1){
                            $array2 = array('dataelementid'=>$row->dateid,'periodid'=>$value1,'sourceid'=>$value,'attributeoptioncomboid'=>$attributeoptionid);
                            $where = array('dataelementid'=>$row->dateid,'periodid'=>$value1,'sourceid'=>$value);
                            $this->db->where($where); 
                            $result = $this->db->update('datavalue',$array2);
                            //$this->newfacility($value,$secid,$supportstart,$supportend,$this->session->userdata('groupid'));
                        }                    
                    } else {
                        return false;
                    }
                    
    
                }
            }            
            return true;
        } else {
            return "An Error Occured During the Data Attribution Process You Do Not Have A Valid Attribution Key Kindly Drop All Selected Facilities And Attribute Again";
        }
        
    }
    
    
    
    
    
    
    
    
    
    
    
    public function attributevalues($sourceidarray,$secid,$supportstart,$supportend,$facilities){
        //step 1: get facilities array => $sourceidarray
        //step 2: get usergroupid
        $usergroupid = $this->db->get_where('usergroup',array('usergroupid'=>$this->session->userdata('groupid')))->row()->usergroupid;
        //step 3: get attributeoptionid
        $attributeoptionid = $this->db->get_where('partneroptionattribution',array('partnergroupid'=>$usergroupid))->row()->categoryoptioncomboid;
        //step 4: get date array 
        $array = array('startdate >=' => $supportstart, 'enddate <=' => $supportend,'periodtypeid'=>'5');
        $query = $this->db->get_where('period', $array); 
        $periodid = '';
        if ($query->num_rows()>0) {
            foreach ($query->result() as $row) {
                $periodid[] = $row->periodid; 
            }             
        } else {
          $periodid = 'empty';  
        }
        

        //step 5: get datalements array using sectionid
        $dataelements = '';
        $query="Select a.dataelementid as id from dataelement a, sectiondataelements b where b.sectionid=$secid and a.dataelementid=b.dataelementid";
        $elements=$this->db->query($query);
        //loop on dataelements
        foreach ($elements->result() as $row) {
            $dataelements[]=$row->id;
            //loop on facilities
            foreach ($sourceidarray as $value){
                //loop on periods
                if ($periodid!='empty') {
                    foreach ($periodid as $value1){
                        $array2 = array('dataelementid'=>$row->id,'periodid'=>$value1,'sourceid'=>$value,'attributeoptioncomboid'=>$attributeoptionid);
                        $where = array('dataelementid'=>$row->id,'periodid'=>$value1,'sourceid'=>$value);
                        $this->db->where($where); 
                        $result = $this->db->update('datavalue',$array2);
                        $this->newfacility($value,$secid,$supportstart,$supportend,$this->session->userdata('groupid'));
                    }                    
                } else {
                    return true;
                }
                

            }
        }
        return $result;  
    }


}
