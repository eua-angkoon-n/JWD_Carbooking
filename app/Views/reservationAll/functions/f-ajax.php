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

// echo json_encode($s);
// exit();

switch ($action) {
    case 'approve' : //อนุมัติการจอง
        $Call   = new Reservation_Approve($_POST['id'], $_POST['remark']);
        $Data   = $Call->getData();
        $Result = $Data;
        break;
    case 'noApprove' : //ไม่อนุมัติการจอง
        $Call   = new Reservation_NoApprove($_POST['id'], $_POST['remark']);
        $Data   = $Call->getData();
        $Result = $Data;
        break;
    case 'detail': //ดูรายละเอียดการจอง
        $Call   = new Reservation_Detail($_POST['id']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;
    case 'edit': //แก้ไขการจอง
        $Call   = new Reservation_Edit($_POST['data']);
        $Data   = $Call->getData();
        $Result = $Data;
        break;
}

print_r($Result);
exit;

Class Reservation_Approve {

    private $id;
    private $remark;
    public function __construct($id, $remark){
        $this->id     = $id;
        $this->remark = $remark;
    }

    public function getData(){
        return $this->DoApprove();
    }

    public function DoApprove(){
        $id_Approve = $this->getApproveID();

        if(is_numeric($id_Approve)){
            $res = $this->updateRes();
            return $res;
        }
        return 0;
    }

    public function getApproveID(){
        $data = [
            'ref_id_reservation' => $this->id,
            'remark_type'        => 1, //1= Approve 2 = Non-Approve 3 = Cancel
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
            'reservation_status' => 1,
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

Class Reservation_NoApprove {

    private $id;
    private $remark;
    public function __construct($id, $remark){
        $this->id     = $id;
        $this->remark = $remark;
    }

    public function getData(){
        return $this->DoNoApprove();
    }

    public function DoNoApprove(){
        $id_Approve = $this->getNoApproveID();

        if(is_numeric($id_Approve)){
            $res = $this->updateRes();
            return $res;
        }
        return 0;
    }

    public function getNoApproveID(){
        $data = [
            'ref_id_reservation' => $this->id,
            'remark_type'        => 2, //1= Approve 2 = Non-Approve 3 = Cancel
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
            'reservation_status' => 2,
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
    private $id_vehicle;
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
        $vehicle  = $this->getVehicle($Res['id_vehicle']);
        return $this->getArrData($Res, $User, $acc, $vehicle);
    }

    public function getResData(){
        $sql  = "SELECT tb_reservation.reservation_status, tb_reservation.id_reservation, tb_vehicle.id_vehicle, tb_vehicle.vehicle_name, tb_reservation.start_date, tb_reservation.end_date, tb_reservation.ref_id_user, tb_coordinates.place_name, tb_coordinates.latitude, tb_coordinates.longitude, tb_coordinates.zoom, tb_reservation.traveling_companion, tb_reservation.reason, tb_reservation.accessories, tb_driver.driver_name, tb_attachment.attachment, tb_attachment.date_uploaded ";
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

    public function getVehicle($id){
        $sql = "SELECT * FROM tb_vehicle WHERE ref_id_site=".$_SESSION['sess_ref_id_site']." ";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->fetchRows($sql);
            $s = "";
            foreach($r as $k => $v){
                $v['id_vehicle'] == $id ? $select = "selected='selected'" : $select = "";
                $vId   = $v['id_vehicle'];
                $vName = $v['vehicle_name'];
                $s .= "<option value='$vId' $select>$vName</option>";
            }

            return $s;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getArrData($MD, $Name, $Acc, $vehicle){
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
            'date_attachment' => $MD['date_uploaded'],
            'vehicle_select'  => $vehicle,

        );
    }
}

Class Reservation_Edit {
    private $id_res;
    private $id_vehicle;
    private $start;
    private $end;

    public function __construct($data){
        parse_str($data, $Data);

        $this->id_res = $Data['modal_id'];
        $this->id_vehicle = $Data['modal_vehicle'];
        convertDateRangeDMY($Data['modal_date'], $this->start, $this->end);
    }

    public function getData() {
        return $this->DoAddData();
    }

    public function DoAddData(){
        $canAdd = $this->chkReservation(); // เช็คอีกทีว่า สามารถจองในเวลานี้ได้ไหม
        // return $canAdd;
        if(!$canAdd)
            return 'dupTime';
        $ResData = $this->getResData(); // สร้างarr tb_reservation
        $idRes = $this->updateRes($ResData); // เพิ่ม tb_reservation

        return $idRes;
    }

    public function chkReservation(){
        $id_res= $this->id_res;
        $id    = $this->id_vehicle;
        $start = $this->start;
        $end   = $this->end;

        $sql  = "SELECT tb_reservation.id_reservation, ";
        $sql .= "   CASE ";
        $sql .= "       WHEN tb_reservation.id_reservation IS NOT NULL THEN 'ไม่ว่าง' ";
        $sql .= "       ELSE 'ว่าง' ";
        $sql .= "   END AS reservation_status ";
        $sql .= "FROM tb_vehicle ";
        $sql .= "LEFT JOIN tb_reservation ON tb_reservation.ref_id_vehicle = tb_vehicle.id_vehicle ";
        $sql .= "AND ( ";
        $sql .= "tb_reservation.start_date < '$end' ";
        $sql .= "AND tb_reservation.end_date > '$start' ";
        $sql .= "AND tb_reservation.reservation_status NOT IN (2, 4, 5, 6) ";
        $sql .= ") ";
        $sql .= "WHERE id_vehicle = $id ";
        // return $sql;
        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $fetchRow = $obj->fetchRows($sql);
            // return $fetchRow['reservation_status'];

            if($fetchRow[0]['reservation_status'] == 'ว่าง'){ //ถ้าstatus ขึ้นว่าง แสดงว่าเพิ่มได้
                return true;
            } else {
                if(count($fetchRow) == 1){ // ถ้าไม่ว่าง แต่นับ row แล้วมีแค่ 1 
                    foreach($fetchRow as $key => $value){  // เช็คต่อว่าถ้า id_res เท่ากัน ก็คืออันเดียวกัน แสดงว่าเพิ่มได้
                        if($value['id_reservation'] == $id_res){
                            return true;
                        }
                    }
                }
                return false;;
            }
            
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getResData(){
        $r = [
            'ref_id_vehicle'     => $this->id_vehicle,
            'start_date'         => $this->start,
            'end_date'           => $this->end,
            'ref_id_user_edited' => $_SESSION['sess_ref_id_site'],
            'date_edited'        => date("Y-m-d H:i:s")
        ];
        return $r;
    }

    public function updateRes($r){
        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $fetchRow = $obj->update($r, "id_reservation=".$this->id_res, 'tb_reservation');

            return $fetchRow;
            
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }
}

