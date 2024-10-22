<?php  
     if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
          $url = "https://";   
     else  
          $url = "http://";   
     // Append the host(domain name, ip) to the URL.   
     $url.= $_SERVER['HTTP_HOST'];   
     
     // Append the requested resource location to the URL   
     $url.= $_SERVER['REQUEST_URI'];    
          
     $pieces = explode("/",$url);
     $active = $pieces[5];
    
    
?>



<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="#" class="logo">
              <img
                src="../../assets/img/kaiadmin/logo_light.svg"
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
              <li class="nav-item">
                <a
                  data-bs-toggle="collapse"
                  href="#dashboard"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
              </li>
              <li class="nav-item <?= $active == 'penyakit' ? 'active' : ''; ?>">
                <a href="../penyakit/index.php">
                  <i class="fas fa-layer-group"></i>
                  <p>Penyakit</p>
                </a>
              </li>
              <li class="nav-item <?= $active == 'gejala' ? 'active' : ''; ?>">
                <a href="../gejala/index.php">
                  <i class="fas fa-th-list"></i>
                  <p>Gejala</p>
                </a>
              </li>
              <li class="nav-item <?= $active == 'relasi' ? 'active' : ''; ?>">
                <a href="../relasi/index.php">
                  <i class="fas fa-th-list"></i>
                  <p>Aturan Gelaja / Relasi</p>
                </a>
              </li>
              
              <li class="nav-item <?= $active == 'hitung' ? 'active' : ''; ?>">
                <a href="../hitung/index.php">
                  <i class="fas fa-plus"></i>
                  <p>Perhitungan</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="#">
                  <i class="fas fa-cogs"></i>
                  <p>Ubah Password</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="../../logout.php">
                  <i class="fas fa-sign-out-alt"></i>
                  <p>Logout</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->