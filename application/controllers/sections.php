<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sections extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');     
		$this->load->model('datasets_model'); 
        $this->load->model('partner_model'); 
        $this->load->model('sections_model'); 
    }
    //Default Function Get User ID:$uid to resolve usergroupid
	public function index($uid=null){
        if($this->session->userdata('marker')!=1){
            $auth=$this->sessionmanager($uid);
            if ($auth) {
                //echo "dhis login".$this->session->userdata('marker');
                //$this->categoryoptionattribution();
                $data['page']='sections';
                //Get All The Programs from All The Datasets From Database
                $data['sections']=$this->datasets_model->datasections();
                //Get programs and the implementation partners
                $data['agencyname']=$this->session->userdata('groupname');
                $this->load->view('template',$data);                      
            }
            
        }else{
            //Skip Creating a new session Key
            $data['page']='sections';
            $data['agencyname']=$this->session->userdata('groupname');
            $data['sections']=$this->datasets_model->datasections();
            $this->load->view('template',$data);            
        }

	}


    //Customize the session fields to add marker and group value
    //Get the sessions and there roles
    public function sessionmanager($uid){
        //Get User Group ID
        $groupid= $this->partner_model->getsessionuser($uid);
        if ($groupid!="error1"&&$groupid!="error2") {

            if ($this->categoryoptionattribution($groupid)=="ok") {
                //Get User Group Agency Level
                if ($this->partner_model->groupagencylevel($groupid)==TRUE) {
                     //Get User Group Name
                    $groupname=$this->partner_model->getsessiongroupname($groupid);
                    //Get User Gender
                    $gender=$this->partner_model->gender($uid);
                    $newdata = array(
                                       'marker'  => '1',
                                       'groupid'=> $groupid,
                                       'groupname'=>$groupname,
                                       'gender'=>$gender,
                                       'logged_in' => TRUE
                                   );
                    $this->session->set_userdata($newdata);
                    return true; 
                } else {
                    $data['message']="Kindly Contact The Administrator You Have To Allocate You A Agency Level";
                    $this->load->view('error',$data);                
                }                               
            } else {
                    $data['message']=$this->categoryoptionattribution();
                    $this->load->view('error',$data);              
            } 
        } else {
            $newdata = array(
                               'marker'  => '0',
                               'groupid'     => '',
                               'logged_in' => FALSE
                           );
            $this->session->set_userdata($newdata);  
            if ($groupid=="error1") {
                $data['message']="Kindly Contact The Administrator You Have Been Allocated More Than One User Group";
            } else {
                $data['message']="Kindly Contact The Administrator You Have Not Been Allocated A User Groups";
            }
            $this->load->view('error',$data);    
        }
    }   
    
    //Get Data Set Section Elements: $secid:-Section id
	public function sectionelements($secid){
		$data['page']='programselements';
		$data['programname']=$this->datasets_model->programname($secid);
		$data['orgunits']=$this->sections_model->sectionorgunits($secid);
		$data['elements']=$this->datasets_model->datasectionselements($secid);
        $data['agencyname']=$this->session->userdata('groupname');
		$this->load->view('template',$data);
	}

    //Impelementing partner target support program $pid:partner id
    function sectionimplementation($secid){
        //Implementing Portal page
        $data['page']='ipportal';
        //Available Organization units for support
        $data['av_org']=$this->sections_model->availableorgunits($secid);
        //Implementer supported organization units
        //Parse sectionid:pid and implementing partner id:ippid
        $data['ip_org']=$this->sections_model->ipsectionorgunits($secid,$this->session->userdata('groupid'));
        $data['programname']=$this->datasets_model->programname($secid);
        $data['elements']=$this->datasets_model->datasectionselements($secid);
        $data['sectionid']=$secid;
        $data['agencyname']=$this->session->userdata('groupname');
        //print_r($this->sections_model->ipsectionorgunits($secid,$this->session->userdata('groupid')));
        //echo "string $secid";
        //die();
        $this->load->view('template',$data);        
    }
    
    //New Implementation Support Facilities 
    public function supportfacilities($secid){
        $infoarray=array();
        if (isset($_POST["data"])) {
            $data = json_decode($_POST["data"]);
            $data_array = '';
            foreach ($data as $key => $value) {
                $infoarray[]=array(
                    "orguid"=>$value->dxCode,
                    "start"=>$value->dxSDate,
                    "end"=>$value->dxEDate
                );
            } 
        }
        if (sizeof($infoarray)<=0) {
            header('Content-Type: application/x-json; charset=utf-8');          
            echo "<span class='error'>Error! You Didn't Select Any Facility. Please Try Again</span>";                
        }
        $result = $this->sections_model->attributioninfo($infoarray,$secid);         
        if ($result!=false) {
            $this->session->set_userdata('key', $result);
            $attribution=$this->sections_model->dataattribution($this->session->userdata('groupid'),$this->session->userdata('key'));
            if ($attribution==true) {
                header('Content-Type: application/x-json; charset=utf-8');          
                echo  "You Have Successfully Implemented the Program in The Facility(s) And Successfully Attributed Data For The Selected Period".$this->session->userdata('key'); 
            }else{
                header('Content-Type: application/x-json; charset=utf-8');          
                echo  "<span class='error'>$attribution</span>"; 
            }                 
        }else{
            header('Content-Type: application/x-json; charset=utf-8');          
            echo  "<span class='error'>An Error Has Occured During Attribution Process Kindly Try Again</span>"; 
        }

    }
    
    
    public function dataattribution(){
        $attribution=$this->sections_model->dataattribution($this->session->userdata('groupid'),$this->session->userdata('key'));
		
        /*if ($attribution==true) {
            header('Content-Type: application/x-json; charset=utf-8');          
            echo  "You Have Successfully Attributed Data For The Selected Facilities"; 
        }else{
            header('Content-Type: application/x-json; charset=utf-8');          
            echo  "<span class='error'>$attribution</span>"; 
        }        */
    }
    
    
    
    //Load Edit Page For Update
    public function supportedit($orgid, $secid){ 
      $data['ip_org']=$this->sections_model->getfacility($orgid);
      $data['sectionid']=$secid;
      $data['partnerid']=$this->session->userdata('groupid');
      $data['facilityid']=$orgid;
      $dates=$this->sections_model->getsecattribution($orgid, $secid);
      $data['start']=$dates['start'];
      $data['end']=$dates['end'];
      $data['page']='facilityedit';
      $data['agencyname']=$this->session->userdata('groupname');
      $this->load->view('template',$data); 
    }
    
    //Drop a facility
    public function dropfacility($orgid, $secid){
          $status = $this->sections_model->dropfacility($orgid, $secid, $this->session->userdata('groupid'));
          if ($status) {
              header('Content-Type: application/x-json; charset=utf-8');          
              echo  "You Have Successfully dropped The Facility";
          } else {
              header('Content-Type: application/x-json; charset=utf-8');          
              echo  "An Error Has Occured. Please Try Again";
          }
    }


    // Update the Start and End Date
    public function supportfacilityedit($sourceid,$secid,$start,$end){
          //Update sectionattribution table
          $status = $this->sections_model->updatefacility($sourceid,$this->session->userdata('groupid'),$secid,$start,$end);
          if ($status) {
              header('Content-Type: application/x-json; charset=utf-8');          
          echo  "Update Was Successfull";
          } else {
              header('Content-Type: application/x-json; charset=utf-8');          
          echo  "An Error Has Occured During The Update. Please Try Again";
          }

    }

    
    //Check If Implementing Partner Has Been Attributed $groupid:groupid
    public function categoryoptionattribution($groupid){
        return $this->partner_model->categoryoption($groupid);
    }
    
    public function k2d(){
        $this->session->sess_destroy();
        redirect('http://localhost:8080');
    }
    
}

