<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| M Pasien Controller
*| --------------------------------------------------------------------------
*| M Pasien site
*|
*/
class M_pasien extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_m_pasien');
	}

	/**
	* show all M Pasiens
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('m_pasien_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['m_pasiens'] = $this->model_m_pasien->get($filter, $field, $this->limit_page, $offset);
		$this->data['m_pasien_counts'] = $this->model_m_pasien->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/m_pasien/index/',
			'total_rows'   => $this->model_m_pasien->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('M Pasien List');
		$this->render('backend/standart/administrator/m_pasien/m_pasien_list', $this->data);
	}
	
	/**
	* Add new m_pasiens
	*
	*/
	public function add()
	{
		$this->is_allowed('m_pasien_add');

		$this->template->title('M Pasien New');
		$this->render('backend/standart/administrator/m_pasien/m_pasien_add', $this->data);
	}

	/**
	* Add New M Pasiens
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('m_pasien_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('nomr', 'Nomr', 'trim|required|max_length[20]|callback_valid_number');
		$this->form_validation->set_rules('pasien', 'Pasien', 'trim|required|max_length[150]');
		$this->form_validation->set_rules('tmp_lhr', 'Tmp Lhr', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('tgl_lhr', 'Tgl Lhr', 'trim|required');
		$this->form_validation->set_rules('nik', 'Nik', 'trim|required|max_length[16]|callback_valid_number');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'nomr' => $this->input->post('nomr'),
				'pasien' => $this->input->post('pasien'),
				'tmp_lhr' => $this->input->post('tmp_lhr'),
				'tgl_lhr' => $this->input->post('tgl_lhr'),
				'nik' => $this->input->post('nik'),
				'tgl_reg' => date('Y-m-d H:i:s'),
			];

			
			$save_m_pasien = $this->model_m_pasien->store($save_data);

			if ($save_m_pasien) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_m_pasien;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/m_pasien/edit/' . $save_m_pasien, 'Edit M Pasien'),
						anchor('administrator/m_pasien', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/m_pasien/edit/' . $save_m_pasien, 'Edit M Pasien')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_pasien');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_pasien');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view M Pasiens
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('m_pasien_update');

		$this->data['m_pasien'] = $this->model_m_pasien->find($id);

		$this->template->title('M Pasien Update');
		$this->render('backend/standart/administrator/m_pasien/m_pasien_update', $this->data);
	}

	/**
	* Update M Pasiens
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('m_pasien_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('nomr', 'Nomr', 'trim|required|max_length[20]|callback_valid_number');
		$this->form_validation->set_rules('pasien', 'Pasien', 'trim|required|max_length[150]');
		$this->form_validation->set_rules('tmp_lhr', 'Tmp Lhr', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('tgl_lhr', 'Tgl Lhr', 'trim|required');
		$this->form_validation->set_rules('nik', 'Nik', 'trim|required|max_length[16]|callback_valid_number');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'nomr' => $this->input->post('nomr'),
				'pasien' => $this->input->post('pasien'),
				'tmp_lhr' => $this->input->post('tmp_lhr'),
				'tgl_lhr' => $this->input->post('tgl_lhr'),
				'nik' => $this->input->post('nik'),
				'tgl_reg' => date('Y-m-d H:i:s'),
			];

			
			$save_m_pasien = $this->model_m_pasien->change($id, $save_data);

			if ($save_m_pasien) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/m_pasien', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/m_pasien');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/m_pasien');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete M Pasiens
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('m_pasien_delete');

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
            set_message(cclang('has_been_deleted', 'm_pasien'), 'success');
        } else {
            set_message(cclang('error_delete', 'm_pasien'), 'error');
        }

		redirect_back();
	}

		/**
	* View view M Pasiens
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('m_pasien_view');

		$this->data['m_pasien'] = $this->model_m_pasien->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('M Pasien Detail');
		$this->render('backend/standart/administrator/m_pasien/m_pasien_view', $this->data);
	}
	
	/**
	* delete M Pasiens
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$m_pasien = $this->model_m_pasien->find($id);

		
		
		return $this->model_m_pasien->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('m_pasien_export');

		$this->model_m_pasien->export('m_pasien', 'm_pasien');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('m_pasien_export');

		$this->model_m_pasien->pdf('m_pasien', 'm_pasien');
	}
}


/* End of file m_pasien.php */
/* Location: ./application/controllers/administrator/M Pasien.php */