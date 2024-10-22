<?php
    session_start();
    include '../../includes/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard Products</title>
<meta
    content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    name="viewport"
/>
<link
    href="../../assets/img/kaiadmin/favicon.ico"
    type="image/x-icon"
/>

<!-- Fonts and icons -->
<script src="../../assets/js/plugin/webfont/webfont.min.js"></script>
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
        urls: ["../../assets/css/fonts.min.css"],
    },
    active: function () {
        sessionStorage.fonts = true;
    },
    });
</script>

<!-- CSS Files -->
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
<link rel="stylesheet" href="../../assets/css/plugins.min.css" />
<link rel="stylesheet" href="../../assets/css/kaiadmin.min.css" />
<link rel="stylesheet" href="../../assets/css/kaiadmin.min.css" />

<!-- CSS Just for demo purpose, don't include it in your project -->
<link rel="stylesheet" href="../../assets/css/froala_editor.pkgd.min.css" />
</head>