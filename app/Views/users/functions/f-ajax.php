<?PHP
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Bangkok');	

require_once __DIR__ . "/../../../../config/connectDB.php";
require_once __DIR__ . "/../../../../config/setting.php";

require_once __DIR__ . "/../../../../tools/crud.tool.php";
require_once __DIR__ . "/../../../../tools/function.tool.php";

$action = $_REQUEST['action']; #รับค่า action มาจากหน้าจัดการ

switch ($action) {
    case 'update-status' :
        $Call   = new Update_Status($_POST['id_row'], $_POST['chk_box_value']);
        $Result = $Call->getUpdate();
        break;
    case 'getUser':
        $Call   = new Get_User($_POST['id']);
        $r = $Call->getData();
        $Result = json_encode($r);
        break;
    case 'save_user':
        $Call   = new Save_User($_POST['data']);
        $r = $Call->getData();
        $Result = json_encode($r);
        break;
}

print_r($Result);
exit;

Class Update_Status {

    public $id_row;
    public $chk_box_value;

    public function __construct($id_row, $chk_box_value)
    {
        $this->id_row        = $id_row;
        $this->chk_box_value = $chk_box_value;
    }

    public function getUpdate(){
        return $this->DoUpdate();
    }

    public function DoUpdate(){
        $value =[
            'status_user' => $this->chk_box_value,
        ];

        try {
            $con = connect_database('e-service');
            $obj = new CRUD($con);
        
            $result = $obj->update($value, 'id_user='.$this->id_row, "tb_user");
            $result == 'Success' ? $s = 1 : $s = 0;
            return $s;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }
}

Class Get_User {
    private $id;
    public function __construct($id){
        $this->id = $id;
    }

    public function getData(){
        $r = $this->getUserData();
        return array(
            'status' => $r['status_user'],
            'no_user' => $r['no_user'],
            'fullname' => $r['fullname'],
            'email' => $r['email'],
            'class_user' => $this->getClassUser(),
            'site' =>    $this->getSite(),
            'dept' =>    $this->getDept($r['ref_id_dept'])
        );
    }

    public function getUserData(){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_user ";
        $sql .= "WHERE id_user=$this->id ";
        
        try {
            $con = connect_database('e-service');
            $obj = new CRUD($con);
        
            $r = $obj->customSelect($sql);
            
            return $r;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getClassUser(){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_user_carbooking ";
        $sql .= "WHERE ref_id_user=$this->id ";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect($sql);
            if(empty($r))
                $c = 0;
            else 
                $c = $r['class_user'];
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }

        $r = "";
        foreach(Setting::$classArr as $k => $v){
            if($k == $c)
                $s = 'checked';
            else 
                $s = '';
            $r .= "<div class='icheck-success d-inline-block mr-3'>";
            $r .= " <input type='radio' value='$k' name='class_user' id='class_user_$k' $s required>";
            $r .= " <label for='class_user_$k'>$v</label>";
            $r .= "</div>";
        }
        return $r;
    }

    public function getSite(){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_site_responsibility ";
        $sql .= "WHERE ref_id_user=$this->id ";

        $site = "SELECT * ";
        $site .= "FROM tb_site ";
        $site .= "WHERE site_status=1";


        try {
            $con = connect_database('e-service');
            $obj = new CRUD($con);
        
            $r = $obj->fetchRows($sql);
            $s = $obj->fetchRows($site); 
            if(empty($r)){
                $u = $this->getUserData();
                $a = $this->createSiteSelect($u['ref_id_site'], false, $s);
            }
            else {
                $a = $this->createSiteSelect($r, true, $s);
            }
            return $a;
                
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function createSiteSelect($data, $isArr, $site){
        $r = "";
        switch($isArr){
            case true:
                foreach($site as $k => $v){
                    foreach($data as $dk=> $dv){
                        if($dv['ref_id_site'] == $v['id_site'] || $dv['ref_id_site'] == '99'){
                            $c = "checked";
                            break;
                        } else {
                            $c = "";
                        }
                    }
              
                    $r .= "<div class='icheck-primary d-inline-block mr-4'>";
                    $r .= "<input type='checkbox' name='ref_id_site[]' id='ref_id_site$k' value='".$v['id_site']."' $c>";
                    $r .= "<label for='ref_id_site$k'>".$v['site_initialname']."</label>";
                    $r .= "</div>";
                }
                break;
            case false:
                foreach($site as $k => $v){
                    if($data == $v['id_site'] || $data == '99'){
                        $c = "checked";
                    } else {
                        $c = "";
                    }
                    $r .= "<div class='icheck-primary d-inline-block mr-4'>";
                    $r .= "<input type='checkbox' name='ref_id_site[]' id='ref_id_site$k' value='".$v['id_site']."' $c>";
                    $r .= "<label for='ref_id_site$k'>".$v['site_initialname']."</label>";
                    $r .= "</div>";
                }
                break;
        }
        return $r;
    }

    public function getDept($dept_id){
        $dept  = "SELECT * ";
        $dept .= "FROM tb_dept ";
        $dept .= "WHERE dept_status=1";


        try {
            $con = connect_database('e-service');
            $obj = new CRUD($con);
        
            $d = $obj->fetchRows($dept);
            $r = "<select class='custom-select rounded-3' id='slt_ref_id_dept' name='slt_ref_id_dept' required>";
            foreach($d as $k => $v){
                if($dept_id == $v['id_dept'])
                    $s = "selected";
                else 
                    $s = "";
                $r .= "<option value='".$v['id_dept']."' $s>".$v['dept_initialname']."</option>";
            }
            $r .= "</select>";

            return $r;
                
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }
}

Class Save_User {
    private $status_user;
    private $no_user;
    private $fullname;
    private $email;
    private $password;
    private $class_user;
    private $ref_id_site;
    private $ref_id_dept;
    private $id;
    public function __construct($d){
        parse_str($d, $v);

        $this->status_user = $v['status_user'];
        $this->no_user     = $v['no_user'];
        $this->fullname    = $v['fullname'];
        $this->email       = $v['email'];
        $this->password    = !IsNullOrEmptyString($v['password']) ? sha1(Setting::$keygen.$v['password']) : false;
        $this->class_user  = $v['class_user'];
        // $this->ref_id_site = $this->ArrSite($v['ref_id_site']);
        // $this->ref_id_dept = $v['slt_ref_id_dept'];
        $this->id          = $v['id_row'];

    }

    public function getData(){
        return $this->DoSaveUser();
    }

    public function DoSaveUser(){
       $updateUser = $this->updateUser();
       if($updateUser != 'Success'){
        return $updateUser;
       }
       $class      = $this->updateClass();
       if($class == 'Success' || is_numeric($class)){
        $result = 1;
       } else {
        $result = $class;
       }
       return $result;
    }

    public function updateUser(){
        $v = [
            'status_user' => $this->status_user,
            'no_user'     => $this->no_user,
            'fullname'    => $this->fullname,
            'email'       => $this->email,
        ];
        if($this->password != false){
            $v = array_merge($v, ['password' => $this->password]);
        }

        try {
            $con = connect_database('e-service');
            $obj = new CRUD($con);
        
            $r   = $obj->update($v, 'id_user='.$this->id, 'tb_user');

            return $r;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function updateClass(){
        $v = [
            'ref_id_user' => $this->id,
            'class_user'  => $this->class_user
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r   = $obj->customSelect("SELECT * FROM tb_user_carbooking WHERE ref_id_user=".$this->id);
            if(empty($r)){
                $c = $obj->addRow($v, 'tb_user_carbooking');
            } else {
                $c = $obj->update($v, 'ref_id_user='.$this->id, 'tb_user_carbooking');
            }
            return $c;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function deleteResponsibility(){
        try {
            $con = connect_database('e-service');
            $obj = new CRUD($con);
        
            $r   = $obj->deleteRow('', 'tb_site_responsibility', 'ref_id_user='.$this->id);
                
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function ArrSite($s){
        $a = array();
        foreach ($s as $d){
            $a[] = $d;
        }
        return $a;
    }
}