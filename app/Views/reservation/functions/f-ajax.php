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
    case 'update-status' :
        $Call   = new Update_Status($_POST['id_row'], $_POST['chk_box_value']);
        $Result = $Call->getUpdate();
        break;
    case 'edit' :
        $Call   = new Edit_Vehicle($_POST['id_row']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;
    case 'viewReservation' :
        $Call   = new View_Vehicle($_POST['id_row']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;
    case 'DoReservation' :
        $Call   = new Do_Vehicle($_POST['id_vehicle']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;
    case 'addReservation' :
        $Call   = new Add_Reservation($_POST['frmData']);
        $Data   = $Call->getData();
        $Result = $Data;
        break;
}

print_r($Result);
exit;

Class Do_Vehicle {

    public $id;

    public function __construct($id){
        $this->id = $id;
    }

    public function getData(){
        $Vehicle  = $this->getVehicle();
        $r = array(
            'vehicle'       => $Vehicle['vehicle_name'], 
            'id_vehicle'    => $Vehicle['id_vehicle'], 
            'id_user'       => $_SESSION['car_id_user'],
            'attachment'    => $Vehicle['attachment'],
            'date_uploaded' => $Vehicle['date_uploaded']
        );
        return $r;
    }

    public function getVehicle(){
        $id = $this->id;
        $sql  = "SELECT tb_vehicle.id_vehicle, tb_vehicle.vehicle_name, tb_attachment.attachment, tb_attachment.date_uploaded ";
        $sql .= "FROM tb_vehicle ";
        $sql .= "LEFT JOIN tb_attachment ON (tb_attachment.id_attachment = tb_vehicle.ref_id_attachment) ";
        $sql .= "WHERE id_vehicle=$id ";

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

        return 0;
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

Class Add_Reservation {
    private $id_vehicle;
    private $date_start;
    private $date_end;
    private $id_user;
    private $phone;
    private $place;
    private $place_id;
    private $lat;
    private $lng;
    private $zm;
    private $traveler;
    private $companion;
    private $reason;
    private $acc;
    private $haveAcc;
    private $driver; 
    // private $test;
    public function __construct($frmData){
        parse_str($frmData, $data);
        convertDateRange($data['res_date'], $start, $end);
        
        // $this->test = $data['res_date'];

        $this->id_vehicle = $data['id_vehicle'];
        $this->date_start = $start;
        $this->date_end   = $end;
        $this->id_user    = $data['id_user'];
        $this->phone      = $data['res_tel'];
        $this->place      = $data['map_place'];
        $this->place_id   = $data['map_place_id'];
        $this->lat        = $data['map_lat'];
        $this->lng        = $data['map_lon'];
        $this->zm         = $data['map_zoom'];
        $this->traveler   = $data['res_travel'];
        $this->companion  = implode(", ",$data['res_companion']);
        $this->reason     = $data['res_reason'];
        $this->chkAcc($data['res_acc']);
        $this->driver     = $data['res_driver'];
    }

    public function getData(){
        return $this->DoAddData();
        // return array(
        //     'id_vehicle'=>  $this->id_vehicle,
        //     'date_start' => $this->date_start,
        //     'date_end' =>   $this->date_end,
        //     'id_user' =>    $this->id_user,
        //     'phone' =>      $this->phone,
        //     'place' =>      $this->place,
        //     'lat' =>        $this->lat,
        //     'lng' =>        $this->lng,
        //     'zm' =>         $this->zm,
        //     'traveler' =>   $this->traveler,
        //     'companion' =>  $this->companion,
        //     'reason' =>     $this->reason,
        //     'acc' =>        $this->acc,
        //     'haveAcc' =>    $this->haveAcc,
        //     'driver' =>     $this->driver
        // );
    }

    public function chkAcc($arrAcc){
        if(empty($arrAcc)){
            $this->haveAcc = false;
        }else{
            $this->haveAcc = true;
            $this->acc = $arrAcc;
        }
    }

    public function chkReservation(){
        $id    = $this->id_vehicle;
        $start = $this->date_start;
        $end   = $this->date_end;

        $sql  = "SELECT CASE ";
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

            $fetchRow = $obj->customSelect($sql);
            // return $fetchRow['reservation_status'];
            if($fetchRow['reservation_status'] == 'ว่าง'){
                return true;
            } else {
                return false;
            }
            
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function DoAddData(){
        $chkAllowed = reservationTimeDiff($this->date_start);
        if(!$chkAllowed)
            return 'notAllowed';
        $canAdd = $this->chkReservation(); // เช็คอีกทีว่า สามารถจองในเวลานี้ได้ไหม
        if(!$canAdd)
            return 'dupTime';
        $ResData = $this->getResData(); // สร้างarr tb_reservation
        $idRes = $this->insertRes($ResData); // เพิ่ม tb_reservation
        if(is_numeric($idRes)){ // ถ้าได้ id_reservation
            $CDNData = $this->getCDNData($idRes); // สร้างarr tb_coordinates
            $idCDN = $this->insertCDN($CDNData); // เพิ่ม tb_reservation
            if($this->haveAcc){ // ถ้ามี accessory
                $this->insertAcc($idRes); // เพิ่ม tb_ref_accessories
            }
            if(!IsNullOrEmptyString($this->phone)){
               $this->chkPhoneEService();
            }
            $this->sendLineNotify($idRes);
            return $idRes;
        }
        return false;
    }

    public function getResData(){
        $r = [
            'ref_id_site'        => $_SESSION['car_ref_id_site'],
            'ref_id_vehicle'     => $this->id_vehicle,
            'ref_id_user'        => $this->id_user, 
            'traveler'           => $this->traveler, 
            'traveling_companion'=> $this->companion, 
            'tel'                => $this->phone, 
            'start_date'         => $this->date_start, 
            'end_date'           => $this->date_end, 
            'accessories'        => ($this->acc) ? 1 : 0, 
            'ref_id_driver'      => $this->driver, 
            'reason'             => $this->reason, 
            'reservation_status' => 0, 
            'date_created'       => date("Y-m-d H:i:s")
        ];
        return $r;
    }

    public function insertRes($r){
        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $fetchRow = $obj->addRow($r, 'tb_reservation');

            return $fetchRow;
            
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getCDNData($rId){
        $c = [
            'ref_id_reservation' => $rId,
            'place_id'           => $this->place_id,
            'place_name'         => $this->place, 
            'latitude'           => ($this->lat == '') ? NULL : $this->lat, 
            'longitude'          => ($this->lng == '') ? NULL : $this->lng, 
            'zoom'               => ($this->zm == '') ? NULL : $this->zm, 
        ];
        return $c;
    }

    public function insertCDN($c){
        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $fetchRow = $obj->addRow($c, 'tb_coordinates');

            return $fetchRow;
            
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function InsertACC($rId) {
        
        try {
            $con = connect_database();
            $obj = new CRUD($con);

            foreach($this->acc as $idAcc){
                $a = [
                    'ref_id_reservation' => $rId,
                    'ref_id_acc' => $idAcc,
                ];
                $fetchRow = $obj->addRow($a, 'tb_ref_accessories');
            }
            return true;
            
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function chkPhoneEService(){

        try {
            $con = connect_database('e-service');
            $obj = new CRUD($con);

            $user = $obj->customSelect("SELECT * FROM tb_user WHERE id_user=$this->id_user ");

            if(IsNullOrEmptyString($user['phone'])){
                $p = [
                    'phone' => $this->phone,
                ];
                $obj->update($p, "id_user=$this->id_user", "tb_user");
            } 
            
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function sendLineNotify($idRes){

        getLineConfig($token, $notify);
        if(!$notify)
            return;
        $res     = $this->getReservationData($idRes);
        $vehicle = $res['vehicle_name'];
        $date    = getDateString2($res['start_date'], $res['end_date']);
        $name    = $_SESSION['car_fullname'];
        $dept    = $_SESSION['car_dept_initialname'];
        $comp    = $res['traveling_companion'];
        $driver  = $res['driver_name'];

        $sToken    = $token;
        $sMessage  = "\nจองยานพาหนะ: $vehicle\n";
        $sMessage .= "วันที่: $date\n";
        $sMessage .= "ชื่อผู้จอง: $name\n";
        $sMessage .= "แผนกที่จอง: $dept\n";
        $sMessage .= "ผู้ร่วมเดินทาง: $comp\n";
        $sMessage .= "พนักงานขับรถ: $driver\n";
        $sMessage .= "รายละเอียด/อนุมัติ: ".Setting::$domain."/?".PageSetting::$prefixController."=res".urlencode('&id=').$idRes;
    

        $chOne = curl_init(); 
        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt( $chOne, CURLOPT_POST, 1); 
        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
    
        try {
            $result = curl_exec($chOne);
            if ($result === false) {
                throw new Exception(curl_error($chOne));
            }
        
            $result_ = json_decode($result, true);
            // echo "status : " . $result_['status'];
            // echo "message : " . $result_['message'];
        } catch (Exception $e) {
            // echo 'Caught exception: ' . $e->getMessage();
        } finally {
            curl_close($chOne);
        }
    }

    public function getReservationData($id){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_reservation ";
        $sql .= "LEFT JOIN tb_driver ON (tb_driver.id_driver = tb_reservation.ref_id_driver) ";
        $sql .= "LEFT JOIN tb_vehicle ON (tb_vehicle.id_vehicle = tb_reservation.ref_id_vehicle) ";
        $sql .= "WHERE id_reservation=$id ";
        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $fetchRow = $obj->customSelect($sql);
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