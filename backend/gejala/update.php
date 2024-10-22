<?php
    session_start();
    include '../../includes/koneksi.php';
    
    $kode_gejala = $_POST['kode_gejala'];
    $nama_gejala = $_POST['nama_gejala'];

    mysqli_query($koneksi, "UPDATE tbl_gejala SET nama_gejala='$nama_gejala' WHERE kode_gejala='$kode_gejala'");

    header('Location:index.php');