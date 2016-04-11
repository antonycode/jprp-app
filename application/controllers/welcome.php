<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');     
		$this->load->model('datasets'); 
    }
	public function index(){
		$sections=$this->datasets->datasections();
		$this->load->view('login');
	}
}

