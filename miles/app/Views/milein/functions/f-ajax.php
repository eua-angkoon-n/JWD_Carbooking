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
        $this->save_out   = $this->chkSave($frmData['save_out'], $frmData['save_out_txt']);
        $this->remark_out = $frmData['remark_out'] != NULL ? $frmData['remark_out'] : NULL;
        $this->id_res     = $frmData['id_res'];
        $this->img        = $img != NULL ? separateArrayImg($img) : NULL;
    }

    public function getData() {
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

        $Mile = $this->DoAddMile();
        if($Mile == 'Success'){
            $this->remark_out != NULL ? $remark = $this->DoAddRemark() : '';
            ($this->img != NULL) ? $img = $this->DoAddImg() : '';
            $status = updateReservationStatus($this->id_res, '4');
            $this->CheckLineNotify($this->id_res);
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
            if($chk['mile_out'] >= $mile_out) {
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
                    'ref_id_reservation' => $this->id_res,
                    'attachment'         => $imageName,
                    'attachment_type'    => 2,
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

    protected function CheckLineNotify($idRes){

        getLineConfig($token, $notify);
        if(!$notify) // ผ่านเช็คแล้วผ่าน แสดงว่ามีส่งแน่นอน
            return;
        
        switch($notify){
            case 1 :
                $this->MainNotify($idRes);
                $this->CustomNotify($idRes);
                break;
            case 2 :
                $this->MainNotify($idRes);
                break;
            case 3 :
                $this->CustomNotify($idRes);
                break;
            default:
            case 4 :
                break;
        }
        return;
    }

    protected function MainNotify($idRes){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_config ";
        $sql .= "WHERE config = 'l_notify_main' ";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $ntf = $obj->customSelect($sql);
    
            if($ntf['config_value'] == 1) {
                $tk = getMainLineToken();
                if($tk){
                    $this->sendLineNotify($idRes, $tk, 'Main');
                }
            }
            
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        } finally {
            $con = null;
        }
    }

    protected function CustomNotify($idRes){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_config ";
        $sql .= "WHERE config = 'l_token' ";
        $sql .= "AND ref_id_site=".$_SESSION['car_ref_id_site']." "; 

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $tk = $obj->customSelect($sql);

            if(empty($tk) || IsNullOrEmptyString($tk['config_value']))
                return;
                $this->sendLineNotify($idRes, $tk['config_value'], 'Custom');
            return;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        } finally {
            $con = null;
        }
    }

    protected function sendLineNotify($idRes, $token, $from){
        switch($from){
            case 'Main':
                $site = "\nไซต์: ".$_SESSION['car_site_initialname'];
                break;
            case 'Custom':
                $site = "";
                break;
        }

        $res     = $this->getReservationData($idRes);
        $vehicle = $res['vehicle_name'];
        $name    = getUserName($res['ref_id_user']);
        $driver  = is_numeric($res['ref_id_driver']) ? getDriver($res['ref_id_driver']) : $res['ref_id_driver'];

        $sToken    = $token;
        $sMessage  = $site;
        $sMessage .= "\nคืนยานพาหนะ: $vehicle\n";
        $sMessage .= "ชื่อผู้จอง: $name\n";
        $sMessage .= "ผู้ขับรถ: $driver\n";

        $chOne = curl_init(); 
        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt( $chOne, CURLOPT_POST, 1); 
        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
    
        try {
            $result = curl_exec($chOne);
            if ($result === false) {
                throw new Exception(curl_error($chOne));
            }
        
            $result_ = json_decode($result, true);
            // echo "status : " . $result_['status'];
            // echo "message : " . $result_['message'];
        } catch (Exception $e) {
            // echo 'Caught exception: ' . $e->getMessage();
        } finally {
            curl_close($chOne);
        }
    }

    protected function getReservationData($id){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_reservation ";
        $sql .= "LEFT JOIN tb_vehicle ON (tb_vehicle.id_vehicle = tb_reservation.ref_id_vehicle) ";
        $sql .= "WHERE id_reservation=$id ";
        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $fetchRow = $obj->customSelect($sql);
            return $fetchRow;
            
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