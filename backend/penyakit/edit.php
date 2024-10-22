<?php
  include '../components/header.php';
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
                  <a href="#">Kriteria</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Edit</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <?php
                  $kode_penyakit = $_GET['kode_penyakit'];
                  $query = mysqli_query($koneksi, "SELECT * FROM tbl_penyakit WHERE kode_penyakit='$kode_penyakit'");
                  while ($data = mysqli_fetch_array($query)) {
                  $selected_gejala = json_decode($data['kode_gejala'], true);
                ?>
                <form method="POST" action="update.php">
                  <div class="card">
                    <div class="card-header">
                      <div class="card-title">Form Edit</div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <label for="kode_kriteria">Kode Penyakit</label>
                            <input
                              type="text"
                              value="<?= $data['kode_penyakit']; ?>"
                              class="form-control"
                              id="kode_penyakit"
                              name=""
                              placeholder="Masukkan Kode Penyakit"
                              disabled
                            />
                            <input type="hidden" name="kode_penyakit"  value="<?= $data['kode_penyakit']; ?>">
                          </div>
                          <div class="form-group">
                            <label for="kode_kriteria">Nama Penyakit</label>
                            <input
                              type="text"
                              value="<?= $data['nama_penyakit']; ?>"
                              class="form-control"
                              id="nama_penyakit"
                              name="nama_penyakit"
                              placeholder="Masukkan Nama Penyakit"
                            />
                          </div>
                          <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea class="form-control" id="Keterangan"  name="keterangan" rows="5"><?= $data['keterangan']; ?></textarea>
                          </div>
                          <div class="form-group">
                            <label for="">Cara Penanganan</label>
                            <textarea class="form-control" id="pencegahan" name="pencegahan"  rows="7"><?= $data['pencegahan']; ?></textarea>
                          </div>
                          <div class="form-group">
                            <label for="">Pilih Gejala</label>
                            <div class="row">
                                <?php
                              // Mengambil data dari Tabel Penyakit
                              $query = mysqli_query($koneksi, "SELECT * FROM tbl_gejala");
                              $index = 0;
                              while($data = mysqli_fetch_array($query)) {
                            ?>
                              <div class="col-6">
                                <div class="form-check p-1">
                                  <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value="<?= $data['kode_gejala'] ?>"
                                    id="flexCheckDefault"
                                    name="gejala[]"
                                    <?php echo in_array($data['kode_gejala'], $selected_gejala) ? 'checked' : ''; ?>
                                  />
                                  <label
                                    class="form-check-label"
                                    for="flexCheckDefault"
                                  >
                                    <?= $data['kode_gejala'] ?> - <?= $data['nama_gejala'] ?>
                                  </label>
                                </div>
                                
                                  </div>
                              <?php 
                              }
                            ?>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="card-action">
                      <button type="submit" class="btn btn-success">Simpan</button>
                      <a href="index.php" class="btn btn-danger">Kembali</a>
                    </div>
                  </div>
                </form>
                <?php
                  }
                ?>
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
    <!-- <script src="https://cdn.tiny.cloud/1/76vv5yc915yv41487s5xwbqpzas2kbhui8gd6fyk5ptjpezx/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> -->
   
    <script src="../../assets/js/froala_editor.pkgd.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="../../assets/js/kaiadmin.min.js"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="../../assets/js/setting-demo2.js"></script>
    <script>
      var editor = new FroalaEditor('#pencegahan');
      

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
