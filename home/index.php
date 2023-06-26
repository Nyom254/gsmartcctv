<?php
session_start();
include '../conn.php';
if (!isset($_SESSION['status'])) {
  header("location:../login/login_page.php");
}
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CCTV</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../adminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../adminLTE/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../adminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../adminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../adminLTE/dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../adminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="../adminLTE/plugins/ekko-lightbox/ekko-lightbox.css">
  <style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
  </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="modal fade" id="modalLogout">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Logout</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda Yakin untuk Logout?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" onclick="location.href='../login/logout_action.php'">Logout</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  </div>
  <!-- /.modal -->
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-primary navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="?" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <!-- <img src="../../dist/img/user2-160x160.jpg" class="user-image img-circle elevation-2" alt="User Image"> -->
            <i class="img-circle fa-lg fas fa-user  text-white"></i>
            <span class="d-none d-md-inline"><?php echo $_SESSION['username'] ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- User image -->
            <li class="user-header bg-primary">
              <!-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
              <i class="img-circle fa-lg fas fa-user  text-white"></i>
              <p>
                <?php echo $_SESSION['username'] ?>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <a class="btn btn-default btn-flat float-right" data-toggle="modal" data-target="#modalLogout">Sign out</a>
            </li>
          </ul>
        </li>
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a class="brand-link">
        <img src="../adminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">CCTV</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2 small">
          <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="?" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item menu-close">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shield-alt"></i>
                <p>
                  Master
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?content=users" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Users</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="?content=supplier" class="nav-link">
                    <i class="fas fa-box-open nav-icon"></i>
                    <p>Supplier</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="?content=customer" class="nav-link">
                    <i class="fas fa-crown nav-icon"></i>
                    <p>Customer</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="?content=group_barang" class="nav-link">
                    <i class="fas fa-sitemap nav-icon"></i>
                    <p>Group Barang</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="?content=barang" class="nav-link">
                    <i class="fas fa-boxes nav-icon"></i>
                    <p>Barang</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="?content=gudang" class="nav-link">
                    <i class="fas fa-warehouse nav-icon"></i>
                    <p>Gudang</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="?content=departemen" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Departemen</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item menu-close">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cart-plus"></i>
                <p>
                  Pembelian
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?content=purchase-order" class="nav-link">
                    <i class=" nav-icon far fa-circle"></i>
                    <p>Purchase Order</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="?content=penerimaan_barang" class="nav-link">
                    <i class=" nav-icon far fa-circle"></i>
                    <p>Penerimaan Barang</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class=" nav-icon far fa-circle"></i>
                    <p>Invoice Pembelian</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class=" nav-icon far fa-circle"></i>
                    <p>Retur Pembelian</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class=" nav-icon far fa-circle"></i>
                    <p>Pembayaran Supplier</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="?content=pemakaian_kertas" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>
                  Pemakaian Kertas
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="?content=inventaris_kantor" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>
                  inventaris kantor
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="?content=log" class="nav-link">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>
                  Log
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="?content=setup_perusahaan" class="nav-link">
                <i class="nav-icon fas fa-wrench"></i>
                <p>
                  Setup Perusahaan
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
      <?php
      if (!isset($_GET['content'])) {
        $_GET['content'] = 'dashboard';
      }

      switch ($_GET['content']) {
        case 'users':
          if ($_SESSION['status'] == "user_login") {
            include_once '../403.html';
          } else {
            include_once './master/users/users.php';
          }
          break;
        case 'barang':
          include_once './master/barang/barang.php';
          break;
        case 'supplier':
          include_once './master/supplier/supplier.php';
          break;
        case 'group_barang':
          include './master/group_barang/group_barang.php';
          break;
        case 'customer':
          include './master/customer/customer.php';
          break;
        case 'gudang':
          include './master/gudang/gudang.php';
          break;
        case 'log':
          include './log/log.php';
          break;
        case 'purchase-order':
          include './pembelian/purchase-order/purchase-order.php';
          break;
        case 'tambah-purchase-order':
          include './pembelian/purchase-order/tambah_purchase-order_form.php';
          break;
        case 'setup_perusahaan':
          include './setup_perusahaan/setup_perusahaan.php';
          break;
        case 'penerimaan_barang':
          include './pembelian/penerimaan-barang/penerimaan.php';
          break;
        case 'tambah-penerimaan-barang':
          include './pembelian/penerimaan-barang/tambah_penerimaan_barang_form.php';
          break;
        case 'pemakaian_kertas':
          include './pemakaian_kertas/pemakaian_kertas.php';
          break;
        case 'departemen':
          include './master/departemen/departemen.php';
          break;
        case 'inventaris_kantor':
          include './inventaris_kantor/inventaris_kantor.php';
          break;
        case 'profile':
          include './profile/profile.php';
          break;
        case 'dashboard':
          include './dashboard/dashboard.php';
          break;
        default:
          include '../404.html';
          break;
      }

      ?>
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
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        G-SMART CCTV
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy;<a href="https://cctv.gsmart-it.net" target="_blank">GSMART</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="../adminLTE/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../adminLTE/dist/js/adminlte.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../adminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../adminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../adminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../adminLTE/plugins/jszip/jszip.min.js"></script>
  <script src="../adminLTE/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../adminLTE/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../adminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../adminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <!-- Select2 -->
  <script src="../adminLTE/plugins/select2/js/select2.full.min.js"></script>
  <!-- jquery-validation -->
  <script src="../adminLTE/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../adminLTE/plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="../adminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Ekko Lightbox -->
  <script src="../adminLTE/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

  <!-- Page specific script -->
  <script>
    $.validator.addMethod('filesize', function(value, element, param) {
      return this.optional(element) || (element.files[0].size <= param * 1000000)
    }, 'File size must be less than {0} MB');
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
      })
      $("#log-data-table").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "ordering": false,
      })
      $("#info-detail-purchase-order").DataTable({
        "responsive": false,
        "lengthChange": true,
        "autoWidth": false,
        "ordering": false,
        "searching": false,
        "paging": false,
        "info": false,
        language: {
          "zeroRecords": "",
          "emptyTable": ""
        }
      })
      $("#tabel-purchase-order").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        order: [
          [1, 'desc']
        ],
      })
      $("#tabel-po-penerimaan").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        order: [
          [1, 'desc']
        ],
      })
      $("#pemakaian_kertas").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        fixedHeader: {
          header: false,
          footer: true,
        },
      })
      $("#tabelSetupPerusahaan").DataTable({
        "searching": false,
        "lengthChange": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": false,
        "paging": false,
        "info": false,
      })
    });
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      });
    });
    $("#form_transaksi").validate({
      rules: {
        tanggal: {
          required: true,
        },
        term: {
          required: true
        },
      },
      messages: {
        tanggal: {
          required: "Mohon isi Tanggal"
        },
        term: {
          required: "Mohon isi term"
        }
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
    $("#formTambahUser").validate({
      rules: {
        nama: {
          required: true,
        },
        username: {
          required: true
        },
        password: {
          required: true
        }
      },
      messages: {
        nama: {
          required: "Mohon isi Nama"
        },
        username: {
          required: "Mohon isi username"
        },
        password: {
          required: "Mohon Isi Password"
        }
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    })
    $("#formTambahBarang").validate({
      rules: {
        nama: {
          required: true,
        },
        harga: {
          required: true
        },
        satuan: {
          required: true
        },

      },
      messages: {
        nama: {
          required: "Mohon isi Nama Barang"
        },
        harga: {
          required: "Mohon isi Harga Barang"
        },
        satuan: {
          required: "Mohon Isi Satuan Barang"
        }
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    })
    $("#formTambahGroupBarang").validate({
      rules: {
        nama_group: {
          required: true,
        },
      },
      messages: {
        nama_group: {
          required: "Mohon isi Nama Group"
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    })
    $("#formTambahCustomer").validate({
      rules: {
        nama: {
          required: true,
        },
        alamat: {
          required: true
        },
        no_telp: {
          required: true
        },
        kota: {
          required: true
        },
        provinsi: {
          required: true
        },
        keterangan: {
          required: true,
        },
        email: {
          required: true,
          email: true
        }
      },
      messages: {
        nama: {
          required: "Mohon isi Nama customer"
        },
        alamat: {
          required: "Mohon isi alamat customer"
        },
        no_telp: {
          required: "Mohon Isi Nomor Telepon customer"
        },
        kota: {
          required: "Mohon Isi Kota customer"
        },
        provinsi: {
          required: "Mohon Isi Provinsi customer"
        },
        keterangan: {
          required: "Mohon Isi keterangan"
        },
        email: {
          required: "Mohon Isi Email customer",
          email: "Mohon isi email customer dengan format yang benar"
        }
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    })
    $("#formTambahSupplier").validate({
      rules: {
        nama: {
          required: true,
        },
        alamat: {
          required: true
        },
        contact: {
          required: true
        },
        kota: {
          required: true
        },
        keterangan: {
          required: true,
        },
        email: {
          required: true,
          email: true
        }
      },
      messages: {
        nama: {
          required: "Mohon isi Nama supplier"
        },
        alamat: {
          required: "Mohon isi alamat supplier"
        },
        contact: {
          required: "Mohon Isi Contact supplier"
        },
        kota: {
          required: "Mohon Isi Kota supplier"
        },
        keterangan: {
          required: "Mohon Isi keterangan"
        },
        email: {
          required: "Mohon Isi Email supplier",
          email: "Mohon isi email supplier dengan benar"
        }
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    })
    $("#form_tambah_penerimaan_barang").validate({
      rules: {
        tanggal: {
          required: true,
        },
        no_po: {
          required: true,
        }
      },
      messages: {
        tanggal: {
          required: "Mohon isi Tanggal"
        },
        no_po: {
          required: "Mohon pilih PO",
        }
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    })
    $("#formTambahDepartemen").validate({
      rules: {
        nama: {
          required: true,
        },
      },
      messages: {
        nama: {
          required: "Mohon isi Nama Departemen"
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
    $("#formPemakaianKertas").validate({
      rules: {
        tanggal: {
          required: true,
        },
        quantity: {
          required: true,
        },
      },
      messages: {
        tanggal: {
          required: "Mohon isi Tanggal"
        },
        quantity: {
          required: "Mohon isi Quantity"
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
    $("#tambahFormInventarisKantor").validate({
      rules: {
        no_inventaris: {
          required: true,
        },
        tanggal: {
          required: true,
        },
        posisi: {
          required: true,
        },
        quantity: {
          required: true,
        },
        gambar: {
          required: true,
          extension: "png|jpg|jpeg|svg|avif",
          accept: "image/*",
          filesize: 20,
        },
      },
      messages: {
        no_inventaris: {
          required: ""
        },
        tanggal: {
          required: "Mohon isi Tanggal"
        },
        posisi: {
          required: "Mohon isi Posisi"
        },
        quantity: {
          required: "Mohon isi Quantity"
        },
        gambar: {
          required: "Mohon Tambahkan attachment",
          extension: "Mohon Masukan Gambar dengan extensi png,jpg,jpeg,svg atau avif ",
          filesize: "Ukuran gambar harus kurang dari 20 MB",
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });


    const urlParams = new URLSearchParams(window.location.search)
    const toastParameter = urlParams.get('t')

    if (urlParams.get('t')) {
      $(function() {
        var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
        $(() => {
          Toast.fire({
            icon: 'warning',
            title: toastParameter,
          })
        })
      })

      // Get the current URL
      const currentUrl = new URL(window.location.href);

      // Get the search parameters from the URL
      const searchParams = currentUrl.searchParams;

      // Remove the last parameter
      const paramNames = Array.from(searchParams.keys());
      const lastParamName = paramNames.pop();
      searchParams.delete(lastParamName);

      // Construct the updated URL
      const updatedUrl = currentUrl.origin + currentUrl.pathname + '?' + searchParams.toString();

      // Update the browser's address bar with the modified URL
      history.pushState({}, '', updatedUrl);

    }
    jQuery('button[data-toggle="collapse"]').click(function(e) {
      jQuery('.collapse').collapse('hide');
    });
    jQuery('#example1 tbody').on('click', 'button[data-toggle="collapse"]', function(e) {
      jQuery('.collapse').collapse('hide');
    });
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    function ReLoadImages() {
      $('img[data-lazysrc]').each(function() {
        //* set the img src from data-src
        $(this).attr('src', $(this).attr('data-lazysrc'));
      });
    }

    document.addEventListener('readystatechange', event => {
      if (event.target.readyState === "complete") { //or at "complete" if you want it to execute in the most last state of window.
        ReLoadImages();
      }
    });
  </script>

</body>

</html>