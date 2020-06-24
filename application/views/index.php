
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Dashboard</h1>
          </div>
          <div class="row">
         
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Supplier</h4>
                  </div>
                  <div class="card-body">
                  <?=$supplier->num_rows();?>
                  </div>
                </div>
              </div>
            </div> 
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-database"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Barang</h4>
                  </div>
                  <div class="card-body">
                  <?=$barang->num_rows();?>
                  </div>
                </div>
              </div>
            </div> 
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-building"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Lokasi</h4>
                  </div>
                  <div class="card-body">
                  <?=$lokasi->num_rows();?>
                  </div>
                </div>
              </div>
            </div> 
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-file"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Kategori Barang</h4>
                  </div>
                  <div class="card-body">
                <?=$kategori_barang->num_rows();?>
                  </div>
                </div>
              </div>
            </div> 
          </div>  

          <div class="row">

          <div class="col-12 col-md-6 col-lg-6 col-sm-12" >
                <div class="card" >
                  <div class="card-header">
                    <h4>Grafik Stok</h4>
                  </div>
                
                  <div class="card-body" >
                    <canvas id="barChart" height="100px"></canvas>
                  </div>
                </div>
              </div>
          <div class="col-12 col-md-6 col-lg-6 col-sm-12" >
                <div class="card" >
                  <div class="card-header">
                    <h4>Grafik Stok</h4>
                  </div>
                
                  <div class="card-body" >
                    <canvas id="barChart2" height="100px"></canvas>
                  </div>
                </div>
              </div>
          </div>
          
          <div class="row">
              
          </div>
        </section>
      </div>
      
      