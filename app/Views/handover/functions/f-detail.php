<?php
class HandOver{


    public function getExpense(){
        return $this->DoExpense();
    }


    public function DoExpense(){
        $sql  = "SELECT id_expense, expense_name ";
        $sql .= "FROM tb_expense ";
        $sql .= "WHERE expense_status=1 ";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $value = $obj->fetchRows($sql);

            $result = $this->createSelectExpense($value);
            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function createSelectExpense($data){
        $result = "<option value='0'>ไม่มี</option>";
        foreach($data as $key => $value ){
            $id   = $value['id_expense'];
            $name = $value['expense_name'];
            $result .= "<option value='$id'>$name</option>";
        }
        return $result;
    }
}
?>