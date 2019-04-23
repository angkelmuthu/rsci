<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Asessment Controller
*| --------------------------------------------------------------------------
*| Form Asessment site
*|
*/
class Form_asessment extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_asessment');
	}

	/**
	* show all Form Asessments
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_asessment_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_asessments'] = $this->model_form_asessment->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_asessment_counts'] = $this->model_form_asessment->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/form_asessment/index/',
			'total_rows'   => $this->model_form_asessment->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Asessment Perawat List');
		$this->render('backend/standart/administrator/form_builder/form_asessment/form_asessment_list', $this->data);
	}

	/**
	* Update view Form Asessments
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_asessment_update');

		$this->data['form_asessment'] = $this->model_form_asessment->find($id);

		$this->template->title('Asessment Perawat Update');
		$this->render('backend/standart/administrator/form_builder/form_asessment/form_asessment_update', $this->data);
	}

	/**
	* Update Form Asessments
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_asessment_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('noreg', 'Noreg', 'trim|required|callback_valid_number');
		$this->form_validation->set_rules('berat_badan', 'Berat Badan', 'trim|required|callback_valid_number');
		$this->form_validation->set_rules('tinggi', 'Tinggi', 'trim|required|callback_valid_number');
		$this->form_validation->set_rules('tekanan_darah', 'Tekanan Darah', 'trim|required|callback_valid_number');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'noreg' => $this->input->post('noreg'),
				'berat_badan' => $this->input->post('berat_badan'),
				'tinggi' => $this->input->post('tinggi'),
				'tekanan_darah' => $this->input->post('tekanan_darah'),
			];

			
			$save_form_asessment = $this->model_form_asessment->change($id, $save_data);

			if ($save_form_asessment) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_asessment', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_asessment');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_asessment');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Asessments
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_asessment_delete');

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
            set_message(cclang('has_been_deleted', 'Form Asessment'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Asessment'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Asessments
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_asessment_view');

		$this->data['form_asessment'] = $this->model_form_asessment->find($id);

		$this->template->title('Asessment Perawat Detail');
		$this->render('backend/standart/administrator/form_builder/form_asessment/form_asessment_view', $this->data);
	}

	/**
	* delete Form Asessments
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_asessment = $this->model_form_asessment->find($id);

		
		return $this->model_form_asessment->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_asessment_export');

		$this->model_form_asessment->export('form_asessment', 'form_asessment');
	}
}


/* End of file form_asessment.php */
/* Location: ./application/controllers/administrator/Form Asessment.php */