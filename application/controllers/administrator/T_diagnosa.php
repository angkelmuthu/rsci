<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| T Diagnosa Controller
*| --------------------------------------------------------------------------
*| T Diagnosa site
*|
*/
class T_diagnosa extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_t_diagnosa');
	}

	/**
	* show all T Diagnosas
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('t_diagnosa_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['t_diagnosas'] = $this->model_t_diagnosa->get($filter, $field, $this->limit_page, $offset);
		$this->data['t_diagnosa_counts'] = $this->model_t_diagnosa->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/t_diagnosa/index/',
			'total_rows'   => $this->model_t_diagnosa->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('T Diagnosa List');
		$this->render('backend/standart/administrator/t_diagnosa/t_diagnosa_list', $this->data);
	}
	
	/**
	* Add new t_diagnosas
	*
	*/
	public function add()
	{
		$this->is_allowed('t_diagnosa_add');

		$this->template->title('T Diagnosa New');
		$this->render('backend/standart/administrator/t_diagnosa/t_diagnosa_add', $this->data);
	}

	/**
	* Add New T Diagnosas
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('t_diagnosa_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('noreg', 'Noreg', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('subjective', 'Subjective', 'trim|required');
		$this->form_validation->set_rules('diag_awal', 'Diagnosa Awal (ICD)', 'trim|required');
		$this->form_validation->set_rules('objective', 'Objective', 'trim|required');
		$this->form_validation->set_rules('asessment', 'Asessment', 'trim|required');
		$this->form_validation->set_rules('plan', 'Planning', 'trim|required');
		$this->form_validation->set_rules('diag_akhir', 'Diagnosa Akhir (ICD)', 'trim|required|max_length[50]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'noreg' => $this->input->post('noreg'),
				'subjective' => $this->input->post('subjective'),
				'diag_awal' => $this->input->post('diag_awal'),
				'objective' => $this->input->post('objective'),
				'asessment' => $this->input->post('asessment'),
				'plan' => $this->input->post('plan'),
				'diag_akhir' => $this->input->post('diag_akhir'),
				'createby' => get_user_data('id'),				'createdate' => date('Y-m-d H:i:s'),
			];

			
			$save_t_diagnosa = $this->model_t_diagnosa->store($save_data);

			if ($save_t_diagnosa) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_t_diagnosa;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/t_diagnosa/edit/' . $save_t_diagnosa, 'Edit T Diagnosa'),
						anchor('administrator/t_diagnosa', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/t_diagnosa/edit/' . $save_t_diagnosa, 'Edit T Diagnosa')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/t_diagnosa');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/t_diagnosa');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view T Diagnosas
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('t_diagnosa_update');

		$this->data['t_diagnosa'] = $this->model_t_diagnosa->find($id);

		$this->template->title('T Diagnosa Update');
		$this->render('backend/standart/administrator/t_diagnosa/t_diagnosa_update', $this->data);
	}

	/**
	* Update T Diagnosas
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('t_diagnosa_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('noreg', 'Noreg', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('subjective', 'Subjective', 'trim|required');
		$this->form_validation->set_rules('diag_awal', 'Diagnosa Awal (ICD)', 'trim|required');
		$this->form_validation->set_rules('objective', 'Objective', 'trim|required');
		$this->form_validation->set_rules('asessment', 'Asessment', 'trim|required');
		$this->form_validation->set_rules('plan', 'Planning', 'trim|required');
		$this->form_validation->set_rules('diag_akhir', 'Diagnosa Akhir (ICD)', 'trim|required|max_length[50]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'noreg' => $this->input->post('noreg'),
				'subjective' => $this->input->post('subjective'),
				'diag_awal' => $this->input->post('diag_awal'),
				'objective' => $this->input->post('objective'),
				'asessment' => $this->input->post('asessment'),
				'plan' => $this->input->post('plan'),
				'diag_akhir' => $this->input->post('diag_akhir'),
				'createby' => get_user_data('id'),				'createdate' => date('Y-m-d H:i:s'),
			];

			
			$save_t_diagnosa = $this->model_t_diagnosa->change($id, $save_data);

			if ($save_t_diagnosa) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/t_diagnosa', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/t_diagnosa');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/t_diagnosa');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete T Diagnosas
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('t_diagnosa_delete');

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
            set_message(cclang('has_been_deleted', 't_diagnosa'), 'success');
        } else {
            set_message(cclang('error_delete', 't_diagnosa'), 'error');
        }

		redirect_back();
	}

		/**
	* View view T Diagnosas
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('t_diagnosa_view');

		$this->data['t_diagnosa'] = $this->model_t_diagnosa->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('T Diagnosa Detail');
		$this->render('backend/standart/administrator/t_diagnosa/t_diagnosa_view', $this->data);
	}
	
	/**
	* delete T Diagnosas
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$t_diagnosa = $this->model_t_diagnosa->find($id);

		
		
		return $this->model_t_diagnosa->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('t_diagnosa_export');

		$this->model_t_diagnosa->export('t_diagnosa', 't_diagnosa');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('t_diagnosa_export');

		$this->model_t_diagnosa->pdf('t_diagnosa', 't_diagnosa');
	}
}


/* End of file t_diagnosa.php */
/* Location: ./application/controllers/administrator/T Diagnosa.php */