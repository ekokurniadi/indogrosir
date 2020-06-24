<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kategori_barang extends MY_Controller {

    protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_barang_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kategori_barang/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kategori_barang/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kategori_barang/index.dart';
            $config['first_url'] = base_url() . 'kategori_barang/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Kategori_barang_model->total_rows($q);
        $kategori_barang = $this->Kategori_barang_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kategori_barang_data' => $kategori_barang,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('kategori_barang_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Kategori_barang_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kode_kategori' => $row->kode_kategori,
		'kategori_barang' => $row->kategori_barang,
	    );
            $this->load->view('header');
            $this->load->view('kategori_barang_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kategori_barang'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('kategori_barang/create_action'),
	    'id' => set_value('id'),
	    'kode_kategori' => set_value('kode_kategori'),
	    'kategori_barang' => set_value('kategori_barang'),
	);

        $data['kode']=$this->Kategori_barang_model->kode();
        $this->load->view('header');
        $this->load->view('kategori_barang_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kode_kategori' => $this->input->post('kode_kategori',TRUE),
		'kategori_barang' => $this->input->post('kategori_barang',TRUE),
	    );

            $this->Kategori_barang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kategori_barang'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kategori_barang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kategori_barang/update_action'),
		'id' => set_value('id', $row->id),
		'kode' => set_value('kode_kategori', $row->kode_kategori),
		'kategori_barang' => set_value('kategori_barang', $row->kategori_barang),
	    );
            $this->load->view('header');
            $this->load->view('kategori_barang_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kategori_barang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'kode_kategori' => $this->input->post('kode_kategori',TRUE),
		'kategori_barang' => $this->input->post('kategori_barang',TRUE),
	    );

            $this->Kategori_barang_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kategori_barang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kategori_barang_model->get_by_id($id);

        if ($row) {
            $this->Kategori_barang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kategori_barang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kategori_barang'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_kategori', 'kode kategori', 'trim|required');
	$this->form_validation->set_rules('kategori_barang', 'kategori barang', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Kategori_barang.php */
/* Location: ./application/controllers/Kategori_barang.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-02-13 13:58:59 */
/* http://harviacode.com */