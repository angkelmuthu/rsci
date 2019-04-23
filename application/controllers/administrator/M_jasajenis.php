<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| M Jasajenis Controller
*| --------------------------------------------------------------------------
*| M Jasajenis site
*|
*/
class M_jasajenis extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_m_jasajenis');
	}

	/**
	* show all M Jasajeniss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('m_jasajenis_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['m_jasajeniss'] = $this->model_m_jasajenis->get($filter, $field, $this->limit_page, $offset);
		$this->data['m_jasajenis_counts'] = $this->model_m_jasajenis->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/m_jasajenis/index/',
			'total_rows'   => $this->model_m_jasajenis->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('M Jasajenis List');
		$this->render('backend/standart/administrator/m_jasajenis/m_jasajenis_list', $this->data);
	}
	
	/**
	* Add new m_jasajeniss
	*
	*/
	public function add()
	{
		$this->is_allowed('m_jasajenis_add');

		$this->template->title('M Jasajenis New');
		$this->render('backend/standart/administrator/m_jasajenis/m_jasajenis_add', $this->data);
	}

	/**
	* Add New M Jasajeniss
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('m_jasajenis_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('jasajenis', 'Jasa Jenis', 'trim|required|max_length[50]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'jasajenis' => $this->input->post('jasajenis'),
			];

			
			$save_m_jasajenis = $this->model_m_jasajenis->store($save_data);

			if ($save_m_jasajenis) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_m_jasajenis;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/m_jasajenis/edit/' . $save_m_jasajenis, 'Edit M Jasajenis'),
						anchor('administrator/m_jasajenis', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/m_jasajenis/edit/' . $save_m_jasajenis, 'Edit M Jasajenis')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_jasajenis');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_jasajenis');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view M Jasajeniss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('m_jasajenis_update');

		$this->data['m_jasajenis'] = $this->model_m_jasajenis->find($id);

		$this->template->title('M Jasajenis Update');
		$this->render('backend/standart/administrator/m_jasajenis/m_jasajenis_update', $this->data);
	}

	/**
	* Update M Jasajeniss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('m_jasajenis_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('jasajenis', 'Jasa Jenis', 'trim|required|max_length[50]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'jasajenis' => $this->input->post('jasajenis'),
			];

			
			$save_m_jasajenis = $this->model_m_jasajenis->change($id, $save_data);

			if ($save_m_jasajenis) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/m_jasajenis', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_jasajenis');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_jasajenis');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete M Jasajeniss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('m_jasajenis_delete');

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
            set_message(cclang('has_been_deleted', 'm_jasajenis'), 'success');
        } else {
            set_message(cclang('error_delete', 'm_jasajenis'), 'error');
        }

		redirect_back();
	}

		/**
	* View view M Jasajeniss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('m_jasajenis_view');

		$this->data['m_jasajenis'] = $this->model_m_jasajenis->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('M Jasajenis Detail');
		$this->render('backend/standart/administrator/m_jasajenis/m_jasajenis_view', $this->data);
	}
	
	/**
	* delete M Jasajeniss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$m_jasajenis = $this->model_m_jasajenis->find($id);

		
		
		return $this->model_m_jasajenis->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('m_jasajenis_export');

		$this->model_m_jasajenis->export('m_jasajenis', 'm_jasajenis');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('m_jasajenis_export');

		$this->model_m_jasajenis->pdf('m_jasajenis', 'm_jasajenis');
	}
}


/* End of file m_jasajenis.php */
/* Location: ./application/controllers/administrator/M Jasajenis.php */