<?php


/**
 * 
 */
class Partner_model extends CI_Model {
	
    function __construct() {
            parent:: __construct();
    $this->load->database();
    }
    //Get session groupid
    public function getsessionuser($uid){
        $userid=$this->db->get_where('userinfo',array('uid'=>$uid));
        if ($userid->result()) {
            $sessiongroupid=$this->db->get_where('usergroupmembers',array('userid'=>$userid->row()->userinfoid));
            if ($sessiongroupid->num_rows()==1) {
               return $sessiongroupid->row()->usergroupid;
            }elseif ($sessiongroupid->num_rows()>1) {
                //Error 1 "Kindly Contact The Administrator You Have Been Allocated More Than One User Group";
                return "error1";
            }elseif($sessiongroupid->num_rows()<1){
                //Error 2 "Kindly Contact The Administrator You Have Not Been Allocated A User Group";
                return "error2";               
            }
        } else {
            return "error2";  
        }
    }
	public function get_userrole($uid){
		$user=$this->db->get_where("userinfo",array("uid"=>$uid));
		if (sizeof($user->result()==1)) {
			return $user->row();
		}
		return "false";
	}
	
    //Get session group id name
    public function getsessiongroupname($groupid){
        $sessionname=$this->db->get_where('usergroup',array('usergroupid'=>$groupid));
        if ($sessionname->result()) {
            return $sessionname->row();
        } else {
            return "gender_male";
        }        
    }
  
    
    //get gender for avatar change
    public function gender($uid){
        $gender=$this->db->get_where('userinfo',array('uid'=>$uid));
        if ($gender->result()) {
            return $gender->row();
        } else {
            return 'm';
        }
        
    }
    
    
    //
    public function agencyleveldetails($levelid) {
        return $this->db->get_where('k2d_agency_levels',array('agencylevelid'=>$levelid));
    }
    
    //Get Agency Detail For Update $gid: User Group ID   
    public function agencydetails($gid){
       return $this->db->get_where('usergroup',array('usergroupid'=>$gid));
    }
    
    //Get All dhis2 User Groups As agencies
    public function getagencies(){
        $agencies='';
        foreach ($this->db->get('usergroup')->result() as $row) {
            $agencies[]=$row;
        }
        return $agencies;
    }
    
    //Agency Details Update Table User Groups
    public function agencyupdate($agencyid,$level,$parent){
        $name=$this->agencyleveldetails($level)->row()->levelname;
        $data = array(
                       'agencylevelid' => $level,
                       'agencylevelname' => $name,
                       'agencylevelparentid' => $parent
                    );
        
        $this->db->where('usergroupid', $agencyid);
        $this->db->update('usergroup', $data);         
    }
    
    //Get Agency Levels
    public function getlevels(){
        $levels='';            
        $this -> db -> select('agencylevelid, levelname');
        $query=$this->db->get('k2d_agency_levels');
        if ($query->result()) {
            foreach ($query->result() as $row) {
                $levels[$row->agencylevelid]=$row->levelname;
            }
            return $levels;
        } else {
            return false;
        }
    }
    
    
    //Get Level Parent
    public function getlevelparent($levelid){
        return $this->db->get_where('k2d_agency_levels',array('agencylevelid'=>$levelid))->row()->levelparent;
    }
    
    
    //Get Level Parent Agencies From User Group Tables
    public function parentagencies($parentid){
        $parent='';
        $query=$this->db->get_where('usergroup',array('agencylevelid'=>$parentid));
        if ($query->result()) {
            foreach ($query->result() as $row) {
                $parent[$row->usergroupid]=$row->name;
            }
            return $parent;
        } else {
            return false;
        }
        
    }
        function get_countries() {
         $this -> db -> select('id, country_name');
         $query = $this -> db -> get('countries');
         
        $countries = array();
         
        if ($query -> result()) {
         foreach ($query->result() as $country) {
         $countries[$country -> id] = $country -> country_name;
         }
         return $countries;
         } else {
         return FALSE;
         }
         }
       
    
    //Get User Group Name For Error Message
    public function getusergroupname($gid){
        return $this->db->get_where('usergroup',array('usergroupid'=>$gid))->row()->name;
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
    
    //Get User Group Access Id For Category Option $gid:User Group Id
    


    public function useraccessid($gid){
         $access=$this->db->query("SELECT a.usergroupaccessid as accessid FROM usergroupaccess a, dataelementcategoryoptionusergroupaccesses b WHERE a.usergroupaccessid=b.usergroupaccessid AND a.usergroupid=$gid");
         //echo $access->num_rows();
         if ($access->num_rows()==1) {
             return $access->row()->accessid;
         }elseif($access->num_rows()>1) {
             //Resolve That One Partner Has Been Allocated More Than One Category Option
            return "multiple";
        } elseif($access->num_rows()==0){
            return "none";
        }
        
    }
    
    
    
    
    
    //Get User Name  
    public function getusername($pid){
        return $this->db->get_where('users',array('userid'=>$pid))->row()->username;
    }
    
    //Check If Name Exists
    public function verifyname($username){
       // echo $username; 
       $name=$this->db->get_where('dataelementcategoryoption',array('name'=>$username));
       if($name->num_rows()==1){
           return $name->row()->categoryoptionid;
       }else{
           return false;
       }
        //return $this->db->get_where('dataelementcategoryoption',array('name'=>$username))->row()->categoryoptionid;
       // die();
    }  
	
	//Here 
    //Add Partner Categoryoption to Category 
    public function addtocategory($catid){
        $categoryid=$this->db->get_where('dataelementcategory',array('name'=>'implementing partners'))->row()->categoryid;
        $exists=$this->db->get_where('categories_categoryoptions',array('categoryid'=>$categoryid,'categoryoptionid'=>$catid));
        if ($exists->num_rows()==0) {
            echo "strings";
            //Max sort_order value for the category
            $maxorder= $this->db->query("SELECT MAX(sort_order) as max FROM categories_categoryoptions WHERE categoryid=$categoryid ")->row()->max;
            return $this->db->insert('categories_categoryoptions',array('categoryoptionid'=>$catid,'categoryid'=>$categoryid,'sort_order'=>$maxorder+1));
        }elseif($exists->num_rows()>0){
            echo "Category Options has been attributed";
        }
    }
    //Create categoryoptioncombo
    public function categoryoptioncombo(){
        $length = 11;
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);         
        $comboid=$this->db->query('Select max(categoryoptioncomboid) as maxs from categoryoptioncombo');
        if ($comboid->num_rows()==1) {            
            $catcombo=$this->db->insert('categoryoptioncombo',array('categoryoptioncomboid'=>$comboid->row()->maxs+1,'uid'=>$randomString,'created'=>date("Y-m-d"),'lastupdated'=>date("Y-m-d"),));         
            return $comboid->row()->maxs+1;
        }else{
            $catcombo=$this->db->insert('categoryoptioncombo',array('categoryoptioncomboid'=>1,'uid'=>$randomString,'created'=>date("Y-m-d"),'lastupdated'=>date("Y-m-d"),));                    
            return 1;
        }

    }
    
    // Add Partner option to categoryoptioncombos_categoryoptions
    public function combocategoryoptions($optid){
        $catoptcomboid=$this->categoryoptioncombo();
        $this->db->insert('categoryoptioncombos_categoryoptions',array('categoryoptionid'=>$optid,'categoryoptioncomboid'=>$catoptcomboid));
        return $catoptcomboid;
    }
    
    //Associate categoryoptioncomboid with Category Combo Default category combo is: partner  table categorycombos_optioncombos
    public function catcombocats($optid){
        $catoptcomboid=$this->combocategoryoptions($optid);
        //Check if Combo partner exixts
        $partner=$this->db->get_where('categorycombo',array('name'=>'implementing partners'));
        if ($partner->num_rows()==1) {
            $this->db->insert('categorycombos_optioncombos',array('categoryoptioncomboid'=>$catoptcomboid,'categorycomboid'=>$partner->row()->categorycomboid));
        } else {
            echo 'No partner Category Combination. Contact Portal Administrator To Resolve Issue And Try Again';
        }
        return $catoptcomboid;
    }
    
    
    //Associate categoryoptioncomboid $catoptcomboid with partner $pid table:partneroptionattribution
    public function partneroptattribution($optid,$groupid){
        echo "partneroptattr called   $optid";
        $catoptcomboid=$this->catcombocats($optid);
        //Check if categoryoptioncomboid is valid or error message
        if (intval($catoptcomboid)) {
            echo "func finished";
           return $this->db->insert('partneroptionattribution',array('partnergroupid'=>$groupid,'categoryoptioncomboid'=>$catoptcomboid,'partnercatoptionid'=>$optid));
        }else{
            echo "partner failed";
            return $catoptcomboid;
        }
        
    }
        
    
    
    
      
    //Create New Groupaccess $pid: partnerid
    public function newgroupaccess($group){
        //get the latest usergroupaccessid
        $this->db->select_max('usergroupaccessid');
        $maxid = $this->db->get('usergroupaccess')->row()->usergroupaccessid;
       //Insert new access with read and edit
        $this->db->insert('usergroupaccess', array('usergroupaccessid'=>$maxid+1,'usergroupid'=>$group,'access'=>'rw------'));   
       //Create New Category Option
       //Get max categoryoptionid 
        $this->db->select_max('categoryoptionid');
        $maxcatid = $this->db->get('dataelementcategoryoption')->row()->categoryoptionid; 
        $length = 11;
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);   
        
        //New Category Option Name
        $optionname=$this->getusergroupname($group);          
        
        //Check If Name Exists in the dataelementcategoryoption table
        $categoryoptionid = $this->verifyname($optionname);
        
        //If Name Exists Update The dataelementcategoryoptionusergroupaccesses with the existing categoryoptionid 
        //If Name Does not Exists Do Below  
        if ($categoryoptionid != '') {
            echo "worked";
             $this->db->insert('dataelementcategoryoptionusergroupaccesses',array('categoryoptionid'=>$categoryoptionid,'usergroupaccessid'=>$maxid+1));
             $this->addtocategory($categoryoptionid); 
             echo "Added.";
             //Get and Add categoryoptioncomboid  Partner 
             $this->partneroptattribution($categoryoptionid,$group);
             echo "Finished";
        }else {
            echo'here';      
            $option=array(
                'categoryoptionid'=>$maxcatid+1,
                'uid'=>$randomString,
                'name'=>$optionname,
                'created'=>date("Y-m-d"),
                'lastupdated'=>date("Y-m-d"),
                'publicaccess'=>'--------'
            
            ); 
            $this->db->insert('dataelementcategoryoption',$option);   
       
            //Update the dataelementcategoryoptionusergroupaccesses table
            $this->db->insert('dataelementcategoryoptionusergroupaccesses',array('categoryoptionid'=>$maxcatid+1,'usergroupaccessid'=>$maxid+1));            
       
             $this->addtocategory($maxcatid+1); 
             //Get and Add categoryoptioncomboid  Partner 
             $this->partneroptattribution($maxcatid+1,$group);        
       
        }

        //Add the Categoryoption to categoryoptioncombos_categoryoptions table
             
    }
    
    
    //Get Implementing Partner Category Option :$pid:userid
    public function categoryoption($group){
        if($group!=0){
            //Check If User Has Been Allocated A Category Opiton                
            //echo $group;
            $access=$this->useraccessid($group);  
            //User has not been allocated an attribution id 
            if($access=='none'){
                echo "none";
                //Create new usergroup access and dataemente
                 $this->newgroupaccess($group);
                 return "ok";
            //User has been allocted multiple attribution ids
            }elseif($access=='multiple'){
                //Error occured
                return "You have been allocated multiple attribution ID's. Kindly Contact Admin to resolve this issue";
             //User has been allocated one attribution id   
            }else{
                return "ok";
                //Return Success To Be Able To Login
               // echo "done";
            }
            
        }else{
            return "You have not been allocated a User Group. Kindly Contact Admin to resolve this issue";
        };
    }

    public function groupagencylevel($groupid){
        $level=$this->db->get_where('usergroup',array('usergroupid'=>$groupid))->row()->agencylevelid;
        if ($level!='') {
            return true;
        } else {
        	//original was false
            return true;
        }
    }



    //    Get UserName
    public function get_username($uid){
        $user=$this->db->get_where("userinfo",array("uid"=>$uid));
        if (sizeof($user->result()==1)) {
            $user_id=$user->row()->userinfoid;

            $user_query=$this->db->get_where('users',array('userid'=>$user_id));
            if(sizeof($user_query->result())==1){
                return $user_query->row()->username;
            }

        }
        return false;
    }

}
