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
// print_r($_POST);
// exit;
switch ($action) {
    case 'save_out' : 
        $Call   = new Mile_Out($_POST, $_FILES['img']);
        $Result = $Call->getData();
        break;
    case 'view' :
        $Call   = new View_Out($_POST['id']);
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
        $this->save_out   = $frmData['save_out'] != NULL ? $frmData['save_out'] : NULL;
        $this->remark_out = $frmData['remark_out'] != NULL ? $frmData['remark_out'] : NULL;
        $this->id_res     = $frmData['id_res'];
        $this->img        = $img != NULL ? separateArrayImg($img) : NULL;
    }

    public function getData() {
        return $this->AddMileData();
    }

    public function AddMileData() {

        $Mile = $this->DoAddMile();
        if($Mile == 'Success'){
            $this->remark_out != NULL ? $remark = $this->DoAddRemark() : '';
            ($this->img != NULL) ? $img = $this->DoAddImg() : '';
            $status = updateReservationStatus($this->id_res, '4');
            return $status;
        }

        if($Mile == 'errmile'){
            return $Mile;
        }

       return 0;
    }

    public function DoAddMile(){

        $date_out      = $this->date_out;
        $mile_out      = $this->mile_out;
        $save_out      = $this->save_out;
        $id_res        = $this->id_res;
        $date_save_out = date('Y-m-d H:i:s');

        $value = [
            'mile_in'           => $mile_out,
            'save_in'           => $save_out,
            'date_in'           => $date_out,
            'date_save_in'      => $date_save_out
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
            $chk = $obj->customSelect("SELECT mile_out FROM tb_mile WHERE ref_id_reservation=$id_res");
            if($chk['mile_out'] > $mile_out) {
                return 'errmile';
            }
        
            $result = $obj->update($value, "ref_id_reservation=$id_res", "tb_mile");
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
        $date          = date('Y-m-d H:i:s');

        $value = [
            'ref_id_reservation' => $id_res,
            'remark_type'        => '5',
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
                    'attachment'      => $imageName,
                    'attachment_type' => 2,
                    'date_uploaded'   => date("Y-m-d")
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

    public function __construct($id){
        $this->id = $id;
    }

    public function getData(){
        return $this->GetMileOutData();
    }

    public function GetMileOutData(){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_mile ";
        $sql .= "WHERE ref_id_reservation=$this->id ";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect($sql);
            $d = CustomDate($r['date_out'], 'Y-m-d H:i:s', 'd/m/Y H:i น.');
            return array(
                'date'     =>  $d,
                'mile'     =>  $r['mile_out'],
                'save'     =>  $r['save_out'],
            );
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }


}