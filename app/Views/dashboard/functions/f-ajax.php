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

// echo json_encode($_POST);
// exit();

switch ($action) {
    case 'calendar' :
        $Call   = new Calendar($_POST['mode']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;
    case 'side_card' :
        $Call   = new Side_Card();
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;
    case 'modal' :
        $Call   = new ModalCalendar($_POST['id']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;  
    case 'show_vehicle' :
        $Call   = new Show_Vehicle($_POST['id']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;  
}
print_r($Result);
exit;

Class Calendar {
    private $mode;
    public function __construct($mode){
        $this->mode = $mode;
    }
    public function getData(){
        $data =  $this->DoCalendar();
        // return $data;
        return $this->CreateArrCalendar($data);
    }

    public function DoCalendar(){
        $sql = $this->getSQL();
        // return $sql;
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

    public function getSQL(){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_reservation ";
        $sql .= "LEFT JOIN tb_vehicle ON (tb_vehicle.id_vehicle = tb_reservation.ref_id_vehicle) ";
        $sql .= "WHERE reservation_status <> 5 ";
        if (!empty($_SESSION['car_id_user'])) {
            if($this->mode == 'self'){
                $sql .= "AND tb_reservation.ref_id_user=".$_SESSION['car_id_user']." ";
            } else {
                $sql .= "AND tb_reservation.ref_id_site=".$_SESSION['car_ref_id_site']." ";
            }
        }
        return $sql;
    }

    public function CreateArrCalendar($data){
        $arr = array();
        foreach($data as $k => $v) {
            $start = explode(" ",$v['start_date']);
            $end   = explode(" ",$v['end_date']);
            if($start[0] == $end[0]){
                $endDate = 0;
            } else {
                $endDate = $v['end_date'];
            }
            $arr[] = array(
                'name' => getUserName($v['ref_id_user']),
                'color'=> $v['hex_color'],
                'start'=> $v['start_date'],
                'end'  => $endDate,
                'id'   => $v['id_reservation']
            );
        }
        return array(
            'calendar' => $arr,
            'list'     => $this->getListOVehicle()
        );
    }

    public function getListOVehicle(){
        $row = $this->getDataOfVehicle();
        // return $row;
        if(!$row)
            return '';

        $r = '';
        foreach ($row as $k => $v){
            $s = empty($_SESSION['car_id_user']) ? $v['site_initialname']." - " : "";

            $r .= "<button type='button' class='btn mr-1 mb-1 show_list_vehicle' data-id='".$v['id_vehicle']."' data-toggle='modal' data-target='#modal-list' style='background-color:".$v['hex_color'].";color:white'>";
            $r .= $s.$v['vehicle_name'];
            $r .= "</button>";
        }
        return $r;
    }

    public function getDataOfVehicle(){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_vehicle ";
        $sql .= "LEFT JOIN tb_site ON (tb_site.id_site = tb_vehicle.ref_id_site) ";
        $sql .= "WHERE vehicle_status=1 ";
        if (!empty($_SESSION['car_id_user'])) {
            $sql .= "AND ref_id_site=".$_SESSION['car_ref_id_site']." ";
        }

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->fetchRows($sql);

            if(empty($result))
                return false;
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

Class Side_Card {

    private $justUser;
    public function getData(){
        $q = $this->getQuery();
        if(empty($q)){
            $q = 0;
        }
        // return $q;
        if($q != 0){
            if($this->justUser){
                $c = $this->getCardUser($q);
            } else {
                $c = $this->getCardAdmin($q);
            }
        } else {
            $c = 0;
        }
        return array(
            'info' => $this->getTodayRes(),
            'card' => $c
        );
    }

    public function getQuery(){
        $sql = $this->getSQL();
        // return $sql;
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

    public function getSQL(){
        $this->justUser = false;

        if($_SESSION['car_class_user'] != 2 && $_SESSION['car_class_user'] != 1){
            $this->justUser = true;
            $sql  = "SELECT * ";
            $sql .= "FROM tb_reservation ";
            $sql .= "LEFT JOIN tb_vehicle ON (tb_vehicle.id_vehicle  = tb_reservation.ref_id_vehicle) ";
            $sql .= "LEFT JOIN tb_attachment ON (tb_attachment.id_attachment = tb_vehicle.ref_id_attachment) ";
            $sql .= "WHERE reservation_status=1 "; 
            $sql .= "AND ref_id_user = ".$_SESSION['car_id_user'] ." ";
        } else {
            $sql  = "SELECT * ";
            $sql .= "FROM tb_reservation ";
            $sql .= "LEFT JOIN tb_vehicle ON (tb_vehicle.id_vehicle  = tb_reservation.ref_id_vehicle) ";
            $sql .= "LEFT JOIN tb_attachment ON (tb_attachment.id_attachment = tb_vehicle.ref_id_attachment) ";
            $sql .= "WHERE reservation_status=0 ";
            $sql .= "AND tb_reservation.ref_id_site=".$_SESSION['car_ref_id_site']." ";
            $sql .= "ORDER BY start_date ASC ";
            $sql .= "LIMIT 5 "; 
        }

        return $sql;
       
    }

    public function getCardUser($q){
        $r = array();
        $prefix = PageSetting::$prefixController;
        foreach($q as $k => $v){
            $id         = $v['id_reservation'];
            $folderDate = str_replace("-", "", $v['date_uploaded']);
            $img        =  $folderDate . "/" . $v['attachment'];
            $name       = $v['vehicle_name'];
            $date       = getDateString2($v['start_date'], $v['end_date']);

            $r[] = array(
                'class'  => 'user',
                'prefix' => $prefix,
                'id'     => $id,
                'img'    => $img,
                'name'   => $name,
                'date'   => $date,
                'reason' => $v['reason']
            );
        }
        return $r;
    }

    public function getCardAdmin($q){
        $r = array();
        $prefix = PageSetting::$prefixController;
        foreach($q as $k => $v){
            $id         = $v['id_reservation'];
            $folderDate = str_replace("-", "", $v['date_uploaded']);
            $img        =  $folderDate . "/" . $v['attachment'];
            $name       = $v['vehicle_name']." (".getUserName($v['ref_id_user']).")";
            $date       = "เวลา: ".CustomDate($v['start_date'], 'Y-m-d H:i:s', 'd/m/Y H:i')."<br>"."ถึง: ".CustomDate($v['end_date'], 'Y-m-d H:i:s', 'd/m/Y H:i');

            $r[] = array(
                'class'  => 'admin',
                'prefix' => $prefix,
                'id'     => $id,
                'img'    => $img,
                'name'   => $name,
                'date'   => $date,
                'reason' => $v['reason']
            );
        }
        return $r;
    }

    public function getTodayRes(){
        $sql  = "SELECT id_reservation ";
        $sql .= "FROM tb_reservation ";
        $sql .= "WHERE DATE(start_date) = '".DATE('Y-m-d')."' ";
        $sql .= "AND tb_reservation.ref_id_site=".$_SESSION['car_ref_id_site']." ";

        // return $sql;

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->countAll($sql);

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

Class ModalCalendar {
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
        return $this->getArrData($Res, $User);
    }

    public function getResData(){
        $sql  = "SELECT tb_reservation.reservation_status, tb_reservation.id_reservation, tb_vehicle.vehicle_name, tb_reservation.start_date, tb_reservation.end_date, tb_reservation.ref_id_user, tb_coordinates.place_name, tb_coordinates.latitude, tb_coordinates.longitude, tb_coordinates.zoom, tb_reservation.traveling_companion, tb_reservation.reason,  tb_driver.driver_name, tb_attachment.attachment, tb_attachment.date_uploaded ";
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


    public function getArrData($MD, $Name){
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
            'attachment'      => $MD['attachment'],
            'date_attachment' => $MD['date_uploaded']

        );
    }

}

Class Show_Vehicle{
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
