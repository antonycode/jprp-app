<?php

/**
 * Created by IntelliJ IDEA.
 * User: banga
 * Date: 22/09/15
 * Time: 10:05
 */
class Message extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('message_model');
        $this->load->model('user_model');
    }
   
    public function index($errors = null)
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_management)
            
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                $data['username']=$this->session->userdata('username');
                $data['sent_mails'] = $this->message_model->sent_mails();
                $data['received_mails'] = $this->message_model->received_mails();
                $data['right'] = $this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'));
                $data['page'] = 'message/inbox.php';
                $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                $data['error_message'] = str_replace("%20", " ", $errors);
                $data['agencyname'] = $this->session->userdata('groupname');
                $this->load->view('template', $data);
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }


//    Send Mail
    public function save_mail()
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_management) To  Save Mail
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                if ($progress = $this->message_model->save_mail() == TRUE) {
                    $message = $message = "Mail Sent";
                    redirect("/message/index/$message", 'refresh');
                } else {
                    $message = $progress . "  error. Kindly Try Again";
                    redirect("/message/index/$message", 'refresh');
                }
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }

    public function reply(){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
                if (isset($_POST["data"])) {
                    $data = json_decode($_POST["data"],true);
                    $infoarray=array(
                        "message_id"=>$data["message_id"],
                        "message"=>$data["reply_message"]
                    );
                    if (sizeof($infoarray)<=0) {
                       header('Content-Type: application/x-json; charset=utf-8');          
                        echo "<span class='error'>Error! No Data Was Captured. Please Try Again</span>";                
                    }       
                    $result = $this->message_model->reply($infoarray);         
                    if ($result===true) {
                        header('Content-Type: application/x-json; charset=utf-8');          
                        echo  "<span>Message Sent</span>";                                          
                    }else{
                        header('Content-Type: application/x-json; charset=utf-8');          
                        echo  "<span class='error'>An Error Occured while sending the mail,Kindly Try Again</span>"; 
                    }                                       
                }   else{
                                    header('Content-Type: application/x-json; charset=utf-8'); 
                                    echo "An Error Occured while sending the mail, Kindly Try Again";
                }       
            } else {
                $data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);           
            }       
        }                                   
    }


    public function message_details(){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
                if (isset($_POST["message_id"])) {
                    $data = $_POST["message_id"];
                    $infoarray=array(
                        "message_id"=>$data
                    );
                    if (sizeof($infoarray)<=0) {
                       header('Content-Type: application/x-json; charset=utf-8');          
                        echo "null";                
                    }       
                    $result = $this->message_model->received_mail_replies($infoarray);         
                    if ($result) {
                        header('Content-Type: application/x-json; charset=utf-8');  
                        echo $data=json_encode($result);       
                        // echo  "<span>Replies Loaded</span>";                                          
                    }else{
                        header('Content-Type: application/x-json; charset=utf-8');          
                        echo "null";
                    }                                       
                }   else{
                        header('Content-Type: application/x-json; charset=utf-8'); 
                        echo "null";
                }
            } else {
                $data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);           
            }       
        }                                   
    }



}
