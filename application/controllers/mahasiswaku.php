<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswaku extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('mahasiswa');
        
    }
	public function index()
	{
        $data['judul']='';
		if ($this->session->userdata('logged_in') !=""){
			$this->mahasiswa->display('dashboard', $data);
		}
		else{
			$this->load->view('v_login', $data);
		}	
	}
}
