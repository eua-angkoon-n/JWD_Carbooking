<?PHP
ob_start();
session_start();
require_once __DIR__ . "/config/connectDB.php";
require_once __DIR__ . "/config/setting.php";

require_once __DIR__ . "/tools/function.tool.php";
require_once __DIR__ . "/tools/crud.tool.php";

require_once __DIR__ . "/app/Controllers/SidebarController.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set(Setting::$AppTimeZone);

$_SESSION['sess_id_user'] = 1;
$_SESSION['sess_no_user'] = '6601076';
$_SESSION['sess_email'] = 'mail.com';
$_SESSION['sess_ref_id_site'] = 1;
$_SESSION['sess_site_initialname'] = 'PCS';
$_SESSION['sess_fullname'] = 'Eua-angkoon';
$_SESSION['sess_phone'] = '0000000000';
$_SESSION['sess_class_user'] = 1;
$_SESSION['sess_id_dept'] = 13;
$_SESSION['sess_dept_name'] = 'IT';
$_SESSION['sess_dept_initialname'] = 'IT';      
$_SESSION['sess_status_user'] = 1;
$_SESSION['sess_popup_howto'] = 0;

main();

function main(){
    $Time = new Processing;
    $start = $Time->Start_Time();
    include("app/Controllers/Controller.php");
    include("app/Views/main/main.php");
}