<?php
session_start();
include '../../includes/koneksi.php';


$kode_gejala= $_POST['kode_gejala'];
$nama_gejala= $_POST['nama_gejala'];


mysqli_query($koneksi,"INSERT INTO tbl_gejala VALUES('$kode_gejala', '$nama_gejala')");

header('Location:index.php');