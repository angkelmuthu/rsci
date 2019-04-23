<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| T Asessment Controller
*| --------------------------------------------------------------------------
*| T Asessment site
*|
*/
class T_asessment extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_t_asessment');
	}

	/**
	* show all T Asessments
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('t_asessment_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['t_asessments'] = $this->model_t_asessment->get($filter, $field, $this->limit_page, $offset);
		$this->data['t_asessment_counts'] = $this->model_t_asessment->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/t_asessment/index/',
			'total_rows'   => $this->model_t_asessment->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('T Asessment List');
		$this->render('backend/standart/administrator/t_asessment/t_asessment_list', $this->data);
	}
	
	/**
	* Add new t_asessments
	*
	*/
	public function add()
	{
		$this->is_allowed('t_asessment_add');

		$this->template->title('T Asessment New');
		$this->render('backend/standart/administrator/t_asessment/t_asessment_add', $this->data);
	}

	/**
	* Add New T Asessments
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('t_asessment_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('noreg', 'Noreg', 'trim|required|max_length[11]|callback_valid_number');
		$this->form_validation->set_rules('bb', 'Berat Badan', 'trim|required|max_length[11]|callback_valid_number');
		$this->form_validation->set_rules('tinggi', 'Tinggi Badan', 'trim|required|max_length[11]|callback_valid_number');
		$this->form_validation->set_rules('darah', 'Tekanan Darah', 'trim|required|max_length[11]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'noreg' => $this->input->post('noreg'),
				'bb' => $this->input->post('bb'),
				'tinggi' => $this->input->post('tinggi'),
				'darah' => $this->input->post('darah'),
				'createby' => get_user_data('id'),				'createdate' => date('Y-m-d H:i:s'),
			];

			
			$save_t_asessment = $this->model_t_asessment->store($save_data);

			if ($save_t_asessment) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_t_asessment;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/t_asessment/edit/' . $save_t_asessment, 'Edit T Asessment'),
						anchor('administrator/t_asessment', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/t_asessment/edit/' . $save_t_asessment, 'Edit T Asessment')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/t_asessment');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/t_asessment');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view T Asessments
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('t_asessment_update');

		$this->data['t_asessment'] = $this->model_t_asessment->find($id);

		$this->template->title('T Asessment Update');
		$this->render('backend/standart/administrator/t_asessment/t_asessment_update', $this->data);
	}

	/**
	* Update T Asessments
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('t_asessment_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('bb', 'Berat Badan', 'trim|required|max_length[11]|callback_valid_number');
		$this->form_validation->set_rules('tinggi', 'Tinggi Badan', 'trim|required|max_length[11]|callback_valid_number');
		$this->form_validation->set_rules('darah', 'Tekanan Darah', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'bb' => $this->input->post('bb'),
				'tinggi' => $this->input->post('tinggi'),
				'darah' => $this->input->post('darah'),
				'createby' => get_user_data('id'),				'createdate' => date('Y-m-d H:i:s'),
			];

			
			$save_t_asessment = $this->model_t_asessment->change($id, $save_data);

			if ($save_t_asessment) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/t_asessment', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/t_asessment');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/t_asessment');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete T Asessments
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('t_asessment_delete');

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
            set_message(cclang('has_been_deleted', 't_asessment'), 'success');
        } else {
            set_message(cclang('error_delete', 't_asessment'), 'error');
        }

		redirect_back();
	}

		/**
	* View view T Asessments
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('t_asessment_view');

		$this->data['t_asessment'] = $this->model_t_asessment->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('T Asessment Detail');
		$this->render('backend/standart/administrator/t_asessment/t_asessment_view', $this->data);
	}
	
	/**
	* delete T Asessments
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$t_asessment = $this->model_t_asessment->find($id);

		
		
		return $this->model_t_asessment->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('t_asessment_export');

		$this->model_t_asessment->export('t_asessment', 't_asessment');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('t_asessment_export');

		$this->model_t_asessment->pdf('t_asessment', 't_asessment');
	}
}


/* End of file t_asessment.php */
/* Location: ./application/controllers/administrator/T Asessment.php */