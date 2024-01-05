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

// if(empty($_FILES['expenseFile']['name'][0])){
//     echo json_encode(array('ว่าง')); 
// }else {
//     echo json_encode(array('ไม่ว่าง')); 
// }

// echo json_encode($_POST['action']);
// exit;

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
    case 'save': //บันทึกส่งมอบ
        $Call = new SaveHandOver($_POST, $_FILES);
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
            'id_user'         => $MD['ref_id_user'],
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

Class SaveHandOver {

    public $id;
    public $conditionIn;
    public $conditionInFile;
    public $conditionOut;
    public $conditionOutFile;
    public $fuel;
    public $fuelFile;
    public $expense;
    public $expenseFile;

    public function __construct($data, $file){
        $this->id               = $data['id_res'];
        $this->conditionIn      = $data['condition_in'];
        $this->conditionOut     = $data['condition_out'];
        $this->fuel             = $data['fuel'];
        $this->expense          = $data['expenses'];

        $this->conditionInFile  = $file['condition_inFile'];
        $this->conditionOutFile = $file['condition_outFile'];
        $this->fuelFile         = $file['fuelFile'];
        $this->expenseFile      = $file['expenseFile'];
    }

    public function getData(){
        return $this->DoSaveData();
    }

    public function DoSaveData(){
        $handOver = $this->AddHandOver();
        if(is_numeric($handOver)){
            $img = $this->AddFileInToServer();
            if($img != 'success')
                return $img;
            if(!empty($this->expense[0]['expenseAmount'])){
                $expenses = $this->AddExpense();
                if(!is_numeric($expenses)){
                    return $expenses; 
                }
            }
            updateReservationStatus($this->id, 6);
            return 'success';
        }
        return 0;
    }

    public function AddHandOver(){
        $v = [
            'ref_id_reservation' => $this->id,
            'condition_inside'   => $this->conditionIn,
            'condition_outside'  => $this->conditionOut,
            'handover_fuel'      => $this->fuel,
            'date_created'       => DATE('Y-m-d H:i:s')
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->addRow($v, 'tb_handover');

            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function AddFileInToServer(){

        if(!empty($this->conditionInFile['name'][0])) {
            $r = $this->AddConditionAndFuelFile($this->conditionInFile, '3');
            if($r !== 'success'){
                return $r; 
            }
        }
        if(!empty($this->conditionOutFile['name'][0])){
            $r = $this->AddConditionAndFuelFile($this->conditionOutFile, '4');
            if($r !== 'success'){
                return $r; 
            } 
        }
        if(!empty($this->fuelFile['name'][0])){
            $r = $this->AddConditionAndFuelFile($this->fuelFile, '5');
            if($r !== 'success'){
                return $r; 
            } 
        }
        return 'success';
    }

    public function AddConditionAndFuelFile($img, $type){

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $PathImg = getPathImg(Setting::$PathImg);

            $i = count($img['name']) - 1; 
            for($c = 0; $c <= $i ; $c++){
                $nImg = array(
                    'tmp_name' => $img['tmp_name'][$c],
                    'name'     => $img['name'][$c],
                    'size'     => $img['size'][$c],
                    'type'     => $img['type'][$c]
                );
                $imageName = $obj->uploadPhoto($nImg, "../../dist/temp_img/". $PathImg . "/");
                $value = [
                    'ref_id_reservation' => $this->id,
                    'attachment'         => $imageName,
                    'attachment_type'    => $type,
                    'date_uploaded'      => date("Y-m-d")
                ];
                $result = $obj->addRow($value, "tb_attachment");
                if(is_numeric($result))
                    continue;
                else
                    return $result; 
            }
            return 'success';
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function AddExpense(){
        $file = $this->expenseFile;
        $i = count($this->expense)-1;
        $expense = $this->expense;
        for($c = 0; $c <= $i ; $c++){
            if(IsNullOrEmptyString($expense[$c]['expenseAmount'])) // เช็คว่าค่าที่ใช้จ่ายที่รับมาว่างไหม
                continue;
            $test[] = $expense[$c]['expense'];
            $Img = NULL;
    
            if(!empty($file['name'][$c])){ // เช็คว่ามีรูปไหม
                $nImg = array(
                    'tmp_name' => $file['tmp_name'][$c],
                    'name'     => $file['name'][$c],
                    'size'     => $file['size'][$c],
                    'type'     => $file['type'][$c]
                );
                $Img = $this->AddFileExpense($nImg);
                if(!is_numeric($Img))
                        return $Img;
            }
            $v = [
                'ref_id_reservation' => $this->id,
                'ref_id_expense'     => $expense[$c]['expense'],
                'ref_id_attachment'  => $Img,
                'amount_expense'     => $expense[$c]['expenseAmount']
             ];
             $id = $this->AddRefExpense($v);
             if(!is_numeric($id))
                return $id;
        }
        return $id;
    }

    public function AddFileExpense($file){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $PathImg = getPathImg(Setting::$PathImg);

            $imageName = $obj->uploadPhoto($file, "../../dist/temp_img/". $PathImg . "/");
            $value = [
                'ref_id_reservation' => $this->id,
                'attachment'         => $imageName,
                'attachment_type'    => 6,
                'date_uploaded'      => date("Y-m-d")
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
    }

    public function AddRefExpense($data){
        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $result = $obj->addRow($data, "tb_ref_expense");
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