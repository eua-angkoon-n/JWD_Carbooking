<?php 
function SideBar($page){
    $SettingSide = PageSetting::$AppPage;
    $prefix = PageSetting::$prefixController;
    $result = "";
    foreach ($SettingSide as $key => $value) {
        if(!$value["isTreeView"]){ // ไม่เป็น TreeView เมนูย่อย 
            $value['href'] == "" || empty($value['href']) ? $href = "./" : $href = "?$prefix=".$value['href'];
            $page == $key ? $active = "active" : $active = "";
            $result .= "<li class='nav-item'>";
            $result .= "<a href='$href' class='nav-link $active'>";
            $result .= "<i class='nav-icon fas ".$value['SideIcon']."'></i>";
            $result .= "<p>".$value['title']."</p>";
            $result .= "</a>";
            $result .= "</li>";
        } else {
            $value['menu-open'] ? $menu = "menu-open" : $menu = "";
            $result .= "<li class='nav-item $menu'>
                            <a href='#' class='nav-link'><i class='nav-icon fas ".$value['TreeIcon']."'></i>
                                <p>".$value['TreeTitle']."<i class='right fas fa-angle-left'></i></p>
                            </a>
                        <ul class='nav nav-treeview'>";
            foreach ($value as $TreeKey => $TreeValue) {
                $UseThis = chkKey($TreeKey);
                if(!$UseThis){ continue; }
                $TreeValue['href'] == "" || empty($TreeValue['href']) ? $href = "./" : $href = "?$prefix=".$TreeValue['href'];
                $page == $TreeKey ? $active = "active" : $active = "";
                $result .= "<li class='nav-item ml-2'>
                    <a href='$href' class='nav-link $active'>
                        <i class='nav-icon fas ".$TreeValue['SideIcon']."'></i>
                        <p>".$TreeValue['title']."</p>
                    </a>
                </li>";
            }
            $result .= "</ul>";
            $result .= "</li>";
        }
    }
    return $result;
}

function chkKey($Key) {
    if ($Key == "isTreeView" 
    || $Key == "menu-open" 
    || $Key == "TreeIcon" 
    || $Key == "TreeTitle") {
        return false;
    }
    return true;
}
?>