<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_m_pasien extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'm_pasien';
	private $field_search 	= ['nomr', 'pasien', 'tmp_lhr', 'tgl_lhr', 'nik', 'tgl_reg'];

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
		 );

		parent::__construct($config);
	}

	public function count_all($q = null, $field = null)
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
	        foreach ($this->field_search as $field) {
	            if ($iterasi == 1) {
	                $where .= "m_pasien.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "m_pasien.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "m_pasien.".$field . " LIKE '%" . $q . "%' )";
        }

		$this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
		$query = $this->db->get($this->table_name);

		return $query->num_rows();
	}

	public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
	        foreach ($this->field_search as $field) {
	            if ($iterasi == 1) {
	                $where .= "m_pasien.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "m_pasien.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "m_pasien.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('m_pasien.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

    /*function getid()
    {
        $query=$this->db->query("SELECT `AUTO_INCREMENT`
								FROM  INFORMATION_SCHEMA.TABLES
								WHERE TABLE_SCHEMA = 'DatabaseName'
								AND   TABLE_NAME   = 'TableName';");
        return $query->result();
    }*/	

    public function join_avaiable() {
        
        return $this;
    }

    public function filter_avaiable() {
        
        return $this;
    }

}

/* End of file Model_m_pasien.php */
/* Location: ./application/models/Model_m_pasien.php */