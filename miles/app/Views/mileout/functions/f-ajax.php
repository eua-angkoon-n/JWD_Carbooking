<?PHP
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Bangkok');	

require_once __DIR__ . "/../../../../../config/connectDB.php";
require_once __DIR__ . "/../../../../../config/setting.php";

require_once __DIR__ . "/../../../../../tools/crud.tool.php";
require_once __DIR__ . "/../../../../../tools/function.tool.php";

$action = $_POST['action']; #รับค่า action มาจากหน้าจัดการ
// $test = separateArrayImg($_FILES['img']);
// print_r($test[0]);
// exit;
switch ($action) {
    case 'save_out' : 
        $Call   = new Mile_Out($_POST, $_FILES['img']);
        $Result = $Call->getData();
        break;
    case 'view' :
        $Call   = new View_Out($_POST['id'], $_POST['idv']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;
}

print_r($Result);
exit;

Class Mile_Out {

    public $date_out;
    public $mile_out;
    public $save_out;
    public $remark_out;
    public $id_res;
    public $img;

    public function __construct($frmData, $img) {
        
        // parse_str($frmData, $output); //$output['period']

        $this->date_out   = $frmData['date_out'] != NULL ? CustomDate($frmData['date_out'], 'd/m/Y H:i', 'Y-m-d H:i:s')  : NULL;
        $this->mile_out   = $frmData['mile_out'];
        $this->save_out   = $this->chkSave($frmData['save_out'], $frmData['save_out_txt']);
        $this->remark_out = $frmData['remark_out'] != NULL ? $frmData['remark_out'] : NULL;
        $this->id_res     = $frmData['id_res'];
        $this->img        = $img != NULL ? separateArrayImg($img) : NULL;
    }

    public function getData() {
        // return $this->save_out;
        return $this->AddMileData();
    }

    public function chkSave($select, $text){
        if($select == '0') {
            if(IsNullOrEmptyString($text)){
                return NULL;
            } else {
                return $text;
            }
        } else {
            return $select;
        }
    }

    public function AddMileData() {
        $canAdd = $this->chkTime();
        // return $canAdd;
        if(!$canAdd)
            return "Diff";
        if(IsNullOrEmptyString($this->save_out))
            return "no_save";
        $Mile = $this->DoAddMile();
        if(is_numeric($Mile)){
            $this->remark_out != NULL ? $remark = $this->DoAddRemark() : '';
            ($this->img != NULL) ? $img = $this->DoAddImg() : '';
            $status = updateReservationStatus($this->id_res, '3');
            return $status;
        }

       return 0;
    }

    public function chkTime(){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_reservation ";
        $sql .= "WHERE id_reservation=$this->id_res ";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->customSelect($sql);

        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }

        $diff = timeDifference($result['start_date'], $this->date_out);
        if($diff > 90) {
            return false;
        } else {
            return true;
        }
    }

    public function DoAddMile(){

        $date_out      = $this->date_out;
        $mile_out      = $this->mile_out;
        $save_out      = $this->save_out;
        $id_res        = $this->id_res;
        $date_save_out = date('Y-m-d H:i:s');

        $value = [
            'ref_id_reservation' => $id_res,
            'mile_out'           => $mile_out,
            'save_out'           => $save_out,
            'date_out'           => $date_out,
            'date_save_out'      => $date_save_out
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->addRow($value, "tb_mile");
            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function DoAddRemark(){
        
        $remark        = $this->remark_out;
        $id_res        = $this->id_res;
        $date = date('Y-m-d H:i:s');

        $value = [
            'ref_id_reservation' => $id_res,
            'remark_type'        => '4',
            'remark'             => $remark,
            'date'               => $date, 
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->addRow($value, "tb_reservation_remark");
            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function DoAddImg(){
        $img           = $this->img;

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $PathImg = getPathImg(Setting::$PathImgMile);

            foreach ($img as $key => $value){
                $imageName = $obj->uploadPhoto($img[$key], "../../../dist/temp_img/". $PathImg . "/");
                $value = [
                    'ref_id_reservation' => $this->id_res,
                    'attachment'         => $imageName,
                    'attachment_type'    => 1,
                    'date_uploaded'      => date("Y-m-d")
                ];
                
                $result = $obj->addRow($value, "tb_attachment");

                if(is_numeric($result))
                    continue;
                else
                    return $result; 
            }

            return 'success';
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

}

Class View_Out {

    private $id;
    private $idv;

    public function __construct($id, $idv){
        $this->id = $id;
        $this->idv= $idv;
    }

    public function getData(){
        return $this->GetMileOutData();
    }

    public function GetMileOutData(){
       
        try {
            $con = connect_database();
            $obj = new CRUD($con);
            $v = $obj->customSelect($this->LastMileStringQuery());

            if(IsNullOrEmptyString($v['mile_in'])){
                $lMile = 0;
            } else {
                $lMile = $v['mile_in'];
            }
        
            return array(
                'lastMile' =>  $lMile
            );
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function LastMileStringQuery(){
        $sql  = "SELECT mile_in ";
        $sql .= "FROM tb_reservation ";
        $sql .= "LEFT JOIN tb_mile ON (tb_mile.ref_id_reservation = tb_reservation.id_reservation)";
        $sql .= "WHERE ref_id_vehicle = $this->idv ";
        $sql .= "ORDER BY mile_in DESC ";
        $sql .= "LIMIT 1";
        return $sql;
    }


}