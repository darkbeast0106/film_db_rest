<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Film extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function index_get($id = 0)
	{
		if (!is_numeric($id)) {
			$this->response(["Az azonosítónak számnak kell lennie."], REST_Controller::HTTP_BAD_REQUEST);
		} else if ($id == 0) {
			$adatok = $this->db->get("filmek")->result_array();
			$this->response($adatok, REST_Controller::HTTP_OK);
		} else {
			$this->db->where('id', $id);
			$adatok = $this->db->get("filmek")->row_array();
			if (empty($adatok)) {
				$this->response(["A megadott azonosítóval nem található film."], REST_Controller::HTTP_NOT_FOUND);
			} else {
				$this->response($adatok, REST_Controller::HTTP_OK);
			}
		}
	}

	public function index_post()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_data($this->post());
		$this->form_validation->set_rules('cim', 'Cím', 'trim|required');
		$this->form_validation->set_rules('kategoria', 'Kategória', 'trim|required');
		$this->form_validation->set_rules('hossz', 'Hossz', 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[999]');
		$this->form_validation->set_rules('ertekeles', 'Értékelés', 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[10]');
		if (!$this->form_validation->run()) {
			$message = validation_errors();
			$message = str_replace('<p>', '', $message);
			$message = str_replace('</p>', '', $message);
			$message = str_replace("\n", " ", $message);
			$this->response($message, REST_Controller::HTTP_BAD_REQUEST);
		} else {
			$data = [];
			$data['cim'] = $this->post('cim');
			$data['kategoria'] = $this->post('kategoria');
			$data['hossz'] = $this->post('hossz');
			$data['ertekeles'] = $this->post('ertekeles');
			$this->db->insert('filmek', $data);
			$data['id'] = $this->db->insert_id();
			$this->response($data, REST_Controller::HTTP_CREATED);
		}
	}

	public function index_put($id)
	{
		if (!is_numeric($id)) {
			$this->response(["Az azonosítónak számnak kell lennie."], REST_Controller::HTTP_BAD_REQUEST);
			return;
		}
		$this->db->where('id', $id);
		$adatok = $this->db->get("filmek")->row_array();
		if (empty($adatok)) {
			$this->response(["A megadott azonosítóval nem található film."], REST_Controller::HTTP_NOT_FOUND);
			return;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_data($this->put());
		$this->form_validation->set_rules('cim', 'Cím', 'trim|required');
		$this->form_validation->set_rules('kategoria', 'Kategória', 'trim|required');
		$this->form_validation->set_rules('hossz', 'Hossz', 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[999]');
		$this->form_validation->set_rules('ertekeles', 'Értékelés', 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[10]');
		if (!$this->form_validation->run()) {
			$message = validation_errors();
			$message = str_replace('<p>', '', $message);
			$message = str_replace('</p>', '', $message);
			$message = str_replace("\n", " ", $message);
			$this->response($message, REST_Controller::HTTP_BAD_REQUEST);
		} else {
			$data = [];
			$data['cim'] = $this->put('cim');
			$data['kategoria'] = $this->put('kategoria');
			$data['hossz'] = $this->put('hossz');
			$data['ertekeles'] = $this->put('ertekeles');
			$this->db->where('id', $id);
			$this->db->update('filmek', $data);
			$data['id'] = $id;
			$this->response($data, REST_Controller::HTTP_OK);
		}
	}

	public function index_delete($id)
	{
		if (!is_numeric($id)) {
			$this->response(["Az azonosítónak számnak kell lennie."], REST_Controller::HTTP_BAD_REQUEST);
			return;
		}
		$this->db->where('id', $id);
		$adatok = $this->db->get("filmek")->row_array();
		if (empty($adatok)) {
			$this->response(["A megadott azonosítóval nem található film."], REST_Controller::HTTP_NOT_FOUND);
			return;
		}
		$this->db->where('id', $id);
		$this->db->delete('filmek');
		$this->response(NULL, REST_Controller::HTTP_NO_CONTENT);
	}
}

/* End of file Film.php */
