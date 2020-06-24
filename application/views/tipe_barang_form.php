
 <div class="main-content">
<section class="section">
  <div class="section-header">
    <h1> Tipe Barang </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></div>
      <div class="breadcrumb-item"><a href="#"> Tipe Barang </a></div>
    </div>
  </div>

  <div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Form Tipe Barang </h4>
        </div>
        <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
	   
              <div class="form-group">
                <label class="col-sm-2 control-label" for="varchar">Tipe Barang <?php echo form_error('tipe_barang') ?></label>
                <div class="col-sm-12">
                  <select name="tipe_barang" id="tipe_barang" class="form-control">
                    <option value="<?=$tipe_barang?>" selected>Select an option</option>
                    <option value="Fast_Moving">Fast Moving</option>
                    <option value="Middle_Moving">Middle Moving</option>
                    <option value="Slow_Moving">Slow Moving</option>
                  </select>
                </div>
              </div>
	   
     
        <div class="card-footer text-left">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><span class="fa fa-edit"></span><?php echo $button ?></button> 
	    <a href="<?php echo site_url('tipe_barang') ?>" class="btn btn-icon icon-left btn-success">Cancel</a>
	
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
