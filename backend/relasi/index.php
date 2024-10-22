<?php
  include '../components/header.php';


  
    // Inisialisasi array asosiatif
    $gejala = [];

    // Mengambil data dari Tabel Gejala
    $query = mysqli_query($koneksi, "SELECT kode_gejala, nama_gejala FROM tbl_gejala");
    while($data = $query->fetch_assoc()) {
      $gejala[$data['kode_gejala']] = $data['nama_gejala'];
    }

    // Inisialisasi array asosiatif
    $penyakit = [];

    // Mengambil data dari Tabel Penyakit
    $query = mysqli_query($koneksi, "SELECT kode_penyakit, nama_penyakit FROM tbl_penyakit");
    while($data = mysqli_fetch_array($query)) {
      $penyakit[$data['kode_penyakit']] = $data['nama_penyakit'];
    }

    $relasi = [];

     // Mengambil data dari Tabel Gejala
    $query = mysqli_query($koneksi, "SELECT kode_penyakit, kode_gejala FROM tbl_penyakit");
    // Memeriksa apakah ada hasil
    if ($query->num_rows > 0) {
        // Mengolah setiap baris hasil
        while ($row = $query->fetch_assoc()) {
            $kode_penyakit = $row['kode_penyakit'];
            $kode_gejala_json = $row['kode_gejala'];
            
            // Mengonversi JSON ke array
            $kode_gejala_array = json_decode($kode_gejala_json, true);
            
            // Menyimpan data relasi
            $relasi[$kode_penyakit] = $kode_gejala_array;
        }
    } else {
        echo "0 hasil";
    }


  // Fungsi untuk mendapatkan nama gejala berdasarkan kode
  function getNamaGejala($kode, $gejala) {
      return isset($gejala[$kode]) ? $gejala[$kode] : "Kode gejala tidak ditemukan";
  }

  // Fungsi untuk mendapatkan nama gejala berdasarkan kode
  function getNamaPenyakit($kode, $penyakit) {
      return isset($penyakit[$kode]) ? $penyakit[$kode] : "Kode penyakit tidak ditemukan";
  }

?>

  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <?php
        include '../components/sidebar.php';
      ?>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="#" class="logo">
                <img
                  src="../assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <?php
            include '../components/navbar.php';
          ?>
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Detail Perhitungan</a>
                </li>
              </ul>
            </div>
            <div class="row">


              <!-- Tahap 2 -->
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                       <h4 class="card-title">Gejala / Aturan Rule untuk Masing-Masing Penyakit</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    

                    <div class="table-responsive">
                      <table
                        id="add-row"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>NAMA PENYAKIT</th>
                            <th>GEJALA</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>NAMA PENYAKIT</th>
                            <th>GEJALA</th>
                          </tr>
                        </tfoot>
                        <tbody>
                       <?php
                        // Mencetak data
                        foreach ($penyakit as $index => $penyakit_id) {
                        ?>
                          <tr>
                            <!-- // Menampilkan ID Penyakit dan Nama Penyakit -->
                            <td><?= htmlspecialchars($index) ?> - <?= htmlspecialchars($penyakit_id) ?></td>
                            <td>
                              <ul>
                              <?php
                                // Pastikan $index ada dalam array $relasi
                                if (isset($relasi[$index])) {
                                  foreach ($relasi[$index] as $kodeGejala) {
                                    ?>
                                    <li><?= $kodeGejala; ?>- <?= htmlspecialchars(getNamaGejala($kodeGejala, $gejala)) ?></li>
                                    <?php
                                  }
                                }
                              ?>
                              </ul>
                            </td>
                          </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>



           
          </div>
        </div>

        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <nav class="pull-left">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="http://www.themekita.com">
                    ThemeKita
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Help </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Licenses </a>
                </li>
              </ul>
            </nav>
            <div class="copyright">
              2024, made with <i class="fa fa-heart heart text-danger"></i> by
              <a href="http://www.themekita.com">ThemeKita</a>
            </div>
            <div>
              Distributed by
              <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
            </div>
          </div>
        </footer>
      </div>


    </div>
    <!--   Core JS Files   -->
    <script src="../../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Datatables -->
    <script src="../../assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Kaiadmin JS -->
    <script src="../../assets/js/kaiadmin.min.js"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="../../assets/js/setting-demo2.js"></script>
    <script>
      $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $(
                  '<select class="form-select"><option value=""></option></select>'
                )
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });

        // Add Row
        $("#add-row").DataTable({
          pageLength: 5,
        });

        var action =
          '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        // $("#addRowButton").click(function () {
        //   $("#add-row")
        //     .dataTable()
        //     .fnAddData([
        //       $("#kode_kriteria").val(),
        //       $("#nama_kriteria").val(),
        //       $("#attribut").val(),
        //       $("#nilai_kriteria").val(),
        //       action,
        //     ]);
        //   $("#addRowModal").modal("hide");
        // });
      });
    </script>
  </body>
</html>
