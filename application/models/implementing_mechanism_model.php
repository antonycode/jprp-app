<?php
/**
 * Created by IntelliJ IDEA.
 * User: banga
 * Date: 14/09/15
 * Time: 11:39
 */

 class Implementing_mechanism_model extends CI_Model{

     public function mechanism_support_list(){
         $hierarchy_uid=$this->session->userdata('group_uid');
		 $datimid=$this->db->get_where("attribution_keys",array("mechanism_uid"=>$this->session->userdata('group_uid')))->row()->datim_id;
         $support=$this->db->get_where("attribution_mechanisms_programs",array("status"=>'active',"datim_id"=>$datimid))->result();
         if (sizeof($support)>=1) {
             return $support;
         }
         return "";
     }

     public function mechanism_details($mechanism_uid)
     {
         $list = $this->db->get_where("attribution_hierarchy", array("uid" => $mechanism_uid));
         if (sizeof($list->result()) >= 1) {
             return $list->row();
         }
         return "";
     }

     public function empty_attribution_mechanisms(){

         $this->db->truncate('attribution_mechanisms');
     }
     public function empty_mechanisms_support_errors(){

         $this->db->truncate('attribution_support_import_errors');
     }

     public function mechanisms_support_errors(){
         $hierarchy_uid=$this->session->userdata('group_uid');
         $errors=$this->db->get_where("attribution_support_import_errors", array("hierarchy_uid"=>$hierarchy_uid));
         if (sizeof($errors->result())>=1) {
             return $errors->result();
         }
         return "";
     }

     public function mechanism_programs_list()
     {
         $hierarchy_uid=$this->session->userdata('group_uid');

         $list = $this->db->get_where("attribution_hierarchy_programs", array("hierarchy_uid" => $hierarchy_uid));
         if (sizeof($list->result()) >= 1) {
             return $list->result();
         }
         return "";
     }



     public function support_excel_import($orgunit_name,$mechanism_name,$datim_id,$program_name,$support_name,$start_date, $end_date){

         $hierarchy_uid=$this->session->userdata('group_uid');

         //Get Datim ID of the Current User
         $current_user_datim_id=false;
         if($current_user=mechansim_details($hierarchy_uid))
         {
             $current_user_datim_id=$current_user->code;
         }
         else{
             return "Invalid Datim ID";
         }

         if($current_user_datim_id!=$datim_id){

             return "Invalid Datim ID";
         }
         //Step 1 Check If Program Exists
         $orgunit=$this->db->get_where("organisationunit",array("name"=>$orgunit_name))->row();
         if (sizeof($orgunit)==1) {
             $program=$this->db->get_where("attribution_programs",array("program_name"=>$program_name))->row();
             if (sizeof($program)==1) {
                 //Check If Support Type Exists
                 $support=$this->db->get_where("attribution_support_types",array("support_name"=>$support_name))->result();
                 if (sizeof($support)==1) {
                     //Check If Record Exists
                     $record=array(
                         "organization_name"=>$orgunit_name,
                         "datim_id"=>$datim_id,
                         "program_name"=>$program_name,
                         "support_type"=>$support_name,
                         "start_date"=>$start_date,
                         "stop_date"=>$end_date
                     );
                     if (sizeof($this->db->get_where("attribution_mechanisms_programs",$record)->result())==0) {
                         //Check For Date Overlaps prevent same support type on same facility same period
                         $overlapquery="SELECT * FROM attribution_mechanisms_programs where (organization_name='$orgunit_name' AND program_name='$program_name' AND support_type='$support_name' AND start_date BETWEEN '$start_date' and  '$end_date') or (organization_name='$orgunit_name' AND program_name='$program_name' AND support_type='$support_name' AND stop_date BETWEEN '$start_date' and '$end_date') ";
                         if (sizeof($this->db->query($overlapquery)->result())==0) {
                             $new_support=array(
                                 "organization_name"=>$orgunit_name,
                                 "organization_id"=>$orgunit->organisationunitid,
                                 "datim_id"=>$datim_id,
                                 "mechanism_name"=>$mechanism_name,
                                 "program_name"=>$program_name,
                                 "program_id"=>$program->program_id,
                                 "support_type"=>$support_name,
                                 "start_date"=>$start_date,
                                 "stop_date"=>$end_date,
                                 "hierarchy_uid"=>$hierarchy_uid,
                                 "status"=>"active"
                             );
                             $this->db->insert("attribution_mechanisms_programs",$new_support);
                             return true;
                         } else {
                             return "Overlap Support For The Same Program and Support Type";
                         }

                     } else {
                         Return  "Support Exists In Database";
                     }
                 } else {
                     return "Support Not Found";
                 }

             }else{
                 return "Program Doesnot Exist";
             }
         }else{
             return "Organization Unit Not Found";
         }

     }


     public function support_import_errors($organization_name,$mechanism_name,$datim_id,$program_name,$support_type,$start_date, $stop_date,$update) {

         $hierarchy_uid=$this->session->userdata('group_uid');

         $support_fail=array(
             "organization_name"=>$organization_name,
             "mechanism_name"=>$mechanism_name,
             "datim_id"=>$datim_id,
             "program_name"=>$program_name,
             "support_type"=>$support_type,
             "start_date"=>$start_date,
             "stop_date"=>$stop_date,
             "import_error"=>$update,
             "hierarchy_uid"=>$hierarchy_uid
         );
         $this->db->insert("attribution_support_import_errors",$support_fail);
     }

     public function drop_mechanism_support($id){
         $details=array(
             "status"=>"dropped",
         );

         $this->db->where('id', $id);

         if (!$this->db->update("attribution_mechanisms_programs", $details)) {
             return false;
         }

         return true;
     }
 }