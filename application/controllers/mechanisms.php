<?php

/**
 * 
 */

class Mechanisms extends CI_Controller {
	
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
        		$data["mechanisms"]=$this->mechanisms_model->mechanisms_list();
				$data['mechanisms_right']=$this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'));
				$data['page']='mechanisms-list'; 
				$data['error_message']=str_replace("%20", " ", $errors); 
	            $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
	            $this->load->view('template',$data);     		       		
			} else {
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);			
			}       
        }			
	}
	
	public function mechanismsexcelimport(){
		$file_name=substr( $this->input->get('url'), strpos( $this->input->get('url'), "?file=") + 6);
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Create Programs
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
                //echo 'getHighestRow() =  [' . $highestRow . ']<br/>';
                
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
                //extract to a PHP readable array format
                //print_r($cell_collection);
                foreach ($cell_collection as $cell) {
            
                    //Only Get Rows With All Columns Filled
                    if ($objPHPExcel->getActiveSheet()->getCell("A".$count)->getValue()!=null && 
                    $objPHPExcel->getActiveSheet()->getCell("B".$count)->getValue()!=null &&
                    $objPHPExcel->getActiveSheet()->getCell("C".$count)->getValue()!=null &&
                     $objPHPExcel->getActiveSheet()->getCell("D".$count)->getValue()!=null){
                        if ($cell=="A".$count) {
                            //Get Mechanism Name    
                            $column ='A';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
                                $mechanisms_name = $data_value;
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
								$partner_name = $data_value;
                            }         
                        }elseif($cell=="D".$count){
                        	$count=$count+1;
                            $column ='D';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='' ) {
                                $kepms_id = $data_value;
                                $data_rows=$data_rows+1;
								$this->mechanisms_model->mechanisms_excel_import($mechanisms_name,$datim_id,$partner_name, $kepms_id);								
                            }
                        //Get Rows With  Partial Column Data
                        }elseif($objPHPExcel->getActiveSheet()->getCell("A".$count)->getValue()!=null || $objPHPExcel->getActiveSheet()->getCell("B".$count)->getValue()!=null || $objPHPExcel->getActiveSheet()->getCell("C".$count)->getValue()!=null || $objPHPExcel->getActiveSheet()->getCell("D".$count)->getValue()!=null){                       
                                $empty_cells_alert[$empty_column]="Empty Cell In Row $count";
                                $empty_column=$empty_column+1;
                                $count=$count+1;
                                $no_empty_rows=FALSE;
                        }
                        
                    
                }  
				     		       		
			}  
                    $data = array(
                    'message' => "Data Has Been Successfully Uploaded Into The Database"
                    );    
                    echo json_encode($data) ;   
        }else {
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);			
			} 	
	}
	}
	
	public function addmechanism(){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Create Programs
        	if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
				$data['page']='mechanisms-add';
				$data['orgunits']=$this->mechanisms_model->get_all_orgunits();
				$data['programs']=$this->programs_model->all_programs_list();
	            $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
	            $this->load->view('template',$data);     		       		
			} else {
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);			
			}       
        }			
	}
	
	public function viewmechanism($datim_id){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Create Programs
        	if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
        		$data["mech_details"]=$this->mechanisms_model->mechanism_info($datim_id);
				$data["mech_programs"]=$this->mechanisms_model->get_mech_programs($datim_id);  
				$data['attribution_right']=$this->user_model->get_user_role('attribution',$this->session->userdata('userroleid'));		
				$data['program_right']=$this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'));				
				$data['page']='mechanisms-view';  
	            $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
	            $this->load->view('template',$data);     		       		
			} else {
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);			
			}       
        }
	}
	
	public function supportupdate(){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Create Programs
        	if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
				if (isset($_POST["data"])) {
					$data = json_decode($_POST["data"],true);
	                $infoarray=array(
	                    "support_type"=>$data["type"],
	                    "start_date"=>$data["sdate"],
	                    "stop_date"=>$data["edate"]
	                );
			        if (sizeof($infoarray)<=0) {
			           header('Content-Type: application/x-json; charset=utf-8');          
			            echo "<span class='error'>Error! No Data Was Captured. Please Try Again</span>";                
			        }		
			        $result = $this->mechanisms_model->supportupdate($infoarray,$data["support_id"]);         
			        if ($result) {
			            header('Content-Type: application/x-json; charset=utf-8');          
			            echo  "<span>Support Update Was Successful</span>"; 			        	                 
			        }else{
			            header('Content-Type: application/x-json; charset=utf-8');          
			            echo  "<span class='error'>An Error Has Occured During Update Process Kindly Try Again</span>"; 
			        }					 					
				}	else{
									header('Content-Type: application/x-json; charset=utf-8'); 
									echo "An Error Occured When Getting The New Details Kindly Try Again";
				}		
			} else {
				$data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);			
			}       
        }									
	}
    public function deletemechanism($datim_id){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
            //Check If User Has Authority(program_magement) To delete Programs
            if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
                if($this->mechanisms_model->deletemechanism($datim_id)==TRUE){
                    header('Content-Type: application/x-json; charset=utf-8'); 
                    echo "The Mechanism Has Successfully Been removed";
                }else{
                    header('Content-Type: application/x-json; charset=utf-8'); 
                    echo "An Error Occured While Deleting The Mechanism. Kindly Try Again";
                }               
            } else {
                $data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);           
            }       
        }           
    }

	
	
	public function mechanisms_support(){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Create Programs
        	if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
        		$data["support"]=$this->mechanisms_model->mechanisms_support();
				$data['mechanisms_right']=$this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'));
				$data['page']='mechanisms-support-import'; 
				$data['error_message']=str_replace("%20", " ", ""); 
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
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
        	//Check If User Has Authority(program_magement) To Import Support
        	if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
        		$file = "C:\\xampp\\htdocs\\attribution\\server\\php\\files\\suportimport.xlsx";
				$no_empty_rows=TRUE;
				$this->mechanisms_model->empty_mechanisms_support_errors();
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
                //echo 'getHighestRow() =  [' . $highestRow . ']<br/>';
                
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
                //extract to a PHP readable array format
                //print_r($cell_collection);
                foreach ($cell_collection as $cell) {
            
                    //Only Get Rows With All Columns Filled
                    if ($objPHPExcel->getActiveSheet()->getCell("A".$count)->getValue()!=null && 
                    $objPHPExcel->getActiveSheet()->getCell("B".$count)->getValue()!=null &&
                    $objPHPExcel->getActiveSheet()->getCell("C".$count)->getValue()!=null &&
                    $objPHPExcel->getActiveSheet()->getCell("D".$count)->getValue()!=null &&
                    $objPHPExcel->getActiveSheet()->getCell("E".$count)->getValue()!=null &&
                    $objPHPExcel->getActiveSheet()->getCell("F".$count)->getValue()!=null &&
                     $objPHPExcel->getActiveSheet()->getCell("G".$count)->getValue()!=null){
                        if ($cell=="A".$count) {
                            //Get Mechanism Name    
                            $column ='A';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
                                $organization_name = $data_value;
                            }    
                        } elseif($cell=="B".$count){
                            $column ='B';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$mechanism_name = $data_value;
                            }         
                        } elseif($cell=="C".$count){
                            $column ='C';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$datim_id = $data_value;
                            }         
                        } elseif($cell=="D".$count){
                            $column ='D';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$program_name = $data_value;
                            }         
                        } elseif($cell=="E".$count){
                            $column ='E';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$support_type = $data_value;
                            }         
                        } elseif($cell=="F".$count){
                            $column ='F';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='') {
								$cell = $objPHPExcel->getActiveSheet()->getCell('F'.$row );
								$InvDate= $cell->getValue();
								if(PHPExcel_Shared_Date::isDateTime($cell)) {
								     $InvDate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($InvDate)); 
								}	
								$start_date=$InvDate;
                            }         
                        } elseif($cell=="G".$count){
                        	$count=$count+1;
                            $column ='G';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value!='' ) {
								$cell = $objPHPExcel->getActiveSheet()->getCell('G'.$row );
								$InvDate= $cell->getValue();
								if(PHPExcel_Shared_Date::isDateTime($cell)) {
								     $InvDate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($InvDate)); 
								}	
								$end_date=$InvDate;
                                $data_rows=$data_rows+1;
								$update=$this->mechanisms_model->support_excel_import($organization_name,$mechanism_name,$datim_id,$program_name,$support_type,$start_date, $end_date);								
								if ($update!=1) {
									$this->mechanisms_model->support_import_errors($organization_name,$mechanism_name,$datim_id,$program_name,$support_type,$start_date, $end_date,$update);
								}
							}
                        //Get Rows With  Partial Column Data
                        }elseif($objPHPExcel->getActiveSheet()->getCell("A".$count)->getValue()!=null || $objPHPExcel->getActiveSheet()->getCell("B".$count)->getValue()!=null || $objPHPExcel->getActiveSheet()->getCell("C".$count)->getValue()!=null 
                        || $objPHPExcel->getActiveSheet()->getCell("D".$count)->getValue()!=null|| $objPHPExcel->getActiveSheet()->getCell("E".$count)->getValue()!=null
						|| $objPHPExcel->getActiveSheet()->getCell("F".$count)->getValue()!=null
						|| $objPHPExcel->getActiveSheet()->getCell("G".$count)->getValue()!=null){                       
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


	public function drop_mechanism_support($id){
        if($this->session->userdata('marker')!=1){
            redirect($this->index());
        }else{
            //Check If User Has Authority(program_magement) To delete Programs
            if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
                if($this->mechanisms_model->drop_mechanism_support($id)==TRUE){
                    header('Content-Type: application/x-json; charset=utf-8'); 
                    echo "The Mechanism Support Has Successfully Been Dropped";
                }else{
                    header('Content-Type: application/x-json; charset=utf-8'); 
                    echo "An Error Occured While Droping The Mechanism Support. Kindly Try Again";
                }               
            } else {
                $data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);           
            }       
        }  		
	}
    public function addnewmechanism()
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To  Create a Mechanism
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                if ($progress = $this->mechanisms_model->addnewmechanism() == TRUE) {
                    $message = $message = "The Mechanism Has Successfully Been Created";
                    redirect("/mechanisms/index/$message", 'refresh');
                } else {
                    $message = "An Error Occured At The " . $progress . " Stage Of Mechanism Creation. Kindly Try Again";
                    redirect("/mechanisms/index/$message", 'refresh');
                }
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }

    public function editmechanism($datim_id)
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            if ($this->user_model->get_user_role('program_management',$this->session->userdata('userroleid'))) {
                $data['page']='mechanisms-edit';
                $data['orgunits']=$this->mechanisms_model->get_all_orgunits();
                $data['programs']=$this->programs_model->all_programs_list();
                $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
                $data['mechanism']=$this->mechanisms_model->mechanism_info($datim_id);
                
                $this->load->view('template',$data);                        
            } else {
                $data['message']="Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error',$data);           
            }      
        }
    }
// Update a mechanism
    public function update_mechanism()
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Update Mechanism
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                $progress = $this->mechanisms_model->update_mechanism();
                if ($progress === TRUE) {

                    echo $message = "The Mechanism Has Successfully Been Updated";
                    // echo base_url("/programmanager/index/null/".$message);
                    redirect("/mechanisms/index/$message",'refresh');
                } else {

                    echo $message = $progress . " at Stage Of Mechanism Update. Kindly Try Again";
                     redirect("/mechanisms/index/$message",'refresh');
                    // echo base_url("/programmanager/index/null/".$message);
                }

            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }

     // Fetch Mechanism Details
    public function show_mechanism_details($datim_id)
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement)  to view details of a mechanism
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                if ($result = $this->mechanisms_model->show_mechanism_details($datim_id)) {

                    echo $data = json_encode($result);
                }
            }
        }

    }	
}
