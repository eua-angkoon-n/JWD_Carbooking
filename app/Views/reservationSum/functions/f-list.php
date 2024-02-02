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
        $r = "";
        foreach($arrStatus as $key => $status){
            $r .= "<option value='$key'>$status</option>";
        }
        return $r;
    }

    public function getVehicle(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $value = $obj->fetchRows("SELECT id_vehicle, vehicle_name FROM tb_vehicle WHERE ref_id_site=".$_SESSION['car_ref_id_site']." AND vehicle_status=1");

            $r = "";
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

    public function getUser(){
        try {
            $con = connect_database('e-service');
            $obj = new CRUD($con);
        
            $value = $obj->fetchRows("SELECT * FROM tb_user WHERE ref_id_site IN (".$_SESSION['car_ref_id_site'].", 99) AND status_user=1 ");

            $r = "";
            foreach($value as $key => $value){
                $r .= "<option value='".$value['id_user']."'>".$value['fullname']."</option>";
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