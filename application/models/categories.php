<?php


/**
 * 
 */
 
 /**
  * 
  */
 class Categories extends CI_Model {
     
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
    }   
    
    public function dataelementcategoryoption() {
        $data='';
        $options=$this->db->get('dataelementcategoryoption');
        foreach ($options->result() as $row) {
            $data[]=$row;            
        }       
        return $data;
    }
    
 }
 
