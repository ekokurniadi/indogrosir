
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Barang </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Barang </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Barang </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kode Kategori <?php echo form_error('kode_kategori') ?></label>
                <div class="col-sm-12">
                  <select name="kode_kategori" id="kode_kategori" class="form-control">
                    <option value="<?=$kode_kategori?>"selected>Select an option</option>
                    <?php foreach($pilih_kategori as $pk):?>
                    <option value="<?=$pk->kode_kategori?>"><?=$pk->kode_kategori?> | <?=$pk->kategori_barang?></option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kategori <?php echo form_error('kategori') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kategori" id="kategori" placeholder="Kategori" value="<?php echo $kategori; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kode Barang <?php echo form_error('kode_barang') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Kode Barang" value="<?php echo $kode_barang; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Nama Barang <?php echo form_error('nama_barang') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" value="<?php echo $nama_barang; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Satuan <?php echo form_error('satuan') ?></label>
                <div class="col-sm-12">
                <select name="satuan" id="satuan" class="form-control">
                    <option value="<?=$satuan?>"selected>Select an option</option>
                    <?php foreach($pilih_satuan as $ps):?>
                    <option value="<?=$ps->satuan?>"><?=$ps->satuan?></option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="double">Harga <?php echo form_error('harga') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kode Lokasi <?php echo form_error('kode_lokasi') ?></label>
                <div class="col-sm-12">
                <select name="kode_lokasi" id="kode_lokasi" class="form-control">
                    <option value="<?=$kode_lokasi?>"selected>Select an option</option>
                    <?php foreach($pilih_lokasi as $pl):?>
                    <option value="<?=$pl->kode_lokasi?>"><?=$pl->kode_lokasi?> | <?=$pl->lokasi?> </option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Lokasi <?php echo form_error('lokasi') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Lokasi" value="<?php echo $lokasi; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Tipe Barang <?php echo form_error('tipe_barang') ?></label>
                <div class="col-sm-12">
                <select name="tipe_barang" id="tipe_barang" class="form-control">
                    <option value="<?=$tipe_barang?>"selected>Select an option</option>
                    <?php foreach($pilih_tipe as $pt):?>
                    <option value="<?=$pt->tipe_barang?>"><?=$pt->tipe_barang?> </option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
	   
              <div class="form-group">
                <!-- <label class="col-sm-2 control-label" for="int">Stok Aman <?php echo form_error('stok_aman') ?></label> -->
                <div class="col-sm-12">
                  <input type="hidden" class="form-control" name="stok_aman" id="stok_aman" placeholder="Stok Aman" value="0" />
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('barang') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>

<!-- Content Header (Page header) -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script type="text/javascript">
$(document).ready(function(){

$('#kode_kategori').change(function(){    
var kode_kategorinya = $('#kode_kategori').val(); 

$.ajax({      
    method: "POST",      
    url: "<?php echo base_url('barang/ambil_data_kategori')?>", 
    dataType:'json',  
    data: { kode_kategori: kode_kategorinya}
  
  })
    .done(function( hasilajax) {   
      $("#kategori").val(hasilajax.kategori_barang);
    });
})
});
$(document).ready(function(){

$('#kode_lokasi').change(function(){    
var kode_lokasinya = $('#kode_lokasi').val(); 

$.ajax({      
    method: "POST",      
    url: "<?php echo base_url('barang/ambil_data_lokasi')?>", 
    dataType:'json',  
    data: { kode_lokasi: kode_lokasinya}
  
  })
    .done(function( hasilajax) {   
      $("#lokasi").val(hasilajax.lokasi);
    });
})
});

    </script>
