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

// echo json_encode($_POST['id']);
// exit();

switch ($action) {
    case 'edit': //แก้ไขการจอง
        $Call   = new Reservation_Edit($_POST['data']);
        $Data   = $Call->getData();
        $Result = $Data;
        break;
    case 'edit-mile': //แก้ไขการจอง
        $Call   = new Mile_Edit($_POST['id'], $_POST['out'], $_POST['in'], $_POST['vehicle']);
        $Data   = $Call->update_mile();
        $Result = json_encode($Data);
        break;
}

print_r($Result);
exit;

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
            'ref_id_user_edited' => $_SESSION['car_ref_id_site'],
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

Class Mile_Edit {
    protected $id;
    protected $out;
    protected $in;
    protected $vehicle;
    public function __construct($id, $out, $in, $vehicle){
        $this->id  = $id;
        $this->out = $out;
        $this->in  = !IsNullOrEmptyString($in) ? $in : false;
        $this->vehicle = $vehicle;
    }

    public function update_mile(){
        if($this->in && $this->out >= $this->in)
            return array('response' => 'err1');
        $canUpdate = $this->chkMileBefore($idBefore);
        if(!$canUpdate)
            return array('response' => 'err2', 'data1' => $idBefore);
        return $this->updateMile();
    }

    private function chkMileBefore(&$idBefore){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_mile ";
        $sql .= "LEFT JOIN tb_reservation ON (tb_reservation.id_reservation = tb_mile.ref_id_reservation) ";
        $sql .= "WHERE id_mile < $this->id ";
        $sql .= "AND ref_id_vehicle=$this->vehicle ";
        $sql .= "AND mile_out IS NOT NULL ";
        $sql .= "ORDER BY id_mile DESC ";
        $sql .= "LIMIT 1 ";

        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $row = $obj->customSelect($sql);

            if(empty($row))
                return true;
            if($row['mile_in'] > $this->out) {
                $idBefore = $row['id_reservation'];
                return false;
            }
            return true;

        } catch (\Exception $e) {
            return "Error:" . $e->getMessage();
        } catch (\PDOException $e) {
            return "Database Error:" . $e->getMessage();
        } finally {
            $con = null;
        }

        
    }

    private function updateMile(){
        $data = [
            'mile_out' => $this->out,
            'mile_in'  => !$this->in ? null : $this->in
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $row = $obj->update($data, "id_mile=".$this->id, 'tb_mile');

            if($row == 'Success')
                return array('response' => 'success');
            else 
                return array('response' => 'err3', 'data1' => $row);
        } catch (\Exception $e) {
            return "Error:" . $e->getMessage();
        } catch (\PDOException $e) {
            return "Database Error:" . $e->getMessage();
        } finally {
            $con = null;
        }
    }
}