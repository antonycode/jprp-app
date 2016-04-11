<?php


/**
 * 
 */
class Datasets extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this->load->model('datasets_model');
        $this->load->helper('url');
	}
    
    public function index(){
        $data['datasets']=$this->datasets_model->getdatasets();
        $data['page']='datasets';
        $data['agencyname']=$this->session->userdata('groupname');
        $this->load->view('template',$data);
    }
    
}
