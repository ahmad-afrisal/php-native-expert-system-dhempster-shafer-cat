<?php
session_start();
include '../../includes/koneksi.php';

$kode_penyakit = $_GET['kode_penyakit'];
mysqli_query($koneksi, "DELETE FROM tbl_penyakit WHERE kode_penyakit='$kode_penyakit'");
header('Location:index.php');

?>