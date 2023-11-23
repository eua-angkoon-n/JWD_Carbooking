<?php 
require_once __DIR__ . "/../../../../config/connectDB.php";

require_once __DIR__ . "/../../../../tools/crud.tool.php";
Class Select {

    public function Data_Type(){

        $sql  = "SELECT id_vehicle_type, vehicle_type ";
        $sql .= "FROM `tb_vehicle_type` ";
        $sql .= "WHERE type_status = 1 ";
        $sql .= "Order By vehicle_type ASC"; 

        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $fetchRow = $obj->fetchRows($sql);
            
            return $fetchRow;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function Data_Brand(){

        $sql  = "SELECT id_vehicle_brand, vehicle_brand ";
        $sql .= "FROM `tb_vehicle_brand` ";
        $sql .= "WHERE brand_status = 1 ";
        $sql .= "Order By vehicle_brand ASC"; 

        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $fetchRow = $obj->fetchRows($sql);
            
            return $fetchRow;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getType(){
        $type = $this->Data_Type();

        $result  = "<div class='row row-4'>";
        $result .= "<div class='col-sm-6 col-md-6 col-xs-6'>";
        $result .= "<div class='form-group'>";
        $result .= "<label for='vehicle_type'>ประเภทยานพาหนะ</label>";
        $result .= "<select class='custom-select custom-select-md rounded-3' id='vehicle_type' name='vehicle_type' aria-describedby='inputGroupPrepend' required>";
        $result .= "<option selected disabled value=''>เลือกประเภทยานพาหนะ</option>";
    
        foreach ($type as $key => $values) {
            $id   = $values['id_vehicle_type'];
            $name = $values['vehicle_type'];
            $result .= "<option value='$id'>$name</option>";
        }
        $result .= "</select></div></div></div>";
        
        return $result;
    }

    public function getBrand(){
        $brand = $this->Data_Brand();

        $result  = "<div class='row row-4'>";
        $result .= "<div class='col-sm-6 col-md-6 col-xs-6'>";
        $result .= "<div class='form-group'>";
        $result .= "<label for='vehicle_brand'>ยี่ห้อยานพาหนะ</label>";
        $result .= "<select class='custom-select custom-select-md rounded-3' id='vehicle_brand' name='vehicle_brand' aria-describedby='inputGroupPrepend' required>";
        $result .= "<option selected disabled value=''>เลือกยี่ห้อยานพาหนะ</option>";
    
        foreach ($brand as $key => $values) {
            $id   = $values['id_vehicle_brand'];
            $name = $values['vehicle_brand'];
            $result .= "<option value='$id'>$name</option>";
        }
        $result .= "</select></div></div></div>";
        
        return $result;
    }
}

?>