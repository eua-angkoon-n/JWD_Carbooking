<?php 
include(__DIR__ . "/component/style.php");
include(__DIR__ . "/functions/f-list.php");

$call = new List_Reservation();
$vehicle = $call->getVehicle();
$save = $call->getSave();
$div  = $call->VehicleList();
include(__DIR__ . "/frame/v-modal.php");
?>

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
           <?php echo $div;?>
        </div>
    </div>
</div>

<?php
include(__DIR__ . "/component/script.php");
include(__DIR__ . "/component/script_dataTable.php");
?>