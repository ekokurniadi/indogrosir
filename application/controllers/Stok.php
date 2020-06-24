<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stok extends MY_Controller {

    protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Stok_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'stok/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'stok/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'stok/index.dart';
            $config['first_url'] = base_url() . 'stok/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Stok_model->total_rows($q);
        $stok = $this->Stok_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'stok_data' => $stok,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('stok_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Stok_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kode_kategori' => $row->kode_kategori,
		'kategori' => $row->kategori,
		'kode_barang' => $row->kode_barang,
		'nama_barang' => $row->nama_barang,
		'satuan' => $row->satuan,
		'qty' => $row->qty,
	    );
            $this->load->view('header');
            $this->load->view('stok_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('stok'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('stok/create_action'),
	    'id' => set_value('id'),
	    'kode_kategori' => set_value('kode_kategori'),
	    'kategori' => set_value('kategori'),
	    'kode_barang' => set_value('kode_barang'),
	    'nama_barang' => set_value('nama_barang'),
	    'satuan' => set_value('satuan'),
	    'qty' => set_value('qty'),
	);

        $this->load->view('header');
        $this->load->view('stok_form', $data);
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
		'kategori' => $this->input->post('kategori',TRUE),
		'kode_barang' => $this->input->post('kode_barang',TRUE),
		'nama_barang' => $this->input->post('nama_barang',TRUE),
		'satuan' => $this->input->post('satuan',TRUE),
		'qty' => $this->input->post('qty',TRUE),
	    );

            $this->Stok_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('stok'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Stok_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('stok/update_action'),
		'id' => set_value('id', $row->id),
		'kode_kategori' => set_value('kode_kategori', $row->kode_kategori),
		'kategori' => set_value('kategori', $row->kategori),
		'kode_barang' => set_value('kode_barang', $row->kode_barang),
		'nama_barang' => set_value('nama_barang', $row->nama_barang),
		'satuan' => set_value('satuan', $row->satuan),
		'qty' => set_value('qty', $row->qty),
	    );
            $this->load->view('header');
            $this->load->view('stok_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('stok'));
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
		'kategori' => $this->input->post('kategori',TRUE),
		'kode_barang' => $this->input->post('kode_barang',TRUE),
		'nama_barang' => $this->input->post('nama_barang',TRUE),
		'satuan' => $this->input->post('satuan',TRUE),
		'qty' => $this->input->post('qty',TRUE),
	    );

            $this->Stok_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('stok'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Stok_model->get_by_id($id);

        if ($row) {
            $this->Stok_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('stok'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('stok'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_kategori', 'kode kategori', 'trim|required');
	$this->form_validation->set_rules('kategori', 'kategori', 'trim|required');
	$this->form_validation->set_rules('kode_barang', 'kode barang', 'trim|required');
	$this->form_validation->set_rules('nama_barang', 'nama barang', 'trim|required');
	$this->form_validation->set_rules('satuan', 'satuan', 'trim|required');
	$this->form_validation->set_rules('qty', 'qty', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Stok.php */
/* Location: ./application/controllers/Stok.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-02-15 13:20:49 */
/* http://harviacode.com */