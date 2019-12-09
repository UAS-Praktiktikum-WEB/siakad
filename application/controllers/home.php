<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('template');
        
    }
	public function index()
	{
        $data['judul']='';
		if ($this->session->userdata('logged_in') !=""){
			$this->template->display('dashboard', $data);
		}
		else{
			$this->load->view('v_login', $data);
		}	
	}
}
