<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| M Datang Controller
*| --------------------------------------------------------------------------
*| M Datang site
*|
*/
class M_datang extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_m_datang');
	}

	/**
	* show all M Datangs
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('m_datang_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['m_datangs'] = $this->model_m_datang->get($filter, $field, $this->limit_page, $offset);
		$this->data['m_datang_counts'] = $this->model_m_datang->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/m_datang/index/',
			'total_rows'   => $this->model_m_datang->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('M Datang List');
		$this->render('backend/standart/administrator/m_datang/m_datang_list', $this->data);
	}
	
	/**
	* Add new m_datangs
	*
	*/
	public function add()
	{
		$this->is_allowed('m_datang_add');

		$this->template->title('M Datang New');
		$this->render('backend/standart/administrator/m_datang/m_datang_add', $this->data);
	}

	/**
	* Add New M Datangs
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('m_datang_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('datang', 'Datang', 'trim|required|max_length[100]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'datang' => $this->input->post('datang'),
			];

			
			$save_m_datang = $this->model_m_datang->store($save_data);

			if ($save_m_datang) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_m_datang;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/m_datang/edit/' . $save_m_datang, 'Edit M Datang'),
						anchor('administrator/m_datang', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/m_datang/edit/' . $save_m_datang, 'Edit M Datang')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_datang');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_datang');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view M Datangs
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('m_datang_update');

		$this->data['m_datang'] = $this->model_m_datang->find($id);

		$this->template->title('M Datang Update');
		$this->render('backend/standart/administrator/m_datang/m_datang_update', $this->data);
	}

	/**
	* Update M Datangs
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('m_datang_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('datang', 'Datang', 'trim|required|max_length[100]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'datang' => $this->input->post('datang'),
			];

			
			$save_m_datang = $this->model_m_datang->change($id, $save_data);

			if ($save_m_datang) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/m_datang', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_datang');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_datang');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete M Datangs
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('m_datang_delete');

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
            set_message(cclang('has_been_deleted', 'm_datang'), 'success');
        } else {
            set_message(cclang('error_delete', 'm_datang'), 'error');
        }

		redirect_back();
	}

		/**
	* View view M Datangs
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('m_datang_view');

		$this->data['m_datang'] = $this->model_m_datang->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('M Datang Detail');
		$this->render('backend/standart/administrator/m_datang/m_datang_view', $this->data);
	}
	
	/**
	* delete M Datangs
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$m_datang = $this->model_m_datang->find($id);

		
		
		return $this->model_m_datang->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('m_datang_export');

		$this->model_m_datang->export('m_datang', 'm_datang');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('m_datang_export');

		$this->model_m_datang->pdf('m_datang', 'm_datang');
	}
}


/* End of file m_datang.php */
/* Location: ./application/controllers/administrator/M Datang.php */