<?php
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . "/../../config/connectDB.php";
require_once __DIR__ . "/../../config/setting.php";

require_once __DIR__ . "/../../tools/crud.tool.php";
require_once __DIR__ . "/../../tools/function.tool.php";

require_once __DIR__ . "/../Views/mileOut/DataTable.php";

$column = $_POST['order']['0']['column'] + 1;
$search = $_POST["search"]["value"];
$start  = $_POST["start"];
$length = $_POST["length"];
$dir    = $_POST['order']['0']['dir'];
$draw   = $_POST["draw"];

$dataGet = array(
    'column' => $column,
    'search' => $search,
    'length' => $length,
    'start'  => $start,
    'dir'    => $dir,
    'draw'   => $draw
);

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'mileOut':
            $Call    = new mileOutTable($dataGet);
            $result = $Call->getTable(); 
            // print_r($result);
            echo json_encode($result); 
            break;
    }
} else {
    echo json_encode('No Action');
}
exit;