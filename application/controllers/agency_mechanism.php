<?php
/**
 * Created by IntelliJ IDEA.
 * User: banga
 * Date: 13/09/15
 * Time: 16:38
 */

 class Agency_mechanism extends CI_Controller{

     function __construct() {
         parent:: __construct();
         $this->load->helper('url');
         $this->load->model('agency_mechanism_model');
         $this->load->model('mechanisms_model');
         $this->load->model('programs_model');
         $this->load->model('user_model');
     }

     public function index($errors=null){
         if($this->session->userdata('marker')!=1){
             redirect($this->index());
         }else{
             //Check If User Has Authority(program_management)
             if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
                 $data["mechanisms"]=$this->agency_mechanism_model->agency_mechanism_list();
                 $data['right']=$this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'));
                 $data['page']='agency_mechanism-list.php';
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

     public function add_mechanism(){
         if($this->session->userdata('marker')!=1){
             redirect($this->index());
         }else{
             //Check If User Has Authority(program_magement) To Create Implementing mechanisms
             if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
                 $data['page']='agency_mechanism-add';
                 $data['programs']=$this->agency_mechanism_model->get_programs_assigned_agency();
                 $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
                 $this->load->view('template',$data);
             } else {
                 $data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                 $this->load->view('error',$data);
             }
         }
     }

     public function save_mechanism()
     {
         if ($this->session->userdata('marker') != 1) {
             redirect($this->index());
         } else {
             //Check If User Has Authority(program_magement) To  Create an Agency
             if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                 if ($progress = $this->agency_mechanism_model->save_mechanism() ===TRUE) {
                     $message = "Mechanism Has  Been Successfully Created";
                     redirect("/agency_mechanism/index/$message", 'refresh');
                 } else {
                     $message =  $progress;
                     redirect("/agency_mechanism/index/$message", 'refresh');
                 }
             } else {
                 $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                 $this->load->view('error', $data);
             }
         }
     }

     public function view_mechanism($mechanism_id){
         if($this->session->userdata('marker')!=1){
             redirect($this->index());
         }else{
             //Check If User Has Authority(program_magement) To Create Programs
             if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
                 $data['program_right']=$this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'));
                 $data['page']='agency_mechanism-view';
                 $data['program'] = $this->agency_mechanism_model->mechanism_programs_list($mechanism_id);
                 $data['support'] = $this->agency_mechanism_model->mechanism_support_list($mechanism_id);
                 $data['mechanism_details']= $this->agency_mechanism_model->mechanism_details($mechanism_id);

                 if(empty($data['mechanism_details'])){
                     $message =  "Invalid Implementing Mechanism ";
                     redirect("/agency_mechanism/index/$message", 'refresh');
                 }
//                 $data['facilities'] = $this->agency_mechanism_model->agency_mechanisms($mechanism_id);
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


     public function update_mechanism($mechanism_id){
         if($this->session->userdata('marker')!=1){
             redirect($this->index());
         }else{
             //Check If User Has Authority(program_magement) To Update
             if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
                 $data['page']='agency_mechanism-edit';
                 $data['programs']=$this->agency_mechanism_model->mechanism_programs_list_update($mechanism_id);
                 $data['mechanism']=$this->agency_mechanism_model->mechanism_update_details($mechanism_id);
                 if(empty($data['mechanism'])){
                     $message =  "Invalid Implementing Mechanism ";
                     redirect("/agency_mechanism/index/$message", 'refresh');
                 }
                 $data['selected_programs'] = $this->agency_mechanism_model->mechanism_programs_list($mechanism_id);
                 $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
                 $this->load->view('template',$data);
             } else {
                 $data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                 $this->load->view('error',$data);
             }
         }
     }

     public function save_mechanism_update()
     {
         if ($this->session->userdata('marker') != 1) {
             redirect($this->index());
         } else {
             //Check If User Has Authority(program_magement)
             if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                 if ($progress = $this->agency_mechanism_model->save_mechanism_update() ===TRUE) {
                     $message = "Agency Has Successfully been Updated";
                     redirect("/agency_mechanism/index/$message", 'refresh');
                 } else {
                     $message =  $progress;
                     redirect("/agency_mechanism/index/$message", 'refresh');
                 }
             } else {
                 $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                 $this->load->view('error', $data);
             }
         }
     }

     // Fetch Mechanism Details
     public function show_mechanism_details($mechanism_uid)
     {
         if ($this->session->userdata('marker') != 1) {
             redirect($this->index());
         } else {
             //Check If User Has Authority(program_magement)  to view details of a mechanism
             if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                 if ($result = $this->agency_mechanism_model->show_mechanism_details($mechanism_uid)) {

                     echo $data = json_encode($result);
                 }
             }
         }

     }



 }