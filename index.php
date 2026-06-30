<?php
include 'koneksi.php';
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="Irene" />
  <meta name="generator" content="Astro v5.13.2" />
  <meta name="theme-color" content="#712cf9" />
  <title>IRENE & ALVIN</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/navbars/" />
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet" />

  <script src="assets/js/color-modes.js"></script>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jquery.min.js"></script>
</head>

<body>
  <main>
    <div class="container">
      <?php
      include 'menu.php';

      if (isset($_GET['menu'])) {
        $menu = $_GET['menu'];
        if ($menu == "dashboard") {
          include 'pages/dashboard/index.php';
        } else if ($menu == "supplier") {
          include 'pages/supplier/index.php';
        } else if ($menu == "produk") {
          include 'pages/produk/index.php';
        }
      } else {
        include 'pages/dashboard/index.php';
      }
      ?>
    </div>
  </main>
  <script src="assets/dist/js/bootstrap.bundle.min.js" class="astro-vvvwv3sm"></script>
</body>

</html>