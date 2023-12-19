<?PHP
require_once __DIR__ . "/../../../../../config/connectDB.php";
require_once __DIR__ . "/../../../../../config/setting.php";

require_once __DIR__ . "/../../../../../tools/crud.tool.php";
require_once __DIR__ . "/../../../../../tools/function.tool.php";
Class MainView {


    public function getOutCount(){

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->countAll("SELECT id_reservation FROM tb_reservation WHERE reservation_status = 1");

            return $r;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        } finally {
            $con = null;
        }

    }

    public function getInCount(){

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->countAll("SELECT id_reservation FROM tb_reservation WHERE reservation_status = 3");

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