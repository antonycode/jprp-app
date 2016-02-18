<?php

/**
 * 
 */
class User_manager extends CI_Controller {
	
	function __construct() {
		parent:: __construct();
        $this->load->helper('url');  
		$this->load->model('moh_model');  	
		$this->load->model('mechanisms_model'); 
		$this->load->model('usermanagement_model');	
		$this->load->model('user_model'); 
	}
	public function index(){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(user_management) To Create Programs
        	if ($this->user_model->get_user_role('global_associate_management',$this->session->userdata('userroleid'))) {
					$data['users']=$this->usermanagement_model->get_global_users();
					$data['page']="user_management/index";
	            	$data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 	$data['agencyname']=$this->session->userdata('groupname');	
					$this->load->view('template',$data);   		       		
			}else{
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);					
			}       
        }		
	}
	public function user_list($errors=null){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(user_management) To Create Programs
        	if ($this->user_model->get_user_role('global_associate_management',$this->session->userdata('userroleid'))) {
					$data['users']=$this->usermanagement_model->get_global_users();
					$data['page']="user_management/user_list";
					$data['error_message']=str_replace("%20", " ", "");
	            	$data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 	$data['agencyname']=$this->session->userdata('groupname');						
					$this->load->view('template',$data);     		       		
			} else if ($this->user_model->get_user_role('org_user_management',$this->session->userdata('userroleid'))) {
					$data['users']=$this->usermanagement_model->get_org_users($this->session->userdata("group_id"));
					$data['page']="user_management";
					$this->load->view('template',$data); 
			}else{
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);					
			}       
        }			
	}
	public function create_user($errors=null){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(user_management) To Create Programs
        	if ($this->user_model->get_user_role('global_associate_management',$this->session->userdata('userroleid'))) {
					$data['users']=$this->usermanagement_model->get_global_users();
					$data['page']="user_management/org_user_create";
					$data['error_message']=str_replace("%20", " ", "");
	            	$data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 	$data['agencyname']=$this->session->userdata('groupname');						
					$this->load->view('template',$data);     		       		
			} else if ($this->user_model->get_user_role('org_user_management',$this->session->userdata('userroleid'))) {
					$data['users']=$this->usermanagement_model->get_org_users($this->session->userdata("group_id"));
					$data['page']="user_management";
					$this->load->view('template',$data); 
			}else{
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);					
			}       
        }			
	}
	public function associates_list($message=null){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_management) To Create Programs
        	if ($this->user_model->get_user_role('global_associate_management',$this->session->userdata('userroleid'))) {
					$data['groups']=$this->usermanagement_model->get_global_groups();
					$data['roles']=$this->usermanagement_model->get_all_roles();
					$data['page']="user_management/associates_management";
	            	$data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
					$data['error_message']=str_replace("%20", " ", "");
                 	$data['agencyname']=$this->session->userdata('groupname');	
					$this->load->view('template',$data);     		       		
			}else{
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);					
			}       
        }		
	}
	
	public function associate_edit($group_id){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_management) To Create Programs
        	if ($this->user_model->get_user_role('global_associate_management',$this->session->userdata('userroleid'))) {
					$level=$this->usermanagement_model->get_groups_level($group_id);
					if($level==2){
						$this->devpupdate($this->usermanagement_model->get_devuid($group_id));
					}elseif($level==3){
						
					}
    		       		
			}else{
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);					
			}       
        }			
	}
	public function update_associate_role($errors = null){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_management) To Create Programs
        	if ($this->user_model->get_user_role('global_associate_management',$this->session->userdata('userroleid'))) {
		        $groupid = $this->input->post('groupid');
		        $roleid = $this->input->post('role');
		        $this->usermanagement_model->update_group($groupid,$roleid);  
		        $data['page'] = 'user_management/associates_management';
				$data['groups']=$this->usermanagement_model->get_global_groups();
				$data['roles']=$this->usermanagement_model->get_all_roles();
		        $data['roles'] = $this->usermanagement_model->get_all_roles();
		        $data['error_message'] = str_replace("%20", " ", $errors);
		        $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
		        $data['agencyname'] = $this->session->userdata('groupname');
		        $this->load->view('template', $data);				      		
        		
			}else{
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
				$data['page']='user_management/developmentpartners-update'; 
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

	public function save_devp_update()
	{
		if ($this->session->userdata('marker') != 1) {
			redirect($this->index());
		} else {
			//Check If User Has Authority(program_magement) To  Create an Agency
			if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
				if ($progress = $this->moh_model->save_devp_update() ===TRUE) {
					$message = "Development Partner Has Successfully been Updated";
					$this->associates_list($message);
				} else {
					$message =  $progress;
					$this->associates_list($message);
				}
			} else {
				$data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
				$this->load->view('error', $data);
			}
		}
	}	
}
