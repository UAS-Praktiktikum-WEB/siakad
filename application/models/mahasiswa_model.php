<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mahasiswa_Model extends CI_Model {
	
	var $table = 'tbl_mahasiswa';
    var $column_order = array('npm','nama','alamat','tempat_lahir','tgl_lahir','program_studi');
    var $column_search = array('npm','nama','alamat','tempat_lahir','tgl_lahir','program_studi');
    var $order = array('npm' => 'asc'); 
	 
	function __construct()
	{
	  parent::__construct();
	} 
	
    private function _get_datatables_query()
    {         
        
        $this->db->from($this->table);
        $i = 0;     
        $cstring="";
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {                 
                if($i===0) // first loop
                {
                    $cstring="(".$item." like '%".$_POST['search']['value']."%'";
                }
                else
                {
                    $cstring=$cstring." or ".$item." like '%".$_POST['search']['value']."%'";
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $cstring=$cstring.")";
            }
            $i++;
        }
        if ($cstring<>"")
        $this->db->where($cstring);
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

	function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        $query = $this->db->get();
		return $query->num_rows();		
    }		
	
	public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('npm',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($data, $where)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('npm', $id);
        $this->db->delete($this->table);
    }

    public function get_program_studi()
    {
        $this->db->from('tbl_program_studi');
        $result = $this->db->get();
        $dd['-'] = '--Pilih Program Studi--';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $dd[$row->program_studi] = $row->nama_program_studi;
            }
        }
        return $dd;     
    }
}