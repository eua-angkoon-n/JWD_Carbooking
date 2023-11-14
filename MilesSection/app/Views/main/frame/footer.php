<footer class="main-footer no-print">
    <strong>Copyright &copy; 2022 <a href="#">jwdcoldchain.com</a>.</strong> All rights reserved.
    <?PHP
            $end = $Time->End_Time();
            $total = $Time->Total_Time($start, $end);
            $Time->show_msg($total);
            echo print_mem();
            ?>
    <div class="float-right d-none d-sm-inline-block">
        <b>Phase 1 / Version</b> 1.0
    </div>
</footer>