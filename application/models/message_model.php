<?php
/**
 * Created by IntelliJ IDEA.
 * User: banga
 * Date: 22/09/15
 * Time: 10:12
 */
class Message_model extends CI_Model {

//    Fetch User's Sent Mails
    public function sent_mails(){
        $mail_username=$this->session->userdata('username');
        if($mail_username!=false) {

            $this->db->order_by("timestamp", "desc"); 
            $sent_mails = $this->db->get_where('portal_message', array('sender_username' => $mail_username));
            if (sizeof($sent_mails->result()) >= 1) {
                return $sent_mails->result();
            }
        }
        return "";

    }

    //    Fetch User's Received Mails
    public function received_mails(){

        $mail_username=$this->session->userdata('username');
        if($mail_username!=false){
            $query="SELECT * FROM  portal_message pm  WHERE  (pm.message_id in (select message_id from portal_message_reply) 
                and pm.sender_username='$mail_username' ) or pm.receiver_username='$mail_username' order by timestamp desc";
            // $this->db->order_by("timestamp", "desc"); 
            // $received_mails=$this->db->get_where('portal_message', array('receiver_username'=>$mail_username));
            $received_mails= $this->db->query($query);
            if (sizeof($received_mails->result())>=1) {
                return $received_mails->result();
            }

        }

        return "";
    }

    //    Fetch User's Received Mail replies
    public function received_mail_replies($info){
        $message_id=$info['message_id'];
        $this->db->order_by("timestamp", "asc"); 
        $replies=$this->db->get_where('portal_message_reply', array('message_id'=>$message_id));
        if (sizeof($replies->result())>=1) {
            return $replies->result();
        }
        return false;
    }

    //Save Mail
    public function save_mail(){

        $sender_username=$this->session->userdata('username');
        $receiver_username=$this->input->post('receiver');
        $subject=$this->input->post('subject');
        $content=$this->input->post('content');
        $timestamp=date("Y-m-d H:m:s");

        if($sender_username!=false){

            $data=array('sender_username' =>$sender_username ,
            'receiver_username'=>$receiver_username,
            'message_subject'=>$subject,
            'message_content'=>$content,
            'delete_status_sender'=>"active",
            'delete_status_receiver'=>"active",
            'timestamp'=>$timestamp);

            if($this->db->insert('portal_message', $data))
            {
                return true;
            }
        }

        return "Sending Mail";
    }

      //Save reply mail
    public function reply($info){

        $message_id=$info['message_id'];
        $content=$info['message'];
        $timestamp=date("Y-m-d H:m:s");
        $username=$this->session->userdata('username');

        if($message_id!=false){

            $data=array('message_id' =>$message_id ,
            'message_content'=>$content,
            'timestamp'=>$timestamp,
            'username'=>$username);

            if($this->db->insert('portal_message_reply', $data))
            {
                return true;
            }
        }

        return false;
    }
}