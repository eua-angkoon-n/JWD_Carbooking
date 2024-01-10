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
    // public $start;
    // public $end;
    // public $vehicle;
    // public $status;
    
    public function __construct($formData,$TableSET){
        parent::__construct($TableSET); //ส่งค่าไปที่ DataTable Class

        // parse_str($formData, $data);
       
        // convertDateDMY($data['res_date'], $this->start, $this->end);
        // $this->status = $data['res_date'];
        // $this->vehicle = $data['res_vehicle'];
    }   
    public function getTable(){
        // return $this->end;
        return $this->SqlQuery();
    }

    public function SqlQuery(){
        $sql      = $this->getSQL(true);
        $sqlCount = $this->getSQL(false);
        // return $sql;
        try {
            $con = connect_database('e-service');
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
        // $vehicle = $this->chkVehicle();
        // $date = $this->chkDate();

        if($OrderBY){
            $sql = "SELECT * ";
            
        } else {
            $sql  = "SELECT count(tb_user.id_user) AS total_row ";
        }
        $sql .= "FROM tb_user ";
        $sql .= "LEFT JOIN tb_site ON (tb_user.ref_id_site = tb_site.id_site) ";
        $sql .= "LEFT JOIN tb_dept ON (tb_user.ref_id_dept = tb_dept.id_dept) ";
        $sql .= "WHERE 1=1 ";
        $sql .= "AND tb_user.ref_id_site IN (".$_SESSION['car_ref_id_site'].", 99) ";

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
                
                $id      = $fetchRow[$key]['id_user'];
                $checked = ($fetchRow[$key]['status_user']==1 ? 'checked value="1" disabled' : 'value="2" disabled ');
                // $date    = getDateString($fetchRow[$key]['start_date'], $fetchRow[$key]['end_date']);
                // $status  = ResStatusTable($fetchRow[$key]['reservation_status']);
                $control = $this->Div($id, '', 'control');
                $status  = $this->Div($id, $checked, 'status');
                // $fetchRow[$key]['accessories'] == 1 ? $acc = getAcc($fetchRow[$key]['id_reservation']) : $acc = "ไม่มี";

                $dataRow = array();
                $dataRow[] = "<h6 class='text-center'>$No.</h6>";
                $dataRow[] = ($fetchRow[$key]['no_user'] == '' ? '-' : $fetchRow[$key]['no_user']);
                $dataRow[] = ($fetchRow[$key]['email'] == '' ? '-' : $fetchRow[$key]['email']);
                $dataRow[] = ($fetchRow[$key]['fullname'] == '' ? '-' : $fetchRow[$key]['fullname']);
                $dataRow[] = $_SESSION['car_site_initialname'];
                $dataRow[] = ($fetchRow[$key]['dept_initialname'] == '' ? '-' : $fetchRow[$key]['dept_initialname']);
                $dataRow[] = $this->getUserClass($id);
                $dataRow[] = "<h6 class='text-center'>$status</h6>";
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

    public function Div($id, $checked, $div){

        if($div == 'status'){
            $result  = "<div class='check-status custom-control custom-switch custom-switch-on-success custom-switch-off-danger d-inline'>";
            $result .= "<input type='checkbox' class='custom-control-input' data-id='$id' id='customSwitch$id' $checked>";
            $result .= "<label class='custom-control-label custom-control-label' for='customSwitch$id'></label>";
            $result .= "</div>";
        } else if ($div == 'control'){
            $result  = "<button type='button' class='btn btn-warning btn-sm edit-vehicle_brand' data-id='$id' data-toggle='modal' data-target='#modal-vehicle_brand' id='edit-data' data-backdrop='static' data-keyboard='false' title='แก้ไขข้อมูล'>";
            $result .= "<i class='fa fa-pencil-alt'></i>";
            $result .= "</button>";
        }
        return $result;
    }

    public function getUserClass($id) {
        $sql  = "SELECT * ";
        $sql .= "FROM tb_user_carbooking ";
        $sql .= "WHERE ref_id_user = $id ";
        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $row = $obj->customSelect($sql);

            if(empty($row)){
                return Setting::$classArr[0];
            } else {
                return Setting::$classArr[$row['class_user']];
            }
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
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
    'email','fullname','no_user','dept_initialname','dept_name'
);

switch($action){
    default:
        $DataTableCol = array( 
            0 => "id_user",
            1 => "id_user",
            2 => "no_user",
            3 => "email",
            4 => "fullname",
            5 => "site_initialname",
            6 => "dept_initialname",
            7 => "id_user",
            8 => "id_user",
            9 => "id_user",
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