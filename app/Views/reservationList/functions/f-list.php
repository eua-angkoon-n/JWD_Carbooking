<?PHP
require_once __DIR__ . "/../../../../config/connectDB.php";
require_once __DIR__ . "/../../../../config/setting.php";

require_once __DIR__ . "/../../../../tools/crud.tool.php";
require_once __DIR__ . "/../../../../tools/function.tool.php";
Class List_Reservation {
    public function __construct(){

    }

    public function getStatus(){
        $arrStatus = Setting::$reservationStatus;
        $r = "<option value='' selected='selected'>ทั้งหมด</option>";
        foreach($arrStatus as $key => $status){
            if($key == 1){
                $s = "selected='selected'";
            } else {
                $s = "";
            }
            $r .= "<option value='$key' $s>$status</option>";
        }
        return $r;
    }

    public function getVehicle(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $value = $obj->fetchRows("SELECT id_vehicle, vehicle_name FROM tb_vehicle WHERE ref_id_site=".$_SESSION['car_ref_id_site']." AND vehicle_status=1");

            $r = "<option value='' selected='selected'>ทั้งหมด</option>";
            foreach($value as $key => $value){
                $r .= "<option value='".$value['id_vehicle']."'>".$value['vehicle_name']."</option>";
            }

            return $r;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        } finally {
            $con = null;
        }
    }
}