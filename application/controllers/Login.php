<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->library('template');
		$this->load->helper('url');
		$this->load->model('app_model','login');
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
   
    public function login_app()
	{			
		$data['judul']='';
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');	
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('v_login',$data);

		}
		else
		{
			$dt['username'] = $this->input->post('username');
			$dt['password'] = $this->input->post('password');
			$this->login->getLoginData($dt);
        }
    }

    function logout()
	{
		$this->session->sess_destroy();
		header('location:'.base_url().'');
	}
	
}
