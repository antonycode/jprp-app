<?php
/**
 * Created by PhpStorm.
 * User: the_fegati
 * Date: 9/3/15
 * Time: 12:35 PM
 */

class Dataimport_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();

    }
    //fetch orgunits from local db
    public function get_orgunits() {
        $data='';
        //$this->db->select('ouid');

        $orgunits=$this->db->query('SELECT a.name as org_name, a.code as mfl_code, a.organisationunitid as id, a.parentid as parent_id, b.organisationunituid as org_uuid, b.level as level FROM organisationunit a, _orgunitstructure b where a.uid=b.organisationunituid AND b.level = 4 ;');
            foreach ($orgunits->result() as $row) {
                $data[]=$row;
            }

        return $data;
    }

    //returns orgunitid given orgunituid
    public function get_orgunit_id($uid){
        $id = $this->db->get_where('organisationunit',array('uid'=>$uid))->row()->organisationunitid;
        return $id;
    }

    //returns dataelementid given dataelementuid
    public function get_dataelement_id($uid){
        $id = $this->db->get_where('dataelement',array('uid'=>$uid))->row()->dataelementid;
        return $id;
    }

    /*Dear maintainer,had to loop here one by one due to error handling limitations of mysql. I wasted a day here trying to optimise this.
    The counter below indicates the approximate number of hours wasted here. If you try to optimise it and fail, just repent and add hours wasted
    to the counter.*/
    public function bulk_dumb($data_array, $update_array) {

                $temp = json_decode(json_encode($data_array));

                foreach($temp as $row){
                    $if_exists = $this->db->get_where('datavalue', array('updateid'=>$row->updateid))->result();
					if (sizeof($if_exists)>=1) {
                        $this->db->where('updateid', $row->updateid);
                        $this->db->update('datavalue', $row);						
					}else{
                        $this->db->insert('datavalue', $row);
                    }
                }

    }

    public function get_dataset($id){
        $name = $this->db->get_where('dataset',array('uid'=>$id))->row()->name;
        return $name;
    }

    public function check_period($period){
        $year = substr($period,0,4);
        $month = substr($period,-2);
        $start_date = $year."-".$month."-"."01";
        //$period_id = ;

        if(empty($this->db->get_where('period',array('startdate'=>$start_date))->row()->periodid)){
            $this->db->select_max('periodid');
            $max_id = $this->db->get('period')->row()->periodid;
            $new_id = $max_id + 1;
            $period_type = 3;
            $end_date = $year."-".$month."-"."30";

            $data = array(
                'periodid' => $new_id ,
                'periodtypeid' => $period_type,
                'startdate' => date($start_date),
                'enddate' => date($end_date)
            );

            $this->db->insert('period',$data);

            $this->db->select_max('periodid');
            $max_id = $this->db->get('period')->row()->periodid;
            return $max_id;
        }else{
            return $this->db->get_where('period',array('startdate'=>$start_date))->row()->periodid;
        }
    }
}