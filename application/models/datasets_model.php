<?php


/**
 * 
 */
class Datasets_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
		$this->load->database();
		
    }	
    
    function getdatasets(){
        $sets='';
        $datasets=$this->db->get('dataset');
        foreach ($datasets->result() as $row) {
            $sets[]=$row;
        }
        return $sets;
    }
	function datasections(){
	    $data='';
        $query="SELECT s.sectionid as sectionid, s.name as name, s.description as description, s.lastupdated as lastupdated,d.name as datasetname FROM section s, dataset d where d.datasetid=s.datasetid";
        $sections=$this->db->query($query);        
        if ($sections->result()) {
            foreach ($sections->result() as $row) {
                $data[]=$row;
            }
            return $data;            
        } else {
           return $data; 
        }
        

	}
	function programname($id){
		$data='';
		$name=$this->db->get_where('section',array('sectionid'=>$id));
		foreach ($name->result() as $row) {
			$data=$row->name;
		}
		return $data;
	}
	function datasectionselements($id){
		$data='';
		$query="Select a.dataelementid as id ,a.name as name, a.shortname as shortname, a.description as description, a.created as created, a.lastupdated as updated from  dataelement a, sectiondataelements b where b.sectionid=$id and a.dataelementid=b.dataelementid ";
		$elements=$this->db->query($query);
		foreach ($elements->result() as $row) {
			$data[]=$row;
		}
		return $data;
	}
	
	function orgunits($id){
		$sectionelements=$this->db->get_where('sectiondataelements',array('sectionid'=>$id));
		$selements=array();
		foreach ($sectionelements->result() as $row) {
			$selements[]=$row->dataelementid;
		}
	//print_r($selements);
		$datasets=$this->db->get('dataset');
		$programdatasets=array();
		//Get datasets with all the programs dataelements
		foreach ($datasets->result() as $row) {
	//echo "</br>".$row->datasetid."</br>";
			$query=$this->db->query("select dataelementid as id from datasetmembers where datasetid = $row->datasetid");
			$elements=array();
			foreach ($query->result() as $element){
				$elements[]=$element->id;
			}			
			//print_r($elements);
			if ($selements==$elements) {
				$programdatasets[]=$row->datasetid;
			}
		}
		$units=array();
		foreach ($programdatasets as $org) {
			$unitsquery=$this->db->query("select a.name as name , a.code as code, a.organisationunitid as id,d.name as ipname  from organisationunit a, datasetsource b, userroledataset c, userrole d where b.datasetid=$org and a.organisationunitid=b.sourceid and c.datasetid =b.datasetid and d.userroleid=c.userroleid");
			foreach ($unitsquery->result() as $row) {
				$units[]=$row;
			}
		}
		return $units;
	}
}
