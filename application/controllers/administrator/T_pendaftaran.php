<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| T Pendaftaran Controller
*| --------------------------------------------------------------------------
*| T Pendaftaran site
*|
*/
class T_pendaftaran extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_t_pendaftaran');
	}

	/**
	* show all T Pendaftarans
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('t_pendaftaran_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['t_pendaftarans'] = $this->model_t_pendaftaran->get($filter, $field, $this->limit_page, $offset);
		$this->data['t_pendaftaran_counts'] = $this->model_t_pendaftaran->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/t_pendaftaran/index/',
			'total_rows'   => $this->model_t_pendaftaran->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('T Pendaftaran List');
		$this->render('backend/standart/administrator/t_pendaftaran/t_pendaftaran_list', $this->data);
	}
	
	/**
	* Add new t_pendaftarans
	*
	*/
	public function add()
	{
		$this->is_allowed('t_pendaftaran_add');

		$this->template->title('T Pendaftaran New');
		$this->render('backend/standart/administrator/t_pendaftaran/t_pendaftaran_add', $this->data);
	}

	/**
	* Add New T Pendaftarans
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('t_pendaftaran_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('nomr', 'Nomr', 'trim|required');
		$this->form_validation->set_rules('kdcarabayar', 'Kdcarabayar', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('kdpoli', 'Kdpoli', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('kdjenispasien', 'Kdjenispasien', 'trim|required');
		$this->form_validation->set_rules('kdjenisdatang', 'Kdjenisdatang', 'trim|required|max_length[11]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'nomr' => $this->input->post('nomr'),
				'kdcarabayar' => $this->input->post('kdcarabayar'),
				'kdpoli' => $this->input->post('kdpoli'),
				'kdjenispasien' => $this->input->post('kdjenispasien'),
				'kdjenisdatang' => $this->input->post('kdjenisdatang'),
				'userid' => get_user_data('id'),			];

			
			$save_t_pendaftaran = $this->model_t_pendaftaran->store($save_data);

			if ($save_t_pendaftaran) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_t_pendaftaran;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/t_pendaftaran/edit/' . $save_t_pendaftaran, 'Edit T Pendaftaran'),
						anchor('administrator/t_pendaftaran', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/t_pendaftaran/edit/' . $save_t_pendaftaran, 'Edit T Pendaftaran')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/t_pendaftaran');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/t_pendaftaran');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view T Pendaftarans
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('t_pendaftaran_update');

		$this->data['t_pendaftaran'] = $this->model_t_pendaftaran->find($id);

		$this->template->title('T Pendaftaran Update');
		$this->render('backend/standart/administrator/t_pendaftaran/t_pendaftaran_update', $this->data);
	}

	/**
	* Update T Pendaftarans
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('t_pendaftaran_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('nomr', 'Nomr', 'trim|required');
		$this->form_validation->set_rules('kdcarabayar', 'Kdcarabayar', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('kdpoli', 'Kdpoli', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('kdjenisdatang', 'Kdjenisdatang', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'tglreg' => date('Y-m-d H:i:s'),
				'nomr' => $this->input->post('nomr'),
				'kdcarabayar' => $this->input->post('kdcarabayar'),
				'kdpoli' => $this->input->post('kdpoli'),
				'kdjenisdatang' => $this->input->post('kdjenisdatang'),
				'userid' => get_user_data('id'),			];

			
			$save_t_pendaftaran = $this->model_t_pendaftaran->change($id, $save_data);

			if ($save_t_pendaftaran) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/t_pendaftaran', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/t_pendaftaran');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/t_pendaftaran');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete T Pendaftarans
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('t_pendaftaran_delete');

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
            set_message(cclang('has_been_deleted', 't_pendaftaran'), 'success');
        } else {
            set_message(cclang('error_delete', 't_pendaftaran'), 'error');
        }

		redirect_back();
	}

		/**
	* View view T Pendaftarans
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('t_pendaftaran_view');

		$this->data['t_pendaftaran'] = $this->model_t_pendaftaran->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('T Pendaftaran Detail');
		$this->render('backend/standart/administrator/t_pendaftaran/t_pendaftaran_view', $this->data);
	}
	
	/**
	* delete T Pendaftarans
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$t_pendaftaran = $this->model_t_pendaftaran->find($id);

		
		
		return $this->model_t_pendaftaran->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('t_pendaftaran_export');

		$this->model_t_pendaftaran->export('t_pendaftaran', 't_pendaftaran');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('t_pendaftaran_export');

		$this->model_t_pendaftaran->pdf('t_pendaftaran', 't_pendaftaran');
	}
}


/* End of file t_pendaftaran.php */
/* Location: ./application/controllers/administrator/T Pendaftaran.php */