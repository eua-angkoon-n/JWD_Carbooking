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
           $sql  = "SELECT count(id_acc) AS total_row ";
       $sql .= "FROM tb_accessories ";
       $sql .= "WHERE 1=1 ";
       // $sql .= "ref_id_site = '".$_SESSION['site']."' "; 
    
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
                $id      = $fetchRow[$key]['id_acc'];
                $checked = ($fetchRow[$key]['acc_status']==1 ? 'checked value="1" disabled' : ' disabled ');

                $dataRow = array();
                $dataRow[] = $No . '.';
              
                $dataRow[] = ($fetchRow[$key]['acc_name'] == '' ? '-' : $fetchRow[$key]['acc_name']);
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
            $result  = "<div class='btn-group dropdown'>";
            $result .= "<button type='button' class='btn btn-success dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>จัดการ</button>";
            $result .= "<div class='dropdown-menu' style='margin-left:-4rem;'>";
            $result .= "<a class='dropdown-item edit-vehicle_acc' data-id='$id' data-toggle='modal' data-target='#modal-vehicle_acc' data-backdrop='static' data-keyboard='false' title='แก้ไขข้อมูล'>";
            $result .= "<i class='fas fa-pencil-alt'></i> แก้ไขข้อมูล</a>";
            $result .= "</div></div>";
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
    0 => "tb_accessories.id_acc",
    1 => "tb_accessories.id_acc",
    2 => "tb_accessories.acc_name",
    3 => "tb_accessories.acc_status",
);
$DataTableSearch = array(
    "acc_name",
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
// print_r($result);
echo json_encode($result);
exit;
?>