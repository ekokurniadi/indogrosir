<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengeluaran_barang_model extends CI_Model
{

    public $table = 'pengeluaran_barang';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }


    function kode()
    {
             $this->db->select('RIGHT(pengeluaran_barang.kode_pengeluaran,2) as kode_pengeluaran', FALSE);
             $this->db->order_by('kode_pengeluaran','DESC');    
             $this->db->limit(1);    
             $query = $this->db->get('pengeluaran_barang');  //cek dulu apakah ada sudah ada kode di tabel.    
             if($query->num_rows() <> 0){      
                  //cek kode jika telah tersedia    
                  $data = $query->row();      
                  $kode = intval($data->kode_pengeluaran) + 1; 
             }
             else{      
                  $kode = 1;  //cek jika kode belum terdapat pada table
             }  
                date_default_timezone_set("Asia/Jakarta");
                 $tgl=date("dYm");
                 $sessi=strtoupper($_SESSION['nama']); 
                 $angka_acak=rand(100,1000);
                 $batas = str_pad($kode, 3, "0", STR_PAD_LEFT);    
                 $kodetampil = "PL-".$tgl.$batas;  //format kode
                 return $kodetampil;  
   }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('kode_pengeluaran', $q);
	$this->db->or_like('tanggal', $q);
	$this->db->or_like('user', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('kode_pengeluaran', $q);
	$this->db->or_like('tanggal', $q);
	$this->db->or_like('user', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Pengeluaran_barang_model.php */
/* Location: ./application/models/Pengeluaran_barang_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-03-11 05:20:34 */
/* http://harviacode.com */