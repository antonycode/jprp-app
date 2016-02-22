<?php

/**
 * 
 */

class Supportimport extends CI_Controller {
	
	function __construct() {
		parent:: __construct();
        $this->load->helper('url');   	
		$this->load->model('ipsl_model');
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
        		$data["support"]=$this->mechanisms_model->mechanisms_support();
				$data['mechanisms_right']=$this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'));
				$data['page']='mechanisms-support-import'; 
				$data['error_message']=str_replace("%20", " ", ""); 
				$data['import_errors']=$this->mechanisms_model->mechanisms_support_errors();
	            $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
	            $this->load->view('template',$data);     		       		
			} else {
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);			
			}       
        }				
	}
	
	
	
	public function supportexcelimport(){
		$file_name=$this->input->post('filename');
        echo("Here");
//        $this->load->view('error');
        die();
		$period='2014-03-01';
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Import Support
        	if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
        		$file = "/var/www/attribution/server/php/files/"+$file_name;
				$no_empty_rows=TRUE;
				$this->mechanisms_model->empty_attribution_mechanisms();
				$this->load->library('excel');
                //read file from path
                $objPHPExcel = PHPExcel_IOFactory::load($file);
                 $sheetname='Sheet1';
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        
                $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
                $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
                        
                $rows = $highestRow; 
                //echo $rows."active  </br>";
                $empty_cells_alert="";
                $count=1; 
                $empty_column=1;
                $data_rows=1;
				$mechanisms_name="";
				$datim_id="";
				$mfl_code="";
                $orgunit_name="";
                $period="";
                //extract to a PHP readable array format
                //print_r($cell_collection);
                foreach ($cell_collection as $cell) {
            //echo "a $count </br>";
                    //Only Get Rows With All Columns Filled
                    if ($objPHPExcel->getActiveSheet()->getCell("A".$count)->getValue()!=null && 
                    $objPHPExcel->getActiveSheet()->getCell("B".$count)->getValue()!=null &&
                    $objPHPExcel->getActiveSheet()->getCell("C".$count)->getValue()!=null &&
                    $objPHPExcel->getActiveSheet()->getCell("D".$count)->getValue()!=null &&
                    $objPHPExcel->getActiveSheet()->getCell("E".$count)->getValue()!=null){
                        if ($cell=="A".$count) {
                        	//echo "a </br>";
                            //Get Facility Name
                            $column ='A';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
                                $orgunit_name = $data_value;
                            }    
                        } elseif($cell=="B".$count){
                            $column ='B';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$mfl_code = $data_value;
                            }         
                        } elseif($cell=="C".$count){
                            $column ='C';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$mechanisms_name = $data_value;
                            }         
                        } elseif($cell=="D".$count){
                            $column ='D';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$datim_id = $data_value;
                            }         
                        } elseif($cell=="E".$count){

                            $count=$count+1;
                            $column ='E';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$period = $data_value;
                                $data_rows=$data_rows+1;
                                $update=$this->Ipsl_model->ipsl_import($orgunit_name,$mfl_code,$mechanism_name,$datim_id,$period);

                                if ($update!=1) {
                                    //$this->mechanisms_model->support_import_errors($organization_name,$mechanism_name,$datim_id,$program_name,$support_type,$period,$update,$datim_id,$mfl_code,$ownership,$typeofsite,$othertypeofsite,$level,$county,$subcounty);
                                }
                            }         
                        }elseif($objPHPExcel->getActiveSheet()->getCell("A".$count)->getValue()==null || $objPHPExcel->getActiveSheet()->getCell("B".$count)->getValue()==null || $objPHPExcel->getActiveSheet()->getCell("C".$count)->getValue()==null
                        || $objPHPExcel->getActiveSheet()->getCell("D".$count)->getValue()==null|| $objPHPExcel->getActiveSheet()->getCell("E".$count)->getValue()==null){
                             //echo "FALSE";
							    $empty_cells_alert[$empty_column]="Empty Cell In Row $count";
                                $empty_column=$empty_column+1;
                                $count=$count+1;
                                $no_empty_rows=FALSE;
                        }
                        
                    
                }  
				     		       		
			}  
                    $data = array(
                    'message' => "IPSL Has Been Successfully Uploaded Into The Database"
                    );    
                    echo json_encode($data) ;   
        }else {
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);			
			} 	
		}
	}	
}