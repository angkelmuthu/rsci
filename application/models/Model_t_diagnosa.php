<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_t_diagnosa extends MY_Model {

	private $primary_key 	= 'iddiag';
	private $table_name 	= 't_diagnosa';
	private $field_search 	= ['noreg', 'subjective', 'diag_awal', 'objective', 'asessment', 'plan', 'diag_akhir', 'createby', 'createdate'];

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
	                $where .= "t_diagnosa.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "t_diagnosa.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "t_diagnosa.".$field . " LIKE '%" . $q . "%' )";
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
	                $where .= "t_diagnosa.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "t_diagnosa.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "t_diagnosa.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('t_diagnosa.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

    public function join_avaiable() {
        $this->db->join('icd', 'icd.code = t_diagnosa.diag_awal', 'LEFT');
        $this->db->join('icd icd1', 'icd1.code = t_diagnosa.diag_akhir', 'LEFT');
        
        return $this;
    }

    public function filter_avaiable() {
        $this->db->where('createby', get_user_data('id'));
        
        return $this;
    }

}

/* End of file Model_t_diagnosa.php */
/* Location: ./application/models/Model_t_diagnosa.php */