<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| M Poli Controller
*| --------------------------------------------------------------------------
*| M Poli site
*|
*/
class M_poli extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_m_poli');
	}

	/**
	* show all M Polis
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('m_poli_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['m_polis'] = $this->model_m_poli->get($filter, $field, $this->limit_page, $offset);
		$this->data['m_poli_counts'] = $this->model_m_poli->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/m_poli/index/',
			'total_rows'   => $this->model_m_poli->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('M Poli List');
		$this->render('backend/standart/administrator/m_poli/m_poli_list', $this->data);
	}
	
	/**
	* Add new m_polis
	*
	*/
	public function add()
	{
		$this->is_allowed('m_poli_add');

		$this->template->title('M Poli New');
		$this->render('backend/standart/administrator/m_poli/m_poli_add', $this->data);
	}

	/**
	* Add New M Polis
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('m_poli_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('poli', 'Poli', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('kdunit', 'Kdunit', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('aktif', 'Aktif', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'poli' => $this->input->post('poli'),
				'kdunit' => $this->input->post('kdunit'),
				'aktif' => $this->input->post('aktif'),
			];

			
			$save_m_poli = $this->model_m_poli->store($save_data);

			if ($save_m_poli) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_m_poli;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/m_poli/edit/' . $save_m_poli, 'Edit M Poli'),
						anchor('administrator/m_poli', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/m_poli/edit/' . $save_m_poli, 'Edit M Poli')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_poli');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_poli');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view M Polis
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('m_poli_update');

		$this->data['m_poli'] = $this->model_m_poli->find($id);

		$this->template->title('M Poli Update');
		$this->render('backend/standart/administrator/m_poli/m_poli_update', $this->data);
	}

	/**
	* Update M Polis
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('m_poli_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('poli', 'Poli', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('kdunit', 'Kdunit', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('aktif', 'Aktif', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'poli' => $this->input->post('poli'),
				'kdunit' => $this->input->post('kdunit'),
				'aktif' => $this->input->post('aktif'),
			];

			
			$save_m_poli = $this->model_m_poli->change($id, $save_data);

			if ($save_m_poli) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/m_poli', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_poli');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_poli');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete M Polis
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('m_poli_delete');

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
            set_message(cclang('has_been_deleted', 'm_poli'), 'success');
        } else {
            set_message(cclang('error_delete', 'm_poli'), 'error');
        }

		redirect_back();
	}

		/**
	* View view M Polis
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('m_poli_view');

		$this->data['m_poli'] = $this->model_m_poli->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('M Poli Detail');
		$this->render('backend/standart/administrator/m_poli/m_poli_view', $this->data);
	}
	
	/**
	* delete M Polis
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$m_poli = $this->model_m_poli->find($id);

		
		
		return $this->model_m_poli->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('m_poli_export');

		$this->model_m_poli->export('m_poli', 'm_poli');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('m_poli_export');

		$this->model_m_poli->pdf('m_poli', 'm_poli');
	}
}


/* End of file m_poli.php */
/* Location: ./application/controllers/administrator/M Poli.php */