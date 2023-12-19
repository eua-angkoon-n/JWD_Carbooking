<?PHP
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Bangkok');	

require_once __DIR__ . "/../../../../config/connectDB.php";
require_once __DIR__ . "/../../../../config/setting.php";

require_once __DIR__ . "/../../../../tools/crud.tool.php";
require_once __DIR__ . "/../../../../tools/function.tool.php";

$action = $_POST['action'];

$_POST['reg_date'] = date('Y-m-d', strtotime(str_replace('\/', '/', $_POST['reg_date']))); 

// echo json_encode($s);
// exit();

switch ($action) {
    case 'addData' : 
        $Call   = new Vehicle($_POST, $_FILES['vehicle_files']);
        $Result = $Call->getData();
        break;
    case 'update-status' :
        $Call   = new Update_Status($_POST['id_row'], $_POST['chk_box_value']);
        $Result = $Call->getUpdate();
        break;
    case 'edit' :
        $Call   = new Edit_Vehicle($_POST['id_row']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;
    case 'view' :
        $Call   = new View_Vehicle($_POST['id_row']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;
}

print_r($Result);
exit;

Class Vehicle {

    public bool $isEdit;
    public $site;
    public $id_row;
    public $vehicle_status;
    public $vehicle_name;
    public $reg_date;
    public $vehicle_type;
    public $vehicle_brand;
    public $vehicle_seat;
    public $vehicle_remark;
    public $action;
    public $File;
    public bool $haveFile;

    public function __construct($frmData,$File) {
        !empty($frmData['id_vehicle']) ? $this->isEdit = true : $this->isEdit = false;
        if(!empty($File['name'])){
            $this->haveFile = true;
            $this->File     = $File;
        } else {
            $this->haveFile = false;
        }
            
        $this->site           = $_SESSION['sess_ref_id_site'];
        
        $this->id_row         = $frmData['id_vehicle'];
        $this->vehicle_status = $frmData['vehicle_status'];
        $this->vehicle_name   = $frmData['vehicle'];
        $this->reg_date       = $frmData['reg_date'];
        $this->vehicle_type   = $frmData['vehicle_type'];
        $this->vehicle_brand  = $frmData['vehicle_brand'];
        $this->vehicle_seat   = $frmData['seat'];
        $this->vehicle_remark = $frmData['vehicle_remark'];

        $this->action         = $frmData['action'];
    }

    public function getData() {
        return $this->AddEditData();
    }

    public function AddEditData() {

        $isEdit   = $this->isEdit;
        $haveFile = $this->haveFile;

        if($haveFile) {
            $img_result = $this->DoAddImg();
        } else {
            $img_result = false;
        }

        if($isEdit) {
            $chk = $this->chkName($this->vehicle_name, 'edit');
            if(!$chk)
                return 0;

            $result = $this->DoEditData($img_result);
        } else {
            $chk = $this->chkName($this->vehicle_name, 'add');
            if(!$chk)
                return 0;
            
            $result = $this->DoAddData($img_result);
        }

       return $result;
    }

    public function DoAddData($IdFile){

        $site           = $this->site;
        $vehicle_status = $this->vehicle_status;
        $vehicle_name   = $this->vehicle_name;
        $reg_date       = $this->reg_date;
        $vehicle_type   = $this->vehicle_type;
        $vehicle_brand  = $this->vehicle_brand;
        $vehicle_seat   = $this->vehicle_seat;
        $vehicle_remark = $this->vehicle_remark;

        $date_created   = date("Y-m-d H:i:s"); 

        $value = [
            'ref_id_site'          => $site,
            'vehicle_name'         => $vehicle_name,
            'vehicle_reg_date'     => $reg_date,
            'ref_id_attachment'    => $IdFile,
            'ref_id_vehicle_type'  => $vehicle_type,
            'ref_id_vehicle_brand' => $vehicle_brand,
            'vehicle_seat'         => $vehicle_seat,
            'vehicle_status'       => $vehicle_status,
            'date_created'         => $date_created,
            'vehicle_remark'       => $vehicle_remark
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->addRow($value, "tb_vehicle");

            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function DoAddImg(){
        $File = $this->File;
        if(!empty($File)){
            try {
                $con = connect_database();
                $obj = new CRUD($con);
                
                $PathImg = getPathImg(Setting::$PathImg);
                $imageName = $obj->uploadPhoto($File, "../../dist/temp_img/". $PathImg . "/");
    
                $value = [
                    'attachment'       => $imageName,
                    'attachment_type'  => 0,
                    'date_uploaded'    => date("Y-m-d")
                ];
            
                $result = $obj->addRow($value, "tb_attachment");
                return $result;
            } catch (PDOException $e) {
                return "Database connection failed: " . $e->getMessage();
            
            } catch (Exception $e) {
                return "An error occurred: " . $e->getMessage();
            
            } finally {
                $con = null;
            }
        } else {
            return 0;
        }
    }

    public function newFileName($name){
        $fileNameCmps = explode('.', $name);
        $fileExtension = strtolower(end($fileNameCmps));
        return time().$fileExtension;

    }

    public function DoEditData($img_result) {
        $site           = $this->site;
        $vehicle_status = $this->vehicle_status;
        $vehicle_name   = $this->vehicle_name;
        $reg_date       = $this->reg_date;
        $vehicle_type   = $this->vehicle_type;
        $vehicle_brand  = $this->vehicle_brand;
        $vehicle_seat   = $this->vehicle_seat;
        $vehicle_remark = $this->vehicle_remark;

        $date_edited   = date("Y-m-d H:i:s"); 

        $value = [
            'ref_id_site'          => $site,
            'vehicle_name'         => $vehicle_name,
            'vehicle_reg_date'     => $reg_date,
            'ref_id_vehicle_type'  => $vehicle_type,
            'ref_id_vehicle_brand' => $vehicle_brand,
            'vehicle_seat'         => $vehicle_seat,
            'vehicle_status'       => $vehicle_status,
            'date_edited'          => $date_edited,
            'vehicle_remark'       => $vehicle_remark
        ];
        
        if($img_result) {
            $value['ref_id_attachment'] = $img_result;
        }

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->update($value, 'id_vehicle='.$this->id_row, "tb_vehicle");
            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function chkName($vehicle_name, $mode){
        $sql  = "SELECT vehicle_name ";
        $sql .= "FROM `tb_vehicle` ";
        $sql .= "WHERE vehicle_name = '$vehicle_name' ";
        if($mode == 'edit'){
            $id_row = $this->id_row;
            $sql .= "AND id_vehicle <> $id_row ";
        }

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->fetchRows($sql);

            empty($result) ? $s = true : $s = false;

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
            'vehicle_status' => $this->chk_box_value,
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->update($value, 'id_vehicle='.$this->id_row, "tb_vehicle");
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

Class Edit_Vehicle {
    public $id_row;
    public function __construct($id_row){
        $this->id_row = $id_row;
    }

    public function getData(){
        return $this->DoGetData();
    }

    public function DoGetData(){
        $sql = $this->getSQL();

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->customSelect($sql);
            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getSQL(){
        $id_row = $this->id_row;

        $sql  = "SELECT * ";
        $sql .= "FROM tb_vehicle ";
        $sql .= "LEFT JOIN tb_attachment ON (tb_vehicle.ref_id_attachment = tb_attachment.id_attachment) ";
        $sql .= "LEFT JOIN tb_vehicle_type ON  (tb_vehicle.ref_id_vehicle_type = tb_vehicle_type.id_vehicle_type) ";
        $sql .= "LEFT JOIN tb_vehicle_brand ON  (tb_vehicle.ref_id_vehicle_brand = tb_vehicle_brand.id_vehicle_brand) ";
        $sql .= "WHERE id_vehicle = $id_row ";
        $sql .= "AND ref_id_site = '".$_SESSION['sess_ref_id_site']."' "; 
 
        return $sql;
    }


}

Class View_Vehicle {

    public $id_row;

    public function __construct($id_row){
        $this->id_row = $id_row;
    }

    public function getData(){
        return $this->DoGetData();
    }

    public function DoGetData(){
        $sql = $this->getViewQuery();

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->fetchRows($sql);

            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }

    }

    public function getViewQuery(){
        $id = $this->id_row;
        
        $sql  = "SELECT vehicle_name, vehicle_reg_date, vehicle_seat, vehicle_status, tb_vehicle.date_created, tb_vehicle.date_edited, vehicle_remark, vehicle_brand, vehicle_type, attachment, date_uploaded ";
        $sql .= "FROM tb_vehicle ";
        $sql .= "LEFT JOIN tb_vehicle_brand ON (tb_vehicle_brand.id_vehicle_brand = tb_vehicle.ref_id_vehicle_brand) ";
        $sql .= "LEFT JOIN tb_vehicle_type ON (tb_vehicle_type.id_vehicle_type = tb_vehicle.ref_id_vehicle_type) ";
        $sql .= "LEFT JOIN tb_attachment ON (tb_attachment.id_attachment = tb_vehicle.ref_id_attachment) ";
        $sql .= "WHERE id_vehicle=$id";

        return $sql;
    }
    

}