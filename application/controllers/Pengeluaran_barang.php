<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengeluaran_barang extends MY_Controller {

    // protected $access = array('Admin', 'Pimpinan','Finance');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pengeluaran_barang_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'pengeluaran_barang/index.dart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'pengeluaran_barang/index.dart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'pengeluaran_barang/index.dart';
            $config['first_url'] = base_url() . 'pengeluaran_barang/index.dart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Pengeluaran_barang_model->total_rows($q);
        $pengeluaran_barang = $this->Pengeluaran_barang_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pengeluaran_barang_data' => $pengeluaran_barang,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('header');
        $this->load->view('pengeluaran_barang_list', $data);
        $this->load->view('footer');
    }

    public function read($id) 
    {
       
        $row = $this->Pengeluaran_barang_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kode' => $row->kode_pengeluaran,
		'tanggal' => $row->tanggal,
        'user' => $row->user,
        'button' => 'Create',
        'action' => site_url('pengeluaran_barang/create_action'),
	    );
            $this->load->view('header');
            $this->load->view('pengeluaran_barang_form_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengeluaran_barang'));
        }
    }


    public function hapus_temp()
    {
        $id=$_GET['id'];
        $this->db->query("DELETE FROM detail_pengeluaran where id='$id'");
    }

    public function ambil_data_barang()
    {
        $kode_barang = $_POST['kode_barang'];
        $data = $this->db->query("SELECT a.*,b.qty FROM barang a join stok b on b.kode_barang=a.kode_barang WHERE a.kode_barang='$kode_barang'")->result();
        foreach($data as $dd)
        {
            $data =array(
                'nama_barang'=>$dd->nama_barang,    
                'satuan'=>$dd->satuan,   
                'stok'=>$dd->qty,
                'harga'=>$dd->harga 
            );
            
           echo json_encode($data);
        }
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
                        <th>Harga Barang</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                        </tr>
                    </thead>";
                     $id=$_GET['kode_pengeluaran'];
                     $no=1;
                     $data = $this->db->query("SELECT * FROM detail_pengeluaran where kode_pengeluaran='$id'")->result();
                  
                   
                     foreach ($data as $d) {
                      
                         echo "<tbody><tr id='dataku$d->id'>
                                 <td>$no</td>
                                 <td>$d->kode_barang</td>
                                 <td>$d->nama_barang</td>
                                 <td>$d->satuan</td>
                                 <td>$d->harga</td>
                                 <td>$d->qty</td>
                                 <td>$d->total</td>
                                 <td><button type ='button' class='btn btn-icon btn-sm btn-danger' onClick='hapus($d->id)'><i class='fa fa-close'></i> Batal</td>
                              </tr>
                            </tbody>  ";
                         $no++;
                         
                     }
                     echo "</table>";  
                    
     }
     public function load_temp3()
     {
         echo " <table class='table table-bordered table-striped table-hover'>
                        <thead>
                        <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Harga Barang</th>
                        <th>Qty</th>
                        <th>Total</th>
                    
                        </tr>
                    </thead>";
                     $id=$_GET['kode_pengeluaran'];
                     $no=1;
                     $data = $this->db->query("SELECT * FROM detail_pengeluaran where kode_pengeluaran='$id'")->result();
                  
                   
                     foreach ($data as $d) {
                      
                         echo "<tbody><tr id='dataku$d->id'>
                                 <td>$no</td>
                                 <td>$d->kode_barang</td>
                                 <td>$d->nama_barang</td>
                                 <td>$d->satuan</td>
                                 <td>$d->harga</td>
                                 <td>$d->qty</td>
                                 <td>$d->total</td>
                                
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
                        <th>Harga Barang</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                        </tr>
                    </thead>";
                     $id=$_GET['kode_pengeluaran'];
                     $no=1;
                     $data = $this->db->query("SELECT * FROM detail_pengeluaran where kode_pengeluaran='$id'")->result();
                  
                   
                     foreach ($data as $d) {
                      
                         echo "<tbody><tr id='dataku$d->id'>
                                 <td>$no</td>
                                 <td>$d->kode_barang</td>
                                 <td>$d->nama_barang</td>
                                 <td>$d->satuan</td>
                                 <td>$d->harga</td>
                                 <td>$d->qty</td>
                                 <td>$d->total</td>
                                 <td><button type ='button' class='btn btn-icon btn-sm btn-danger' onClick='hapus($d->id)'><i class='fa fa-close'></i> Batal</td>
                              </tr>
                            </tbody>  ";
                         $no++;
                         
                     }
                     echo "</table>";  
                    
     }

     function input_ajax()
    {
 
         $kode_pengeluaran       = $_GET['kode_pengeluaran'];
         $kode_barang           = $_GET['kode_barang'];
         $tanggal               = $_GET['tanggal'];
         $nama_barang           = $_GET['nama_barang'];
         $qty                   = $_GET['qty'];
         $harga                  = $_GET['harga'];
         $total                  = $_GET['total'];
         $satuan                = $_GET['satuan'];
         $user                   = $_GET['user'];
       
      
 
        $data=array(
            'kode_pengeluaran'=>$kode_pengeluaran,
            'kode_barang'=>$kode_barang,
            'nama_barang'=>$nama_barang,
            'qty'=>$qty,
            'harga'=>$harga,
            'total'=>$total,
            'satuan'=>$satuan,
            'tanggal'=>$tanggal,
            'user'=>$user,
              
            );
        $this->db->insert('detail_pengeluaran',$data);
    }


    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('pengeluaran_barang/create_action'),
	    'id' => set_value('id'),
	    'kode_pengeluaran' => set_value('kode_pengeluaran'),
	    'tanggal' => set_value('tanggal'),
        'user' => $_SESSION['username'],
        'pilih_barang'=>$this->db->query("SELECT * FROM barang")->result(),
	);

        $data['kode']=$this->Pengeluaran_barang_model->kode();
        $this->load->view('header');
        $this->load->view('pengeluaran_barang_form', $data);
        $this->load->view('footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kode_pengeluaran' => $this->input->post('kode_pengeluaran',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'user' => $this->input->post('user',TRUE),
	    );

            $this->Pengeluaran_barang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pengeluaran_barang'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Pengeluaran_barang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pengeluaran_barang/update_action'),
		'id' => set_value('id', $row->id),
		'kode' => set_value('kode_pengeluaran', $row->kode_pengeluaran),
		'tanggal' => set_value('tanggal', $row->tanggal),
		'user' => set_value('user', $row->user),
	    );
            $this->load->view('header');
            $this->load->view('pengeluaran_barang_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengeluaran_barang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'kode_pengeluaran' => $this->input->post('kode_pengeluaran',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
		'user' => $this->input->post('user',TRUE),
	    );

            $this->Pengeluaran_barang_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pengeluaran_barang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Pengeluaran_barang_model->get_by_id($id);

        if ($row) {
            $this->Pengeluaran_barang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pengeluaran_barang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengeluaran_barang'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_pengeluaran', 'kode pengeluaran', 'trim|required');
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
	$this->form_validation->set_rules('user', 'user', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pengeluaran_barang.php */
/* Location: ./application/controllers/Pengeluaran_barang.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-03-11 05:20:34 */
/* http://harviacode.com */