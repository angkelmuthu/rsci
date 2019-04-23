<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class M_carabayar extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_m_carabayar');
	}

	/**
	 * @api {get} /m_carabayar/all Get all m_carabayars.
	 * @apiVersion 0.1.0
	 * @apiName AllMcarabayar 
	 * @apiGroup m_carabayar
	 * @apiHeader {String} X-Api-Key M carabayars unique access-key.
	 * @apiHeader {String} X-Token M carabayars unique token.
	 * @apiPermission M carabayar Cant be Accessed permission name : api_m_carabayar_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of M carabayars.
	 * @apiParam {String} [Field="All Field"] Optional field of M carabayars : kdcarabayar, carabayar, aktif.
	 * @apiParam {String} [Start=0] Optional start index of M carabayars.
	 * @apiParam {String} [Limit=10] Optional limit data of M carabayars.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of m_carabayar.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataM carabayar M carabayar data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_m_carabayar_all');

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['kdcarabayar', 'carabayar', 'aktif'];
		$m_carabayars = $this->model_api_m_carabayar->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_m_carabayar->count_all($filter, $field);

		$data['m_carabayar'] = $m_carabayars;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data M carabayar',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /m_carabayar/detail Detail M carabayar.
	 * @apiVersion 0.1.0
	 * @apiName DetailM carabayar
	 * @apiGroup m_carabayar
	 * @apiHeader {String} X-Api-Key M carabayars unique access-key.
	 * @apiHeader {String} X-Token M carabayars unique token.
	 * @apiPermission M carabayar Cant be Accessed permission name : api_m_carabayar_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of M carabayars.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of m_carabayar.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError M carabayarNotFound M carabayar data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_m_carabayar_detail');

		$this->requiredInput(['kdcarabayar']);

		$id = $this->get('kdcarabayar');

		$select_field = ['kdcarabayar', 'carabayar', 'aktif'];
		$data['m_carabayar'] = $this->model_api_m_carabayar->find($id, $select_field);

		if ($data['m_carabayar']) {
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail M carabayar',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'M carabayar not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /m_carabayar/add Add M carabayar.
	 * @apiVersion 0.1.0
	 * @apiName AddM carabayar
	 * @apiGroup m_carabayar
	 * @apiHeader {String} X-Api-Key M carabayars unique access-key.
	 * @apiHeader {String} X-Token M carabayars unique token.
	 * @apiPermission M carabayar Cant be Accessed permission name : api_m_carabayar_add
	 *
 	 * @apiParam {String} Carabayar Mandatory carabayar of M carabayars. Input Carabayar Max Length : 100. 
	 * @apiParam {String} Aktif Mandatory aktif of M carabayars.  
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError ValidationError Error validation.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function add_post()
	{
		$this->is_allowed('api_m_carabayar_add');

		$this->form_validation->set_rules('carabayar', 'Carabayar', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('aktif', 'Aktif', 'trim|required');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'carabayar' => $this->input->post('carabayar'),
				'aktif' => $this->input->post('aktif'),
			];
			
			$save_m_carabayar = $this->model_api_m_carabayar->store($save_data);

			if ($save_m_carabayar) {
				$this->response([
					'status' 	=> true,
					'message' 	=> 'Your data has been successfully stored into the database'
				], API::HTTP_OK);

			} else {
				$this->response([
					'status' 	=> false,
					'message' 	=> cclang('data_not_change')
				], API::HTTP_NOT_ACCEPTABLE);
			}

		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> validation_errors()
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	/**
	 * @api {post} /m_carabayar/update Update M carabayar.
	 * @apiVersion 0.1.0
	 * @apiName UpdateM carabayar
	 * @apiGroup m_carabayar
	 * @apiHeader {String} X-Api-Key M carabayars unique access-key.
	 * @apiHeader {String} X-Token M carabayars unique token.
	 * @apiPermission M carabayar Cant be Accessed permission name : api_m_carabayar_update
	 *
	 * @apiParam {String} Carabayar Mandatory carabayar of M carabayars. Input Carabayar Max Length : 100. 
	 * @apiParam {String} Aktif Mandatory aktif of M carabayars.  
	 * @apiParam {Integer} kdcarabayar Mandatory kdcarabayar of M Carabayar.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError ValidationError Error validation.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function update_post()
	{
		$this->is_allowed('api_m_carabayar_update');

		
		$this->form_validation->set_rules('carabayar', 'Carabayar', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('aktif', 'Aktif', 'trim|required');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'carabayar' => $this->input->post('carabayar'),
				'aktif' => $this->input->post('aktif'),
			];
			
			$save_m_carabayar = $this->model_api_m_carabayar->change($this->post('kdcarabayar'), $save_data);

			if ($save_m_carabayar) {
				$this->response([
					'status' 	=> true,
					'message' 	=> 'Your data has been successfully updated into the database'
				], API::HTTP_OK);

			} else {
				$this->response([
					'status' 	=> false,
					'message' 	=> cclang('data_not_change')
				], API::HTTP_NOT_ACCEPTABLE);
			}

		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> validation_errors()
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}
	
	/**
	 * @api {post} /m_carabayar/delete Delete M carabayar. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteM carabayar
	 * @apiGroup m_carabayar
	 * @apiHeader {String} X-Api-Key M carabayars unique access-key.
	 * @apiHeader {String} X-Token M carabayars unique token.
	 	 * @apiPermission M carabayar Cant be Accessed permission name : api_m_carabayar_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of M carabayars .
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError ValidationError Error validation.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function delete_post()
	{
		$this->is_allowed('api_m_carabayar_delete');

		$m_carabayar = $this->model_api_m_carabayar->find($this->post('kdcarabayar'));

		if (!$m_carabayar) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'M carabayar not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_m_carabayar->remove($this->post('kdcarabayar'));

			}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'M carabayar deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'M carabayar not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file M carabayar.php */
/* Location: ./application/controllers/api/M carabayar.php */