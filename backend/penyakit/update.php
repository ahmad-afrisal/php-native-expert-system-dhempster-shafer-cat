<?php
    session_start();
    include '../../includes/koneksi.php';
    
    $kode_penyakit = $_POST['kode_penyakit'];
    $nama_penyakit = $_POST['nama_penyakit'];
    $keterangan= $_POST['keterangan'];
    $pencegahan = $_POST['pencegahan'];
    $gejala = json_encode($_POST['gejala']);


    mysqli_query($koneksi, "UPDATE tbl_penyakit SET nama_penyakit='$nama_penyakit', keterangan='$keterangan', pencegahan='$pencegahan', kode_gejala='$gejala' WHERE kode_penyakit='$kode_penyakit'");

    header('Location:index.php');