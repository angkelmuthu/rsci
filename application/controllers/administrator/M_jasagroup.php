<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| M Jasagroup Controller
*| --------------------------------------------------------------------------
*| M Jasagroup site
*|
*/
class M_jasagroup extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_m_jasagroup');
	}

	/**
	* show all M Jasagroups
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('m_jasagroup_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['m_jasagroups'] = $this->model_m_jasagroup->get($filter, $field, $this->limit_page, $offset);
		$this->data['m_jasagroup_counts'] = $this->model_m_jasagroup->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/m_jasagroup/index/',
			'total_rows'   => $this->model_m_jasagroup->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('M Jasagroup List');
		$this->render('backend/standart/administrator/m_jasagroup/m_jasagroup_list', $this->data);
	}
	
	/**
	* Add new m_jasagroups
	*
	*/
	public function add()
	{
		$this->is_allowed('m_jasagroup_add');

		$this->template->title('M Jasagroup New');
		$this->render('backend/standart/administrator/m_jasagroup/m_jasagroup_add', $this->data);
	}

	/**
	* Add New M Jasagroups
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('m_jasagroup_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('jasagroup', 'Jasa Group', 'trim|required|max_length[75]');
		$this->form_validation->set_rules('kdjasajenis', 'Jasa Jenis', 'trim|required|max_length[11]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'jasagroup' => $this->input->post('jasagroup'),
				'kdjasajenis' => $this->input->post('kdjasajenis'),
			];

			
			$save_m_jasagroup = $this->model_m_jasagroup->store($save_data);

			if ($save_m_jasagroup) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_m_jasagroup;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/m_jasagroup/edit/' . $save_m_jasagroup, 'Edit M Jasagroup'),
						anchor('administrator/m_jasagroup', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/m_jasagroup/edit/' . $save_m_jasagroup, 'Edit M Jasagroup')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_jasagroup');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_jasagroup');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view M Jasagroups
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('m_jasagroup_update');

		$this->data['m_jasagroup'] = $this->model_m_jasagroup->find($id);

		$this->template->title('M Jasagroup Update');
		$this->render('backend/standart/administrator/m_jasagroup/m_jasagroup_update', $this->data);
	}

	/**
	* Update M Jasagroups
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('m_jasagroup_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('jasagroup', 'Jasa Group', 'trim|required|max_length[75]');
		$this->form_validation->set_rules('kdjasajenis', 'Jasa Jenis', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'jasagroup' => $this->input->post('jasagroup'),
				'kdjasajenis' => $this->input->post('kdjasajenis'),
			];

			
			$save_m_jasagroup = $this->model_m_jasagroup->change($id, $save_data);

			if ($save_m_jasagroup) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/m_jasagroup', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_jasagroup');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_jasagroup');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete M Jasagroups
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('m_jasagroup_delete');

		$this->load->helper('file');

		$arr_id = $this->input->get('id');
		$remove = false;

		if (!empty($id)) {
			$remove = $this->_remove($id);
		} elseif (count($arr_id) >0) {
			foreach ($arr_id as $id) {
				$remove = $this->_remove($id);
			}
		}

		if ($remove) {
            set_message(cclang('has_been_deleted', 'm_jasagroup'), 'success');
        } else {
            set_message(cclang('error_delete', 'm_jasagroup'), 'error');
        }

		redirect_back();
	}

		/**
	* View view M Jasagroups
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('m_jasagroup_view');

		$this->data['m_jasagroup'] = $this->model_m_jasagroup->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('M Jasagroup Detail');
		$this->render('backend/standart/administrator/m_jasagroup/m_jasagroup_view', $this->data);
	}
	
	/**
	* delete M Jasagroups
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$m_jasagroup = $this->model_m_jasagroup->find($id);

		
		
		return $this->model_m_jasagroup->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('m_jasagroup_export');

		$this->model_m_jasagroup->export('m_jasagroup', 'm_jasagroup');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('m_jasagroup_export');

		$this->model_m_jasagroup->pdf('m_jasagroup', 'm_jasagroup');
	}
}


/* End of file m_jasagroup.php */
/* Location: ./application/controllers/administrator/M Jasagroup.php */