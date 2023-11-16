<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?PHP echo $title; ?></title>
    <?php 
        include( __DIR__ . "/component/link.php"); 
        include( __DIR__ . "/component/style.php"); 
    ?>
</head>

<!-- Script -->
<?php include( __DIR__ . "/component/script.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <!--sidebar-collapse sidebar-mini layout-fixed layout-navbar-fixed sidebar-closed sidebar-collapse layout-navbar-fixed-->
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/SCGJWDLogo.png" alt="SCGJWDLogo" height="40" width="200">
        </div>

        <!-- Main Navbar Container -->
        <?php include( __DIR__ . "/frame/navbar.php"); ?>

        <!-- Main Sidebar Container -->
        <?php include( __DIR__ . "/frame/sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>

            <!-- Main content -->
            <?PHP 
            include __DIR__ . "/" . $include_view;
            ?>
            <!-- Main content -->

        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer Container -->
        <?php include( __DIR__ . "/frame/footer.php"); ?>

    </div>
    <!-- ./wrapper -->

    
    

    <a href="#" class="scrollup"><i class="fas fa-angle-double-up"></i> เลื่อนขึ้น</a>
</body>

</html>