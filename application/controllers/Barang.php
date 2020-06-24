<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Barang extends MY_Controller {

    protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model');
        $this->load->library('form_validation');
    }

    public function ambil_data_kategori()
    {
        $kode_kategori = $_POST['kode_kategori'];
        $data = $this->db->query("SELECT * FROM kategori_barang WHERE kode_kategori='$kode_kategori'")->result();
        foreach($data as $dd)
        {
            $data =array(
                'kategori_barang'=>$dd->kategori_barang    
            );
            
           echo json_encode($data);
        }
    }
    public function ambil_data_lokasi()
    {
        $kode_lokasi = $_POST['kode_lokasi'];
        $data = $this->db->query("SELECT * FROM lokasi WHERE kode_lokasi='$kode_lokasi'")->result();
        foreach($data as $dd)
        {
            $data =array(
                'lokasi'=>$dd->lokasi    
            );
            
           echo json_encode($data);
        }
    }


    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'barang/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'barang/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'barang/index.dart';
            $config['first_url'] = base_url() . 'barang/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Barang_model->total_rows($q);
        $barang = $this->Barang_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'barang_data' => $barang,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('barang_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Barang_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kode_kategori' => $row->kode_kategori,
		'kategori' => $row->kategori,
		'kode_barang' => $row->kode_barang,
		'nama_barang' => $row->nama_barang,
		'satuan' => $row->satuan,
		'harga' => $row->harga,
		'kode_lokasi' => $row->kode_lokasi,
		'lokasi' => $row->lokasi,
		'tipe_barang' => $row->tipe_barang,
		'stok_aman' => $row->stok_aman,
	    );
            $this->load->view('header');
            $this->load->view('barang_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('barang'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('barang/create_action'),
	    'id' => set_value('id'),
	    'kode_kategori' => set_value('kode_kategori'),
	    'kategori' => set_value('kategori'),
	    'kode_barang' => set_value('kode_barang'),
	    'nama_barang' => set_value('nama_barang'),
	    'satuan' => set_value('satuan'),
	    'harga' => set_value('harga'),
	    'kode_lokasi' => set_value('kode_lokasi'),
	    'lokasi' => set_value('lokasi'),
	    'tipe_barang' => set_value('tipe_barang'),
        'stok_aman' => set_value('stok_aman'),
        'pilih_kategori'=>$this->db->query("select * from kategori_barang")->result(),
        'pilih_satuan'=>$this->db->query("select * from satuan_barang")->result(),
        'pilih_lokasi'=>$this->db->query("select * from lokasi")->result(),
        'pilih_tipe'=>$this->db->query("select * from tipe_barang")->result(),
	);

        $this->load->view('header');
        $this->load->view('barang_form', $data);
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
		'harga' => $this->input->post('harga',TRUE),
		'kode_lokasi' => $this->input->post('kode_lokasi',TRUE),
		'lokasi' => $this->input->post('lokasi',TRUE),
		'tipe_barang' => $this->input->post('tipe_barang',TRUE),
		'stok_aman' => $this->input->post('stok_aman',TRUE),
	    );

            $this->Barang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('barang'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Barang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('barang/update_action'),
		'id' => set_value('id', $row->id),
		'kode_kategori' => set_value('kode_kategori', $row->kode_kategori),
		'kategori' => set_value('kategori', $row->kategori),
		'kode_barang' => set_value('kode_barang', $row->kode_barang),
		'nama_barang' => set_value('nama_barang', $row->nama_barang),
		'satuan' => set_value('satuan', $row->satuan),
		'harga' => set_value('harga', $row->harga),
		'kode_lokasi' => set_value('kode_lokasi', $row->kode_lokasi),
		'lokasi' => set_value('lokasi', $row->lokasi),
		'tipe_barang' => set_value('tipe_barang', $row->tipe_barang),
		'stok_aman' => set_value('stok_aman', $row->stok_aman),
	    );
            $this->load->view('header');
            $this->load->view('barang_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('barang'));
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
		'harga' => $this->input->post('harga',TRUE),
		'kode_lokasi' => $this->input->post('kode_lokasi',TRUE),
		'lokasi' => $this->input->post('lokasi',TRUE),
		'tipe_barang' => $this->input->post('tipe_barang',TRUE),
		'stok_aman' => $this->input->post('stok_aman',TRUE),
	    );

            $this->Barang_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('barang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Barang_model->get_by_id($id);

        if ($row) {
            $this->Barang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('barang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('barang'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_kategori', 'kode kategori', 'trim|required');
	$this->form_validation->set_rules('kategori', 'kategori', 'trim|required');
	$this->form_validation->set_rules('kode_barang', 'kode barang', 'trim|required');
	$this->form_validation->set_rules('nama_barang', 'nama barang', 'trim|required');
	$this->form_validation->set_rules('satuan', 'satuan', 'trim|required');
	$this->form_validation->set_rules('harga', 'harga', 'trim|required|numeric');
	$this->form_validation->set_rules('kode_lokasi', 'kode lokasi', 'trim|required');
	$this->form_validation->set_rules('lokasi', 'lokasi', 'trim|required');
	$this->form_validation->set_rules('tipe_barang', 'tipe barang', 'trim|required');
	$this->form_validation->set_rules('stok_aman', 'stok aman', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Barang.php */
/* Location: ./application/controllers/Barang.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-02-14 13:41:26 */
/* http://harviacode.com */