<?php
session_start();
include '../../includes/koneksi.php';


$kode_penyakit = $_POST['kode_penyakit'];
$nama_penyakit = $_POST['nama_penyakit'];
$keterangan= $_POST['keterangan'];
$pencegahan = $_POST['pencegahan'];

$gejala = json_encode($_POST['gejala']);


mysqli_query($koneksi,"INSERT INTO tbl_penyakit VALUES('$kode_penyakit', '$nama_penyakit', '$keterangan', '$pencegahan', '$gejala')");

header('Location:index.php');