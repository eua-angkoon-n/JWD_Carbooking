<?php 
function Show_Sidebar($hrefNow){
    $r  = SideBar(
        PageSetting::$AppPage[""]["title"], 
        PageSetting::$AppPage[""]["href"], 
        PageSetting::$AppPage[""]["SideIcon"], 
        $hrefNow
    );
    $r .= SideBar(
        PageSetting::$AppPage["reservation"]["title"], 
        PageSetting::$AppPage["reservation"]["href"], 
        PageSetting::$AppPage["reservation"]["SideIcon"], 
        $hrefNow
    );
    $r .= SideBar(
        PageSetting::$AppPage["reservationList"]["title"], 
        PageSetting::$AppPage["reservationList"]["href"], 
        PageSetting::$AppPage["reservationList"]["SideIcon"], 
        $hrefNow
    );
    if ($_SESSION['sess_class_user'] == 1 || $_SESSION['sess_class_user'] == 2) {
        $r .= "<li class='nav-item menu-open'>";
        $r .= "<a href='#' class='nav-link'><i class='nav-icon fas fa-users-cog'></i>";
        $r .= "<p>ส่วนของผู้ดูแล<i class='right fas fa-angle-left'></i></p></a>";   
        $r .= "<ul class='nav nav-treeview'>";
        $r .= SideBar(
            PageSetting::$AppPage["approve"]["title"], 
            PageSetting::$AppPage["approve"]["href"], 
            PageSetting::$AppPage["approve"]["SideIcon"], 
            $hrefNow
        );
        $r .= SideBar(
            PageSetting::$AppPage["reservationAll"]["title"], 
            PageSetting::$AppPage["reservationAll"]["href"], 
            PageSetting::$AppPage["reservationAll"]["SideIcon"], 
            $hrefNow
        );
        $r .= "</ul></li>";
    }

    if ($_SESSION['sess_class_user'] == 2) {
        $r .= "<li class='nav-item menu-open'>";
        $r .= "<a href='#' class='nav-link'><i class='nav-icon fas fa-cog'></i>";
        $r .= "<p>จัดการระบบ<i class='right fas fa-angle-left'></i></p></a>";   
        $r .= "<ul class='nav nav-treeview'>";
        $r .= SideBar(
            PageSetting::$AppPage["vehicleconfig"]["title"], 
            PageSetting::$AppPage["vehicleconfig"]["href"], 
            PageSetting::$AppPage["vehicleconfig"]["SideIcon"],  
            $hrefNow
        );
        $r .= "</ul></li>";
    }

    return $r;
}


function Sidebar($title, $href, $Icon, $active){
    $prefix = PageSetting::$prefixController;
    $active == $href ? $a = "active" : $a = "";
    $href != "" ? $l = "?$prefix=$href" : $l = "./";

    $r  = "<li class='nav-item'>";
    $r .= "<a href='$l' class='nav-link $a'>";
    $r .= "<i class='nav-icon fas $Icon'></i>";
    $r .= "<p>$title</p>";
    $r .= "</a></li>"; 
    return $r;
}


// SideBar เก่า (ใช้ไม่ได้เพราะ ไม่ได้เขียนเช็ค SESSION CLASS USER)////////////////////////////////
// function nSideBar($page){
//     $SettingSide = PageSetting::$AppPage;
//     $prefix = PageSetting::$prefixController;
//     $result = "";
//     foreach ($SettingSide as $key => $value) {
//         if (!isset($value['Class']) || (isset($value['Class']) && (empty($value['Class']) || !is_array($value['Class'])))) {
//         if(!$value["isTreeView"]){ // ไม่เป็น TreeView เมนูย่อย 
//             $value['href'] == "" || empty($value['href']) ? $href = "./" : $href = "?$prefix=".$value['href'];
//             $page == $key ? $active = "active" : $active = "";
//             $result .= "<li class='nav-item'>";
//             $result .= "<a href='$href' class='nav-link $active'>";
//             $result .= "<i class='nav-icon fas ".$value['SideIcon']."'></i>";
//             $result .= "<p>".$value['title']."</p>";
//             $result .= "</a>";
//             $result .= "</li>";
//         } else {
//             $value['menu-open'] ? $menu = "menu-open" : $menu = "";
//             $result .= "<li class='nav-item $menu'>
//                             <a href='#' class='nav-link'><i class='nav-icon fas ".$value['TreeIcon']."'></i>
//                                 <p>".$value['TreeTitle']."<i class='right fas fa-angle-left'></i></p>
//                             </a>
//                         <ul class='nav nav-treeview'>";
//             foreach ($value as $TreeKey => $TreeValue) {
//                 $UseThis = chkKey($TreeKey);
//                 if(!$UseThis){ continue; }
//                 $TreeValue['href'] == "" || empty($TreeValue['href']) ? $href = "./" : $href = "?$prefix=".$TreeValue['href'];
//                 $page == $TreeKey ? $active = "active" : $active = "";
//                 $result .= "<li class='nav-item ml-2'>
//                     <a href='$href' class='nav-link $active'>
//                         <i class='nav-icon fas ".$TreeValue['SideIcon']."'></i>
//                         <p>".$TreeValue['title']."</p>
//                     </a>
//                 </li>";
//             }
//             $result .= "</ul>";
//             $result .= "</li>";
//         }
//         } elseif (in_array($_SESSION['sess_class_user'], $value['Class'])) {
//             if(!$value["isTreeView"]){ // ไม่เป็น TreeView เมนูย่อย 
//                 $value['href'] == "" || empty($value['href']) ? $href = "./" : $href = "?$prefix=".$value['href'];
//                 $page == $key ? $active = "active" : $active = "";
//                 $result .= "<li class='nav-item'>";
//                 $result .= "<a href='$href' class='nav-link $active'>";
//                 $result .= "<i class='nav-icon fas ".$value['SideIcon']."'></i>";
//                 $result .= "<p>".$value['title']."</p>";
//                 $result .= "</a>";
//                 $result .= "</li>";
//             } else {
//                 $value['menu-open'] ? $menu = "menu-open" : $menu = "";
//                 $result .= "<li class='nav-item $menu'>
//                                 <a href='#' class='nav-link'><i class='nav-icon fas ".$value['TreeIcon']."'></i>
//                                     <p>".$value['TreeTitle']."<i class='right fas fa-angle-left'></i></p>
//                                 </a>
//                             <ul class='nav nav-treeview'>";
//                 foreach ($value as $TreeKey => $TreeValue) {
//                     $UseThis = chkKey($TreeKey);
//                     if(!$UseThis){ continue; }
//                     $TreeValue['href'] == "" || empty($TreeValue['href']) ? $href = "./" : $href = "?$prefix=".$TreeValue['href'];
//                     $page == $TreeKey ? $active = "active" : $active = "";
//                     $result .= "<li class='nav-item ml-2'>
//                         <a href='$href' class='nav-link $active'>
//                             <i class='nav-icon fas ".$TreeValue['SideIcon']."'></i>
//                             <p>".$TreeValue['title']."</p>
//                         </a>
//                     </li>";
//                 }
//                 $result .= "</ul>";
//                 $result .= "</li>";
//             }  
//         }
//     }
//     return $result;
// }

// function chkKey($Key) {
//     if ($Key == "isTreeView" 
//     || $Key == "menu-open" 
//     || $Key == "TreeIcon" 
//     || $Key == "TreeTitle") {
//         return false;
//     }
//     return true;
// }
?>