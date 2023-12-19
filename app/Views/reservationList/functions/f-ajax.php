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

// echo json_encode($_POST['remark']);
// exit();

switch ($action) {
    case 'cancel' : //ยกเลิกการจอง
        $Call   = new Reservation_Cancel($_POST['id'], $_POST['remark']);
        $Data   = $Call->getData();
        $Result = $Data;
        break;
    case 'detail': //ดูรายละเอียดการจอง
        $Call = new Reservation_Detail($_POST['id']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;
}

print_r($Result);
exit;

Class Reservation_Cancel {

    private $id;
    private $remark;
    public function __construct($id, $remark){
        $this->id     = $id;
        $this->remark = $remark == "" ? false : $remark;
    }

    public function getData(){
        return $this->DoCancel();
    }

    public function DoCancel(){
        if($this->remark){
            $this->getCancelID();
        }
        $res = $this->updateRes();
        return $res;
    }

    public function getCancelID(){
        $data = [
            'ref_id_reservation' => $this->id,
            'remark_type'        => 3, //1= Approve 2 = Non-Approve 3 = Cancel
            'remark'             => $this->remark,
            'date'               => date('Y-m-d H:i:s')
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->addRow($data, 'tb_reservation_remark');

            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }

        return false;
    }

    public function updateRes(){
        $data = [
            'reservation_status' => 5,
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->update($data, 'id_reservation='.$this->id, 'tb_reservation');

            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }

        return false;
    }
}

Class Reservation_Detail {
    private $id;
    public function __construct($id){
        $this->id = $id;
    }

    public function getData(){
        return $this->DoGetDetail();
    }

    public function DoGetDetail(){
        $Res      = $this->getResData();
        $User     = $this->getUserName($Res['ref_id_user']);
        $acc      = 'ไม่มี';
        if($Res['accessories'] == 1){
            $acc  = $this->getAccessory(); 
        }
        return $this->getArrData($Res, $User, $acc);
    }

    public function getResData(){
        $sql  = "SELECT tb_reservation.reservation_status, tb_reservation.id_reservation, tb_vehicle.vehicle_name, tb_reservation.start_date, tb_reservation.end_date, tb_reservation.ref_id_user, tb_coordinates.place_name, tb_coordinates.latitude, tb_coordinates.longitude, tb_coordinates.zoom, tb_reservation.traveling_companion, tb_reservation.reason, tb_reservation.accessories, tb_driver.driver_name, tb_attachment.attachment, tb_attachment.date_uploaded ";
        $sql .= "FROM tb_reservation ";
        $sql .= "LEFT JOIN db_carbooking.tb_vehicle ON (tb_vehicle.id_vehicle = tb_reservation.ref_id_vehicle) ";
        $sql .= "LEFT JOIN db_carbooking.tb_coordinates ON (tb_coordinates.ref_id_reservation = tb_reservation.id_reservation) ";
        $sql .= "LEFT JOIN db_carbooking.tb_driver ON (tb_driver.id_driver = tb_reservation.ref_id_driver) ";
        $sql .= "LEFT JOIN db_carbooking.tb_attachment ON (tb_attachment.id_attachment = tb_vehicle.ref_id_attachment) ";
        $sql .= "WHERE id_reservation=$this->id;";

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

    public function getUserName($id){
        $sql  = "SELECT fullname, phone ";
        $sql .= "FROM tb_user ";
        $sql .= "WHERE id_user = $id";

        try {
            $con = connect_database('e-service');
            $obj = new CRUD($con);
        
            $result = $obj->customSelect($sql);

            $r = $result['fullname'];
            !IsNullOrEmptyString($result['phone']) ? $r .= " (".$result['phone'].")" : ''; 
            return $r;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getAccessory(){
        $sql  = "SELECT acc_name ";
        $sql .= "FROM tb_ref_accessories ";
        $sql .= "LEFT JOIN tb_accessories ON (tb_ref_accessories.ref_id_acc = tb_accessories.id_acc) ";
        $sql .= "WHERE ref_id_reservation = $this->id";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $s = $obj->fetchRows($sql);
            $r = array();
            foreach($s as $k => $v){
                $a[] = $v['acc_name'];
            }
            $r = implode(', ', $a);

            return $r;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getArrData($MD, $Name, $Acc){
        return array(
            'status'          => $MD['reservation_status'],
            'res_id'          => $MD['id_reservation'],
            'vehicle_name'    => $MD['vehicle_name'],
            'start'           => $MD['start_date'],
            'end'             => $MD['end_date'],
            'userName'        => $Name,
            'place_Name'      => $MD['place_name'],
            'lat'             => $MD['latitude'],
            'lng'             => $MD['longitude'],
            'zm'              => $MD['zoom'],
            'companion'       => $MD['traveling_companion'],
            'reason'          => $MD['reason'],
            'acc'             => $Acc,
            'driver'          => $MD['driver_name'],
            'attachment'      => $MD['attachment'],
            'date_attachment' => $MD['date_uploaded']

        );
    }
}

