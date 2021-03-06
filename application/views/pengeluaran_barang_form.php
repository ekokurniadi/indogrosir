<!-- javascript -->
<body onload="load_data_temp()"></body>

</style>

<!-- Content Header (Page header) -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script type="text/javascript">
function load_data_temp()
        {
            var hasil =$('#hasil').val();
            var kode_pengeluaran  =  $("#kode_pengeluaran").val();
            $.ajax({
                type:"GET",
                url:"<?php echo base_url('pengeluaran_barang/load_temp')?>",
                data:"kode_pengeluaran="+kode_pengeluaran,
                success:function(hasilajax){
                    $('#list_ku').html(hasilajax);
                    $("#kode_barang").val('');
                    document.getElementById("kode_barang").focus();
                }
            });
            
        }

         function hapus(id)
        {
            $.ajax({
                type:"GET",
                url:"<?php echo base_url('pengeluaran_barang/hapus_temp')?>",
                data:"id="+id,
                success:function(html){
                  $("#dataku"+id).hide(500);
                  load_data_temp();
                }
            });
        }

        function add_barang()
        {
                var kode_pengeluaran     = $("#kode_pengeluaran").val();
                var tanggal             = $("#tanggal").val();
                var kode_barang         = $("#kode_barang").val();
                var nama_barang         = $("#nama_barang").val();
                var harga               = $("#harga").val();
                var qty                 = $("#qty").val();
                var total                 = $("#total").val();
                var satuan              = $("#satuan").val();
                var user              = $("#user").val();
            
               
            if(kode_pengeluaran == '' || qty == '' || kode_barang == '' || tanggal== '' ){
                alert("Data Belum Lengkap");
                die;
            }
            else
            {
             $.ajax({
                type:"GET",
                url:"<?php echo base_url('pengeluaran_barang/input_ajax')?>",
                data:"kode_pengeluaran="+kode_pengeluaran+"&tanggal="+tanggal+"&kode_barang="+kode_barang+"&nama_barang="+nama_barang+"&qty="+qty+"&satuan="+satuan+"&user="+user+"&harga="+harga+"&total="+total,
                success:function(html){
                   load_data_temp();
                    $("#kode_barang").val('');
                    $("#nama_barang").val('');
                    $("#satuan").val('');
                    $("#harga").val('');
                    $("#total").val('');
                    $("#qty").val('');
                    $("#stok").val('');
                    document.getElementById("kode_barang").focus();
                   
                }
             });
        }
}

// $(document).ready(function(){

// $('#kode_barang').change(function(){    
// var kode_barangnya = $('#kode_barang').val(); 

// $.ajax({      
//     method: "POST",      
//     url: "<?php echo base_url('penerimaan_barang/ambil_data_barang')?>", 
//     dataType:'json',  
//     data: { kode_barang: kode_barangnya}
  
//   })
//     .done(function( hasilajax) {   
//       $("#nama_barang").val(hasilajax.nama_barang);
//       $("#satuan").val(hasilajax.satuan);
//     });
// })
// });

    </script>
<!-- javascript -->



 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Pengeluaran Barang </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Pengeluaran Barang </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Pengeluaran Barang </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Kode Pengeluaran <?php echo form_error('kode_pengeluaran') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="kode_pengeluaran" id="kode_pengeluaran" placeholder="Kode Pengeluaran" value="<?php echo $kode; ?>" readonly/>
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="date">Tanggal <?php echo form_error('tanggal') ?></label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" />
                </div>
              </div>
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">User <?php echo form_error('user') ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="user" id="user" placeholder="User" value="<?php echo $user; ?>" readonly />
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <input type="button" class="btn btn-block btn-flat btn-primary" readonly value="Detail Barang"/>
                </div>
              </div>

              <div class="form-group">
              
              <div class="col-sm-12">
                  <div class="table-responsive">
                      <table class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <td width="330px">Kode Barang
                            <select name="kode_barang" id="kode_barang" class="form-control">
                              <option value="">Select an option</option>
                              <?php foreach($pilih_barang as $pb):?>
                                <option value="<?=$pb->kode_barang?>"><?=$pb->kode_barang?> | <?=$pb->nama_barang?></option>
                              <?php endforeach;?>
                            </select>
                            </td>
                            <td  width="300px">Nama Barang
                              <input type="text" class="form-control" name="nama_barang" id="nama_barang" readonly>
                            </td>
                            <td  width="200px">Satuan Barang
                              <input type="text" class="form-control" name="satuan" id="satuan" readonly>
                            </td>
                            <td  width="200px">Harga
                              <input type="text" class="form-control" name="harga" id="harga" readonly>
                            </td>
                            <td width="150px">Qty
                              <input type="number" class="form-control" name="qty" id="qty" oninput="sum();sum2();">
                              <!-- <input type="number" class="form-control" name="stok" id="stok"> -->
                            </td>
                            <td  width="200px">Total
                              <input type="text" class="form-control" name="total" id="total" readonly>
                            </td>
                            <td>Action <br>
                             <a class="btn btn-primary" style="color:white;" onclick="add_barang();"><i class="fas fa-plus"> Tambah</i> </a>
                            </td>
                          </tr> 
                        </thead>
                      </table>
                      <input type="hidden" class="form-control" name="stok" id="stok" readonly>
                  </div>
                </div>      
              
              
                <div class="col-sm-12">
                     <div id="list_ku" class="table-responsive">
                </div>
                </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('pengeluaran_barang') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
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

$('#kode_barang').change(function(){    
var kode_barangnya = $('#kode_barang').val(); 
$.ajax({      
    method: "POST",      
    url: "<?php echo base_url('pengeluaran_barang/ambil_data_barang')?>", 
    dataType:'json',  
    data: { kode_barang: kode_barangnya}
  
  })
  .done(function( hasilajax) {   
      $("#nama_barang").val(hasilajax.nama_barang);
      $("#satuan").val(hasilajax.satuan);
      $("#stok").val(hasilajax.stok);
      $("#harga").val(hasilajax.harga);
    });
})
});
    </script>

<script>
function sum() {
      var txtFirstNumberValue = $('#qty').val();
      var txtSecondNumberValue = $('#stok').val();
      var desc =$('#nama_barang').val();
      var jumlah_stok=parseInt(txtSecondNumberValue);
      var jumlah_qty=parseInt(txtFirstNumberValue);
    //   fungsi pengecekan stok
      if(jumlah_stok < jumlah_qty || jumlah_qty < 0)
         {
            alert('Stok tidak mencukupi, stok item : '+ desc +' tersedia : '+jumlah_stok );
            document.getElementById('qty').value='';    
            document.getElementById("qty").focus();
        }else{
          document.getElementById('qty').value=jumlah_qty;
        }
    }
</script>
<script>
function sum2() {
      var txtFirst = $('#qty').val();
      var txtSecond = $('#harga').val();
      var total = $('#total').val();
      var result = parseInt(txtFirst) * parseInt(txtSecond);
        if (!isNaN(result)) {
            document.getElementById('total').value = result;
        }else{
            document.getElementById('total').value=0;     
        }
    }
</script>