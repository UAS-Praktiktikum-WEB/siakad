<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->load->helper('url');	
		$this->load->model('mahasiswa_model','mahasiswa');					
	}

	public function index()
	{
		$data['judul'] = 'Mahasiswa ';
        $data['status'] = '';

        // data untuk dropdown menu 
        $data['dd_program_studi'] = $this->mahasiswa->get_program_studi();
		$this->template->display('admin/v_mahasiswa', $data);
	}

	public function ajax_list()
    {		
        $list = $this->mahasiswa->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $mahasiswa) {
            $no++;
            $row = array();
			$row[] = $no;
            $row[] = $mahasiswa->npm;					 			
            $row[] = $mahasiswa->nama;
            $row[] = $mahasiswa->alamat;
            $row[] = $mahasiswa->tempat_lahir;
			$row[] = date_format(date_create($mahasiswa->tgl_lahir), 'd-m-Y');
			$row[] = $mahasiswa->program_studi;			
			$row[] = "<div class='btn-group'>                      
                      <button type='button' class='btn btn-danger dropdown-toggle btn-xs' data-toggle='dropdown' aria-expanded='false'>
                        <span class='caret'></span>
                        <span class='sr-only'>Toggle Dropdown</span>
                      </button>
                      <ul class='dropdown-menu pull-right' role='menu'>
                        <li><a href='javascript:void(0)' title='View' onclick='view_mahasiswa(".'"'.$mahasiswa->npm.'"'.")'>View</a>
                        </li>
                        <li><a href='javascript:void(0)' title='Edit' onclick='edit_mahasiswa(".'"'.$mahasiswa->npm.'"'.")'>Edit</a>
                        </li>
                        <li><a href='javascript:void(0)' title='Delete' onclick='delete_mahasiswa(".'"'.$mahasiswa->npm.'"'.")'>Delete</a>
                        </li>
                      </ul>
                    </div>";
            //add html for action
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->mahasiswa->count_all(),
                        "recordsFiltered" => $this->mahasiswa->count_filtered(),
                        "data" => $data
                );
        //output to json format
        echo json_encode($output);
	}

    public function ajax_edit($id)
    {
        $data = $this->mahasiswa->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('npm','NPM','required|is_natural');
        $this->form_validation->set_rules('nama','Nama Mahasiswa','required|alpha');
        $this->form_validation->set_rules('program_studi','Program Studi','required',
            array(
                'required'      => 'You have not provided %s.'
            ));
        if ($this->form_validation->run()){
            $data = array(
                'npm' => $this->input->post('npm'),
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),             
                'tgl_lahir' => $this->input->post('tgl_lahir'),              
                'program_studi' => $this->input->post('program_studi')
            );
            $insert = $this->mahasiswa->save($data);
            echo json_encode(array("status" => TRUE));
        } else {
            $errors = array(
                'status'   => false,
                'npm_error' => form_error('npm'),
                'nama_error' => form_error('nama'),
                'program_studi_error' => form_error('program_studi')
            );
            echo json_encode($errors);
        }
    }

    public function ajax_update()
    {
        $data = array(
                'npm' => $this->input->post('npm'),
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),             
                'tgl_lahir' => $this->input->post('tgl_lahir'),              
                'program_studi' => $this->input->post('program_studi')
            );
        $this->mahasiswa->update($data, array('npm' => $this->input->post('hnpm')));
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->mahasiswa->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
