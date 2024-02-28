<?PHP
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . "/../../../../../config/connectDB.php";
require_once __DIR__ . "/../../../../../config/setting.php";

require_once __DIR__ . "/../../../../../tools/crud.tool.php";
require_once __DIR__ . "/../../../../../tools/function.tool.php";

require_once __DIR__ . "/../../../../../app/Class/datatable_processing.php";

Class DataTable extends TableProcessing {
    public $start;
    public $end;
    public $vehicle;
    public $radio;
    // public $status;
    
    public function __construct($formData,$TableSET){
        parent::__construct($TableSET); //ส่งค่าไปที่ DataTable Class

        parse_str($formData, $data);

        $date = DateTime::createFromFormat('d/m/Y', $data['date_start']);
        $this->start = $date ? $date->format('Y-m-d') : null;

        $this->radio = $data['r1'];
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
        $sql .= "WHERE reservation_status=3 ";
        $sql .= "AND tb_reservation.ref_id_site=".$_SESSION['car_ref_id_site']." ";
        $sql .= "$vehicle ";
        if($this->radio == 1){
            $sql .= "$date ";
        }

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
        if(!IsNullOrEmptyString($this->start)) {
            $r .= "AND DATE(start_date) = '$this->start' ";
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
                $date    = $this->getDateString($fetchRow[$key]['end_date']);
                $status  = ResStatusTable($fetchRow[$key]['reservation_status']);
                $control = $this->getControl($fetchRow[$key]['id_reservation'], getDateString2($fetchRow[$key]['start_date'], $fetchRow[$key]['end_date']), $fetchRow[$key]['vehicle_name']);

                $dataRow = array();
                $dataRow[] = "<h6 class='text-center'>$No.</h6>";
                $dataRow[] = $control;
                $dataRow[] = "<div class='text-center'><img src='../dist/temp_img/$img' alt='Vehicle Image' class='rounded img-thumbnail mx-auto d-block p-0 w-100' style='width=200px'></div>";
                $dataRow[] = "<div class='text-center'>".($fetchRow[$key]['vehicle_name'] == '' ? '-' : $fetchRow[$key]['vehicle_name'])."</div>";
                $dataRow[] = getUserName($fetchRow[$key]['ref_id_user']);
                $dataRow[] = $value['ref_id_driver'] ?? "-";
                $dataRow[] = implode("<br>", explode(", ", $fetchRow[$key]['traveling_companion']));
                $dataRow[] = $date;
        
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

    public function getDateString($date){
        $txtdate = convertToThaiDate($date);
        $s  = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        $sd = $s->format('H:i');

        if (strtotime($sd) >= strtotime('00:00') && strtotime($sd) < strtotime('12:00')) {
            $r = "<span class='badge badge-warning' style='font-size:100%'>$txtdate<br>$sd น.</span>";
        } else {
            $r = "<span class='badge badge-success' style='font-size:100%'>$txtdate<br>$sd น.</span>";
        }
        return $r;
    }

    public function getControl($id, $date, $vehicle){
        $result = "<div class='text-center'><button type='button' style='background-color:#F15C22;color:#EEEEEE' class='btn text-center modalMile' data-id='$id' data-datetext='$date' data-vehicle='$vehicle' data-toggle='modal' data-target='#modal-mile' data-backdrop='static' data-keyboard='false' id='modalMile' title='บันทึกเลขไมล์'>";
        $result .= "<i class='fa fa-save'></i><span> บันทึกเลขไมล์</span> ";
        $result .= "</button></div>";
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
    'vehicle_name', 'traveling_companion', 'end_date'
);

switch($action){
    default:
        $DataTableCol = array( 
            0 => "tb_reservation.id_reservation",
            1 => "tb_reservation.id_reservation",
            2 => "tb_reservation.id_reservation",
            3 => "tb_vehicle.id_vehicle",
            4 => "tb_vehicle.vehicle_name",
            5 => "tb_reservation.ref_id_user",
            6 => "tb_reservation.traveling_companion",
            7 => "tb_reservation.end_date",
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