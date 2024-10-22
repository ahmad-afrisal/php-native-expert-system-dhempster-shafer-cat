<?php
session_start();
include '../../includes/koneksi.php';

$kode_gejala = $_GET['kode_gejala'];
mysqli_query($koneksi, "DELETE FROM tbl_gejala WHERE kode_gejala='$kode_gejala'");
header('Location:index.php');

?>