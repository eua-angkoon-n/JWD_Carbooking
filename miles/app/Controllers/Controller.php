<?php 
// if(empty($_SESSION['car_id_user'])){ 
//     $_SESSION = []; //empty array. 
//     session_destroy(); 
//     die(include('login.php')); 
// }

$prefixController = PageSetting::$prefixController;
$prefixVehicle = PageSetting::$prefixVehicleMiles;
isset($_REQUEST[$prefixController]) ? $nowHref     = $_REQUEST[$prefixController] : $nowHref     = '';
isset($_REQUEST[$prefixVehicle])    ? $vehiclePage = $_REQUEST[$prefixVehicle]    : $vehiclePage = false;
// $MilePage = PageSetting::$MilePage;

setSideBarAndView($nowHref, $vehiclePage, $include_view, $title);
$HeadTitle = TitlePage($nowHref, $title, $vehiclePage);

function setSideBarAndView ($nowHref, $vehiclePage, &$include_view, &$title){
    $title = PageSetting::$MilePage[$nowHref]['title'];
    if($vehiclePage){
        $include_view = PageSetting::$MilePage[$nowHref]['viewTable'];
    } else {
        $include_view = PageSetting::$MilePage[$nowHref]['view'];
    }
}

function TitlePage ($nowHref, $title ,$vehiclePage) {
    if($nowHref != "") {
        $vehicle = "";
        if(!$vehiclePage)
            $href = './';
        else {
            $href = "?".PageSetting::$prefixController."="."$nowHref";
            $vehicle = " - ".VehicleName($vehiclePage);
        }    
        return "<a type='button' href='$href'  class='btn btn-xs btn-outline-primary mr-1 mt-1 pt-1 justify-content-center'>
                    <i class='fas fa-caret-left'></i> กลับ
                </a>
                <h1 class='m-0 text-primary'><strong>$title$vehicle</strong></h1>";
    } else {
        return "<h1 class='m-0 text-primary'><strong>$title</strong></h1>";
    }
}

function VehicleName($id){
    $sql  = "SELECT vehicle_name ";
    $sql .= "FROM tb_vehicle ";
    $sql .= "WHERE id_vehicle = $id ";

    try {
        $con = connect_database();
        $obj = new CRUD($con);

        $row = $obj->customSelect($sql);

        return $row['vehicle_name'];
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    } catch (\PDOException $e){
        return "Database Error: " . $e->getMessage();
    } finally {
        $con = null;
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

