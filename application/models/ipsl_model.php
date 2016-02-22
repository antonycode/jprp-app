<?php
/**
 * Created by PhpStorm.
 * User: the_fegati
 * Date: 2/21/16
 * Time: 8:06 PM
 */

class Ipsl_model extends CI_Model {
    function __construct() {
        parent:: __construct();
        $this->load->database();
    }

    public function import_ipsl($mechanisms_name, $partner_name,$partner_uid, $kepms_partner_name, $kepms_partner_id){

        for ($i=0; $i <= sizeof($mechanisms_name)-1 ; $i++) {
            //Do not insert empty
            if ($mechanisms_name[$i+1]['A']&&$partner_name[$i+1]['B']&&$partner_uid[$i+1]['C']&&$kepms_partner_name[$i+1]['D']&&$kepms_partner_id[$i+1]['E']) {

                $elements=array(
                    'mechanism_name'=>$mechanisms_name[$i+1]['A'],
                    'partner_name'=>$partner_name[$i+1]['B'],
                    'partner_uid'=>$partner_uid[$i+1]['C'],
                    'kepms_partner_name'=>$kepms_partner_name[$i+1]['D'],
                    'kepms_partner_id'=>$kepms_partner_id[$i+1]['E']
                );
                $this->db->insert('funding_mechanisms',$elements);

            }
        }
        return TRUE;
    }

}