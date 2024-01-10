<?PHP
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Bangkok');	

require_once __DIR__ . "/../../../../config/connectDB.php";
require_once __DIR__ . "/../../../../config/setting.php";

require_once __DIR__ . "/../../../../tools/crud.tool.php";
require_once __DIR__ . "/../../../../tools/function.tool.php";

$action = $_REQUEST['action']; #รับค่า action มาจากหน้าจัดการ

switch ($action) {
    case 'update-status' :
        $Call   = new Update_Status($_POST['id_row'], $_POST['chk_box_value']);
        $Result = $Call->getUpdate();
        break;
}

print_r($Result);
exit;

Class Update_Status {

    public $id_row;
    public $chk_box_value;

    public function __construct($id_row, $chk_box_value)
    {
        $this->id_row        = $id_row;
        $this->chk_box_value = $chk_box_value;
    }

    public function getUpdate(){
        return $this->DoUpdate();
    }

    public function DoUpdate(){
        $value =[
            'status_user' => $this->chk_box_value,
        ];

        try {
            $con = connect_database('e-service');
            $obj = new CRUD($con);
        
            $result = $obj->update($value, 'id_user='.$this->id_row, "tb_user");
            $result == 'Success' ? $s = 1 : $s = 0;
            return $s;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }
}