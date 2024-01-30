<?php
class Reservation{


    public function getAcc(){
        return $this->DoAcc();
    }

    public function getDriver(){
        return $this->DoDriver();
    }

    public function getUser(){
        return $this->DoUser();
    }

    public function DoAcc(){
        $sql  = "SELECT id_acc, acc_name ";
        $sql .= "FROM tb_accessories ";
        $sql .= "WHERE acc_status=1 ";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $value = $obj->fetchRows($sql);

            $result = $this->createSelectAcc($value);
            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function createSelectAcc($data){
        $result = "";
        foreach($data as $key => $value ){
            $id   = $value['id_acc'];
            $name = $value['acc_name'];
            $result .= "<option value='$id'>$name</option>";
        }
        return $result;
    }

    public function DoDriver(){
        $sql  = "SELECT id_driver, driver_name ";
        $sql .= "FROM tb_driver ";
        $sql .= "WHERE driver_status=1 ";
        $sql .= "AND ref_id_site IN (".$_SESSION['car_ref_id_site'].",0) ";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $value = $obj->fetchRows($sql);

            $result = $this->createSelectDriver($value);
            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function createSelectDriver($data){
        $result = "";
        foreach($data as $key => $value ){
            $id   = $value['id_driver'];
            $name = $value['driver_name'];
            $id == 1 ? $s = "select" : $s = "";
            $result .= "<option value='$id' $s>$name</option>";
        }
        return $result;
    }

    public function DoUser(){
        $sql  = "SELECT fullname, id_user ";
        $sql .= "FROM tb_user ";
        $sql .= "WHERE ref_id_site=".$_SESSION['car_ref_id_site']." ";
        // $sql .= "AND ref_id_dept=".$_SESSION['car_id_dept']." ";

        try {
            $con = connect_database('e-service');
            $obj = new CRUD($con);
        
            $value = $obj->fetchRows($sql);

            $result = $this->createSelectUser($value);
            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function createSelectUser($data){
        $result = "";
        foreach($data as $key => $value ){
            $name = $value['fullname'];
            $result .= "<option value='$name'>$name</option>";
        }
        return $result;
    }

}
?>