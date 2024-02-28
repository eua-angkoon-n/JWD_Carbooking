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

    public function getReservation_txt(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect("SELECT config_value FROM tb_config WHERE id_config=12");

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

    public function getLineToken(){
        $sql  = "SELECT config_value ";
        $sql .= "FROM tb_config ";
        $sql .= "WHERE config = 'l_token' AND ref_id_site =".$_SESSION['car_ref_id_site']." ";
        
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect($sql);

            if(empty($r['config_value'])){
                return "";
            }
            return $r['config_value'];
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        } finally {
            $con = null;
        }
    }

    public function getLineNotify(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect("SELECT config_value FROM tb_config WHERE config='l_notify' AND ref_id_site =".$_SESSION['car_ref_id_site']." ");

            if(empty($r['config_value'])){
                $w1 = "";
                $w2 = "";
                $w3 = "";
                $w4 = "checked";
            } else {
                switch($r['config_value']){
                    case 1:
                        $w1 = "checked";
                        $w2 = "";
                        $w3 = "";
                        $w4 = "";
                        break;
                    case 2:
                        $w1 = "";
                        $w2 = "checked";
                        $w3 = "";
                        $w4 = "";
                        break;
                    case 3:
                        $w1 = "";
                        $w2 = "";
                        $w3 = "checked";
                        $w4 = "";
                        break;
                    case 4:
                        $w1 = "";
                        $w2 = "";
                        $w3 = "";
                        $w4 = "checked";
                        break;
                }
            }
            
            $d = '<div class="row">
                    <div class="col-sm-12 col-md-6 mb-2">
                        <div class="icheck-success d-inline">
                            <input type="radio" id="l_notify1" name="l_notify" value="1" '.$w1.' aria-describedby="inputGroupPrepend" required>
                                <label for="l_notify1">
                                    แจ้งเตือนกลุ่มหลักจองรถธุรการ และ กลุ่มที่กำหนด
                                </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 mb-2">
                        <div class="icheck-success d-inline ">
                            <input type="radio" id="l_notify2" name="l_notify" value="2" '.$w2.' aria-describedby="inputGroupPrepend" required>
                                <label for="l_notify2">
                                แจ้งเตือนกลุ่มหลักจองรถธุรการ
                                </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 mb-2">
                        <div class="icheck-success d-inline ">
                            <input type="radio" id="l_notify3" name="l_notify" value="3" '.$w3.' aria-describedby="inputGroupPrepend" required>
                                <label for="l_notify3">
                                แจ้งเตือนกลุ่มที่กำหนด
                                </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 mb-2">
                        <div class="icheck-danger d-inline ">
                            <input type="radio" id="l_notify4" name="l_notify" value="4" '.$w4.' aria-describedby="inputGroupPrepend" required>
                                <label for="l_notify4">
                                 ปิดการแจ้งเตือน
                                </label>
                        </div>
                    </div>
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

    public function getLineTokenMain(){
        $sql  = "SELECT config_value ";
        $sql .= "FROM tb_config ";
        $sql .= "WHERE config = 'l_token_main' ";
        
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect($sql);

            if(empty($r['config_value'])){
                return "";
            }
            return $r['config_value'];
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        } finally {
            $con = null;
        }
    }

    public function getLineNotifyMain(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect("SELECT config_value FROM tb_config WHERE config='l_notify_main'");

            if(empty($r['config_value'])){
                $w1 = "";
                $w2 = "";
            } else {
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
            }
            
            $d = '<div class="row mb-2">
                    <div class="col-sm-12 col-md-6 mb-2">
                        <div class="icheck-success d-inline">
                            <input type="radio" id="l_notify_main1" name="l_notify_main" value="1" '.$w1.' aria-describedby="inputGroupPrepend" required>
                                <label for="l_notify_main1">
                                    เปิดแจ้งเตือน
                                </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 mb-2">
                        <div class="icheck-danger d-inline ">
                            <input type="radio" id="l_notify_main2" name="l_notify_main" value="2" '.$w2.' aria-describedby="inputGroupPrepend" required>
                                <label for="l_notify_main2">
                                    ปิดแจ้งเตือน
                                </label>
                        </div>
                    </div>
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


    public function getUrgent_Reservation(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect("SELECT config_value FROM tb_config WHERE config='urgent_reservation'");
            
            switch($r['config_value']){
                case 1:
                    $w1 = "checked";
                    $w2 = "";
                    break;
                case 0:
                    $w1 = "";
                    $w2 = "checked";
                    break;
            }
           
            $d = '<div class="icheck-success d-inline">
                    <input type="radio" id="urgent_reservation1" name="urgent_reservation" value="1" '.$w1.' aria-describedby="inputGroupPrepend" required>
                         <label for="urgent_reservation1">
                            เปิดการใช้งาน
                        </label>
                    </div>
                    <div class="icheck-danger d-inline ">
                        <input type="radio" id="urgent_reservation2" name="urgent_reservation" value="0" '.$w2.' aria-describedby="inputGroupPrepend" required>
                            <label for="urgent_reservation2">
                                ปิดการใช้งาน
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

    public function getHandOver(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect("SELECT config_value FROM tb_config WHERE config='handover'");
            
            switch($r['config_value']){
                case 1:
                    $w1 = "checked";
                    $w2 = "";
                    break;
                case 0:
                    $w1 = "";
                    $w2 = "checked";
                    break;
            }
           
            $d = '<div class="icheck-success d-inline">
                    <input type="radio" id="handover1" name="handover" value="1" '.$w1.' aria-describedby="inputGroupPrepend" required>
                         <label for="handover1">
                            เปิดการใช้งาน
                        </label>
                </div>
                <div class="icheck-danger d-inline ">
                    <input type="radio" id="handover2" name="handover" value="0" '.$w2.' aria-describedby="inputGroupPrepend" required>
                        <label for="handover2">
                            ปิดการใช้งาน
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

    public function getHandover_Field(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect("SELECT config_value FROM tb_config WHERE config='handover_f'");
            
            switch($r['config_value']){
                case 1:
                    $w1 = "checked";
                    $w2 = "";
                    break;
                case 0:
                    $w1 = "";
                    $w2 = "checked";
                    break;
            }
           
            $d = '<div class="icheck-success d-inline">
                    <input type="radio" id="handover_f1" name="handover_f" value="1" '.$w1.' aria-describedby="inputGroupPrepend" required>
                         <label for="handover_f1">
                            เปิดการใช้งาน
                        </label>
                    </div>
                    <div class="icheck-danger d-inline ">
                        <input type="radio" id="handover_f2" name="handover_f" value="0" '.$w2.' aria-describedby="inputGroupPrepend" required>
                            <label for="handover_f2">
                                ปิดการใช้งาน
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

    public function getHandover_l(){
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $r = $obj->customSelect("SELECT config_value FROM tb_config WHERE config='handover_l'");

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