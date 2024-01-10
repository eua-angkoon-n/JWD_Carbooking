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
    
    public function __construct($formData,$TableSET){
        parent::__construct($TableSET); //ส่งค่าไปที่ DataTable Class
    }
    public function getTable(){
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
       if($OrderBY)
           $sql  = "SELECT * ";
       else
           $sql  = "SELECT count(id_vehicle) AS total_row ";
       $sql .= "FROM tb_vehicle ";
       $sql .= "LEFT JOIN tb_attachment ON (tb_vehicle.ref_id_attachment = tb_attachment.id_attachment) ";
       $sql .= "LEFT JOIN tb_vehicle_type ON  (tb_vehicle.ref_id_vehicle_type = tb_vehicle_type.id_vehicle_type) ";
       $sql .= "LEFT JOIN tb_vehicle_brand ON  (tb_vehicle.ref_id_vehicle_brand = tb_vehicle_brand.id_vehicle_brand) ";
       $sql .= "WHERE 1=1 ";
       $sql .= "AND ref_id_site = ".$_SESSION['car_ref_id_site']." "; 
    
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
                $id      = $fetchRow[$key]['id_vehicle'];
                $checked = ($fetchRow[$key]['vehicle_status']==1 ? 'checked value="1" disabled' : ' disabled ');
                if(!empty($fetchRow[$key]['vehicle_reg_date'])){
                    $dateString = $fetchRow[$key]['vehicle_reg_date'];
                    $dateObj = DateTime::createFromFormat('Y-m-d', $dateString);
                    $formattedDate = $dateObj->format('d/m/Y');
                }
                $folderDate = str_replace("-", "", $fetchRow[$key]['date_uploaded']);
                $img =  $folderDate . "/" . $fetchRow[$key]['attachment'];

                $dataRow = array();
                $dataRow[] = $No . '.';
                $dataRow[] = "<img src='dist/temp_img/$img' alt='Vehicle Image' class='img-thumbnail rounded mx-auto d-block'>";
                $dataRow[] = ($fetchRow[$key]['vehicle_name'] == '' ? '-' : $fetchRow[$key]['vehicle_name']);
                $dataRow[] = ($fetchRow[$key]['vehicle_reg_date'] == '' ? '-' : $formattedDate );
                $dataRow[] = ($fetchRow[$key]['vehicle_type'] == '' ? '-' : $fetchRow[$key]['vehicle_type']);
                $dataRow[] = ($fetchRow[$key]['vehicle_brand'] == '' ? '-' : $fetchRow[$key]['vehicle_brand']);
                $dataRow[] = ($fetchRow[$key]['vehicle_seat'] == '' ? '-' : $fetchRow[$key]['vehicle_seat']);
                $dataRow[] = $this->Div($id, $checked, 'status');
                $dataRow[] = $this->Div($id, $checked, 'control');
    
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
            $result  = "<button type='button' class='btn btn-success btn-sm view-vehicle mr-1' data-id='$id' data-toggle='modal' data-target='#modal-view' id='viewData' data-backdrop='static' data-keyboard='false' title='ดูข้อมูล'>";
            $result .= "<i class='fa fa-file-alt'></i>";
            $result .= "</button>";
            $result .= "<button type='button' class='btn btn-warning btn-sm edit-vehicle' data-id='$id' data-toggle='modal' data-target='#modal-vehicle' id='edit-data' data-backdrop='static' data-keyboard='false' title='แก้ไขข้อมูล'>";
            $result .= "<i class='fa fa-pencil-alt'></i>";
            $result .= "</button>";
        }
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

$DataTableCol = array( 
    0 => "tb_vehicle.id_vehicle",
    1 => "tb_vehicle.id_vehicle",
    2 => "tb_vehicle.id_vehicle",
    3 => "tb_vehicle.vehicle_name",
    4 => "tb_vehicle.vehicle_reg_date",
    5 => "tb_vehicle_type.vehicle_type",
    6 => "tb_vehicle_brand.vehicle_brand",
    7 => "tb_vehicle.vehicle_seat",
    8 => "tb_vehicle.vehicle_status",
    9 => "tb_vehicle.id_vehicle",

);
$DataTableSearch = array(
    "vehicle_name",
    "vehicle_type",
    "vehicle_brand",
    "vehicle_reg_date",
    "vehicle_seat",
);

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
///////////////////////////////////////////////////////////////////////////////////
//  echo 'asdasd';
$Call   = new DataTable($_POST['formData'],$dataGet);
$result = $Call->getTable(); 
// print_r(json_encode($result));
echo json_encode($result);
exit;
?>