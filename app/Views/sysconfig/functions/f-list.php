<?PHP
require_once __DIR__ . "/../../../../config/connectDB.php";
require_once __DIR__ . "/../../../../config/setting.php";

require_once __DIR__ . "/../../../../tools/crud.tool.php";
require_once __DIR__ . "/../../../../tools/function.tool.php";
Class List_Config {

    public function getReservation_t(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect("SELECT config_value FROM tb_config WHERE id_config=1");

            return $r['config_value'];
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getReservation_w(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect("SELECT config_value FROM tb_config WHERE id_config=2");
            
            switch($r['config_value']){
                case 1:
                    $w1 = "checked";
                    $w2 = "";
                    break;
                case 2:
                    $w1 = "";
                    $w2 = "checked";
                    break;
            }
           
            $d = '<div class="icheck-primary d-inline">
                    <input type="radio" id="reservation_w1" name="reservation_w" value="1" '.$w1.' aria-describedby="inputGroupPrepend" required>
                         <label for="reservation_w1">
                            แจ้งเตือนเท่านั้น
                        </label>
                </div>
                <div class="icheck-primary d-inline ">
                    <input type="radio" id="reservation_w2" name="reservation_w" value="2" '.$w2.' aria-describedby="inputGroupPrepend" required>
                        <label for="reservation_w2">
                        ทำให้ไม่สามารถจองได้
                        </label>
                </div>';

            return $d;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getPhase(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect("SELECT config_value FROM tb_config WHERE id_config=3");

            return $r['config_value'];
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getVersion(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect("SELECT config_value FROM tb_config WHERE id_config=4");

            return $r['config_value'];
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }
}