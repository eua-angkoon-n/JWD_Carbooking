<?php 
require_once __DIR__ . "/../../Class/datatable_processing.php";

class mileOutTable extends TableProcessing {
    
    public function __construct($TableSET) {
        parent::__construct($TableSET);
    }

    public function getTable(){
        return $this->SqlQuery();
    }

    public function splitDateRange($dateRange) {
        // Split the date range string by " - "
        $dateParts = explode(" - ", $dateRange);
    
        if (count($dateParts) === 2) {
            // If there are two parts, assume the first part is the start date and the second part is the end date
            $startDate = trim($dateParts[0]);
            $endDate = trim($dateParts[1]);
    
            // You can further format the dates if needed
            $startDate = date("Y-m-d H:i:s", strtotime($startDate));
            $endDate = date("Y-m-d H:i:s", strtotime($endDate));
    
            return [$startDate, $endDate];
        } else {
            return [];
        }
    }
    public function SqlQuery(){
        $sql      = $this->getSQL(true);
        $sqlCount = $this->getSQL(false);
        // return $sql;
        try {
            $con = connect_database();
            $obj = new CRUD($con);

            $fetchRow = $obj->fetchRows($sql);
            $numRow   = $obj->getCount($sqlCount);

            $Result   = $this->createArrayDataTable($fetchRow, $numRow);
            
            return $Result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        } finally {
            $con = null;
        }
    }

    public function getSQL(bool $OrderBY){

        if($OrderBY)
            $sql  = "SELECT * ";
        else
            $sql  = "SELECT count(id) AS total_row ";
        $sql .= "FROM new_car_car_reservation ";
        $sql .= "WHERE 1=1 ";
        // $sql .= "AND team = '$team' ";
        // if(!empty($date)) {
        //     $sql .= "AND logs_datetime BETWEEN '".$date[0]."' AND '".$date[1]."' ";
        //     $sql .= "$this->query_search ";
        // }
        if($OrderBY) {
            $sql .= "ORDER BY ";
            $sql .= "$this->orderBY ";
            $sql .= "$this->dir ";
            $sql .= "$this->limit ";
        }
        
        return $sql;
    }

    public function createArrayDataTable($fetchRow, $numRow){

        $arrData = null;
        $output = array(
            "draw" => intval($this->draw),
            "recordsTotal" => intval(0),
            "recordsFiltered" => intval(0),
            "data" => $arrData,
        );

        if (count($fetchRow) > 0) {
            $No = ($numRow - $this->pStart);
            foreach ($fetchRow as $key => $value) {

                $dataRow = array();
                $dataRow[] = $No . '.';
              
                $dataRow[] = ($fetchRow[$key]['begin'] == '' ? '-' : date("d/m/Y H:i:s", strtotime($fetchRow[$key]['begin'])));
                $dataRow[] = ($fetchRow[$key]['vehicle_id']     == '' ? '-' : $fetchRow[$key]['vehicle_id']);
                $dataRow[] = ($fetchRow[$key]['member_id']     == '' ? '-' : $fetchRow[$key]['member_id']);
                $dataRow[] = ($fetchRow[$key]['detail']     == '' ? '-' : $fetchRow[$key]['detail']);
                $dataRow[] = ($fetchRow[$key]['status']    == '' ? '-' : $fetchRow[$key]['status']);
                $dataRow[] = ($fetchRow[$key]['travelers']    == '' ? '-' : $fetchRow[$key]['travelers']);
              
                $arrData[] = $dataRow;
                $No--;
            }
        }

        $output = array(
            "draw" => intval($this->draw),
            "recordsTotal" => intval($numRow),
            "recordsFiltered" => intval($numRow),
            "data" => $arrData,
        );

        return $output;
    }
}
