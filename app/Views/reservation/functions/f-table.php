<?PHP
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . "/../../../../config/connectDB.php";
require_once __DIR__ . "/../../../../config/setting.php";

require_once __DIR__ . "/../../../../tools/crud.tool.php";
require_once __DIR__ . "/../../../../tools/function.tool.php";

require_once __DIR__ . "/../../../Class/datatable_processing.php";

Class DataTable extends TableProcessing {
    public $start;
    public $end;
    public $radio;
    
    public function __construct($formData,$TableSET){
        parent::__construct($TableSET); //ส่งค่าไปที่ DataTable Class

        parse_str($formData, $data);

        // $date = $this->formatDateTime($data['date_select'], $data['time_start'], $data['time_end']);

        $this->start = $this->formatDate($data['date_start'], $data['time_start']);
        $this->end = $this->formatDate($data['date_end'], $data['time_end']);
        // $this->end   = $data['end'];
        $this->radio = $data['radio_value'];
    }
    public function getTable(){
        // return $this->start;
        return $this->SqlQuery();
    }

    public function formatDate($date, $time) {
        // Convert date to YYYY-MM-DD format
        $dateTime = DateTime::createFromFormat('m/d/Y H:i', $date . ' ' . $time);

        // Format DateTime object into the desired format
        $formatted_datetime = $dateTime->format('Y-m-d H:i:s');
    
        return $formatted_datetime;
    }
    

    public function SqlQuery(){
        $sql      = $this->getSQL(true);
        $sqlCount = $this->getSQL(false);
        // return $sql;

        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $fetchRow = $obj->fetchRows($sql);
            $numRow   = $obj->getCount($sqlCount);
            // return $fetchRow;

            $Result   = $this->createArrayDataTable($fetchRow, $numRow);
            
            return $Result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getSQL(bool $OrderBY){

       if($OrderBY){
            $sql = $this->chkModeRadio(true);
          
       } else {
            $sql  = "SELECT count(tb_vehicle.id_vehicle) AS total_row ";
       }
        $sql .= "FROM tb_vehicle ";
        $sql .= $this->chkModeRadio();
     
        
       $sql .= "$this->query_search ";
       if($OrderBY) {
           $sql .= "ORDER BY ";
           $sql .= "$this->orderBY ";
           $sql .= "$this->dir ";
           $sql .= "$this->limit ";
       }

       return $sql;
    }

    
    public function chkModeRadio($Select = false){
        if($Select){
            $result   = "SELECT tb_attachment.attachment, tb_attachment.date_uploaded, tb_vehicle.id_vehicle, tb_vehicle.vehicle_name, tb_vehicle_type.vehicle_type, tb_vehicle.vehicle_seat, tb_reservation.start_date, tb_reservation.end_date ";
            if($this->radio == 'rAll'){
             $result .= ", CASE ";
             $result .= "       WHEN tb_reservation.id_reservation IS NOT NULL THEN 'ไม่ว่าง' ";
             $result .= "       ELSE 'ว่าง' ";
             $result .= "  END AS reservation_status ";
            }
            return $result;
        }

        $mode  = $this->radio;
        $start = $this->start;
        $end   = $this->end;

        $result  = "LEFT JOIN tb_reservation ON tb_reservation.ref_id_vehicle = tb_vehicle.id_vehicle ";
        $result .= "AND ( ";
        $result .= "    tb_reservation.start_date < '$end' ";
        $result .= "    AND tb_reservation.end_date > '$start' ";
        $result .= "    AND tb_reservation.reservation_status NOT IN (2,4,5) ";
        $result .= ") ";
        switch($mode){
            case 'rFree':
                $result .= "LEFT JOIN db_carbooking.tb_vehicle_type ON (tb_vehicle.ref_id_vehicle_type = tb_vehicle_type.id_vehicle_type) ";
                $result .= "LEFT JOIN db_carbooking.tb_attachment ON (tb_vehicle.ref_id_attachment = tb_attachment.id_attachment) ";
                $result .= "WHERE tb_vehicle.vehicle_status = 1 AND ";
                $result .= "tb_reservation.id_reservation IS NULL ";
                break;
            case 'rNotFree':
                $result .= "LEFT JOIN db_carbooking.tb_vehicle_type ON (tb_vehicle.ref_id_vehicle_type = tb_vehicle_type.id_vehicle_type) ";
                $result .= "LEFT JOIN db_carbooking.tb_attachment ON (tb_vehicle.ref_id_attachment = tb_attachment.id_attachment) ";
                $result .= "WHERE tb_vehicle.vehicle_status = 1 AND ";
                $result .= "tb_reservation.id_reservation IS NOT NULL ";
                break;
            case 'rAll':
                $result .= "LEFT JOIN db_carbooking.tb_vehicle_type ON (tb_vehicle.ref_id_vehicle_type = tb_vehicle_type.id_vehicle_type) ";
                $result .= "LEFT JOIN db_carbooking.tb_attachment ON (tb_vehicle.ref_id_attachment = tb_attachment.id_attachment) ";
                $result .= "WHERE tb_vehicle.vehicle_status = 1 ";
                break;
        }
        $result .= "AND tb_vehicle.ref_id_site=".$_SESSION['car_ref_id_site']." ";
        return $result;
    }
    
    public function createArrayDataTable($fetchRow, $numRow){

        $arrData = null;
        $output = array(
            "draw" => intval($this->draw),
            "recordsTotal" => intval(0),
            "recordsFiltered" => intval(0),
            "data" => $arrData,
        );

        if (count($fetchRow) > 0) {
            $No = ($numRow - $this->pStart);
            foreach ($fetchRow as $key => $value) {
                $folderDate = str_replace("-", "", $fetchRow[$key]['date_uploaded']);
                $img =  $folderDate . "/" . $fetchRow[$key]['attachment'];

                // if(!empty($fetchRow[$key]['start_date']) && !empty($fetchRow[$key]['end_date'])){
                //     $date = formatDates($fetchRow[$key]['start_date'], $fetchRow[$key]['end_date']);
                // } else {
                //     $date = '';
                // }
                $status = $this->chkStatus($fetchRow[$key]['reservation_status'], $fetchRow[$key]['id_vehicle'], $control);

                $dataRow = array();
                $dataRow[] = "<img src='dist/temp_img/$img' alt='Vehicle Image' class='rounded mx-auto d-block' style='width:150px;'>";
                $dataRow[] = ($fetchRow[$key]['vehicle_name'] == '' ? '-' : $fetchRow[$key]['vehicle_name']);
                $dataRow[] = ($fetchRow[$key]['vehicle_type'] == '' ? '-' : $fetchRow[$key]['vehicle_type']);
                $dataRow[] = "<h6 class='text-center'>".($fetchRow[$key]['vehicle_seat'] == '' ? '-' : $fetchRow[$key]['vehicle_seat'])."</h6>";
                $dataRow[] = $status;
                $dataRow[] = "<h6 class='text-center'>".$control."</h6>";
    
                $arrData[] = $dataRow;
                $No--;
            }
        }

        $output = array(
            "draw" => intval($this->draw),
            "recordsTotal" => intval($numRow),
            "recordsFiltered" => intval($numRow),
            "data" => $arrData,
        );

        return $output;
    }

    public function chkStatus($status, $id_vehicle, &$c){
        if(empty($status)){
            $status = $this->radio;
        }
        switch ($status){
            case 'rFree':
            case 'ว่าง':
                $s  = "<h4 class='text-center'><span class='badge badge-success'>ว่าง</span></h4>";
                $c  = $this->Div($id_vehicle, 'free');
                break;
            case 'rNotFree':
            case 'ไม่ว่าง';
                $s  = "<h4 class='text-center'><span class='badge badge-danger'>ไม่ว่าง</span></h4>";
                $c  = $this->Div($id_vehicle, 'notFree');
                break;
        }
        return $s;
    }

    public function Div($id, $div){

        switch ($div){
            case 'free':
                $result  = "<button type='button' class='btn btn-primary doReservation text-center' data-id='$id' id='doReservation' data-backdrop='static' data-keyboard='false' title='จองยานพาหนะ'>";
                $result .= "<i class='fa fa-book'></i><span> จองยานพาหนะ</span>";
                $result .= "</button>";
                break;
            case 'notFree':
                $result  = "<button type='button' class='btn btn-info viewReservation text-center' data-id='$id' data-toggle='modal' data-target='#modal-view' id='viewReservation' data-backdrop='static' data-keyboard='false' title='รายละเอียด'>";
                $result .= "<i class='fa fa-info-circle'></i><span> รายละเอียด</span>";
                $result .= "</button>";
                break;
        }
        return $result;
    }
    
}

Class DataTable_ViewReservation extends TableProcessing {
    public $start;
    public $end;
    public $id;
    
    public function __construct($formData,$TableSET){
        parent::__construct($TableSET); //ส่งค่าไปที่ DataTable Class

        parse_str($formData, $data);

        $this->start = $this->formatDate($data['date_start'], $data['time_start']);
        $this->end = $this->formatDate($data['date_end'], $data['time_end']);
        $this->id = $data['id_row'];
    }
    public function getTable(){
        // return $this->start;
        return $this->SqlQuery();
    }

    public function formatDate($date, $time) {
        // Convert date to YYYY-MM-DD format
        $dateTime = DateTime::createFromFormat('m/d/Y H:i', $date . ' ' . $time);

        // Format DateTime object into the desired format
        $formatted_datetime = $dateTime->format('Y-m-d H:i:s');
    
        return $formatted_datetime;
    }
    

    public function SqlQuery(){
        $sql      = $this->getSQL(true);
        $sqlCount = $this->getSQL(false);
        // return $sql;

        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $fetchRow = $obj->fetchRows($sql);
            $numRow   = $obj->getCount($sqlCount);
            // return $fetchRow;

            $Result   = $this->createArrayDataTable($fetchRow, $numRow);
            
            return $Result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getSQL(bool $OrderBY){

        $id    = $this->id;
        $start = $this->start;
        $end   = $this->end;

       if($OrderBY){
            $sql = "SELECT * ";
          
       } else {
            $sql  = "SELECT count(tb_reservation.id_reservation) AS total_row ";
       }
        $sql .= "FROM tb_reservation ";
        $sql .= "WHERE ref_id_vehicle = $id ";
        $sql .= "AND start_date < '$end' ";
        $sql .= "AND end_date > '$start' ";
        $sql .= "AND tb_reservation.reservation_status NOT IN (2,4,5) ";
     
       $sql .= "$this->query_search ";
       if($OrderBY) {
           $sql .= "ORDER BY ";
           $sql .= "$this->orderBY ";
           $sql .= "$this->dir ";
           $sql .= "$this->limit ";
       }

       return $sql;
    }
    
    public function createArrayDataTable($fetchRow, $numRow){

        $arrData = null;
        $output = array(
            "draw" => intval($this->draw),
            "recordsTotal" => intval(0),
            "recordsFiltered" => intval(0),
            "data" => $arrData,
        );

        if (count($fetchRow) > 0) {
            $No = ($numRow - $this->pStart);
            foreach ($fetchRow as $key => $value) {
                $name = $this->getNameReservation($fetchRow[$key]['ref_id_site']);
                $time = formatDates($fetchRow[$key]['start_date'], $fetchRow[$key]['end_date']);

                $dataRow = array();
                $dataRow[] = $name;
                $dataRow[] = $time;
    
                $arrData[] = $dataRow;
                $No--;
            }
        }

        $output = array(
            "draw" => intval($this->draw),
            "recordsTotal" => intval($numRow),
            "recordsFiltered" => intval($numRow),
            "data" => $arrData,
        );

        return $output;
    }

    public function getNameReservation($id){

        $sql  = "SELECT fullname ";
        $sql .= "FROM tb_user ";
        $sql .= "WHERE id_user=$id ";

        try {
            $con = connect_database('login');
            $obj = new CRUD($con);

            $result = $obj->customSelect($sql);

            return $result['fullname'];
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


//////////////////////////////////////////////////////////////////////////////////
$column = $_POST['order']['0']['column'] + 1;
$search = $_POST["search"]["value"];
$start  = $_POST["start"];
$length = $_POST["length"];
$dir    = $_POST['order']['0']['dir'];
$draw   = $_POST["draw"];

$action = $_POST['action'];

$DataTableSearch = array(

);

switch($action){
    case 'viewReservation':
        $DataTableCol = array( 
            0 => "tb_reservation.id_reservation",
            1 => "tb_reservation.id_reservation",
            2 => "tb_reservation.id_reservation",
            3 => "tb_reservation.start_date"
        );
        break;
    default:
        $DataTableCol = array( 
            0 => "tb_vehicle.id_vehicle",
            1 => "tb_vehicle.id_vehicle",
            2 => "tb_vehicle.vehicle_name",
            3 => "tb_vehicle_type.vehicle_type",
            4 => "tb_vehicle.vehicle_seat",
            5 => "reservation_status",
            6 => "reservation_status",
        );
    break;
}

$dataGet = array(
    'column'     => $column,
    'search'     => $search,
    'length'     => $length,
    'start'      => $start,
    'dir'        => $dir,
    'draw'       => $draw,
    'dataCol'    => $DataTableCol,
    'dataSearch' => $DataTableSearch
);


switch($action) {
    case 'viewReservation':
        $Call   = new DataTable_ViewReservation($_POST['formData'],$dataGet);
        $result = $Call->getTable(); 
        break;
    default:
        $Call   = new DataTable($_POST['formData'],$dataGet);
        $result = $Call->getTable(); 
    break;
}
// print_r(($_POST));
// exit;
///////////////////////////////////////////////////////////////////////////////////

echo json_encode($result);
exit;
?>