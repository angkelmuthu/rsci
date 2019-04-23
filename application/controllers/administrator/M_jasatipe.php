<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| M Jasatipe Controller
*| --------------------------------------------------------------------------
*| M Jasatipe site
*|
*/
class M_jasatipe extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_m_jasatipe');
	}

	/**
	* show all M Jasatipes
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('m_jasatipe_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['m_jasatipes'] = $this->model_m_jasatipe->get($filter, $field, $this->limit_page, $offset);
		$this->data['m_jasatipe_counts'] = $this->model_m_jasatipe->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/m_jasatipe/index/',
			'total_rows'   => $this->model_m_jasatipe->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('M Jasatipe List');
		$this->render('backend/standart/administrator/m_jasatipe/m_jasatipe_list', $this->data);
	}
	
	/**
	* Add new m_jasatipes
	*
	*/
	public function add()
	{
		$this->is_allowed('m_jasatipe_add');

		$this->template->title('M Jasatipe New');
		$this->render('backend/standart/administrator/m_jasatipe/m_jasatipe_add', $this->data);
	}

	/**
	* Add New M Jasatipes
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('m_jasatipe_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('jasatipe', 'Jasatipe', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('stok', 'Stok', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'jasatipe' => $this->input->post('jasatipe'),
				'stok' => $this->input->post('stok'),
			];

			
			$save_m_jasatipe = $this->model_m_jasatipe->store($save_data);

			if ($save_m_jasatipe) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_m_jasatipe;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/m_jasatipe/edit/' . $save_m_jasatipe, 'Edit M Jasatipe'),
						anchor('administrator/m_jasatipe', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/m_jasatipe/edit/' . $save_m_jasatipe, 'Edit M Jasatipe')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_jasatipe');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_jasatipe');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view M Jasatipes
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('m_jasatipe_update');

		$this->data['m_jasatipe'] = $this->model_m_jasatipe->find($id);

		$this->template->title('M Jasatipe Update');
		$this->render('backend/standart/administrator/m_jasatipe/m_jasatipe_update', $this->data);
	}

	/**
	* Update M Jasatipes
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('m_jasatipe_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('jasatipe', 'Jasatipe', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('stok', 'Stok', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'jasatipe' => $this->input->post('jasatipe'),
				'stok' => $this->input->post('stok'),
			];

			
			$save_m_jasatipe = $this->model_m_jasatipe->change($id, $save_data);

			if ($save_m_jasatipe) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/m_jasatipe', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_jasatipe');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_jasatipe');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete M Jasatipes
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('m_jasatipe_delete');

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
            set_message(cclang('has_been_deleted', 'm_jasatipe'), 'success');
        } else {
            set_message(cclang('error_delete', 'm_jasatipe'), 'error');
        }

		redirect_back();
	}

		/**
	* View view M Jasatipes
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('m_jasatipe_view');

		$this->data['m_jasatipe'] = $this->model_m_jasatipe->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('M Jasatipe Detail');
		$this->render('backend/standart/administrator/m_jasatipe/m_jasatipe_view', $this->data);
	}
	
	/**
	* delete M Jasatipes
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$m_jasatipe = $this->model_m_jasatipe->find($id);

		
		
		return $this->model_m_jasatipe->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('m_jasatipe_export');

		$this->model_m_jasatipe->export('m_jasatipe', 'm_jasatipe');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('m_jasatipe_export');

		$this->model_m_jasatipe->pdf('m_jasatipe', 'm_jasatipe');
	}
}


/* End of file m_jasatipe.php */
/* Location: ./application/controllers/administrator/M Jasatipe.php */