<?php 
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Bangkok');

require_once __DIR__ . "/../../../../config/connectDB.php";
require_once __DIR__ . "/../../../../config/setting.php";

require_once __DIR__ . "/../../../../tools/crud.tool.php";
require_once __DIR__ . "/../../../../tools/function.tool.php";

$action = $_POST['action'];

// echo json_encode($_POST);
// exit();

switch ($action) {
    case 'login' : //ยกเลิกการจอง
        $Call   = new Login($_POST['data']);
        $Data   = $Call->getLogin();
        $Result = $Data;
        break;
    case 'regis': //ดูรายละเอียดการจอง
        $Call = new Register($_POST['data']);
        $Data   = $Call->getIDRegister();
        $Result = ($Data);
        break;
}

echo $Data;
exit();

Class Login{
    private $email;
    private $pass;
    private $site;
    public function __construct($data){
        parse_str($data, $d);

        $this->email = $d['email'];
        $this->pass  = $d['password'];
        $this->site  = $d['slt_manage_site'];
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
            $start_date = date('Y-m-d H:i:s', strtotime('+1 hour'));
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

Class Register{
    private $output;
    public function __construct($data){
        parse_str($_POST['data'], $output);
        $this->output = $output;
    }

    public function getIDRegister(){
        return $this->TryRegister();
    }

    public function TryRegister(){
        $output = $this->output;
        $mail_dup = $this->chkMailDup();
        // return $mail_dup;
        if($mail_dup){
            return "mail_dup";
        }
        
        $output['password_regis'] = sha1(Setting::$keygen.$output['password_regis']); 
        $insertRow = [
            'no_user' => (!empty($output['no_user'])) ? $output['no_user'] : '',
            'password' => (!empty($output['password_regis'])) ? $output['password_regis'] : '',
            'email' => (!empty($output['email_regis'])) ? $output['email_regis'] : '',
            'line_token' => NULL,
            'fullname' => (!empty($output['fullname'])) ? $output['fullname'] : '',
            'sex' => NULL,
            'phone' => NULL,
            'photo' => NULL,
            'class_user' => 1,
            'ref_id_site' => (!empty($output['slt_regis_site'])) ? $output['slt_regis_site'] : '',
            'ref_id_dept' => (!empty($output['slt_regis_dept'])) ? $output['slt_regis_dept'] : '',
            'ref_id_position' => NULL,
            'status_user' => 3,
            'create_date' => (date('Y-m-d H:i:s')),
            'ref_id_user_add' => 0,
            'edit_date' => NULL,
            'ref_id_user_edit' => NULL,
            'latest_login' => NULL,
            'ip_address' => NULL,
        ];

        $conn  = connect_database("login");
        $obj   = new CRUD($conn);

        try{
            $rowID = $obj->addRow($insertRow, "tb_user");
            if($rowID!=NULL){
                $insertRow = [				
                    'ref_id_user' => $rowID,
                    'ref_id_site' => (!empty($output['slt_regis_site'])) ? $output['slt_regis_site'] : '',
                ];
                $rowSite = $obj->addRow($insertRow, "tb_site_responsibility");
            }
            return $rowID;
        } catch (PDOException $e) {
            return "Caught exception : <b>".$e->getMessage()."</b><br/>";
        } finally {
            $conn = null;
        }
    }

    public function chkMailDup(){
        $email = $this->output['email_regis'];
        $sql   = "SELECT count(id_user) AS total_row ";
        $sql  .= "FROM tb_user ";
        $sql  .= "WHERE email = '".(trim($email))."';";

        $conn  = connect_database("login");
        $obj   = new CRUD($conn);

        try{
            $totalRow =$obj->getCount($sql);
            if($totalRow!=0){
                return $totalRow;
            }
            return false;
        } catch (PDOException $e) {
            return "Caught exception : <b>".$e->getMessage()."</b><br/>";
        } finally {
            $conn = null;
        }
    }
}

?>