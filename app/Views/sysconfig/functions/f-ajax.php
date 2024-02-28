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
    private $reservation_txt;
    private $sysPhase;
    private $sysVersion;
    private $l_token;
    private $l_notify;
    private $l_token_main;
    private $l_notify_main;
    private $urgent_res;
    private $handover;
    private $handover_f;
    private $handover_l;
    public function __construct($data){
        parse_str($data, $v);

        $this->reservation_t     = ['config_value' => $v['reservation_t']];
        $this->reservation_w     = ['config_value' => $v['reservation_w']];
        $this->reservation_txt   = ['config_value' => $v['reservation_txt']];
        $this->urgent_res        = ['config_value' => $v['urgent_reservation']];
        $this->handover          = ['config_value' => $v['handover']];
        $this->handover_f        = ['config_value' => $v['handover_f']];
        $this->handover_l        = ['config_value' => $v['handover_l']];
        $this->l_token           = ['config_value' => $v['l_token']];
        $this->l_notify          = ['config_value' => $v['l_notify']];
        if ($_SESSION['car_class_user'] == 2) {
            $this->l_token_main  = ['config_value' => $v['l_token_main']];
            $this->l_notify_main = ['config_value' => $v['l_notify_main']];
            $this->sysPhase      = ['config_value' => $v['sysPhase']];
            $this->sysVersion    = ['config_value' => $v['sysVersion']];
        }
    }

    public function saveData(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $reservation_t   = $obj->update($this->reservation_t, 'id_config=1', 'tb_config');
            $reservation_w   = $obj->update($this->reservation_w, 'id_config=2', 'tb_config');
            $reservation_txt = $obj->update($this->reservation_txt, 'id_config=12', 'tb_config');
            $urgent_res      = $obj->update($this->urgent_res, 'config="urgent_reservation"', 'tb_config');
            $handover        = $obj->update($this->handover, 'config="handover"', 'tb_config');
            $handover_f      = $obj->update($this->handover_f, 'config="handover_f"', 'tb_config');
            $handover_l      = $obj->update($this->handover_l, 'config="handover_l"', 'tb_config');
            if($this->chkEmptyRow('l_token', true)){
                $l_token  = $this->insertNewConfig('l_token', $this->l_token['config_value'], true);
            } else {
                $l_token  = $obj->update($this->l_token, 'config="l_token" AND ref_id_site='.$_SESSION['car_ref_id_site'], 'tb_config');
            }
            if($this->chkEmptyRow('l_notify', true)){
                $l_notify = $this->insertNewConfig('l_notify', $this->l_notify['config_value'], true);
            } else {
                $l_notify = $obj->update($this->l_notify, 'config="l_notify" AND ref_id_site='.$_SESSION['car_ref_id_site'], 'tb_config');
            }

            if ($_SESSION['car_class_user'] == 2) {
                if($this->chkEmptyRow('l_token_main')){
                    $l_token_main  = $this->insertNewConfig('l_token', $this->l_token['config_value']);
                } else {
                    $l_token_main  = $obj->update($this->l_token_main, 'config="l_token_main"', 'tb_config');
                }
                if($this->chkEmptyRow('l_notify_main')){
                    $l_notify_main = $this->insertNewConfig('l_notify', $this->l_notify['config_value']);
                } else {
                    $l_notify_main = $obj->update($this->l_notify_main, 'config="l_notify_main"', 'tb_config');
                }
                $sysPhase        = $obj->update($this->sysPhase, 'id_config=3', 'tb_config');
                $sysVersion      = $obj->update($this->sysVersion, 'id_config=4', 'tb_config');
                sysVersion($_SESSION['phase'], $_SESSION['version']);
                sysCon($_SESSION['urgent'], $_SESSION['handover']);
                return $this->chkSuccess(array($reservation_t, $reservation_w, $reservation_txt, $sysPhase, $sysVersion, $l_token, $l_notify, $l_token_main, $l_notify_main));
            }
            
            return $this->chkSuccess(array($reservation_t, $reservation_w, $reservation_txt, $urgent_res, $handover, $handover_f, $handover_l, $l_token, $l_notify));
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function insertNewConfig($config, $value, $site = false){
        
        $v = [
            'config' => $config,
            'config_value' => $value,
        ];
        if($site)
            $v['ref_id_site'] = $_SESSION['car_ref_id_site'];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
            
            $c = $obj->addRow($v, 'tb_config');

            if(is_numeric($c))
                return 'Success';

            return $c;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function chkEmptyRow($config, $site = false){
        $sql  = "SELECT id_config ";
        $sql .= "FROM tb_config ";
        $sql .= "WHERE config='$config' ";
        if($site)
            $sql .= "AND ref_id_site=".$_SESSION['car_ref_id_site'];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
            
            $c = $obj->fetchRows($sql);

            if(empty($c))
                return true;

            return false;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function chkSuccess($ch){
        foreach($ch as $v){
            if($v != 'Success'){
                return $v;
            }
        }
        return true;
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
