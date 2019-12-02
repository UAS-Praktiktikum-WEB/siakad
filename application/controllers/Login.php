<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->library('template');
		$this->load->model('app_model','app');
    }
	public function index()
	{
		if ($this->session->userdata('logged_in') !=""){
			$this->template->display('dashboard', $data);
		}
		else{
			$this->load->view('v_login', $data);
		}	
    }
   
    public function login_app()
	{			
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password]|md5');	
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('v_login');
		}
		else
		{
			$dt['username'] = $this->input->post('username');
			$dt['password'] = md5($this->input->post('password'));
			$this->app->getLoginData($dt);
        }
    }

    function logout()
	{
		$this->session->sess_destroy();
		header('location:'.base_url().'');
	}
	
}
