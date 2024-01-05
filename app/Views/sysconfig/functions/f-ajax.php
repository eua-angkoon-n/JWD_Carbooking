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

// print_r ($_POST);
// exit();

switch ($action) {
    case 'save' :
        $Call   = new save_config($_POST['frmData']);
        $Result = $Call->saveData();
        break;
}

print_r($Result);
exit;

Class save_config {
    private $reservation_t;
    private $reservation_w;
    private $sysPhase;
    private $sysVersion;
    public function __construct($data){
        parse_str($data, $v);

        $this->reservation_t = ['config_value' => $v['reservation_t']];
        $this->reservation_w = ['config_value' => $v['reservation_w']];
        $this->sysPhase      = ['config_value' => $v['sysPhase']];
        $this->sysVersion    = ['config_value' => $v['sysVersion']];
    }

    public function saveData(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $reservation_t = $obj->update($this->reservation_t, 'id_config=1', 'tb_config');
            $reservation_w = $obj->update($this->reservation_w, 'id_config=2', 'tb_config');
            $sysPhase      = $obj->update($this->sysPhase, 'id_config=3', 'tb_config');
            $sysVersion    = $obj->update($this->sysVersion, 'id_config=4', 'tb_config');
            
            $p = $this->chkSuccess($reservation_t, $reservation_w, $sysPhase, $sysVersion);

            return $p;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function chkSuccess($a, $b, $c, $d){

        if($a == 'Success' && $b == 'Success' && $c == 'Success' && $d == 'Success'){
            return true;
        }else {
            $ch = array($a, $b, $c, $d);
            foreach($ch as $v){
                if($v != 'Success'){
                    return $v;
                }
            }
        }
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
