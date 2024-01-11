<?php 
function Show_Sidebar($hrefNow){
    $Call = new CounterSide();
    $c    = $Call->getCount();
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
        $hrefNow,
        $c['myRes']
    );
    $r .= SideBar(  
        PageSetting::$AppPage["handover"]["title"], 
        PageSetting::$AppPage["handover"]["href"], 
        PageSetting::$AppPage["handover"]["SideIcon"], 
        $hrefNow,
        $c['myHand']
    );
    if ($_SESSION['car_class_user'] == 1 || $_SESSION['car_class_user'] == 2) {
        $r .= "<li class='nav-item menu-open'>";
        $r .= "<a href='#' class='nav-link'><i class='nav-icon fas fa-users-cog'></i>";
        $r .= "<p>ส่วนของผู้ดูแล<i class='right fas fa-angle-left'></i></p></a>";   
        $r .= "<ul class='nav nav-treeview ml-2'>";
        $r .= SideBar(
            PageSetting::$AppPage["approve"]["title"], 
            PageSetting::$AppPage["approve"]["href"], 
            PageSetting::$AppPage["approve"]["SideIcon"], 
            $hrefNow,
            $c['Approve']
        );
        $r .= SideBar(
            PageSetting::$AppPage["res"]["title"], 
            PageSetting::$AppPage["res"]["href"], 
            PageSetting::$AppPage["res"]["SideIcon"], 
            $hrefNow,
            $c['AllRes']
        );
        $r .= "</ul></li>";
    }

    if ($_SESSION['car_class_user'] == 2) {
        $r .= "<li class='nav-item menu-open'>";
        $r .= "<a href='#' class='nav-link'><i class='nav-icon fas fa-cogs'></i>";
        $r .= "<p>จัดการระบบ<i class='right fas fa-angle-left'></i></p></a>";   
        $r .= "<ul class='nav nav-treeview ml-2'>";
        $r .= SideBar(
            PageSetting::$AppPage["vehicleconfig"]["title"], 
            PageSetting::$AppPage["vehicleconfig"]["href"], 
            PageSetting::$AppPage["vehicleconfig"]["SideIcon"],  
            $hrefNow
        );
        $r .= SideBar(
            PageSetting::$AppPage["user"]["title"], 
            PageSetting::$AppPage["user"]["href"], 
            PageSetting::$AppPage["user"]["SideIcon"], 
            $hrefNow
        );
        $r .= SideBar(
            PageSetting::$AppPage["sysconfig"]["title"], 
            PageSetting::$AppPage["sysconfig"]["href"], 
            PageSetting::$AppPage["sysconfig"]["SideIcon"], 
            $hrefNow
        );
        $r .= "</ul></li>";
    }
    $r .= SideBar(
        PageSetting::$AppPage["logout"]["title"], 
        PageSetting::$AppPage["logout"]["href"], 
        PageSetting::$AppPage["logout"]["SideIcon"], 
        $hrefNow
    );

    return $r;
}


function Sidebar($title, $href, $Icon, $active, $count = 0){
    $prefix = PageSetting::$prefixController;
    $active == $href ? $a = "active" : $a = "";
    $href != "" ? $l = "?$prefix=$href" : $l = "./";

    $r  = "<li class='nav-item'>";
    $r .= "<a href='$l' class='nav-link $a'>";
    $r .= "<i class='nav-icon fas $Icon'></i>";
    $r .= "<p>$title</p>";
    if($count != 0){
        $r .= "<span class='float-right badge' style='background-color:#f15c22;color:white'>$count</span>";
    }
    $r .= "</a></li>"; 
    return $r;
}

Class CounterSide{
    public function getCount(){
        $myRes  = $this->myRes();
        $myHand = $this->myHand();
        $r = array(
            'myRes' => $myRes,
            'myHand'=> $myHand
        );
        if ($_SESSION['car_class_user'] == 1 || $_SESSION['car_class_user'] == 2) {
            $Approve = $this->Approve();
            $AllRes  = $this->AllRes();
            $r['Approve'] = $Approve;
            $r['AllRes'] = $AllRes;
        }
        return $r;
    }

    public function myRes(){
        $sql  = "SELECT id_reservation ";
        $sql .= "FROM tb_reservation ";
        $sql .= "WHERE ref_id_user= ".$_SESSION['car_id_user']." ";
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->countAll($sql);

            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function myHand(){
        $sql  = "SELECT id_reservation ";
        $sql .= "FROM tb_reservation ";
        $sql .= "WHERE ref_id_user= ".$_SESSION['car_id_user']." ";
        $sql .= "AND reservation_status = 4 ";
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->countAll($sql);

            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function Approve(){
        $sql  = "SELECT id_reservation ";
        $sql .= "FROM tb_reservation ";
        $sql .= "WHERE reservation_status = 0 ";
        $sql .= "AND ref_id_site = ".$_SESSION['car_ref_id_site']." ";
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->countAll($sql);

            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function AllRes(){
        $sql  = "SELECT id_reservation ";
        $sql .= "FROM tb_reservation ";
        $sql .= "WHERE ";
        $sql .= "ref_id_site = ".$_SESSION['car_ref_id_site']." ";
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->countAll($sql);

            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }
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
//         } elseif (in_array($_SESSION['car_class_user'], $value['Class'])) {
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