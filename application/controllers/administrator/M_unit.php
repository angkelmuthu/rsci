<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| M Unit Controller
*| --------------------------------------------------------------------------
*| M Unit site
*|
*/
class M_unit extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_m_unit');
	}

	/**
	* show all M Units
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('m_unit_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['m_units'] = $this->model_m_unit->get($filter, $field, $this->limit_page, $offset);
		$this->data['m_unit_counts'] = $this->model_m_unit->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/m_unit/index/',
			'total_rows'   => $this->model_m_unit->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('M Unit List');
		$this->render('backend/standart/administrator/m_unit/m_unit_list', $this->data);
	}
	
	/**
	* Add new m_units
	*
	*/
	public function add()
	{
		$this->is_allowed('m_unit_add');

		$this->template->title('M Unit New');
		$this->render('backend/standart/administrator/m_unit/m_unit_add', $this->data);
	}

	/**
	* Add New M Units
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('m_unit_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('unit', 'Unit', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('aktif', 'Aktif', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'unit' => $this->input->post('unit'),
				'aktif' => $this->input->post('aktif'),
			];

			
			$save_m_unit = $this->model_m_unit->store($save_data);

			if ($save_m_unit) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_m_unit;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/m_unit/edit/' . $save_m_unit, 'Edit M Unit'),
						anchor('administrator/m_unit', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/m_unit/edit/' . $save_m_unit, 'Edit M Unit')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_unit');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_unit');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view M Units
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('m_unit_update');

		$this->data['m_unit'] = $this->model_m_unit->find($id);

		$this->template->title('M Unit Update');
		$this->render('backend/standart/administrator/m_unit/m_unit_update', $this->data);
	}

	/**
	* Update M Units
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('m_unit_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('unit', 'Unit', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('aktif', 'Aktif', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'unit' => $this->input->post('unit'),
				'aktif' => $this->input->post('aktif'),
			];

			
			$save_m_unit = $this->model_m_unit->change($id, $save_data);

			if ($save_m_unit) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/m_unit', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_unit');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_unit');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete M Units
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('m_unit_delete');

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
            set_message(cclang('has_been_deleted', 'm_unit'), 'success');
        } else {
            set_message(cclang('error_delete', 'm_unit'), 'error');
        }

		redirect_back();
	}

		/**
	* View view M Units
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('m_unit_view');

		$this->data['m_unit'] = $this->model_m_unit->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('M Unit Detail');
		$this->render('backend/standart/administrator/m_unit/m_unit_view', $this->data);
	}
	
	/**
	* delete M Units
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$m_unit = $this->model_m_unit->find($id);

		
		
		return $this->model_m_unit->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('m_unit_export');

		$this->model_m_unit->export('m_unit', 'm_unit');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('m_unit_export');

		$this->model_m_unit->pdf('m_unit', 'm_unit');
	}
}


/* End of file m_unit.php */
/* Location: ./application/controllers/administrator/M Unit.php */