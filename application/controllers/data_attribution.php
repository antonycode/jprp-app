<?php

/**
 * 
 */
class Data_attribution extends CI_Controller{
	
	function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('dataattribution_model');
        $this->load->model('user_model');		
        $this->load->model('programs_model');		
		$this->load->model('mechanisms_model');	
	}
	public function index(){
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                $data['page'] = 'dataattribution-index';
                $data['ipsl'] = $this->dataattribution_model->attribution_mechanisms_programs();
				$data['programs'] = $this->programs_model->all_programs_list();
				$data['mechanisms'] = $this->mechanisms_model->mechanisms_list();
				$data['program_right'] = $this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'));
                $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
                $this->load->view('template', $data);
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }		
	}
	
	
	public function ipsl_attribution(){
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
            		$message=$this->dataattribution_model->global_attribution();
                    $data = array(
                    'message' => $message
                    );    
                    echo json_encode($data) ;  
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }	
	}
	
	
	public function program_attribution($prog_id){
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
            		$message=$this->dataattribution_model->program_dataattribution($prog_id);
                    $data = array(
                    'message' => $message
                    );    
                    echo json_encode($data) ;  
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }		
	}
	public function mechanism_attribution($datim_id){
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
            		$message=$this->dataattribution_model->mechanism_dataattribution($datim_id);
                    $data = array(
                    'message' => $message
                    );    
                    echo json_encode($data) ;  
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }		
	}	
}
