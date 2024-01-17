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
    public $vehicle;
    // public $status;
    
    public function __construct($formData,$TableSET){
        parent::__construct($TableSET); //ส่งค่าไปที่ DataTable Class

        parse_str($formData, $data);
       
        convertDateRange($data['res_date'], $this->start, $this->end);
        $this->vehicle = $data['res_vehicle'];
    }   
    public function getTable(){
        // return $this->start;
        return $this->SqlQuery();
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

        // $status = $this->chkStatus();
        $vehicle = $this->chkVehicle();
        $date = $this->chkDate();

        if($OrderBY){
            $sql = "SELECT * ";
            
        } else {
            $sql  = "SELECT count(tb_reservation.id_reservation) AS total_row ";
        }
        $sql .= "FROM tb_reservation ";
        $sql .= "LEFT JOIN tb_vehicle ON (tb_vehicle.id_vehicle = tb_reservation.ref_id_vehicle) ";
        $sql .= "LEFT JOIN tb_attachment ON (tb_attachment.id_attachment = tb_vehicle.ref_id_attachment) ";
        $sql .= "LEFT JOIN tb_coordinates ON (tb_coordinates.ref_id_reservation = tb_reservation.id_reservation) ";
        $sql .= "LEFT JOIN tb_driver ON (tb_driver.id_driver = tb_reservation.ref_id_driver) ";
        $sql .= "WHERE ";
        $sql .= "reservation_status = 0 ";
        $sql .= "AND tb_reservation.ref_id_site=".$_SESSION['car_ref_id_site']." ";
        $sql .= "$vehicle ";
        $sql .= "$date ";

        $sql .= "$this->query_search ";
        if($OrderBY) {
            $sql .= "ORDER BY ";
            $sql .= "$this->orderBY ";
            $sql .= "$this->dir ";
            $sql .= "$this->limit ";
        }

        return $sql;
    }

    public function chkVehicle(){
        $r = "";
        if(!IsNullOrEmptyString($this->vehicle)) {
            $r = "AND ref_id_vehicle=$this->vehicle ";
        }
        return $r;
    }
    
    public function chkDate(){
        $r = "";
        if(!IsNullOrEmptyString($this->start) && !IsNullOrEmptyString($this->end)) {
            $r .= "AND start_date < '$this->end' ";
            $r .= "AND end_date > '$this->start' ";
        }
        return $r;
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

                
                // $status = $this->chkStatus($fetchRow[$key]['reservation_status'], $fetchRow[$key]['id_vehicle'], $control);
                $username= getUserName($fetchRow[$key]['ref_id_user']);
                $date    = getDateString($fetchRow[$key]['start_date'], $fetchRow[$key]['end_date']);
                $status  = ResStatusTable($fetchRow[$key]['reservation_status'], $fetchRow[$key]['urgent']);
                $control = $this->getControl($fetchRow[$key]['id_reservation']);
                $fetchRow[$key]['accessories'] == 1 ? $acc = getAcc($fetchRow[$key]['id_reservation']) : $acc = "ไม่มี";

                $dataRow = array();
                $dataRow[] = "<h6 class='text-center'>$No.</h6>";
                $dataRow[] = "<img src='dist/temp_img/$img' alt='Vehicle Image' class='rounded img-thumbnail mx-auto d-block p-0 w-100' style='width=200px'>";
                $dataRow[] = ($fetchRow[$key]['vehicle_name'] == '' ? '-' : $fetchRow[$key]['vehicle_name']);
                $dataRow[] = $username;
                $dataRow[] = ($fetchRow[$key]['traveling_companion'] == '' ? '-' : implode("<br>", explode(", ", $fetchRow[$key]['traveling_companion'])) );
                $dataRow[] = ($fetchRow[$key]['driver_name'] == '' ? '-' : wordwrap($fetchRow[$key]['driver_name'], 15, "<br>\n"));
                $dataRow[] = $date;
                $dataRow[] = $status;
                $dataRow[] = "<h6 class='text-center'>$control</h6>";
    
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


    public function getControl($id){

        // $result  = "<div class='btn-group dropdown'>";
        // $result .= "<button type='button' class='btn btn-success dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>จัดการ</button>";
        // $result .= "<div class='dropdown-menu' style='margin-left:-4rem;'>";
        // $result .= "<a class='dropdown-item ' data-id='$id' id='' title='อนุมัติ'><i class='fas fa-pencil-alt'></i> อนุมัติ</a>";
        // $result .= "<a class='dropdown-item ' data-id='$id' id='' title='อนุมัติ'><i class='fas fa-pencil-alt'></i> อนุมัติ</a>";
        // $result .= "</div></div>";

        $result  = "<button type='button' class='btn btn-success btn-approve text-center' data-id='$id'  id='btn-approve' title='อนุมัติ'>";
        $result .= "<i class='fa fa-stamp'></i><span> อนุมัติ</span>";
        $result .= "</button> ";    
        $result .= "<button type='button' class='btn btn-danger btn-noApprove text-center mr-1' data-id='$id'  id='btn-noApprove' title='ไม่อนุมัติ'>";
        $result .= "<i class='fa fa-times-circle'></i><span> ไม่อนุมัติ</span>";
        $result .= "</button>";
        $result .= "<button type='button' class='btn btn-info detailReservation text-center' data-id='$id'  id='detailReservation' title='รายละเอียด'>";
        $result .= "<i class='fa fa-info-circle'></i> ";
        $result .= "</button>";
        return $result;
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
    'vehicle_name','start_date','end_date','place_name','traveling_companion'
);

switch($action){
    default:
        $DataTableCol = array( 
            0 => "tb_reservation.id_reservation",
            1 => "tb_reservation.id_reservation",
            2 => "tb_vehicle.id_vehicle",
            3 => "tb_vehicle.vehicle_name",
            4 => "tb_reservation.traveling_companion",
            5 => "tb_coordinates.place_name",
            6 => "tb_reservation.accessories",
            7 => "tb_reservation.start_date",
            8 => "reservation_status",
            9 => "reservation_status",
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
    default:
        $Call   = new DataTable($_POST['formData'],$dataGet);
        $result = $Call->getTable(); 
    break;
}
// print_r($_POST['formData']);
// exit;
///////////////////////////////////////////////////////////////////////////////////

echo json_encode($result);
exit;
?>