<?PHP
require_once __DIR__ . "/../../../../../config/connectDB.php";
require_once __DIR__ . "/../../../../../config/setting.php";

require_once __DIR__ . "/../../../../../tools/crud.tool.php";
require_once __DIR__ . "/../../../../../tools/function.tool.php";
Class List_Reservation {
    public function __construct(){

    }

    public function getStatus(){
        $arrStatus = Setting::$reservationStatus;
        $r = "<option value='' selected='selected'>ทั้งหมด</option>";
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

    public function getSave(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $value = $obj->fetchRows("SELECT * FROM tb_security WHERE ref_id_site=".$_SESSION['car_ref_id_site']." AND security_status=1");

            $r  = "";
            foreach($value as $key => $value){
                $r .= "<option value='".$value['security_name']."'>".$value['security_name']."</option>";
            }
            $r .= "<option value='0'>ระบุเอง</option>";

            return $r;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function VehicleList(){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_vehicle ";
        $sql .= "LEFT JOIN tb_attachment ON (tb_vehicle.ref_id_attachment = tb_attachment.id_attachment) ";
        $sql .= "WHERE ref_id_site=".$_SESSION['car_ref_id_site']." ";
        $sql .= "AND vehicle_status=1 ";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $value = $obj->fetchRows($sql);

            $r = $this->CreateListVehicle($value);

            return $r;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    private function CreateListVehicle($row) {
        $prefix = PageSetting::$prefixController;
        $path   = Setting::$PathBaseImg;
        $div = "";
        foreach($row as $key => $value){
            $id   = $value['id_vehicle'];
            $name = $value['vehicle_name'];
            $img  = CustomDate($value['date_uploaded'], 'Y-m-d', 'Ymd')."/".$value['attachment'];
            
            $div .= "<div class='col-sm-12 col-md-6 col-xl-4'>";
            $div .= "<div class='card'>";
            $div .= "<div class='card-body p-0 card-primary card-outline'>";
            $div .= "<a type='button' href='?$prefix=mileout&vehicle=$id' class='btn btn-default btn-block btn-lg p-5' style='border-radius:0;'>";
            $div .= "<div class='row d-flex align-items-center'>";
            $div .= "<div class='col-md-12'>";
            $div .= "<img class='img-fluid' src='../$path/$img' alt='Vehicle' style='height:150px'>";
            $div .= "<h3 class='text-primary'><strong>$name</strong></h3>";
            $div .= "</div></div></a></div></div></div>";
        }
        return $div;
    }
}