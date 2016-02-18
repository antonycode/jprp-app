<?php


/**
 * 
 */
class Agencies extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('partner_model');
    }
    
    public function index(){
        $data['page']='agencies';
        $data['agency']=$this->partner_model->getagencies();
      //  $data['partners']=$this->categories->dataelementcategoryoption();
        $data['levels']=$this->partner_model->getlevels();
        $data['agencyname']=$this->session->userdata('groupname');
        $this->load->view('template',$data);        
    }
    
    //Edit Agency Details $groupid:User Group ID
    public function agencyedit($groupid){
        $data['page']='agencyedit';
        $data['agency']=$this->partner_model->agencydetails($groupid);
        $data['agencyid']=$groupid;
        $data['levels']=$this->partner_model->getlevels();
      //  $data['partners']=$this->categories->dataelementcategoryoption();
        $data['agencyname']=$this->session->userdata('groupname');
        $this->load->view('template',$data);          
    }
    
    //Update The Agency Details $agencyid: User Group ID
    public function agencyupdate(){
        $level=$this->input->post('levelid');
        $parent=$this->input->post('parentid');
        $agencyid = $this->input->post('agencyid');
        $result = $this->partner_model->agencyupdate($agencyid,$level,$parent);
        if($result){
            header('Content-Type: application/x-json; charset=utf-8');          
            echo  "Successfully Updated User Group";
        }
        else{
            header('Content-Type: application/x-json; charset=utf-8');          
            echo "<span class='error'>An Error Has Occured. Please Try Again</span>";
        }
    }
    
    //Return Level Parents
    public function getparent($levelid){
        $levelparent=$this->partner_model->getlevelparent($levelid);
        $parents=$this->partner_model->parentagencies($levelparent);
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($parents));        
    }
    

}
