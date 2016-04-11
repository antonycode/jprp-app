<?php
/**
 * Created by IntelliJ IDEA.
 * User: banga
 * Date: 14/09/15
 * Time: 11:16
 */

class Implementing_mechanism extends CI_Controller
{

    function __construct()
    {
        parent:: __construct();
        $this->load->helper('url');
        $this->load->model('implementing_mechanism_model');
        $this->load->model('programs_model');
        $this->load->model('user_model');
    }

    public function upload_view()
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                $data["support"] = $this->implementing_mechanism_model->mechanism_support_list();
                $data['mechanism_right'] = $this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'));
                $data['page'] = 'upload_ipsl';
                $data['import_errors'] = $this->implementing_mechanism_model->mechanisms_support_errors();
                $data['error_message'] = str_replace("%20", " ", "");
                $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
                $this->load->view('template', $data);
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }

    public function index()
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                $data["support"] = $this->implementing_mechanism_model->mechanism_support_list();
                $data["programs"] = $this->implementing_mechanism_model->mechanism_programs_list();
                $data['mechanism_right'] = $this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'));
                $data['page'] = 'mechanism_support-list';
                $data['error_message'] = str_replace("%20", " ", "");
                $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
                $this->load->view('template', $data);
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }

    public function supportexcelimport()
    {
        $file_name = substr($this->input->get('url'), strpos($this->input->get('url'), "?file=") + 6);
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Import Support
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
//                $file = "C:\\xampp\\htdocs\\attribution\\server\\php\\files\\suportimport.xlsx";
                $file="~/home/banga/Downloads/suportimport.xlsx";
                $no_empty_rows = TRUE;
                $this->implementing_mechanism_model->empty_attribution_mechanisms();
                $this->load->library('excel');
                //read file from path
                $objPHPExcel = PHPExcel_IOFactory::load($file);
                $sheetname = 'MER category option combos';
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
                $empty_cells_alert = "";
                $count = 1;
                $empty_column = 1;
                $data_rows = 1;
                $mechanisms_name = "";
                $mechanisms_id = "";
                $mechanisms_uid = "";
                $attribution_key = "";
                //extract to a PHP readable array format
                //print_r($cell_collection);
                foreach ($cell_collection as $cell) {

                    //Only Get Rows With All Columns Filled
                    if ($objPHPExcel->getActiveSheet()->getCell("A" . $count)->getValue() != null &&
                        $objPHPExcel->getActiveSheet()->getCell("B" . $count)->getValue() != null &&
                        $objPHPExcel->getActiveSheet()->getCell("C" . $count)->getValue() != null &&
                        $objPHPExcel->getActiveSheet()->getCell("D" . $count)->getValue() != null &&
                        $objPHPExcel->getActiveSheet()->getCell("E" . $count)->getValue() != null &&
                        $objPHPExcel->getActiveSheet()->getCell("F" . $count)->getValue() != null &&
                        $objPHPExcel->getActiveSheet()->getCell("G" . $count)->getValue() != null
                    ) {
                        if ($cell == "A" . $count) {
                            //Get Mechanism Name
                            $column = 'A';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $organization_name = $data_value;
                            }
                        } elseif ($cell == "B" . $count) {
                            $column = 'B';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $mechanism_name = $data_value;
                            }
                        } elseif ($cell == "C" . $count) {
                            $column = 'C';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $datim_id = $data_value;
                            }
                        } elseif ($cell == "D" . $count) {
                            $column = 'D';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $program_name = $data_value;
                            }
                        } elseif ($cell == "E" . $count) {
                            $column = 'E';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $support_type = $data_value;
                            }
                        } elseif ($cell == "F" . $count) {
                            $column = 'F';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $cell = $objPHPExcel->getActiveSheet()->getCell('F' . $row);
                                $InvDate = $cell->getValue();
                                if (PHPExcel_Shared_Date::isDateTime($cell)) {
                                    $InvDate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($InvDate));
                                }
                                $start_date = $InvDate;
                            }
                        } elseif ($cell == "G" . $count) {
                            $count = $count + 1;
                            $column = 'G';
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1 && $data_value != '') {
                                $cell = $objPHPExcel->getActiveSheet()->getCell('G' . $row);
                                $InvDate = $cell->getValue();
                                if (PHPExcel_Shared_Date::isDateTime($cell)) {
                                    $InvDate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($InvDate));
                                }
                                $end_date = $InvDate;
                                $data_rows = $data_rows + 1;


                                $update = $this->implementing_mechanism_model->support_excel_import($organization_name, $mechanism_name, $datim_id, $program_name, $support_type, $start_date, $end_date);
                                if ($update != 1) {
                                    $this->implementing_mechanism_model->support_import_errors($organization_name, $mechanism_name, $datim_id, $program_name, $support_type, $start_date, $end_date, $update);
                                }

                            }
                            //Get Rows With  Partial Column Data
                        } elseif ($objPHPExcel->getActiveSheet()->getCell("A" . $count)->getValue() != null || $objPHPExcel->getActiveSheet()->getCell("B" . $count)->getValue() != null || $objPHPExcel->getActiveSheet()->getCell("C" . $count)->getValue() != null
                            || $objPHPExcel->getActiveSheet()->getCell("D" . $count)->getValue() != null || $objPHPExcel->getActiveSheet()->getCell("E" . $count)->getValue() != null
                            || $objPHPExcel->getActiveSheet()->getCell("F" . $count)->getValue() != null
                            || $objPHPExcel->getActiveSheet()->getCell("G" . $count)->getValue() != null
                        ) {
                            $empty_cells_alert[$empty_column] = "Empty Cell In Row $count";
                            $empty_column = $empty_column + 1;
                            $count = $count + 1;
                            $no_empty_rows = FALSE;
                        }


                    }

                }
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

    public function drop_mechanism_support($id)
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To delete Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                if ($this->implementing_mechanism_model->drop_mechanism_support($id) == TRUE) {
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo "The Mechanism Support Has Successfully Been Dropped";
                } else {
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo "An Error Occured While Droping The Mechanism Support. Kindly Try Again";
                }
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }

}