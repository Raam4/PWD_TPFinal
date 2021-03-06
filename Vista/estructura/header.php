<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/fontawesome/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Architects+Daughter">
    <link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../vendor/almasaeed2010/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="../css/toastr.css"><link rel="stylesheet" href="../css/style.css">
    <script src="../js/jquery/jquery-3.6.0.min.js"></script>
    <title><?php $Titulo ?></title>
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper" id="wrapM">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light" id="header-nav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="../public/Index.php" class="nav-link">Inicio</a>
          </li>
        </ul>
      </nav>
      <!-- /Navbar -->
      <!-- side menu -->
      <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4" id='asidecont'>
        <a href="../public/Index.php" class="brand-link">
          <img src="../css/img/log3.png" alt="logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span id='logot' class="brand-text font-weight-light">Toc Toc</span>
        </a>
        <div class="sidebar">
          <!--menu-->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
              <?php
                echo $perfil;
                echo $menu;
              ?>
            </ul>
          </nav>
          <!-- /menu-->
        </div>

        <!-- sidebar-custom -->
        <?php
        if($objSess->activa()){
          echo '
            <div class="sidebar-custom">
            <a href="../accion/public/cerrarSesion.php" class="link-danger hide-on-collapse pos-right m-0" id="cerrarSess" >Cerrar sesion</a>
            </div>';
        }
        ?>
        <!-- /sidebar-custom -->
      </aside>
      <!-- /side menu -->
        