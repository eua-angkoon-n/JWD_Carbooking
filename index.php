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

// $_SESSION['car_id_user'] = 1;
// $_SESSION['car_no_user'] = '6601076';
// $_SESSION['car_email'] = 'mail.com';
// $_SESSION['car_ref_id_site'] = 1;
// $_SESSION['car_site_initialname'] = 'PCS';
// $_SESSION['car_fullname'] = 'MIS TEST';
// $_SESSION['car_phone'] = '4537';
// $_SESSION['car_class_user'] = 2;
// $_SESSION['car_id_dept'] = 13;
// $_SESSION['car_dept_name'] = 'IT';
// $_SESSION['car_dept_initialname'] = 'IT';      
// $_SESSION['car_status_user'] = 1;
// $_SESSION['car_popup_howto'] = 0;

if(empty($_SESSION['car_id_user'])){ 
    
    $_SESSION = []; //empty array. 
    session_destroy(); 
    $prefixController = PageSetting::$prefixController;
    isset($_REQUEST[$prefixController]) ? $nowHref = $_REQUEST[$prefixController] : $nowHref = '';
    $AppPage = PageSetting::$AppPage;
    if($nowHref == 'login'){
        include("app/Views/main/login.php"); 
    } else {
        main();
    }
} else {
    main();
}


function main(){
    $Time = new Processing;
    $start = $Time->Start_Time();
    include("app/Controllers/Controller.php");
    include("app/Views/main/main.php");
}
