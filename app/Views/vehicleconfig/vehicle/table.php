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
           $sql  = "SELECT count(id) AS total_row ";
       $sql .= "FROM tb_vehicle ";
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

                $dataRow = array();
                $dataRow[] = $No . '.';
              
                $dataRow[] = ($fetchRow[$key]['vehicle_name']               == '' ? '-' : $fetchRow[$key]['vehicle_name']);
                $dataRow[] = ($fetchRow[$key]['ref_id_attachment']          == '' ? '-' : $fetchRow[$key]['ref_id_attachment']);
                $dataRow[] = ($fetchRow[$key]['ref_id_vehicle_type']        == '' ? '-' : $fetchRow[$key]['ref_id_vehicle_type']);
                $dataRow[] = ($fetchRow[$key]['ref_id_vehicle_brand']       == '' ? '-' : $fetchRow[$key]['ref_id_vehicle_brand']);
                $dataRow[] = ($fetchRow[$key]['vehicle_seat']               == '' ? '-' : $fetchRow[$key]['vehicle_seat']);
                $dataRow[] = ($fetchRow[$key]['vehicle_status']             == '' ? '-' : $fetchRow[$key]['vehicle_status']);
                $dataRow[] = 0;

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
    2 => "tb_vehicle.vehicle_name",
    3 => "tb_vehicle.ref_id_attachment",
    4 => "ref_id_vehicle_type",
);
$DataTableSearch = array(
    "vehicle_name",
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

$Call   = new DataTable($_POST['formData'],$dataGet);
$result = $Call->getTable(); 
// print_r($result);
echo json_encode($result);
exit;
?>