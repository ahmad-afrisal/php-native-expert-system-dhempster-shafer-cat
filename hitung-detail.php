<?php
  include 'includes/koneksi.php';

  // TANGKAP GEJALA YANG DIKIRIM USER
  $gejalaTest = [];

    // Cek apakah ada data checkbox yang dikirimkan
    if (isset($_POST['gejala']) && is_array($_POST['gejala'])) {
        $gejala = $_POST['gejala'];

      for($i = 0; $i < count($gejala); $i++) {
          $gejalaTest[$i] = $gejala[$i];
      }
    } else {
        header("location:index.php?alert=Tidak ada gejala yang dipilih");
    }
  
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

  $nilaiGejala = [];

                        // Mencetak data
                        foreach ($penyakit as $index => $penyakit_id) {
                        // Pastikan $index ada dalam array $relasi
                            if (isset($relasi[$index])) {
                              // Hitung nilai untuk setiap gejala
                            $value = 1.0 / count($relasi[$index]);
                            // Array untuk menyimpan nilai gejala
                            $nilaiGejala[$index] = [];
                              foreach ($relasi[$index] as $kodeGejala) {
                                $nilaiGejala[$index][$kodeGejala] = $value;
                                
                              }
                            }
                        }

                      
                      $fungsi_densitas = [];

                    // Melakukan iterasi pada setiap penyakit dan gejala terkaitnya
                    foreach ($relasi as $penyakit_kode => $gejalas) {
                        foreach ($gejalas as $g) {
                            // Menambahkan penyakit ke dalam daftar penyakit untuk gejala tertentu
                            if (!isset($fungsi_densitas[$g])) {
                                $fungsi_densitas[$g] = [];
                            }
                            $fungsi_densitas[$g][] = $penyakit_kode;
                        }
                    }

                    // $beliefs = [];
                    // Menghitung nilai belief dan plausibility untuk setiap gejala
                    $beliefs = [];
                    $plausibility = [];
                      foreach ($fungsi_densitas as $gj => $penyakitall) {
                        $nilai_gejala_total = [];
                        
                        // Mengumpulkan nilai gejala untuk penyakit yang terkait
                        foreach ($penyakitall as $p) {
                            if (isset($nilaiGejala[$p][$gj])) {
                                $nilai_gejala_total[] = $nilaiGejala[$p][$gj];
                            }
                        }

                        // var_dump($nilai_gejala_total);
                        
                        // Hitung rata-rata belief untuk gejala
                        if (!empty($nilai_gejala_total)) {
                            $average_belief = array_sum($nilai_gejala_total) / count($nilai_gejala_total);
                            $beliefs[$gj] = $average_belief;
                            $plausibility[$gj] = 1 - $average_belief;
                        } else {
                            $beliefs[$gj] = 0;
                            $plausibility[$gj] = 1;
                        }
                      }

                  
                    // var_dump($gejala);
                      
                    ?>

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Sistem Pakar Penyakit Kucing</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img
                src="assets/img/kaiadmin/logo_light.svg"
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
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a
                  href="index.php"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Home</p>
                </a>

              </li>
              <li class="nav-item">
                <a
                
                  href="login.php"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-sign-in-alt"></i>
                  <p>Login</p>
                </a>
              </li>
            </ul>
          </div>
        </div>

      </div>
      <!-- End Sidebar -->

     <div class="main-panel">

        <div class="container">
          <div class="page-inner">
            <?php

            // Pengecekana apakah ada gejala yang terpilih
              if ($gejalaTest) {
                $indexGejala1 = $gejalaTest[0];


                // Mengambil Simbol Gej 1
                $m1Symbols = [$fungsi_densitas[$indexGejala1], [-1]];
                // Mengambil Nilai Bel & Plau Gej 1
                $m1Values = [$plausibility[$indexGejala1], $beliefs[$indexGejala1]];

                // Validasi Jika Pilihan Gejala Lebih dari 1
                if (count($gejalaTest) > 1) {
                  // Buat For Sebanyak Gejala
                    for ($i = 1; $i < count($gejalaTest); $i++) {
                      // Ambil Gejala 2
                        $indexGejala2 = $gejalaTest[$i];
                         // Mengambil Simbol Gej 2
                        $m2Symbols = [$fungsi_densitas[$indexGejala2], [-1]];
                        // Mengambil Nilai Bel & Plau Gej 2
                        $m2Values = [$plausibility[$indexGejala2], $beliefs[$indexGejala2]];
            
                        $matrixSymbols = array_fill(0, count($m1Values), array_fill(0, count($m2Values), null));
                        $matrixValues = array_fill(0, count($m1Values), array_fill(0, count($m2Values), 0));

                        $sumNULL = 0;
            
                        for ($j = 0; $j < count($matrixValues); $j++) {
                            for ($k = 0; $k < count($matrixValues[$j]); $k++) {
                                $matrixValues[$j][$k] = $m1Values[$j] * $m2Values[$k];
                                $symbol1 = $m1Symbols[$j];
                                $symbol2 = $m2Symbols[$k];
            
                                if ($j < count($matrixValues) - 1) {
                                    if ($k < count($matrixValues[$j]) - 1) {
                                        $isSubset = true;
                                        foreach ($symbol1 as $s1) {
                                            if (!in_array($s1, $symbol2)) {
                                                $isSubset = false;
                                                break;
                                            }
                                        }
                                        $matrixSymbols[$j][$k] = $isSubset ? $symbol1 : null;
                                    } else {
                                        $matrixSymbols[$j][$k] = $symbol1;
                                    }
                                } else {
                                    $matrixSymbols[$j][$k] = ($k < count($matrixValues[$j]) - 1) ? $symbol2 : [-1];
                                }
            
                                if ($matrixSymbols[$j][$k] === null) {
                                    $sumNULL += $matrixValues[$j][$k];
                                }
                            }
                        }
            
                        $newSymbols = array_fill(0, count($m1Symbols) + 1, []);
                        $newValues = array_fill(0, count($m1Values) + 1, 0);
                        $denominator = 1 - $sumNULL;
            
                        for ($j = 0; $j < count($m1Symbols) - 1; $j++) {
                            $newSymbols[$j] = $m1Symbols[$j];
                            $numerator = $matrixValues[$j][1];
                            $newValues[$j] = $numerator / $denominator;
                        }
            
                        $newSymbols[count($m1Symbols) - 1] = $m2Symbols[0];
                        $numerator = $matrixValues[count($matrixValues) - 1][0];
                        $newValues[count($m1Symbols) - 1] = $numerator / $denominator;
            
                        $newSymbols[count($newSymbols) - 1] = [-1];
                        $numerator = $matrixValues[count($matrixValues) - 1][count($matrixValues[0]) - 1];
                        $newValues[count($newValues) - 1] = $numerator / $denominator;
            
                        $m1Symbols = $newSymbols;
                        $m1Values = $newValues;
                    }
            
                    $penyakitTerdeteksi = [];
                    for ($i = 0; $i < count($m1Symbols); $i++) {
                        foreach ($m1Symbols[$i] as $symbol) {
                            if ($symbol !== -1 && !in_array($symbol, $penyakitTerdeteksi)) {
                                $penyakitTerdeteksi[] = $symbol;
                            }
                        }
                    }
            
                    $iMAX = -1;
                    $MAX_DENSITY = PHP_FLOAT_MIN;
                    $densitasPenyakit = array_fill(0, count($penyakitTerdeteksi), 0);
                    for ($i = 0; $i < count($penyakitTerdeteksi); $i++) {
                        $value = 0;
                        $p = $penyakitTerdeteksi[$i];
                        for ($j = 0; $j < count($m1Symbols); $j++) {
                            if (in_array($p, $m1Symbols[$j])) {
                                $value += $m1Values[$j];
                            }
                        }
                        $densitasPenyakit[$i] = $value;
                        if ($densitasPenyakit[$i] > $MAX_DENSITY) {
                            $MAX_DENSITY = $densitasPenyakit[$i];
                            $iMAX = $i;
                        }
                }

                $fungsi_densitas = []; 

                    // Looping melalui setiap penyakit
                    foreach ($relasi as $pen => $daftarGejala) {
                        // Looping melalui gejala yang terkait dengan penyakit tersebut
                        foreach ($daftarGejala as $geja) {
                            // Menambahkan penyakit ke dalam daftar fungsi densitas untuk gejala terkait
                            $fungsi_densitas[$geja][] = $pen;
                        }
                    }


                    // Inisialisasi belief dan plausibility untuk setiap gejala
                    $belief = [];
                    $plausibility = [];

                    // Hitung Belief dan Plausibility untuk setiap gejala
                    foreach ($fungsi_densitas as $gejala => $penyakitTerkait) {
                        $b = 0;
                        $n = count($penyakitTerkait); // Jumlah penyakit yang terkait dengan gejala ini
                        
                        // Loop melalui setiap penyakit yang terkait dengan gejala
                        foreach ($penyakitTerkait as $pen) {
                            // Cek apakah gejala ada dalam penyakit yang terkait
                            if (isset($nilai_gejala[$pen][$gejala])) {
                                // Tambahkan nilai gejala ke variabel $b
                                $b += $nilai_gejala[$pen][$gejala];
                            }
                        }
                        
                        // Menghitung belief sebagai rata-rata nilai gejala terkait
                        $belief[$gejala] = ($n > 0) ? $b / $n : 0;
                        
                        // Menghitung plausibility (1 - belief)
                        $plausibility[$gejala] = 1 - $belief[$gejala];
                    }

                    $indexPenyakitDiagnosa = $penyakitTerdeteksi[$iMAX]; // Mendapatkan key penyakit dengan densitas maksimum
                          // var_dump($penyakit);
                    $penyakitDiagnosa = $penyakit[$indexPenyakitDiagnosa];

                    //  var_dump($penyakitTerdeteksi);
                    // var_dump($densitasPenyakit);
            ?>


            <!-- Tahap 4 Hasil -->
            <div class="row">
              <div class="col-md-12">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-secondary bubble-shadow-small"
                        >
                          <i class="far fa-check-circle"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                        <p class="card-category">Hasil Diagnosis :   </p>
                          <h4 class="card-title"><?= $penyakitDiagnosa; ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
                  }
                }
                
            ?>

              <?php 
              include 'includes/koneksi.php';
               // Mengambil data dari Tabel Penyakit
                $keterangan = "";
                $pencegahan = "";
                $query = mysqli_query($koneksi, "SELECT * FROM tbl_penyakit WHERE nama_penyakit='$penyakitDiagnosa'");
                while($data = mysqli_fetch_array($query)) {
                  $keterangan = $data['keterangan'];
                  $pencegahan = $data['pencegahan'];
                }
            ?>

            <div class="row">
              <div class="col-md-6 col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Keterangan Penyakit</div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <?=  $keterangan; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Cara Pengobatan</div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <?=  $pencegahan; ?>
                      </div>
                    </div>
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

      <!-- Custom template | don't include it in your project! -->
      <div class="custom-template">
        <div class="title">Settings</div>
        <div class="custom-content">
          <div class="switcher">
            <div class="switch-block">
              <h4>Logo Header</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="selected changeLogoHeaderColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="selected changeLogoHeaderColor"
                  data-color="blue"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="purple"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="light-blue"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="green"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="orange"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="red"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="white"
                ></button>
                <br />
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="dark2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="blue2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="purple2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="light-blue2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="green2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="orange2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="red2"
                ></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Navbar Header</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="blue"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="purple"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="light-blue"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="green"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="orange"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="red"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="white"
                ></button>
                <br />
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="dark2"
                ></button>
                <button
                  type="button"
                  class="selected changeTopBarColor"
                  data-color="blue2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="purple2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="light-blue2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="green2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="orange2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="red2"
                ></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Sidebar</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="selected changeSideBarColor"
                  data-color="white"
                ></button>
                <button
                  type="button"
                  class="changeSideBarColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeSideBarColor"
                  data-color="dark2"
                ></button>
              </div>
            </div>
          </div>
        </div>
        <div class="custom-toggle">
          <i class="icon-settings"></i>
        </div>
      </div>
      <!-- End Custom template -->
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