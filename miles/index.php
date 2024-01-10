<?PHP
ob_start();
session_start();
require_once __DIR__ . "/../config/connectDB.php";
require_once __DIR__ . "/../config/setting.php";

require_once __DIR__ . "/../tools/function.tool.php";
require_once __DIR__ . "/../tools/crud.tool.php";

require_once __DIR__ . "/../app/Controllers/SidebarController.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set(Setting::$AppTimeZone);

sysVersion($_SESSION['phase'], $_SESSION['version']);

main();

function main(){
    $Time = new Processing;
    $start = $Time->Start_Time();
    include(__DIR__ . "/app/Controllers/Controller.php");
    include(__DIR__ . "/app/Views/main/view.php");
}