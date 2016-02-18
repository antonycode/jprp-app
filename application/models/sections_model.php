<?php


/**
 * 
 */
 
 /**
  * 
  */
 class Sections_model extends CI_Model {
     
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
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
