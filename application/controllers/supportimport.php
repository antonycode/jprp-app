<?php

/**
 * 
 */

class Supportimport extends CI_Controller {
	
	function __construct() {
		parent:: __construct();
        $this->load->helper('url');   	
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
		$file_name=substr( $this->input->get('url'), strpos( $this->input->get('url'), "?file=") + 6);
		$period='2014-03-01';
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Import Support
        	if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
        		$file = "C:\\xampp\\htdocs\\attribution\\server\\php\\files\\$file_name";
				$no_empty_rows=TRUE;
				$this->mechanisms_model->empty_attribution_mechanisms();
				$this->load->library('excel');
                //read file from path
                $objPHPExcel = PHPExcel_IOFactory::load($file);
                 $sheetname='MER category option combos';
                //get only the Cell Collection
                //$active=$objPHPExcel->setActiveSheetIndexByName($sheetname);
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        
                $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
                $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
                
                //echo 'getHighestColumn() =  [' . $highestColumm . ']<br/>';
               // echo 'getHighestRow() =  [' . $highestRow . ']<br/>';
                
                //$cell_collection= array_map('array_filter', $objPHPExcel);
                        
                $rows = $highestRow; 
                //echo $rows."active  </br>";
                $empty_cells_alert="";
                $count=1; 
                $empty_column=1;
                $data_rows=1;
				$mechanisms_name="";
				$mechanisms_id="";
				$mechanisms_uid="";
				$attribution_key="";
				$datim_id="";
				$mfl_code="";
				$ownership="";
				$typeofsite="";
				$othertypeofsite='';
				$level="";
				$county="";
				$subcounty="";
                //extract to a PHP readable array format
                //print_r($cell_collection);
                foreach ($cell_collection as $cell) {
            //echo "a $count </br>";
                    //Only Get Rows With All Columns Filled
                    if ($objPHPExcel->getActiveSheet()->getCell("A".$count)->getValue()!=null && 
                    $objPHPExcel->getActiveSheet()->getCell("B".$count)->getValue()!=null &&
                    $objPHPExcel->getActiveSheet()->getCell("C".$count)->getValue()!=null &&
                    $objPHPExcel->getActiveSheet()->getCell("K".$count)->getValue()!=null &&
                     $objPHPExcel->getActiveSheet()->getCell("L".$count)->getValue()!=null){
                        if ($cell=="A".$count) {
                        	//echo "a </br>";
                            //Get Mechanism Name    
                            $column ='A';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
                                $mechanism_name = $data_value;
                            }    
                        } elseif($cell=="B".$count){
                            $column ='B';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$datim_id = $data_value;
                            }         
                        } elseif($cell=="C".$count){
                            $column ='C';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$organization_name = $data_value;
                            }         
                        } elseif($cell=="D".$count){
                            $column ='D';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$mfl_code = $data_value;
                            }         
                        } elseif($cell=="E".$count){
                            $column ='E';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$ownership = $data_value;
                            }         
                        } elseif($cell=="F".$count){
                            $column ='F';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$typeofsite = $data_value;
                            }         
                        } elseif($cell=="G".$count){
                            $column ='G';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$othertypeofsite = $data_value;
                            }         
                        } elseif($cell=="H".$count){
                            $column ='H';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$level = $data_value;
                            }         
                        }  elseif($cell=="I".$count){
                            $column ='I';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$county = $data_value;
                            }         
                        } elseif($cell=="J".$count){
                            $column ='J';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$subcounty = $data_value;
                            }         
                        } elseif($cell=="K".$count){
                            $column ='K';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$program_name = $data_value;
                            }         
                        } elseif($cell=="L".$count){
                        	//echo "Kss </br>";
                        	//$count++;
                        	$count=$count+1;
							//echo "$count";
                            $column ='L';
							//echo "string";
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
							//echo "datais ".$data_value;
							
							//echo "here </br>";
							//die();
                            if ($row != 1 && $data_value!='' ) {
                            	//echo "ok </br>";
                            	$support_type = $data_value;
                                $data_rows=$data_rows+1;
								$update=$this->mechanisms_model->support_excel_import($organization_name,$mechanism_name,$datim_id,$program_name,$support_type,$period,$datim_id,$mfl_code,$ownership,$typeofsite,$othertypeofsite,$level,$county,$subcounty);								
								if ($update!=1) {
									//$this->mechanisms_model->support_import_errors($organization_name,$mechanism_name,$datim_id,$program_name,$support_type,$period,$update,$datim_id,$mfl_code,$ownership,$typeofsite,$othertypeofsite,$level,$county,$subcounty);
								}
							}
                        //Get Rows With  Partial Column Data
                        }elseif($objPHPExcel->getActiveSheet()->getCell("A".$count)->getValue()==null || $objPHPExcel->getActiveSheet()->getCell("B".$count)->getValue()==null || $objPHPExcel->getActiveSheet()->getCell("C".$count)->getValue()==null 
                        || $objPHPExcel->getActiveSheet()->getCell("K".$count)->getValue()==null|| $objPHPExcel->getActiveSheet()->getCell("L".$count)->getValue()==null){                       
                             //echo "FALSE";
							    $empty_cells_alert[$empty_column]="Empty Cell In Row $count";
                                $empty_column=$empty_column+1;
                                $count=$count+1;
                                $no_empty_rows=FALSE;
                        }
                        
                    
                }  
				     		       		
			}  
                    $data = array(
                    'message' => "Support Information Has Been Successfully Uploaded Into The Database"
                    );    
                    echo json_encode($data) ;   
        }else {
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);			
			} 	
		}
	}	
}