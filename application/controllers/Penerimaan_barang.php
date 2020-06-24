<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penerimaan_barang extends MY_Controller {

    protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Penerimaan_barang_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'penerimaan_barang/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'penerimaan_barang/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'penerimaan_barang/index.dart';
            $config['first_url'] = base_url() . 'penerimaan_barang/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Penerimaan_barang_model->total_rows($q);
        $penerimaan_barang = $this->Penerimaan_barang_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'penerimaan_barang_data' => $penerimaan_barang,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('penerimaan_barang_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
        $row = $this->Penerimaan_barang_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kode_penerimaan' => $row->kode_penerimaan,
		'tanggal' => $row->tanggal,
		'kode_supplier' => $row->kode_supplier,
		'nama_supplier' => $row->nama_supplier,
		'user' => $row->user,
	    );
            $this->load->view('header');
            $this->load->view('penerimaan_barang_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penerimaan_barang'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('penerimaan_barang/create_action'),
	    'id' => set_value('id'),
	    'kode_penerimaan' => set_value('kode_penerimaan'),
	    'tanggal' => set_value('tanggal'),
	    'kode_supplier' => set_value('kode_supplier'),
	    'nama_supplier' => set_value('nama_supplier'),
        'user' => set_value('user'),
        'pilih_sup'=>$this->db->query("SELECT * FROM supplier")->result(),
        'pilih_barang'=>$this->db->query("SELECT * FROM barang")->result(),

	);
        $data['kode']=$this->Penerimaan_barang_model->kode();
        $data['data_user']=$_SESSION['nama'];
        $data['get_date']=date('Y-m-d');
        $this->load->view('header');
        $this->load->view('penerimaan_barang_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kode_penerimaan' => $this->input->post('kode_penerimaan',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'kode_supplier' => $this->input->post('kode_supplier',TRUE),
		'nama_supplier' => $this->input->post('nama_supplier',TRUE),
		'user' => $this->input->post('user',TRUE),
	    );

            $this->Penerimaan_barang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('penerimaan_barang'));
        }
    }
    
    public function ambil_data_supplier()
    {
        $kode_supplier = $_POST['kode_supplier'];
        $data = $this->db->query("SELECT * FROM supplier WHERE kode_supplier='$kode_supplier'")->result();
        foreach($data as $dd)
        {
            $data =array(
                'nama_supplier'=>$dd->nama_supplier    
            );
            
           echo json_encode($data);
        }
    }

    public function hapus_temp()
    {
        $id=$_GET['id'];
        $this->db->query("DELETE FROM detail_penerimaan where id='$id'");
    }

     // fungsi ajax
     public function load_temp()
     {
         echo " <table class='table table-bordered table-striped table-hover'>
                        <thead>
                        <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Qty</th>
                        <th>Action</th>
                        </tr>
                    </thead>";
                     $id=$_GET['kode_penerimaan'];
                     $no=1;
                     $data = $this->db->query("SELECT * FROM detail_penerimaan where kode_penerimaan='$id'")->result();
                  
                   
                     foreach ($data as $d) {
                      
                         echo "<tbody><tr id='dataku$d->id'>
                                 <td>$no</td>
                                 <td>$d->kode_barang</td>
                                 <td>$d->nama_barang</td>
                                 <td>$d->satuan</td>
                                 <td>$d->qty</td>
                                 <td><button type ='button' class='btn btn-icon btn-sm btn-danger' onClick='hapus($d->id)'><i class='fa fa-close'></i> Batal</td>
                              </tr>
                            </tbody>  ";
                         $no++;
                         
                     }
                     echo "</table>";  
                    
     }
     public function load_temp2()
     {
         echo " <table class='table table-bordered table-striped table-hover'>
                        <thead>
                        <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Qty</th>
                        <th>Action</th>
                        </tr>
                    </thead>";
                     $id=$_GET['kode_penerimaan'];
                     $no=1;
                     $data = $this->db->query("SELECT * FROM detail_penerimaan where kode_penerimaan='$id'")->result();
                  
                   
                     foreach ($data as $d) {
                      
                         echo "<tbody><tr id='dataku$d->id'>
                                 <td>$no</td>
                                 <td>$d->kode_barang</td>
                                 <td>$d->nama_barang</td>
                                 <td>$d->satuan</td>
                                 <td>$d->qty</td>
                                 <td><button type ='button' class='btn btn-icon btn-sm btn-danger' onClick='hapus($d->id)'><i class='fa fa-close'></i> Batal</td>
                              </tr>
                            </tbody>  ";
                         $no++;
                         
                     }
                     echo "</table>";  
                    
     }

     function input_ajax()
    {
 
         $kode_penerimaan       = $_GET['kode_penerimaan'];
         $kode_barang           = $_GET['kode_barang'];
         $tanggal               = $_GET['tanggal'];
         $nama_barang           = $_GET['nama_barang'];
         $qty                   = $_GET['qty'];
         $satuan                   = $_GET['satuan'];
         $user                   = $_GET['user'];
       
      
 
        $data=array(
            'kode_penerimaan'=>$kode_penerimaan,
            'kode_barang'=>$kode_barang,
            'nama_barang'=>$nama_barang,
            'qty'=>$qty,
            'satuan'=>$satuan,
            'tanggal'=>$tanggal,
            'user'=>$user,
              
            );
        $this->db->insert('detail_penerimaan',$data);
    }

    public function ambil_data_barang()
    {
        $kode_barang = $_POST['kode_barang'];
        $data = $this->db->query("SELECT * FROM barang WHERE kode_barang='$kode_barang'")->result();
        foreach($data as $dd)
        {
            $data =array(
                'nama_barang'=>$dd->nama_barang,    
                'satuan'=>$dd->satuan,    
            );
            
           echo json_encode($data);
        }
    }

    public function update($id) 
    {
        $row = $this->Penerimaan_barang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('penerimaan_barang/update_action'),
		'id' => set_value('id', $row->id),
		'kode' => set_value('kode_penerimaan', $row->kode_penerimaan),
		'get_date' => set_value('tanggal', $row->tanggal),
		'kode_supplier' => set_value('kode_supplier', $row->kode_supplier),
		'nama_supplier' => set_value('nama_supplier', $row->nama_supplier),
        'user' => set_value('user', $row->user),
        'pilih_sup'=>$this->db->query("SELECT * FROM supplier")->result(),
        'pilih_barang'=>$this->db->query("SELECT * FROM barang")->result(),
	    );
             $data['data_user']=$_SESSION['nama'];
            $this->load->view('header');
            $this->load->view('penerimaan_barang_edit', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penerimaan_barang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'kode_penerimaan' => $this->input->post('kode_penerimaan',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'kode_supplier' => $this->input->post('kode_supplier',TRUE),
		'nama_supplier' => $this->input->post('nama_supplier',TRUE),
		'user' => $this->input->post('user',TRUE),
	    );

            $this->Penerimaan_barang_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('penerimaan_barang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Penerimaan_barang_model->get_by_id($id);

        if ($row) {
            $this->Penerimaan_barang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('penerimaan_barang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penerimaan_barang'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_penerimaan', 'kode penerimaan', 'trim|required');
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
	$this->form_validation->set_rules('kode_supplier', 'kode supplier', 'trim|required');
	$this->form_validation->set_rules('nama_supplier', 'nama supplier', 'trim|required');
	$this->form_validation->set_rules('user', 'user', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Penerimaan_barang.php */
/* Location: ./application/controllers/Penerimaan_barang.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-02-15 13:41:36 */
/* http://harviacode.com */