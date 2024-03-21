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
    public $status;
    
    public function __construct($TableSET){
        parent::__construct($TableSET); //ส่งค่าไปที่ DataTable Class
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


        if($OrderBY){
            $sql = "SELECT * ";
            
        } else {
            $sql  = "SELECT count(tb_reservation.id_reservation) AS total_row ";
        }
        $sql .= "FROM tb_reservation ";
        $sql .= "LEFT JOIN tb_vehicle ON (tb_vehicle.id_vehicle = tb_reservation.ref_id_vehicle) ";
        $sql .= "LEFT JOIN tb_attachment ON (tb_attachment.id_attachment = tb_vehicle.ref_id_attachment) ";
        $sql .= "LEFT JOIN tb_coordinates ON (tb_coordinates.ref_id_reservation = tb_reservation.id_reservation) ";
        $sql .= "WHERE reservation_status=4 ";
        $sql .= "AND ref_id_user=".$_SESSION['car_id_user']." ";

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
                $folderDate = str_replace("-", "", $fetchRow[$key]['date_uploaded']);
                $img =  $folderDate . "/" . $fetchRow[$key]['attachment'];

                
                // $status = $this->chkStatus($fetchRow[$key]['reservation_status'], $fetchRow[$key]['id_vehicle'], $control);
                $date    = getDateString($fetchRow[$key]['start_date'], $fetchRow[$key]['end_date']);
                $status  = ResStatusTable($fetchRow[$key]['reservation_status']);
                $control = $this->getControl($fetchRow[$key]['id_reservation'], $fetchRow[$key]['reservation_status']);


                $dataRow = array();
                $dataRow[] = "<h6 class='text-center'>$No.</h6>";
                $dataRow[] = "<img src='dist/temp_img/$img' alt='Vehicle Image' class='rounded img-thumbnail mx-auto d-block p-0 w-100' style='width=200px'>";
                $dataRow[] = ($fetchRow[$key]['vehicle_name'] == '' ? '-' : $fetchRow[$key]['vehicle_name']);
                $dataRow[] = ($fetchRow[$key]['ref_id_driver'] == '' ? '-' : getDriver($value['ref_id_driver']));
                $dataRow[] = ($fetchRow[$key]['traveling_companion'] == '' ? '-' : implode("<br>", explode(", ", $fetchRow[$key]['traveling_companion'])) );
                $dataRow[] = ($fetchRow[$key]['place_name'] == '' ? '-' : wordwrap($fetchRow[$key]['place_name'], 50, "<br>\n"));
                $dataRow[] = $date;
                $dataRow[] = $this->chkMile($value['id_reservation']);
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

    protected function chkMile($id){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_mile ";
        $sql .= "WHERE ref_id_reservation=$id ";

        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $Row = $obj->customSelect($sql);
            
            if(empty($Row)) return "-";

           
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
        $out = IsNullOrEmptyString($Row['mile_out']) ? "-" : $Row['mile_out']; 
        $in = IsNullOrEmptyString($Row['mile_in']) ? "-" : $Row['mile_in']; 

        $r = "<b>ออก</b>&nbsp;: $out<br>";
        $r .="<b>เข้า</b> &nbsp;: $in";

        return $r;
    }

    public function getControl($id, $status){

        $result  = "<button type='button' class='btn btn-success detailReservation text-center' data-id='$id'  id='detailReservation' title='ส่งมอบ'>";
        $result .= "<i class='fa fa-flag-checkered'></i><span> ส่งมอบ</span>";
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
            6 => "tb_reservation.start_date",
            7 => "reservation_status",
            8 => "reservation_status",
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
        $Call   = new DataTable($dataGet);
        $result = $Call->getTable(); 
    break;
}
// print_r($_POST['formData']);
// exit;
///////////////////////////////////////////////////////////////////////////////////

echo json_encode($result);
exit;
?>