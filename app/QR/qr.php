<?php 
ob_start();
session_start();
include_once __DIR__ . "/../../config/mysecret.php";
include_once __DIR__ . "/../../config/setting.php";
include_once __DIR__ . "/../../config/connectDB.php";

include_once __DIR__ . "/../../tools/crud.tool.php";
include_once __DIR__ . "/../../tools/function.tool.php";

$prefixController = PageSetting::$prefixController;
isset($_REQUEST[$prefixController]) ? $nowHref = $_REQUEST[$prefixController] : $nowHref = '';

switch($nowHref){
    case MySecret::$PACJSecurity: 
        $login = new Login(MySecret::$PACJSecuritymail, MySecret::$PACJSecuritypass, 2);
        $r     = $login->getLogin();
        break;
    case MySecret::$PACKSecurity: 
        $login = new Login(MySecret::$PACKSecuritymail, MySecret::$PACKSecuritypass, 5);
        $r     = $login->getLogin();
        break;
    default:
        header("Location:".Setting::$domain);
        break;
}
header("Location: https://".Setting::$domain."/miles");
exit;
Class Login{
    private $email;
    private $pass;
    private $site;
    public function __construct($email, $pass, $site){

        $this->email = $email;
        $this->pass  = $pass;
        $this->site  = $site;
    }

    public function getLogin(){
        $email = $this->email;
        $pass  = $this->pass;
        $slt_manage_site = $this->site;
        if(isset($email) && isset($pass) ){
            $email = trim($email);
            $pass = trim($pass);
            $password = sha1(Setting::$keygen.$pass); //เก็บรหัสผ่านในรูปแบบ sha1 
        

            $query_login  = "SELECT tb_user.*, tb_dept.dept_initialname, tb_dept.dept_name, tb_site.site_initialname, tb_site_responsibility.ref_id_site AS chk_ref_id_site ";
            $query_login .= "FROM tb_user ";
            $query_login .= "LEFT JOIN tb_dept ON (tb_dept.id_dept=tb_user.ref_id_dept) "; 
            $query_login .= "LEFT JOIN tb_site_responsibility ON (tb_site_responsibility.ref_id_user=tb_user.id_user) "; 
            $query_login .= "LEFT JOIN tb_site ON (tb_site.id_site=$slt_manage_site) "; 
            $query_login .= "WHERE tb_user.email='$email' ";
            $query_login .= "AND tb_user.password='$password' ";
            $query_login .= "AND (tb_site_responsibility.ref_id_site=$slt_manage_site OR tb_user.ref_id_site=$slt_manage_site) ";

            $conn = connect_database("login");
            $obj  = new CRUD($conn);
            try{
                $Row = $obj->customSelect($query_login);  

                if(empty($Row['id_user'])){
                    return 0;
                }

                if (((!empty($Row) && ($Row['chk_ref_id_site']!='' || $Row['ref_id_site']==$slt_manage_site)) || $Row['class_user']==5) && $Row['status_user']==1){
        
                    $_SESSION['car_id_user'] = $Row['id_user'];
                    $_SESSION['car_no_user'] = $Row['no_user'];
                    $_SESSION['car_email'] = $Row['email'];
                    $_SESSION['car_ref_id_site'] = intval($slt_manage_site);
                    $_SESSION['car_site_initialname'] = $Row['site_initialname'];
                    $_SESSION['car_fullname'] = $Row['fullname'];
                    $_SESSION['car_class_user'] = $this->getClassUser($Row['id_user']);
                    $_SESSION['car_id_dept'] = $Row['ref_id_dept'];
                    $_SESSION['car_dept_name'] = $Row['dept_name'];
                    $_SESSION['car_dept_initialname'] = $Row['dept_initialname'];    
                    $_SESSION['car_phone'] = $Row['phone'];
                    $_SESSION['car_status_user'] = $Row['status_user'];
                    sysVersion($_SESSION['phase'], $_SESSION['version']);
                    sysCon($_SESSION['urgent'], $_SESSION['handover']);

                    $fetchPermission= $obj->fetchRows("SELECT tb_permission.* FROM tb_permission WHERE ref_class_user=".$Row['class_user']."");
                    foreach($fetchPermission as $key=>$value){
                      $_SESSION['module_access'] =  $fetchPermission[$key]['module_name'].'-'.$fetchPermission[$key]['accept_denied'];
                    }
                    
                    return true;
        
                  } else {
                    if($Row['status_user']==2){       
                        return '<script>sweetAlert("ถูกระงับใช้งาน", "คุณถูกระงับการใช้งาน \r\n กรุณาติดต่อฝ่าย IT เพื่อตรวจสอบ", "error");</script>';
                      }else if($Row['status_user']==3){        
                        return '<script>sweetAlert("รออนุมัติ...", "ชื่อผู้ใช้งานนี้ \r\nอยู่ระหว่างรออนุมัติการใช้", "error");</script>';
                      }else{
                        return '<script>sweetAlert("ผิดพลาด...", "ชื่อผู้ใช้ระบบหรือเลือกไซต์งานไม่ถูกต้อง ", "error");</script>';
                      }
                  }

            } finally {
                $conn = null;
            }
        } 
    }

    public function getClassUser($id){
        $sql  = "SELECT class_user ";
        $sql .= "FROM tb_user_carbooking ";
        $sql .= "WHERE ref_id_user = $id ";

        try{
            $conn = connect_database();
            $obj  = new CRUD($conn);
            $start_date = date('Y-m-d H:i:s', strtotime('-8 hour'));
            $fetchRow = $obj->customSelect($sql);
            $chkStillNotApprove = $obj->update(['reservation_status' => 2], "reservation_status = 0 AND start_date < '".$start_date."'", "tb_reservation");
            if(!empty($fetchRow['class_user'])){
                return $fetchRow['class_user'];
            } else {
                return 0;
            }
        } catch(Exception $e) {
            return "Caught exception : <b>".$e->getMessage()."</b><br/>";
        } finally {
            $conn = null;
        }
    }
}
?>