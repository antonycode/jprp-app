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
	
	
	public function ipsl($errors=null){
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                $data["ipsl"] = $this->ipsl_model->get_ipsl();
                $data['mechanisms_right'] = $this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'));
                $data['page'] = 'ipsl-import';
                $data['error_message'] = str_replace("%20", " ", "");
				$data['import_errors']=$this->mechanisms_model->mechanisms_support_errors();
				$data["support"]=$this->mechanisms_model->mechanisms_support();
                $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                $data['agencyname'] = $this->session->userdata('groupname');
                $this->load->view('template', $data);
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }
	public function supportexcelimport(){
		$file_name=$this->input->post('filename');
        echo("Here");
//        $this->load->view('error');
        
		$period='2014-03-01';
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Import Support
        	if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
        		$file = "C:\\xampp\\htdocs\\jprp\\server\\php\\files\\".$file_name;
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

    public function ipslexcelimport()
    {
		$file_name=substr( $this->input->get('url'), strpos( $this->input->get('url'), "?file=") + 6);
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Import Support
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                $file = "C:\\xampp\\htdocs\\jprp\\server\\php\\files\\".$file_name;
				echo "string";
                $this->mechanisms_model->empty_attribution_mechanisms();

                $this->load->library('excel');
                $objPHPExcel = PHPExcel_IOFactory::load($file);
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

                $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                $rows = $highestRow;
                //echo $rows."active  </br>";
                $count = 2;
                $data_array = '';
                $array_count = 0;
                $error_array = '';
                $error_count = '';
                $orgunit_name = '';
                $mfl_code = '';
                $mechanism_name = '';
                $datim_id = '';
                $period = '';
                $import_errors = '';

                foreach ($cell_collection as $cell) {
                    if ($objPHPExcel->getActiveSheet()->getCell("A" . $count)->getValue() != null &&
                        $objPHPExcel->getActiveSheet()->getCell("B" . $count)->getValue() != null &&
                        $objPHPExcel->getActiveSheet()->getCell("C" . $count)->getValue() != null &&
                        $objPHPExcel->getActiveSheet()->getCell("D" . $count)->getValue() != null &&
                        $objPHPExcel->getActiveSheet()->getCell("E" . $count)->getValue() != null
                    ) {
                        if ($cell == "A" . $count) {
                            $column = 'A';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $orgunit_name = $data_value;
                            }
                        } elseif ($cell == "B" . $count) {
                            $column = 'B';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $mfl_code = $data_value;
                            }
                        } elseif ($cell == "C" . $count) {
                            $column = 'C';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $mechanism_name = $data_value;
                            }
                        } elseif ($cell == "D" . $count) {
                            $column = 'D';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $datim_id = $data_value;
                            }
                        } elseif ($cell == "E" . $count) {
                            $column = 'E';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $period = $data_value;
                            }

                            $data_array[$array_count] = array(
                                "orgunitname" => $orgunit_name,
                                "mflcode" => $mfl_code,
                                "mechanism" => $mechanism_name,
                                "datimid" => $datim_id,
                                "period" => $period
                            );
                            $count = $count + 1;
                            $array_count = $array_count + 1;
                        }

                    } elseif ($objPHPExcel->getActiveSheet()->getCell("A" . $count)->getValue() == null || $objPHPExcel->getActiveSheet()->getCell("B" . $count)->getValue() == null || $objPHPExcel->getActiveSheet()->getCell("C" . $count)->getValue() == null
                        || $objPHPExcel->getActiveSheet()->getCell("K" . $count)->getValue() == null || $objPHPExcel->getActiveSheet()->getCell("L" . $count)->getValue() == null
                    ) {
                        if ($cell == "A" . $count) {
                            $column = 'A';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value == '') {
                                $import_errors = $import_errors . "Missing orgunit name; ";
                            }
                            $orgunit_name = $data_value;
                        } elseif ($cell == "B" . $count) {
                            $column = 'B';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value == '') {
                                $import_errors = $import_errors . "Missing MFL code; ";
                            }
                            $mfl_code = $data_value;
                        } elseif ($cell == "C" . $count) {
                            $column = 'C';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $import_errors = $import_errors . "Missing mechanism name; ";
                            }
                            $mechanism_name = $data_value;
                        } elseif ($cell == "D" . $count) {
                            $column = 'D';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value == '') {
                                $import_errors = $import_errors . "Missing DATIM id; ";
                            }
                            $datim_id = $data_value;
                        } elseif ($cell == "E" . $count) {
                            $column = 'E';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value == '') {
                                $import_errors = $import_errors . "Missing period value; ";
                            }
                            $period = $data_value;
                        }
                        $error_array[$error_count] = array(
                            "orgunitname" => $orgunit_name,
                            "mflcode" => $mfl_code,
                            "mechanism" => $mechanism_name,
                            "datimid" => $datim_id,
                            "period" => $period,
                            "error" => $import_errors
                        );
                        $count = $count + 1;
                        $error_count = $error_count + 1;

                    }


                }
                echo json_encode($data_array);
                echo "Import Errors\n";
                echo json_encode($error_array);

                $this->ipsl_model->import_ipsl($data_array);
                $this->ipsl_model->import_errors($error_array);

                $data = array(
                    'message' => "Support Information Has Been Successfully Uploaded Into The Database"
                );
                echo json_encode($data);
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }

    }	
}