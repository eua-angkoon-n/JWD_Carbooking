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
    case 'addData' : 
        $Call   = new Brand_Vehicle($_POST['data'], $action);
        $Result = $Call->getData();
        break;
    case 'update-status' :
        $Call   = new Update_Status($_POST['id_row'], $_POST['chk_box_value']);
        $Result = $Call->getUpdate();
        break;
    case 'edit' :
        $Call   = new Edit_Acc($_POST['id_row']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;
}

print_r($Result);
exit;

Class Brand_Vehicle {

    public bool $isEdit;
    public $brand_status;
    public $vehicle_brand;
    public $id_row;
    public $action;

    public function __construct($frmData,$action) {
        
        parse_str($frmData, $output); //$output['period']

        !empty($output['id_vehicle_brand']) ? $this->isEdit = true : $this->isEdit = false;
        $this->brand_status  = $output['brand_status'];
        $this->vehicle_brand = $output['vehicle_brand'];
        $this->id_row       = $output['id_vehicle_brand'];
        $this->action       = $action;
    }

    public function getData() {
        return $this->AddEditData();
    }

    public function AddEditData() {

        $isEdit = $this->isEdit;

        if($isEdit) {
            $result = $this->DoEditData();
        } else {
            $result = $this->DoAddData();
        }

       return $result;
    }

    public function DoAddData(){

        $vehicle_brand = $this->vehicle_brand;
        $brand_status  = $this->brand_status;
        $date_created = date("Y-m-d H:i:s");

        $chk = $this->chkName($vehicle_brand, 'add');
        if(!$chk)
            return 0;

        $value = [
            'vehicle_brand' => $vehicle_brand,
            'brand_status'  => $brand_status,
            'date_created' => $date_created
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->addRow($value, "tb_vehicle_brand");
            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function DoEditData() {
        $vehicle_brand = $this->vehicle_brand;
        $brand_status  = $this->brand_status;
        $date_edited    = date("Y-m-d H:i:s");

        $chk = $this->chkName($vehicle_brand, 'edit');
        if(!$chk)
            return 0;

        $value = [
            'vehicle_brand' => $vehicle_brand,
            'brand_status'  => $brand_status,
            'date_edited' => $date_edited
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->update($value, 'id_vehicle_brand='.$this->id_row, "tb_vehicle_brand");
            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function chkName($vehicle_brand, $mode){
        $sql  = "SELECT id_vehicle_brand ";
        $sql .= "FROM `tb_vehicle_brand` ";
        $sql .= "WHERE vehicle_brand = '$vehicle_brand' ";
        if($mode == 'edit'){
            $id_row = $this->id_row;
            $sql .= "AND id_vehicle_brand <> $id_row ";
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
            'brand_status' => $this->chk_box_value,
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->update($value, 'id_vehicle_brand='.$this->id_row, "tb_vehicle_brand");
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

Class Edit_Acc {
    public $id_row;
    public function __construct($id_row){
        $this->id_row = $id_row;
    }

    public function getData(){
        return $this->DoGetData();
    }

    public function DoGetData(){
        $id_row = $this->id_row;

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->customSelect("SELECT * FROM tb_vehicle_brand WHERE `tb_vehicle_brand`.id_vehicle_brand=$id_row;");
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