<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lokasi extends MY_Controller {

    protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Lokasi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'lokasi/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'lokasi/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'lokasi/index.dart';
            $config['first_url'] = base_url() . 'lokasi/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Lokasi_model->total_rows($q);
        $lokasi = $this->Lokasi_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'lokasi_data' => $lokasi,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('lokasi_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Lokasi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kode_lokasi' => $row->kode_lokasi,
		'lokasi' => $row->lokasi,
	    );
            $this->load->view('header');
            $this->load->view('lokasi_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lokasi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('lokasi/create_action'),
	    'id' => set_value('id'),
	    'kode_lokasi' => set_value('kode_lokasi'),
	    'lokasi' => set_value('lokasi'),
	);

        $data['kode']=$this->Lokasi_model->kode();
        $this->load->view('header');
        $this->load->view('lokasi_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kode_lokasi' => $this->input->post('kode_lokasi',TRUE),
		'lokasi' => $this->input->post('lokasi',TRUE),
	    );

            $this->Lokasi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('lokasi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Lokasi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('lokasi/update_action'),
		'id' => set_value('id', $row->id),
		'kode' => set_value('kode_lokasi', $row->kode_lokasi),
		'lokasi' => set_value('lokasi', $row->lokasi),
	    );
            $this->load->view('header');
            $this->load->view('lokasi_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lokasi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'kode_lokasi' => $this->input->post('kode_lokasi',TRUE),
		'lokasi' => $this->input->post('lokasi',TRUE),
	    );

            $this->Lokasi_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('lokasi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Lokasi_model->get_by_id($id);

        if ($row) {
            $this->Lokasi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('lokasi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lokasi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_lokasi', 'kode lokasi', 'trim|required');
	$this->form_validation->set_rules('lokasi', 'lokasi', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Lokasi.php */
/* Location: ./application/controllers/Lokasi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-02-13 15:01:55 */
/* http://harviacode.com */