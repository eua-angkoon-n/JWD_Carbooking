<?php 
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Bangkok');

require_once __DIR__ . "/connect_db.inc.php";
// require_once __DIR__ . "/setting.php";


    $con = connect_database();

    echo 'sadsadasd';

?>