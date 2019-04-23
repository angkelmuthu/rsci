<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| M Carabayar Controller
*| --------------------------------------------------------------------------
*| M Carabayar site
*|
*/
class M_carabayar extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_m_carabayar');
	}

	/**
	* show all M Carabayars
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('m_carabayar_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['m_carabayars'] = $this->model_m_carabayar->get($filter, $field, $this->limit_page, $offset);
		$this->data['m_carabayar_counts'] = $this->model_m_carabayar->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/m_carabayar/index/',
			'total_rows'   => $this->model_m_carabayar->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('M Carabayar List');
		$this->render('backend/standart/administrator/m_carabayar/m_carabayar_list', $this->data);
	}
	
	/**
	* Add new m_carabayars
	*
	*/
	public function add()
	{
		$this->is_allowed('m_carabayar_add');

		$this->template->title('M Carabayar New');
		$this->render('backend/standart/administrator/m_carabayar/m_carabayar_add', $this->data);
	}

	/**
	* Add New M Carabayars
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('m_carabayar_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('carabayar', 'Carabayar', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('aktif', 'Aktif', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'carabayar' => $this->input->post('carabayar'),
				'aktif' => $this->input->post('aktif'),
			];

			
			$save_m_carabayar = $this->model_m_carabayar->store($save_data);

			if ($save_m_carabayar) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_m_carabayar;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/m_carabayar/edit/' . $save_m_carabayar, 'Edit M Carabayar'),
						anchor('administrator/m_carabayar', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/m_carabayar/edit/' . $save_m_carabayar, 'Edit M Carabayar')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_carabayar');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_carabayar');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view M Carabayars
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('m_carabayar_update');

		$this->data['m_carabayar'] = $this->model_m_carabayar->find($id);

		$this->template->title('M Carabayar Update');
		$this->render('backend/standart/administrator/m_carabayar/m_carabayar_update', $this->data);
	}

	/**
	* Update M Carabayars
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('m_carabayar_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('carabayar', 'Carabayar', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('aktif', 'Aktif', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'carabayar' => $this->input->post('carabayar'),
				'aktif' => $this->input->post('aktif'),
			];

			
			$save_m_carabayar = $this->model_m_carabayar->change($id, $save_data);

			if ($save_m_carabayar) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/m_carabayar', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_carabayar');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_carabayar');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete M Carabayars
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('m_carabayar_delete');

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
            set_message(cclang('has_been_deleted', 'm_carabayar'), 'success');
        } else {
            set_message(cclang('error_delete', 'm_carabayar'), 'error');
        }

		redirect_back();
	}

		/**
	* View view M Carabayars
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('m_carabayar_view');

		$this->data['m_carabayar'] = $this->model_m_carabayar->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('M Carabayar Detail');
		$this->render('backend/standart/administrator/m_carabayar/m_carabayar_view', $this->data);
	}
	
	/**
	* delete M Carabayars
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$m_carabayar = $this->model_m_carabayar->find($id);

		
		
		return $this->model_m_carabayar->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('m_carabayar_export');

		$this->model_m_carabayar->export('m_carabayar', 'm_carabayar');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('m_carabayar_export');

		$this->model_m_carabayar->pdf('m_carabayar', 'm_carabayar');
	}
}


/* End of file m_carabayar.php */
/* Location: ./application/controllers/administrator/M Carabayar.php */