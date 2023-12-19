<?php 
// if(empty($_SESSION['sess_id_user'])){ 
//     $_SESSION = []; //empty array. 
//     session_destroy(); 
//     die(include('login.php')); 
// }

$prefixController = PageSetting::$prefixController;
isset($_REQUEST[$prefixController]) ? $nowHref = $_REQUEST[$prefixController] : $nowHref = '';
// $MilePage = PageSetting::$MilePage;

setSideBarAndView($nowHref, $include_view, $title);
$HeadTitle = TitlePage($nowHref, $title);

function setSideBarAndView ($nowHref, &$include_view, &$title){
    $title = PageSetting::$MilePage[$nowHref]['title'];
    $include_view = PageSetting::$MilePage[$nowHref]['view'];
}

function TitlePage ($nowHref, $title) {
    if($nowHref != "") {
        return "<a type='button' href='./'  class='btn btn-xs btn-outline-primary mr-1 mt-1 pt-1 justify-content-center'>
                    <i class='fas fa-caret-left'></i> กลับ
                </a>
                <h1 class='m-0 text-primary'><strong>$title</strong></h1>";
    } else {
        return "<h1 class='m-0 text-primary'><strong>$title</strong></h1>";
    }
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

