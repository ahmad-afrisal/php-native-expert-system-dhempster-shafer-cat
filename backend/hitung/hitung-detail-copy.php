<?php
  include '../components/header.php';


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
  
    $gejala = [];

    // Mengambil data dari Tabel Penyakit
    $query = mysqli_query($koneksi, "SELECT nama_gejala FROM tbl_gejala");
    while($data = mysqli_fetch_array($query)) {
      $gejala[] = $data['nama_gejala'];
    }


    $penyakit = [];

    // Mengambil data dari Tabel Penyakit
    $query = mysqli_query($koneksi, "SELECT nama_penyakit FROM tbl_penyakit");
    while($data = mysqli_fetch_array($query)) {
      $penyakit[] = $data['nama_penyakit'];
    }


  // $penyakit = [
  //     "Scabies",
  //     "Virus Panleukopenia",
  //     "FLUTD",
  //     "Calicivirus",
  //     "Radang Mata",
  // ];

  

  $relasi = [
      [0, 1, 2, 3, 4],
      [2, 5, 6, 7, 8],
      [2, 6, 9, 10, 11],
      [2, 5, 8, 12, 13],
      [14, 15, 16]
  ];
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
                          // Mengambil data dari Tabel Kriteria
                          for ($i = 0; $i < count($penyakit); $i++) {

                        ?>
                          <tr>
                            <td><?= $penyakit[$i] ?></td>
                            <td>
                              <ul>
                              <?php
                                  for ($j = 0; $j < count($relasi[$i]); $j++) {
                                    $indexGejala = $relasi[$i][$j];
                                ?>
                                  <li><?= $gejala[$indexGejala] . ", "?></li>
                                <?php
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

              <!-- Tahap 2 -->
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">NILAI GEJALA</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    

                    <?php
                      // NILAI GEJALA
                      $nilaiGejala = [];
                      for ($i = 0; $i < count($relasi); $i++) {
                          $nilaiGejala[$i] = [];
                          $value = 1.0 / count($relasi[$i]);
                          for ($j = 0; $j < count($relasi[$i]); $j++) {
                              $nilaiGejala[$i][$j] = $value;
                          }
                      }
                    ?>
                    <div class="table-responsive">
                      <table
                        id="add-row"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>NAMA PENYAKIT</th>
                            <th>GEJALA</th>
                            <th>KATEGORI BOBOT</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>NAMA PENYAKIT</th>
                            <th>GEJALA</th>
                            <th>NILAI GEJALA</th>
                          </tr>
                        </tfoot>
                        <tbody>
                        <?php
                          // Mengambil data dari Tabel Kriteria
                          for ($i = 0; $i < count($relasi); $i++) {

                        ?>
                          <tr>
                            <td><?= $penyakit[$i] ?></td>
                            <td>
                              <ul>
                              <?php
                                  for ($j = 0; $j < count($relasi[$i]); $j++) {
                                    $indexGejala = $relasi[$i][$j];
                                ?>
                                  <li><?= $gejala[$indexGejala]; ?></li>
                                <?php
                                  }
                                ?>

                              </ul>
                            </td>
                            <td>
                              <ul>
                              <?php
                                  for ($j = 0; $j < count($relasi[$i]); $j++) {
                                    $indexGejala = $relasi[$i][$j];
                                ?>
                                  <li><?=  $nilaiGejala[$i][$j]; ?></li>
                                <?php
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

              <!-- Tahap 3 -->
              <!-- Nilai Belief (Bel) dan Plausibility (PI) untuk Masing-Masing Gejala -->
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">Nilai Belief (Bel) dan Plausibility (PI)</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    

                    <?php
                      // FUNGSI DENSITAS
                      $simbolFungsiDensitas = array_fill(0, count($gejala), []);

                      for ($i = 0; $i < count($penyakit); $i++) {
                          for ($j = 0; $j < count($relasi[$i]); $j++) {
                              $indexGejala = $relasi[$i][$j];
                              $simbolFungsiDensitas[$indexGejala][] = $i;
                          }
                      }

                     // Hitung Belief and Plausality
                      $belief = array_fill(0, count($gejala), 0);
                      $plausibility = array_fill(0, count($gejala), 0);

                      for ($i = 0; $i < count($belief); $i++) {
                          $b = 0;
                          $n = count($simbolFungsiDensitas[$i]);
                          for ($j = 0; $j < $n; $j++) {
                              $indexPenyakit = $simbolFungsiDensitas[$i][$j];
                              $indexGejala = array_search($i, $relasi[$indexPenyakit]);
                              $b += $nilaiGejala[$indexPenyakit][$indexGejala];
                          }

                          $belief[$i] = $b / $n;
                          $plausibility[$i] = 1 - $belief[$i];
                      }
                    ?>
                    <div class="table-responsive">
                      <table
                        id="add-row"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>KODE GEJALA</th>
                            <th>NAMA PENYAKIT MATA</th>
                            <th>SIMBOL FUNGSI DENSITAS</th>
                            <th>NILAI BELIEF (BEL)</th>
                            <th>NILAI PLAUSABILITY (PI)</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>KODE GEJALA</th>
                            <th>NAMA PENYAKIT MATA</th>
                            <th>NILAI BELIEF (BEL)</th>
                            <th>SIMBOL FUNGSI DENSITAS</th>
                            <th>NILAI PLAUSABILITY (PI)</th>
                          </tr>
                        </tfoot>
                        <tbody>
                        <?php
                          for ($i = 0; $i < count($simbolFungsiDensitas); $i++) {

                        ?>
                          <tr>
                            <td>
                              <?php echo "G" . ($i + 1)?>
                            </td>
                            <td>
                              <?php
                                echo "{";
                                for ($j = 0; $j < count($simbolFungsiDensitas[$i]); $j++) {
                                    if ($j > 0) {
                                      echo ", ";
                                  }
                                  echo "P" . ($simbolFungsiDensitas[$i][$j] + 1);
                                }
                                echo "}";
                              ?>
                            </td>
                            <td>
                              <?php
                                echo "G" . ($i + 1) . "{";
                                for ($j = 0; $j < count($simbolFungsiDensitas[$i]); $j++) {
                                    if ($j > 0) {
                                        echo ", ";
                                    }
                                    echo "P" . ($simbolFungsiDensitas[$i][$j] + 1);
                                }
                                echo "}";
                              ?>
                            </td>
                            <td>
                              <?=  $belief[$i]; ?>
                            </td>
                            <td>
                              <?= $plausibility[$i]; ?>
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
            <?php
              if ($gejalaTest) {
                $indexGejala1 = $gejalaTest[0];
                $m1Symbols = [$simbolFungsiDensitas[$indexGejala1], [-1]];
                $m1Values = [$plausibility[$indexGejala1], $belief[$indexGejala1]];
            
                if (count($gejalaTest) > 1) {
                    for ($i = 1; $i < count($gejalaTest); $i++) {
                        $indexGejala2 = $gejalaTest[$i];
                        $m2Symbols = [$simbolFungsiDensitas[$indexGejala2], [-1]];
                        $m2Values = [$plausibility[$indexGejala2], $belief[$indexGejala2]];
            
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
                    $densitasPenyakit = [];
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

            ?>
             <!-- Tahap  4-->
              <!-- Nilai Densitas -->
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">Nilai Densitas</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    

                    <?php
                      // FUNGSI DENSITAS
                      $simbolFungsiDensitas = array_fill(0, count($gejala), []);

                      for ($i = 0; $i < count($penyakit); $i++) {
                          for ($j = 0; $j < count($relasi[$i]); $j++) {
                              $indexGejala = $relasi[$i][$j];
                              $simbolFungsiDensitas[$indexGejala][] = $i;
                          }
                      }
// print_r($simbolFungsiDensitas);
                     // Hitung Belief and Plausality
                      $belief = array_fill(0, count($gejala), 0);
                      $plausibility = array_fill(0, count($gejala), 0);

                      for ($i = 0; $i < count($belief); $i++) {
                          $b = 0;
                          $n = count($simbolFungsiDensitas[$i]);
                          for ($j = 0; $j < $n; $j++) {
                              $indexPenyakit = $simbolFungsiDensitas[$i][$j];
                              $indexGejala = array_search($i, $relasi[$indexPenyakit]);
                              $b += $nilaiGejala[$indexPenyakit][$indexGejala];
                          }

                          $belief[$i] = $b / $n;
                          $plausibility[$i] = 1 - $belief[$i];
                      }
                    ?>
                    <div class="table-responsive">
                      <table
                        id="add-row"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>KODE PENTAKIT</th>
                            <th>NILAI DENSITAS</th>
                            <th>NILAI DENSITAS (%)</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>KODE PENYAKIT</th>
                            <th>NILAI DENSITAS</th>
                            <th>NILAI DENSITAS (%)</th>
                          </tr>
                        </tfoot>
                        <tbody>
                        <?php
                            for ($i = 0; $i < count($penyakitTerdeteksi); $i++) {
                              $value = $densitasPenyakit[$i];
                          ?>
                          
                          <tr>
                            <td>
                              <?php echo "m{P" . ($penyakitTerdeteksi[$i] + 1) . "}"; ?>
                            </td>
                            <td>
                              <?= (round($value,2)); ?>
                            </td>
                            <td>
                            <?= (round($value * 100, 2))."%"; ?>
                            </td>

                          </tr>

                          <?php
                            }
                            $indexPenyakitDiagnosa = $penyakitTerdeteksi[$iMAX];
                            $penyakitDiagnosa = $penyakit[$indexPenyakitDiagnosa];
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

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
                          <h4 class="card-title"><a href="../penyakit/detail.php?nama_penyakit=<?= $penyakitDiagnosa; ?>"><?= $penyakitDiagnosa; ?></a></h4>
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
