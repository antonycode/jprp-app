<?php


/**
 * 
 */
class Moh_manager extends CI_Controller {
	
	function __construct() {
		parent:: __construct();
        $this->load->helper('url');  
		$this->load->model('moh_model');  	
		$this->load->model('mechanisms_model'); 
		$this->load->model('programs_model');	
		$this->load->model('user_model'); 
	}
	public function index($errors=null){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Create Programs
        	if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
        		$data["dplist"]=$this->moh_model->development_list();
				$data['program_right']=$this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'));
				$data['page']='developmentpartners-list'; 
				$data['error_message']=str_replace("%20", " ", $errors); 
	            $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
	            $this->load->view('template',$data);     		       		
			} else {
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);			
			}       
        }			
	}
	
	public function adddevp(){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Create Programs
        	if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
				$data['program_right']=$this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'));
				$data['page']='developmentpartners-add'; 
				$data['programs'] = $this->programs_model->all_programs_list();
				$data['error_message']=str_replace("%20", " ", ""); 
	            $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
	            $this->load->view('template',$data);     		       		
			} else {
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);			
			}       
        }			
	}
	//Create new Donor/development partner
    public function newdevp()
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To  Create a Mechanism
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
            	$progress = $this->moh_model->addnewdevp();
                if ($progress === true) {
                    $message = "The Development Partner Has Successfully Been Created";
                    redirect("/moh_manager/index/$message", 'refresh');
                } else {
                    $message =  $progress ;
                    redirect("/moh_manager/index/$message", 'refresh');
                }
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }
	
	public function devpartnerview($devuid){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Create Programs
        	if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
				$data['program_right']=$this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'));
				$data['page']='developmentpartners-view'; 
				$data['program'] = $this->moh_model->devpartner_programs_list($devuid);
				$data['devpartner_details']= $this->moh_model->devpartner_details($devuid);
				$data['agencies'] = $this->moh_model->devpartner_agencies($devuid);
				$data['error_message']=str_replace("%20", " ", ""); 
	            $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
	            $this->load->view('template',$data);     		       		
			} else {
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);			
			}       
        }		
	}

	public function devpupdate($devuid){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Create Programs
        	if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
				$data['program_right']=$this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'));
				$data['page']='developmentpartners-update'; 
				$data['dev_programs'] = $this->moh_model->devpartner_programs_list($devuid);
				$data['programs'] = $this->moh_model->devpartner_programs_update($devuid) ; 
				$data['devpartner_details']= $this->moh_model->devpartner_details($devuid);
				$data['error_message']=str_replace("%20", " ", ""); 
	            $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
	            $this->load->view('template',$data);     		       		
			} else {
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);			
			}       
        }			
	}

	public function save_devp_update($url=null)
	{
		if ($this->session->userdata('marker') != 1) {
			redirect($this->index());
		} else {
			//Check If User Has Authority(program_magement) To  Create an Agency
			if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
				if ($progress = $this->moh_model->save_devp_update() ===TRUE) {
					$message = "Development Partner Has Successfully been Updated";
					redirect("/moh_manager/index/$message", 'refresh');
				} else {
					$message =  $progress;
					redirect("/moh_manager/index/$message", 'refresh');
				}
			} else {
				$data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
				$this->load->view('error', $data);
			}
		}
	}

	public function check_username_uniqueness(){

		$username=$this->moh_model->check_username_uniqueness();

		if($username===1){

			echo "True";
		}
		else{
			echo "False";
		}

	}
}
