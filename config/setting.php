<?php
class Setting
{
    public static $AppTimeZone = 'Asia/Bangkok';
    public static $DefaultProvinceTH = 'สมุทรสาคร';
    public static $DefaultProvince = 'Samut Sakhon';
    public static $title = "ระบบจองรถธุรการ";
    public static $titleMile = "ระบบบันทึกเลขไมล์ จองรถธุรการ";
    public static $SiteList = array('PCS', 'JPK', 'JPAC', 'PACM', 'PLP', 'PACS', 'PACA', 'PACT');
    public static $classArr = array(0=> "ผู้ใช้ระบบ", 1 => "ธุระการ", 2 => "ผู้ดูแลระบบ", 3 => "ผู้บันทึก");	
    public static $keygen = 'Pcs@'; //sha1+password
    public static $noreply_mail = "no-reply@cc.pcs-plp.com";
    public static $domain = "ebooking.cc.pcs-plp.com/carbooking";
    public static $pass_mail = "Pcs@1234";
    public static $PathImg = "../../../../dist/temp_img";
    public static $PathImgMile = "../../../../../dist/temp_img";
    public static $warning_text = array(
        0 => "คุณไม่มีสิทธิ์ใช้งานในส่วนนี้", 
        1 => "คุณไม่มีสิทธิ์เข้าดูข้อมูลส่วนนี้", 
        2 => "คุณไม่มีสิทธิ์จัดการข้อมูลส่วนนี้",
        3 => "กรุณาติดต่อแผนก IT/MIS เพื่อสอบถามข้อมูลเพิ่มเติม โทร. 1111"
    );	//ข้อความ เกี่ยวกับความปลอดภัย

    public static $reservationStatus = array(0=>"รอตรวจสอบ", 1=>"อนุมัติ", 2=>"ไม่อนุมัติ", 3=>"กำลังใช้งาน", 4=>"คืนรถ" , 5=>"ยกเลิก", 6=>"ส่งมอบ");
    public static $reservationUrgent = array(0=>"จองด่วน");
    public static $arr_day_of_week = array('','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์','อาทิตย์');
    public static $arr_day_of_weekEN = array('','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');	
    public static $arr_mouth = array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');	
    public static $arr_mouthEN = array('January','February','March','April','May','June','July','August','September','October','November','December');	

    public static $arr_newMonths = array(
        '01' => 'มกราคม',
        '02' => 'กุมภาพันธ์',
        '03' => 'มีนาคม',
        '04' => 'เมษายน',
        '05' => 'พฤษภาคม',
        '06' => 'มิถุนายน',
        '07' => 'กรกฎาคม',
        '08' => 'สิงหาคม',
        '09' => 'กันยายน',
        '10' => 'ตุลาคม',
        '11' => 'พฤศจิกายน',
        '12' => 'ธันวาคม'
    );
    public static $arr_newMonthsEN = array(
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    );
    public static $ColumnBarColor = array(
        "#3459B8", // Dark Blue
        "#5077C6",
        "#6D94D4",
        "#89B2E2",
        "#A6CFF0", // Pale Blue
        "#C4ECFF", // Lighter Blue
        "#7BA3CC", // Medium Blue
        "#5389B4",
        "#306FA0",
        "#0D559C", // Deep Blue
        "#003C87",  // Navy Blue
        "#022a5c"
    );

    public static $CalendarColor = array( // Color of Year 2024
        '1' => "#C06A46", // Topaz 070
        '2' => "#EFD99A", // Honeybee CSP-950
        '3' => "#F4C3B2", // Teacup Rose 2170-50
        '4' => "#364042",  // Regent Green 2136-20
        '5' => "#CBDDE2", // Polar Sky 1674 
        '6' => "#F0E0D1", // Pristine oc-75
        '7' => "#5b6d92", // Blue Nova 825
        '8' => "#F0EDE4", // White Dove OC-17
        '9' => "#9B8E9C", // Hazy Lilac 2116-40
        '10' => "#8C887A", // Antique Pewter 1560
    );
    public static $SQLSET = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));";

    public static $HundredColor = array (
        '#0054FF', '#FF0000', '#00FF00', '#0000FF', '#FF00FF', '#FFFF00', '#00FFFF', '#FFA500', '#800080', '#008000',
        '#008080', '#800000', '#808000', '#8000FF', '#0080FF', '#00FF80', '#FF8000', '#C0C0C0', '#808080', '#FFC0CB',
        '#FF69B4', '#FF1493', '#FF00FF', '#FF4500', '#2E8B57', '#B22222', '#4B0082', '#D2691E', '#ADFF2F', '#FFD700',
        '#DC143C', '#BDB76B', '#A0522D', '#2E8B57', '#F0E68C', '#DDA0DD', '#ADFF2F', '#FF69B4', '#8A2BE2', '#A52A2A',
        '#FFFFE0', '#FA8072', '#FFE4B5', '#F5DEB3', '#D3D3D3', '#FF6347', '#DA70D6', '#20B2AA', '#87CEFA', '#00FA9A',
        '#98FB98', '#F0FFF0', '#7FFF00', '#DB7093', '#F5F5F5', '#FFFAF0', '#D8BFD8', '#DEB887', '#40E0D0', '#6A5ACD',
        '#00CED1', '#FF00FF', '#FF6A6A', '#00FFFF', '#20B2AA', '#E9967A', '#FF1493', '#FFFACD', '#ADD8E6', '#90EE90',
        '#FFD700', '#F5DEB3', '#F0E68C', '#FFA07A', '#CD853F', '#FFB6C1', '#FFC0CB', '#FFE4E1', '#8B4513', '#0000CD',
        '#FF4500', '#00FF7F', '#48D1CC', '#87CEEB', '#00FA9A', '#98FB98', '#FF00FF', '#FF69B4', '#7B68EE', '#0000CD',
        '#8A2BE2', '#D2691E', '#FFD700', '#FF4500', '#DB7093', '#20B2AA', '#7FFF00', '#00FFFF', '#F5F5F5', '#FFFAF0',
        '#D8BFD8', '#DEB887', '#40E0D0', '#6A5ACD', '#00CED1', '#FF00FF', '#FF6A6A', '#00FFFF', '#20B2AA', '#E9967A'
    );

    public static $condition = array(
        1 => 'ดี',
        2 => 'ไม่ดี'
    );

    public static $fuel = array(
        1 => 'เต็ม',
        2 => 'เกือบเต็ม',
        3 => 'ปานกลาง',
        4 => 'ใกล้หมด',
        5 => 'หมด'
    );

}

class PageSetting 
{
    public static $prefixController = 'app';

    // ตั้งค่า SideBar (อย่าลืมไปตั้ง Controller ที่ app/Controller/Controllers.php)
    public static $AppPage = array (
        "" => array (
            "title" => "หน้าหลัก",
            "view" => "../dashboard/view.php",
            "href" => "",
            "SideIcon" => "fa-chalkboard"
        ),
        "manuals" => array( 
            "title" => "คู่มือการใช้งาน",
            "view" => "../manuals/view.php",
            "href" => "manuals",
            "SideIcon" => "fa-book",
        ),
        "reservation" => array( 
            "title" => "จองยานพาหนะ",
            "view" => "../reservation/view.php",
            "href" => "reservation",
            "SideIcon" => "fa-book",
        ),
        "reservationList" => array( 
            "title" => "รายการจองของฉัน",
            "view" => "../reservationList/view.php",
            "href" => "reservationList",
            "SideIcon" => "fa-address-book"
        ),
        "handover" => array( 
            "title" => "ส่งมอบยานพาหนะ",
            "view" => "../handover/view.php",
            "href" => "handover",
            "SideIcon" => "fa-flag-checkered"
        ),
        "approve"=> array(
            "title" => "การอนุมัติ",
            "view" => "../approve/view.php",
            "href" => "approve",
            "SideIcon" => "fa-stamp"
        ),
        "res" => array (
            "title" => "รายการจองทั้งหมด",
            "view" => "../reservationAll/view.php",
            "href" => "res",
            "SideIcon" => "fa-car"
        ),
        "vehicleconfig" => array (
            "title" => "ยานพาหนะ",
            "view" => "../vehicleconfig/view.php",
            "href" => "vehicleconfig",
            "SideIcon" => "fa-car-side"
        ),
        "user" => array (
            "title" => "ผู้ใช้งาน",
            "view" => "../users/view.php",
            "href" => "user",
            "SideIcon" => "fa-users"
        ),
        "sysconfig" => array (
            "title" => "ตั้งค่าระบบ",
            "view" => "../sysconfig/view.php",
            "href" => "sysconfig",
            "SideIcon" => "fa-cog"
        ),
        "logout" => array (
            "title" => "ออกจากระบบ",
            "view" => "../main/logout.php",
            "href" => "logout",
            "SideIcon" => "fa-sign-out-alt"
        ),
    );

    public static $MilePage = array (
        "" => array (
            "title" => "หน้าหลัก",
            "view" => "../dashboard/view.php",
            "href" => "",
            "SideIcon" => "fa-chalkboard"
        ),
        "manuals" => array( 
            "title" => "คู่มือการใช้งาน",
            "view" => "../manuals/view.php",
            "href" => "manuals",
            "SideIcon" => "fa-book",
        ),
        "mileout" => array (
            "title" => "บันทึกเลขไมล์ออกบริษัท",
            "view" => "../mileout/view.php",
            "href" => "mileout",
            "SideIcon" => "fa-chalkboard"
        ),
        "milein" => array (
            "title" => "บันทึกเลขไมล์เข้าบริษัท",
            "view" => "../milein/view.php",
            "href" => "milein",
            "SideIcon" => "fa-chalkboard"
        ),
        "editMile" => array (
            "title" => "แก้ไขการบันทึกเลขไมล์",
            "view" => "../mileEdit/view.php",
            "href" => "editMile",
            "SideIcon" => "fa-chalkboard"
        ),
        "logout" => array (
            "title" => "ออกจากระบบ",
            "view" => "../../../app/Views/main/logout.php",
            "href" => "logout",
            "SideIcon" => "fa-sign-out-alt"
        ),
    );

}

        // Main Page ห้ามตั้งชื่อ key------------------------
        // "" => array( 
        //     "isTreeView" => false,
        //     "title" => "หน้าหลัก",
        //     "action" => "Dashboard",
        //     "view" => "../dashboard/view.php",
        //     "href" => "",
        //     "SideIcon" => "fa-chalkboard"
        // ),
        // "reservation" => array( 
        //     "isTreeView" => false,
        //     "title" => "จองยานพาหนะ",
        //     "action" => "Reservation",
        //     "view" => "../reservation/view.php",
        //     "href" => "reservation",
        //     "SideIcon" => "fa-book",
        // ),
        // "reservationList" => array( 
        //     "isTreeView" => false,
        //     "title" => "รายการจองของฉัน",
        //     "action" => "Reservation",
        //     "view" => "../reservationList/view.php",
        //     "href" => "reservationList",
        //     "SideIcon" => "fa-address-book"
        // ),
        // "Admin" => array(
        //     "isTreeView" => true,
        //     "menu-open" => true,
        //     "TreeIcon" => "fa-users-cog",
        //     "TreeTitle" => "ส่วนของผู้ดูแล",
        //     "approve"=> array(
        //         "isTreeView" => false,
        //         "title" => "การอนุมัติ",
        //         "action" => "approve",
        //         "view" => "../approve/view.php",
        //         "href" => "approve",
        //         "SideIcon" => "fa-stamp"
        //     ),
            // "mileIn"=> array(
            //     "isTreeView" => false,
            //     "title" => "ไซต์งาน",
            //     "action" => "mileIn",
            //     "view" => "../mileIn/mileIn.php",
            //     "href" => "mileIn",
            //     "SideIcon" => "fa-caret-square-left"
            // ),
        //     "Class" => array(1, 5)
        // ),
        // "mileIn" => array(
        //     "isTreeView" => false,
        //     "title" => "บันทึกเลขไมล์เข้า",
        //     "action" => "mileIn",
        //     "view" => "../mileIn/mileIn.php",
        //     "href" => "mileIn",
        //     "SideIcon" => "fa-book"
        // ),
        //  "Test1" => array(
        //     "isTreeView" => false,
        //     "title" => "จองยานพาหนะ",
        //     "action" => "Test",
        //     "view" => "Dashboard.php",
        //     "href" => "Test1",
        //     "SideIcon" => "fa-book"
        // ),
        // "Test2" => array(
        //     "isTreeView" => false,
        //     "title" => "รายการจองของฉัน",
        //     "action" => "Test",
        //     "view" => "Dashboard.php",
        //     "href" => "Test2",
        //     "SideIcon" => "fa-book"
        // ),
 
        // ----------------------------------
        // "Test" => array(
        //     "isTreeView" => false,
        //     "title" => "รายการจองยานพาหนะ",
        //     "action" => "Test",
        //     "view" => "Dashboard.php",
        //     "href" => "Test",
        //     "SideIcon" => "fa-book"
        // ),
       

        // "Setting" => array(
        //     "isTreeView" => true,
        //     "menu-open" => true,
        //     "TreeIcon" => "fa-cog",
        //     "TreeTitle" => "จัดการระบบ",
        //     "vehicleconfig"=> array(
        //         "isTreeView" => false,
        //         "title" => "ยานพาหนะ",
        //         "action" => "vehicleconfig",
        //         "view" => "../vehicleconfig/view.php",
        //         "href" => "vehicleconfig",
        //         "SideIcon" => "fa-car"
        //     ),
        //     "mileIn"=> array(
        //         "isTreeView" => false,
        //         "title" => "ไซต์งาน",
        //         "action" => "mileIn",
        //         "view" => "../mileIn/mileIn.php",
        //         "href" => "mileIn",
        //         "SideIcon" => "fa-caret-square-left"
        //     ),
        // ),
        // "Miles2" => array(
        //     "isTreeView" => true,
        //     "menu-open" => true,
        //     "TreeIcon" => "fa-user-lock",
        //     "TreeTitle" => "เมนูผู้ดูแล",
        //     "mileOut5"=> array(
        //         "isTreeView" => false,
        //         "title" => "รายการรออนุมัติ",
        //         "action" => "mileOut",
        //         "view" => "Dashboard.php",
        //         "href" => "mileOut5",
        //         "SideIcon" => "fa-caret-right"
        //     ),
        //     "mileIn1"=> array(
        //         "isTreeView" => false,
        //         "title" => "รายงาน",
        //         "action" => "mileIn",
        //         "view" => "Dashboard.php",
        //         "href" => "mileIn5",
        //         "SideIcon" => "fa-caret-right"
        //     ),
        // ),
        // "Miles1" => array(
        //     "isTreeView" => true,
        //     "menu-open" => true,
        //     "TreeIcon" => "fa-cog",
        //     "TreeTitle" => "ตั้งค่า",
        //     "mileOut1"=> array(
        //         "isTreeView" => false,
        //         "title" => "ผู้ใช้งาน",
        //         "action" => "mileOut",
        //         "view" => "Dashboard.php",
        //         "href" => "mileOut",
        //         "SideIcon" => "fa-caret-right"
        //     ),
        //     "mileIn4"=> array(
        //         "isTreeView" => false,
        //         "title" => "ยี่ห้อยานพาหนะ",
        //         "action" => "mileIn",
        //         "view" => "Dashboard.php",
        //         "href" => "mileIn4",
        //         "SideIcon" => "fa-caret-right"
        //     ),
        //     "mileIn1"=> array(
        //         "isTreeView" => false,
        //         "title" => "ยานพาหนะ",
        //         "action" => "mileIn",
        //         "view" => "Dashboard.php",
        //         "href" => "mileIn",
        //         "SideIcon" => "fa-caret-right"
        //     ),
        // ),
        // "Test7" => array(
        //     "isTreeView" => false,
        //     "title" => "ออกจากระบบ",
        //     "action" => "Test",
        //     "view" => "Dashboard.php",
        //     "href" => "Test7",
        //     "SideIcon" => "fa-sign-out-alt"
        // ),