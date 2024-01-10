<?php 
// if(empty($_SESSION['car_id_user'])){ 
//     $_SESSION = []; //empty array. 
//     session_destroy(); 
//     die(include('login.php')); 
// }

$prefixController = PageSetting::$prefixController;
isset($_REQUEST[$prefixController]) ? $nowHref = $_REQUEST[$prefixController] : $nowHref = '';
$AppPage = PageSetting::$AppPage;

setSideBarAndView($nowHref, $include_view, $title);

function setSideBarAndView ($nowHref, &$include_view, &$title){
    $title = PageSetting::$AppPage[$nowHref]['title'];
    $include_view = PageSetting::$AppPage[$nowHref]['view'];
}


// ฟังก์ชันเก่า//////////////////////////////////////////////////////////////////
// switch ($prefix) {
//     case "vehicleconfig":
//       setViewTree($prefix, 'Setting', $include_view, $action, $title);
//     break;
//     case "approve":
//       setViewTree($prefix, 'Admin', $include_view, $action, $title);
//     break;
//     default:
//         setView($prefix, $include_view, $action, $title);
//       break;
// }

// function setView($prefix, &$include_view, &$action, &$title) {
//     $AppPage = PageSetting::$AppPage;
//     $include_view = $AppPage[$prefix]['view'];
//     $action = $AppPage[$prefix]['action'];
//     $title = $AppPage[$prefix]['title'];
// }

// //ชื่อหน้า , ชื่อหัวข้อของ Tree
// function setViewTree($prefix, $treeName, &$include_view, &$action, &$title) {
//     $AppPage = PageSetting::$AppPage;
//     $include_view = $AppPage[$treeName][$prefix]['view'];
//     $action = $AppPage[$treeName][$prefix]['action'];
//     $title = $AppPage[$treeName][$prefix]['title'];
// }

