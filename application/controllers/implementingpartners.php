<?php


/**
 * 
 */
class Implementingpartners extends CI_Controller {
	
    function __construct() {
        parent::__construct();
        $this->load->helper('url');     
        $this->load->model('categories'); 
        $this->load->model('partner_model');
    }
    
    public function index(){
        $data['page']='partners';
        $data['partners']=$this->categories->dataelementcategoryoption();
        $data['agencyname']=$this->session->userdata('groupname');
        $this->load->view('template',$data);        
    }
    
    
    public function agencymanagement(){
        $data['page']='agencies';
        $data['agency']=$this->partner_model->getagencies();
        $data['partners']=$this->categories->dataelementcategoryoption();
        $data['agencyname']=$this->session->userdata('groupname');
        $this->load->view('template',$data);          
    }
}
