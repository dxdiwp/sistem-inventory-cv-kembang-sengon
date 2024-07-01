<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?> | Sistem Pengelolaan Data Gudang</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/adminlte.min.css">

  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/daterangepicker/daterangepicker.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link"><h5><b>CV.KEMBANG SENGON</b></h5></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-user"></i>
          <?= userdata('nama'); ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('profile'); ?>" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
            <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('profile/setting'); ?>" class="dropdown-item">
            <i class="fas fa-cogs mr-2"></i> Settings
            <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('profile/ubahpassword'); ?>" class="dropdown-item">
            <i class="fas fa-lock mr-2"></i> Change Password
            <!-- <span class="float-right text-muted text-sm">2 days</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
            <!-- <span class="float-right text-muted text-sm">2 days</span> -->
          </a>
          <!-- <a href="#" class="dropdown-item dropdown-footer">Logout</a> -->
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light"><center>PENGELOLAAN DATA <br> GUDANG TRIPLEKS</center></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= base_url('dashboard'); ?>" class="nav-link">
              <i class="nav-icon fas fa-fw fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-header">Transaksi</li>
          <li class="nav-item">
            <a href="<?= base_url('barangmasuk'); ?>" class="nav-link">
              <i class="nav-icon fas fa-fw fa-download"></i>
              <p>
                Data Pembelian
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('barangkeluar'); ?>" class="nav-link">
              <i class="nav-icon fas fa-fw fa-upload"></i>
              <p>
                Data Penjualan
              </p>
            </a>
          </li>
          <li class="nav-header">Data Produksi</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <!-- <a href=""> -->
              <i class="nav-icon fas fa-fw fa-folder"></i>
              <p>
                Data Barang
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('barang?q=1'); ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bahan Baku</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('barang?q=2'); ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Barang Produksi</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-fw fa-folder"></i>
              <p>
                Data Produksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('keluarharian'); ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengeluaran Bahan </p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="<?= base_url('keuangan'); ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Catatan Keuangan</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="<?= base_url('hasilproduksi'); ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hasil Produksi</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('supplier'); ?>" class="nav-link">
              <i class="nav-icon fas fa-fw fa-users"></i>
              <p>
                Supplier
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('keuangan'); ?>" class="nav-link">
              <i class="nav-icon fas fa-fw  fa-folder"></i>
              <p>
                Catatan Keuangan
              </p>
            </a>
          </li>
         
          <li class="nav-header">Report</li>
          <li class="nav-item">
            <a href="<?= base_url('laporan'); ?>" class="nav-link">
              <i class="nav-icon fas fa-fw fa-print"></i>
              <p>
                Cetak Laporan
              </p>
            </a>
          </li>
          <li class="nav-header">Settings</li>
          <li class="nav-item">
            <a href="<?= base_url('user'); ?>" class="nav-link">
              <i class="nav-icon fas fa-fw fa-user-plus"></i>
              <p>
                User Management
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <?= $contents ?>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <!-- <footer class="main-footer"> -->
    <!-- To the right -->
    <!-- <div class="float-right d-none d-sm-inline">
      Anything you want
    </div> -->
    <!-- Default to the left -->
    <!-- <strong>Copyright &copy; 2024 <a href="#">Sistem Pengelolaan Data Ternak</a>.</strong> All rights reserved.
  </footer> -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Yakin ingin logout?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Klik "Logout" dibawah ini jika anda yakin ingin logout.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batalkan</button>
          <a class="btn btn-primary" href="<?= base_url('logout'); ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

<!-- jQuery -->
<script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/') ?>dist/js/adminlte.min.js"></script>
<!-- ChartJS -->
<script src="<?= base_url('assets/') ?>plugins/chart.js/Chart.min.js"></script>

<script src="<?= base_url(); ?>assets/vendor/daterangepicker/moment.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/daterangepicker/daterangepicker.js"></script>

<script type="text/javascript">
  $(function() {
      var start = moment().subtract(29, 'days');
      var end = moment();

      function cb(start, end) {
        $('#tangal').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      }

      $('#tanggal').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
          'Hari ini': [moment(), moment()],
          'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          '7 hari terakhir': [moment().subtract(6, 'days'), moment()],
          '30 hari terakhir': [moment().subtract(29, 'days'), moment()],
          'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
          'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
          'Tahun ini': [moment().startOf('year'), moment().endOf('year')],
          'Tahun lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        }
      }, cb);

      cb(start, end);
    });

  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#858796';

      function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
          prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
          dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
          s = '',
          toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
          };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
          s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
          s[1] = s[1] || '';
          s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
      }

  var ctx = document.getElementById("myAreaChart");
      var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
          datasets: [{
              label: "Total Barang Masuk",
              lineTension: 0.3,
              backgroundColor: "rgba(235, 64, 52, 1)",
              borderColor: "rgba(78, 115, 223, 1)",
              pointRadius: 3,
              pointBackgroundColor: "rgba(78, 115, 223, 1)",
              pointBorderColor: "rgba(78, 115, 223, 1)",
              pointHoverRadius: 3,
              pointHoverBackgroundColor: "#5a5c69",
              pointHoverBorderColor: "#5a5c69",
              pointHitRadius: 10,
              pointBorderWidth: 2,
              data: <?= json_encode(@$cbm); ?>,
            },
            {
              label: "Total Barang Masuk",
              lineTension: 0.3,
              backgroundColor: "rgba(52, 82, 235, 1)",
              borderColor: "#e74a3b",
              pointRadius: 3,
              pointBackgroundColor: "#e74a3b",
              pointBorderColor: "#e74a3b",
              pointHoverRadius: 3,
              pointHoverBackgroundColor: "#5a5c69",
              pointHoverBorderColor: "#5a5c69",
              pointHitRadius: 10,
              pointBorderWidth: 2,
              data: <?= json_encode(@$cbk); ?>,
            }
          ],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: 5
          },
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false,
                drawBorder: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                  return number_format(value);
                }
              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }],
          },
          legend: {
            display: false
          },
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
              label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
              }
            }
          }
        }
      });
</script>

</body>
</html>
