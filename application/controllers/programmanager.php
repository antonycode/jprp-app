<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Programmanager extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('datasets_model');
        $this->load->model('partner_model');
        $this->load->model('programs_model');
        $this->load->model('user_model');
    }

    //Default Function Get User ID:$uid to resolve usergroupid
    public function index($uid = null, $errors = null)
    {
        if ($this->session->userdata('marker') != 1) {
            $auth = $this->sessionmanager($uid);
            if ($auth) {
                $data['page'] = 'programs-list';
                //Get All The Programs from All The Datasets From Database
                $data['programs'] = $this->programs_model->all_programs_list();
                $data['attribution_right'] = $this->user_model->get_user_role('attribution', $this->session->userdata('userroleid'));
                $data['program_right'] = $this->user_model->get_user_role('program_create', $this->session->userdata('userroleid'));
				$data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                $data['error_message'] = str_replace("%20", " ", $errors);
                //Get programs and the implementation partners
                $data['agencyname'] = $this->session->userdata('groupname');
                $this->load->view('template', $data);
            }

        } else {
            //Skip Creating a new session Key
            $data['page'] = 'programs-list';
            $data['attribution_right'] = $this->user_model->get_user_role('attribution', $this->session->userdata('userroleid'));
            $data['program_right'] = $this->user_model->get_user_role('program_create', $this->session->userdata('userroleid'));
            $data['agencyname'] = $this->session->userdata('groupname');
			$data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
            $data['error_message'] = str_replace("%20", " ", $errors);
            $data['programs'] = $this->programs_model->all_programs_list();
            $this->load->view('template', $data);
        }

    }


    //Customize the session fields to add marker and group value
    //Get the sessions and there roles
    public function sessionmanager($uid)
    {
        //Get User Group UID
        $groupid = $this->partner_model->getsessionuser($uid);
        if ($groupid != "error1" && $groupid != "error2") {
        	//CheckIF User Has Been ALlocated A Role
        	$groupname = $this->partner_model->getsessiongroupname($groupid);
        	$userrole=$this->partner_model->get_userrole($uid);
			if ($userrole=="false") {
				$data['message'] = "Kindly Contact The Administrator User Desnot Exists";
				$this->load->view('error', $data);
				die();
			} else {
				if ($userrole->attributionroleid!="") {
					$roleid=$userrole->attributionroleid;
				} else {
					$roleid=$groupname->attributionroleid;
				}			
			}
            //Get User Gender
            $gender = $this->partner_model->gender($uid);
            $newdata = array(
                'marker' => '1',
                'groupid' => $groupid,
                'groupname' => $groupname->name,
                'group_uid'=>$groupname->uid,
                'gender' => $gender->gender,
                'userid' => $gender->userinfoid,
                'useruid' => $uid,
                'name'=>$gender->firstname,
                'logged_in' => TRUE,
                'userroleid'=>$roleid,
                'username'=>$this->partner_model->get_username($uid)
            );
            $this->session->set_userdata($newdata);
            return true;

        } else {
            $newdata = array(
                'marker' => '0',
                'groupid' => '',
                'useruid' => $uid,
                'logged_in' => FALSE
            );
            $this->session->set_userdata($newdata);
            if ($groupid == "error1") {
                $data['message'] = "Kindly Contact The Administrator You Have Been Allocated More Than One User Group";
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have Not Been Allocated A User Groups";
            }
            $this->load->view('error', $data);
        }
    }

    public function createprogram()
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_create', $this->session->userdata('userroleid'))) {
                $data['page'] = 'programs-create';
//                Steve: Get data sets from Database
                $data['datasets'] = $this->programs_model->get_datasets();
                $data['datasetmembers'] = $this->programs_model->get_datasetmembers();
//                End Steve
                //Get All The Dataelements From Database
                $data['dataelements'] = $this->programs_model->get_dataelements();
                //Get programs and the implementation partners
                $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                $data['agencyname'] = $this->session->userdata('groupname');
                $this->load->view('template', $data);
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }

    public function addnewprogram()
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                if ($progress = $this->programs_model->newprogram() == TRUE) {
                    $message = $message = "The Program Has Successfully Been Created";
                    redirect("/programmanager/index/null/$message", 'refresh');
                } else {
                    $message = "An Error Occured At The " . $progress . " Stage Of Program Creation. Kindly Try Again";
                    redirect("/programmanager/null/$message", 'refresh');
                }
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }

    public function editprogram($programid)
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                $data["program_details"] = $this->programs_model->program_info($programid);
                $data["program_dataelements"] = $this->programs_model->get_program_dataelements($programid);
                $data["available"] = $this->programs_model->get_available_elements($programid);
                $data['page'] = 'programs-edit';
                $data['agencyname'] = $this->session->userdata('groupname');
                 // Steve: Get data sets from Database
                 $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                $data['datasets'] = $this->programs_model->get_datasets();
                $data['datasetmembers'] = $this->programs_model->get_datasetmembers();
//                End Steve
                $this->load->view('template', $data);
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }

    public function check_program_exists_archive($program_id)
    {
        echo $this->programs_model->check_program_exists_archive($program_id);
    }

    public function updateprogram_archive($program_id)
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {

                if ($progress = $this->programs_model->create_program_dataelements_archive($program_id) == TRUE) {

                    echo $message = $message = "The Program Has Successfully Been Updated and Archived";

                } else {

                    echo $message = "An Error Occured At The " . $progress . " Stage Of Program Update. Kindly Try Again";
                }

            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }

    public function updateprogram($program_id)
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                $progress = $this->programs_model->update_program($program_id);
                if ($progress === TRUE) {

                    echo $message = "The Program Has Successfully Been Updated";
                    // echo base_url("/programmanager/index/null/".$message);
//                        redirect("/programmanager/index/null/$message",'refresh');
                } else {

                    echo $message = $progress . " at Stage Of Program Update. Kindly Try Again";
                    // echo base_url("/programmanager/index/null/".$message);
                }

            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }

    public function check_changes_program_dataelements($program_id)
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                if ($progress = $this->programs_model->check_change_in_program_dataelements($program_id) === TRUE) {
//                    Data elements not changed
                    echo 0;
                }

                if ($progress = $this->programs_model->check_change_in_program_dataelements($program_id) === FALSE) {
//                    Data elements changed
                    echo -1;
                }
            }
        }
    }


    public function viewprogram($program_id)
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                $data["program_details"] = $this->programs_model->program_info($program_id);
                $data["program_dataelements"] = $this->programs_model->get_program_dataelements($program_id);
                $data['page'] = 'programs-view';
				$data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                $data['agencyname'] = $this->session->userdata('groupname');
                $this->load->view('template', $data);
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }


    public function deleteprogram($program_id)
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement) To Create Programs
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                if ($this->programs_model->deleteprogram($program_id) == TRUE) {
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo "The Program Has Successfully Been Deleted";
                } else {
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo "An Error Occured While Deleting The Program. Kindly Try Again";
                }
            } else {
                $data['message'] = "Kindly Contact The Administrator You Have No Access Rights To This Module";
                $this->load->view('error', $data);
            }
        }
    }


    // Show Program Details
    public function show_program_details($program_id)
    {
        if ($this->session->userdata('marker') != 1) {
            redirect($this->index());
        } else {
            //Check If User Has Authority(program_magement)  to view details of a program
            if ($this->user_model->get_user_role('program_management', $this->session->userdata('userroleid'))) {
                if ($result = $this->programs_model->show_program_details($program_id)) {

                    echo $data = json_encode($result);
                }
            }
        }

    }


    //Get Data Set Section Elements: $secid:-Section id
    public function sectionelements($secid)
    {
        $data['page'] = 'programselements';
        $data['programname'] = $this->datasets_model->programname($secid);
        $data['orgunits'] = $this->programs_model->sectionorgunits($secid);
        $data['elements'] = $this->datasets_model->datasectionselements($secid);
		$data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
        $data['agencyname'] = $this->session->userdata('groupname');
        $this->load->view('template', $data);
    }

    //Impelementing partner target support program $pid:partner id
    function sectionimplementation($secid)
    {
        //Implementing Portal page
        $data['page'] = 'ipportal';
        //Available Organization units for support
        $data['av_org'] = $this->programs_model->availableorgunits($secid);
        //Implementer supported organization units
        //Parse sectionid:pid and implementing partner id:ippid
        $data['ip_org'] = $this->programs_model->ipsectionorgunits($secid, $this->session->userdata('groupid'));
        $data['programname'] = $this->datasets_model->programname($secid);
        $data['elements'] = $this->datasets_model->datasectionselements($secid);
        $data['sectionid'] = $secid;
		$data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
        $data['agencyname'] = $this->session->userdata('groupname');
        //print_r($this->programs_model->ipsectionorgunits($secid,$this->session->userdata('groupid')));
        //echo "string $secid";
        //die();
        $this->load->view('template', $data);
    }

    //New Implementation Support Facilities 
    public function supportfacilities($secid)
    {
        $infoarray = array();
        if (isset($_POST["data"])) {
            $data = json_decode($_POST["data"]);
            $data_array = '';
            foreach ($data as $key => $value) {
                $infoarray[] = array(
                    "orguid" => $value->dxCode,
                    "start" => $value->dxSDate,
                    "end" => $value->dxEDate
                );
            }
        }
        if (sizeof($infoarray) <= 0) {
            header('Content-Type: application/x-json; charset=utf-8');
            echo "<span class='error'>Error! You Didn't Select Any Facility. Please Try Again</span>";
        }
        $result = $this->programs_model->attributioninfo($infoarray, $secid);
        if ($result != false) {
            $this->session->set_userdata('key', $result);
            $attribution = $this->programs_model->dataattribution($this->session->userdata('groupid'), $this->session->userdata('key'));
            if ($attribution == true) {
                header('Content-Type: application/x-json; charset=utf-8');
                echo "You Have Successfully Implemented the Program in The Facility(s) And Successfully Attributed Data For The Selected Period" . $this->session->userdata('key');
            } else {
                header('Content-Type: application/x-json; charset=utf-8');
                echo "<span class='error'>$attribution</span>";
            }
        } else {
            header('Content-Type: application/x-json; charset=utf-8');
            echo "<span class='error'>An Error Has Occured During Attribution Process Kindly Try Again</span>";
        }

    }


    public function dataattribution()
    {
        $attribution = $this->programs_model->dataattribution($this->session->userdata('groupid'), $this->session->userdata('key'));

        /*if ($attribution==true) {
            header('Content-Type: application/x-json; charset=utf-8');          
            echo  "You Have Successfully Attributed Data For The Selected Facilities"; 
        }else{
            header('Content-Type: application/x-json; charset=utf-8');          
            echo  "<span class='error'>$attribution</span>"; 
        }        */
    }


    //Load Edit Page For Update
    public function supportedit($orgid, $secid)
    {
        $data['ip_org'] = $this->programs_model->getfacility($orgid);
        $data['sectionid'] = $secid;
        $data['partnerid'] = $this->session->userdata('groupid');
        $data['facilityid'] = $orgid;
        $dates = $this->programs_model->getsecattribution($orgid, $secid);
        $data['start'] = $dates['start'];
        $data['end'] = $dates['end'];
		$data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
        $data['page'] = 'facilityedit';
        $data['agencyname'] = $this->session->userdata('groupname');
        $this->load->view('template', $data);
    }

    //Drop a facility
    public function dropfacility($orgid, $secid)
    {
        $status = $this->programs_model->dropfacility($orgid, $secid, $this->session->userdata('groupid'));
        if ($status) {
            header('Content-Type: application/x-json; charset=utf-8');
            echo "You Have Successfully dropped The Facility";
        } else {
            header('Content-Type: application/x-json; charset=utf-8');
            echo "An Error Has Occured. Please Try Again";
        }
    }


    // Update the Start and End Date
    public function supportfacilityedit($sourceid, $secid, $start, $end)
    {
        //Update sectionattribution table
        $status = $this->programs_model->updatefacility($sourceid, $this->session->userdata('groupid'), $secid, $start, $end);
        if ($status) {
            header('Content-Type: application/x-json; charset=utf-8');
            echo "Update Was Successfull";
        } else {
            header('Content-Type: application/x-json; charset=utf-8');
            echo "An Error Has Occured During The Update. Please Try Again";
        }

    }


    //Check If Implementing Partner Has Been Attributed $groupid:groupid
    public function categoryoptionattribution($groupid)
    {
        //return $this->partner_model->categoryoption($groupid);
        return "ok";
    }

    public function k2d()
    {
        $this->session->sess_destroy();
        redirect('http://localhost:8080/dhis/');
    }

}

