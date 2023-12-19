<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?PHP echo $title; ?>
    </title>
    <?php 
        include( __DIR__ . "/component/link.php"); 
        include( __DIR__ . "/component/style.php"); 
    ?>
</head>

<!-- Script -->
<?php include( __DIR__ . "/component/script.php"); ?>

<body class="hold-transition layout-top-nav">
    <!--sidebar-collapse sidebar-mini layout-fixed layout-navbar-fixed sidebar-closed sidebar-collapse layout-navbar-fixed-->

    <div class="wrapper">

        <!-- Main Navbar Container -->
        <?php include( __DIR__ . "/frame/navbar.php"); ?>

        <!-- Main content -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper content-gradient" >
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6 row">
                            <?PHP echo $HeadTitle; ?>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-item active">
                                    <?PHP echo $title; ?>
                                </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <?PHP 
            include __DIR__ . "/" . $include_view;
            ?>
            <!-- Main content -->

        </div>
        <!-- /.content-wrapper -->


        <!-- Main Footer Container -->
        <?php include( __DIR__ . "/../../../../app/Views/main/frame/footer.php"); ?>

    </div>

    <a href="#" class="scrollup"><i class="fas fa-angle-double-up"></i> เลื่อนขึ้น</a>
</body>

</html>