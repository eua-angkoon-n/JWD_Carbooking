<footer class="main-footer no-print">
    <strong>Copyright &copy; 2022 <a href="#">www.scgjwd.com</a>.</strong> All rights reserved.
    <?PHP
            $end = $Time->End_Time();
            $total = $Time->Total_Time($start, $end);
            $Time->show_msg($total);
            echo print_mem();
            ?>
    <?php  if (!empty($_SESSION['car_id_user'])) { ?>
    <div class="float-right d-none d-sm-inline-block">
        <b>Phase <?php echo $_SESSION['phase'];?> / Version</b> <?php echo $_SESSION['version'];?>
    </div>
    <?php  } ?>
</footer>