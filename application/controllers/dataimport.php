<?php


/**
 * Created by PhpStorm.
 * User: the_fegati
 * Date: 9/2/15
 * Time: 9:53 AM
 */
class Dataimport extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('dataimport_model');
		$this->load->model('user_model');	
    }

    function index()
    {
        $data['page'] = 'data-import';
        $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
        $data['orgUnits'] = $this->dataimport_model->get_orgunits();
        $this->load->view('template', $data);
    }

    function fetch_data()
    {
        $data_array = "";
        $update_array = "";
        $stats_array = "";
        $total_fetched = 0;
        $success = 0;
        $blank_values = 0;
        $stats_counter = 0;

        $count = 0;
        $datasets = $this->input->post('datasets');
        # API login Credentials
        $username = "gigi10";
        $password = "Gichangi123";

        $period = $this->input->post('startDate');


        $periodid = $this->dataimport_model->check_period($period);

        //get orgunits from dataimport_model and loop fetching data for each
        $orgUnits = $this->input->post('orgUnits');
        foreach ($datasets as $key => $value) {
            $dataset = $value;

            foreach ($orgUnits as $key => $value) {

                //HTTP GET request -Using Curl -Response JSON

                $orgUnit = $value;

                // $url ="http://test.hiskenya.org/api/dataSets/"."$dataset"."/dataValueSet?";
                $url = "http://41.89.93.236:8080/api/dataValueSets.json?dataSet=" . $dataset . "&period=" . $period . "&orgUnit=" . $orgUnit . "&children=false";
				//echo $url;


                //$data = array("period" => "$period", "orgUnit" => "$orgUnit");
                //$data_string = http_build_query($data);
                //  $url.="$data_string";

                // initailizing curl
                $ch = curl_init();
                //curl options
                curl_setopt($ch, CURLOPT_POST, false);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
                //execute
                $result = curl_exec($ch);

                //close connection
                curl_close($ch);

                // print_r($result); die();
                if ($result) {
                    $json = json_decode($result, TRUE);
                    if (isset($json['dataValues'])) {
                        $total_fetched = $total_fetched +  sizeof($json['dataValues']);
                        foreach ($json['dataValues'] as $key => $val) {
                            //echo ."  ".." ".$val["period"]."  ".$val["value"];
                            $dataelementid = $this->dataimport_model->get_dataelement_id($val["dataElement"]);
                            $categoryoptioncomboid = 15;
                            $attributeoptioncomboid = 15;
                            $sourceid = $this->dataimport_model->get_orgunit_id($val["orgUnit"]);
                            $storedby = $val["storedBy"];
                            $lastupdated = $val["lastUpdated"];
                            $value = $val["value"];
                            $followup = $val["followUp"];
                            $updateid = $dataelementid.$sourceid.$periodid;
                            if(isset($value)){
                                $data_array[$count] = array(
                                    "dataelementid" => $dataelementid,
                                    "periodid" => $periodid,
                                    "sourceid" => $sourceid,
                                    "categoryoptioncomboid" => $categoryoptioncomboid,
                                    "attributeoptioncomboid" => $attributeoptioncomboid,
                                    "value" => $value,
                                    "storedby" => $storedby,
                                    "created" => $lastupdated,
                                    "lastupdated" => $lastupdated,
                                    "followup" => "false",
                                    "updateid" => $updateid
                                );

                                $update_array[$count] = array(
                                    "value" => $value,
                                    "storedby" => $storedby,
                                    "created" => $lastupdated,
                                    "lastupdated" => $lastupdated,
                                    "updateid" => $updateid
                                );

                            }else{
                                $blank_values = $blank_values + 1;
                            }
                            $count = $count + 1;


                            if ($count == 1000) {
                                $success = $success + 1000;
                                $this->dataimport_model->bulk_dumb($data_array, $update_array);
                                $count = 0;
                                unset($data_array);
                            }
                        }
                        if ($data_array != "") {
                            $success = $success + sizeof($data_array);
                            $this->dataimport_model->bulk_dumb($data_array, $update_array);
                            unset($data_array);
                        }

                    } else {

                       // echo -1;
                    }

                }

            }
            $stats_counter ++;
            $dataset_name = $this->dataimport_model->get_dataset($dataset);

            $stats_array[$stats_counter]["dataset"] = $dataset_name;
            $stats_array[$stats_counter]["fetched"] = $total_fetched;
            $stats_array[$stats_counter]["success"] = $success;
            $stats_array[$stats_counter]["blank"] = $blank_values;

            $total_fetched = 0;
            $success = 0;
        }
        $data['page'] = 'import-stats';
        $data['stats'] = $stats_array;
        $data['menu'] = $this->user_model->menu_items($this->session->userdata('userroleid'));
                 $data['agencyname']=$this->session->userdata('groupname');
        $this->load->view('template', $data);

    }
}