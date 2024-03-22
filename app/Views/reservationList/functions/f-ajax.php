<?PHP
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Bangkok');	

require_once __DIR__ . "/../../../../config/connectDB.php";
require_once __DIR__ . "/../../../../config/setting.php";

require_once __DIR__ . "/../../../../tools/crud.tool.php";
require_once __DIR__ . "/../../../../tools/function.tool.php";

$action = $_POST['action'];

// echo json_encode($_POST['remark']);
// exit();

switch ($action) {
    case 'cancel' : //ยกเลิกการจอง
        $Call   = new Reservation_Cancel($_POST['id'], $_POST['remark']);
        $Data   = $Call->getData();
        $Result = $Data;
        break;
    case 'detail': //ดูรายละเอียดการจอง
        $Call = new Reservation_Detail($_POST['id']);
        $Data   = $Call->getData();
        $Result = json_encode($Data);
        break;
}

print_r($Result);
exit;

Class Reservation_Cancel {

    private $id;
    private $remark;
    public function __construct($id, $remark){
        $this->id     = $id;
        $this->remark = $remark == "" ? false : $remark;
    }

    public function getData(){
        return $this->DoCancel();
    }

    public function DoCancel(){
        if($this->remark){
            $this->getCancelID();
        }
        $res = $this->updateRes();
        return $res;
    }

    public function getCancelID(){
        $data = [
            'ref_id_reservation' => $this->id,
            'remark_type'        => 3, //1= Approve 2 = Non-Approve 3 = Cancel
            'remark'             => $this->remark,
            'date'               => date('Y-m-d H:i:s')
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->addRow($data, 'tb_reservation_remark');

            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }

        return false;
    }

    public function updateRes(){
        $data = [
            'reservation_status' => 5,
        ];

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->update($data, 'id_reservation='.$this->id, 'tb_reservation');

            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }

        return false;
    }
}

Class Reservation_Detail {
    private $id;
    public function __construct($id){
        $this->id = $id;
    }

    public function getData(){
        return $this->DoGetDetail();
    }

    public function DoGetDetail(){
        $TimeLine = 0;
        $hand     = 0;
        $Res      = $this->getResData();
        if(!$Res)
            return true;
        if($Res['reservation_status'] == 3 || $Res['reservation_status'] == 4 || $Res['reservation_status'] == 6){
            $Mile    = $this->getMileData();
            $MileIMG = $this->getMileIMG();
            $TimeLine= $this->createMileTimeLine($Mile, $MileIMG);
        }
        if($Res['reservation_status'] == 6){
            $HandOver = $this->getHandOverData();
            $hand     = $this->createHandOver($HandOver);
        }
        $User     = $this->getUserName($Res['ref_id_user']);
        $acc      = 'ไม่มี';
        if($Res['accessories'] == 1){
            $acc  = $this->getAccessory(); 
        }
        return $this->getArrData($Res, $User, $acc, $TimeLine, $hand, $Mile);
    }

    public function getResData(){
        $sql  = "SELECT tb_reservation.reservation_status, tb_reservation.id_reservation, tb_reservation.ref_id_driver, tb_reservation.ref_id_vehicle, tb_vehicle.vehicle_name, tb_reservation.start_date, tb_reservation.end_date, tb_reservation.ref_id_user, tb_reservation.urgent, tb_coordinates.place_name, tb_coordinates.latitude, tb_coordinates.longitude, tb_coordinates.zoom, tb_reservation.traveling_companion, tb_reservation.reason, tb_reservation.accessories, tb_attachment.attachment, tb_attachment.date_uploaded ";
        $sql .= "FROM tb_reservation ";
        $sql .= "LEFT JOIN db_carbooking.tb_vehicle ON (tb_vehicle.id_vehicle = tb_reservation.ref_id_vehicle) ";
        $sql .= "LEFT JOIN db_carbooking.tb_coordinates ON (tb_coordinates.ref_id_reservation = tb_reservation.id_reservation) ";
        $sql .= "LEFT JOIN db_carbooking.tb_attachment ON (tb_attachment.id_attachment = tb_vehicle.ref_id_attachment) ";
        $sql .= "WHERE id_reservation=$this->id;";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $result = $obj->customSelect($sql);
            if(empty($result))
                return false;

            return $result;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }

    }

    public function getUserName($id){
        $sql  = "SELECT fullname, phone ";
        $sql .= "FROM tb_user ";
        $sql .= "WHERE id_user = $id";

        try {
            $con = connect_database('e-service');
            $obj = new CRUD($con);
        
            $result = $obj->customSelect($sql);

            $r = $result['fullname'];
            !IsNullOrEmptyString($result['phone']) ? $r .= " (".$result['phone'].")" : ''; 
            return $r;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();    
        } finally {
            $con = null;
        }
    }

    public function getAccessory(){
        $sql  = "SELECT acc_name ";
        $sql .= "FROM tb_ref_accessories ";
        $sql .= "LEFT JOIN tb_accessories ON (tb_ref_accessories.ref_id_acc = tb_accessories.id_acc) ";
        $sql .= "WHERE ref_id_reservation = $this->id";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $s = $obj->fetchRows($sql);
            $r = array();
            foreach($s as $k => $v){
                $a[] = $v['acc_name'];
            }
            $r = implode(', ', $a);

            return $r;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getMileData(){
        $sql  = "SELECT *, ";
        $sql .= "   (SELECT remark  ";
        $sql .= "       FROM tb_reservation_remark ";
        $sql .= "       WHERE ref_id_reservation = $this->id ";
        $sql .= "       AND remark_type = 4 ";
        $sql .= "   ) AS remark_out, ";
        $sql .= "   (SELECT remark ";
        $sql .= "       FROM tb_reservation_remark ";
        $sql .= "       WHERE ref_id_reservation = $this->id ";
        $sql .= "       AND remark_type = 5 ";
        $sql .= "   ) AS remark_in ";
        $sql .= "FROM tb_mile ";
        $sql .= "WHERE ref_id_reservation = $this->id";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $s = $obj->customSelect($sql);

            return $s;
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function getMileIMG(){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_attachment ";
        $sql .= "WHERE ref_id_reservation = $this->id ";
        $sql .= "AND (attachment_type = 1 ";
        $sql .= "OR attachment_type = 2) ";

        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $s = $obj->fetchRows($sql);
            if(empty($s)){
                return NULL;
            }
            $in = array();
            $out= array();
            foreach ($s as $k => $v) {
                if($v['attachment_type'] == 2){
                    $in[] = array(
                        'attachment' => $v['attachment'],
                        'date_uploaded' => $v['date_uploaded']
                    );
                } else if($v['attachment_type'] == 1){
                    $out[] = array(
                        'attachment' => $v['attachment'],
                        'date_uploaded' => $v['date_uploaded']
                    );
                } 
            }

            return array(
                'mileIn'  => $in,
                'mileOut' => $out
            );
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function createMileTimeLine($data, $img){
        $dateOut = convertToThaiDate($data['date_out']);
        $timeOut = CustomDate($data['date_out'], "Y-m-d H:i:s", "H:i");
        $saveOut = $data['save_out'];
        $mileOut = $data['mile_out'];

        if(!empty($data['mile_in'])) {
            $dateIn = convertToThaiDate($data['date_in']);
            $timeIn = CustomDate($data['date_in'], "Y-m-d H:i:s", "H:i");
            $saveIn = $data['save_in'];
            $mileIn = $data['mile_in'];
        }
        
        $r  = "<h4 class='text-primary'><strong>บันทึกเข้า-ออกบริษัท</strong></h4>";
        $r .= "<div class='timeline'>";
        $r .= " <div class='time-label'>";
        $r .= "     <span class='bg-red'>$dateOut</span>";
        $r .= "</div><div>";
        $r .= "     <i class='fas fa-arrow-left bg-red'></i>";
        $r .= "     <div class='timeline-item'>";
        $r .= "     <span class='time'><i class='fas fa-clock'></i>$timeOut</span>";
        $r .= "     <h4 class='timeline-header'><a href='#'>ออกจากบริษัท</a> บันทึกโดย $saveOut</h4>";
        $r .= "     <div class='timeline-body'>";
        $r .= "         <div class='row'>&nbsp;เลขไมล์ : $mileOut</div>";
        if(!empty($img['mileOut'])){
            $r .= "<div class='row'>";
            foreach($img['mileOut'] as $k => $v){
                $imgOut  = "dist/temp_img/".str_replace("-", "", $v['date_uploaded'])."/".$v['attachment'];
                $r .= "<img class='product-image-thumb modal-img m-0 mt-1'src='$imgOut' alt='Img' data-id='$imgOut' data-toggle='modal' data-target='#modal-img'>";
            }
            $r .= "</div>";
        }
        $r .= "</div>";
        if(!IsNullOrEmptyString($data['remark_out'])){
            $remark_out = $data['remark_out'];
            $r .= "<div class='timeline-footer'><h6 class='timeline-header '>$remark_out</h6></div>";
        }
        $r .= "</div></div>";

        if(!empty($data['mile_in'])) {
            $r .= "<div class='time-label'><span class='bg-green'>$dateIn</span></div>";
            $r .= "<div><i class='fas fa-arrow-right bg-green'></i>";
            $r .= "     <div class='timeline-item'>";
            $r .= "     <span class='time'><i class='fas fa-clock'></i>$timeIn</span>";
            $r .= "     <h4 class='timeline-header'><a href='#'>กลับเข้าบริษัท</a> บันทึกโดย $saveIn</h4>";
            $r .= "     <div class='timeline-body'>";
            $r .= "         <div class='row'>&nbsp;เลขไมล์ : $mileIn</div>";
            if(!empty($img['mileIn'])){
                $r .= "<div class='row'>";
                foreach($img['mileIn'] as $k => $v){
                    $imgIn  = "dist/temp_img/".str_replace("-", "", $v['date_uploaded'])."/".$v['attachment'];
                    $r .= "<img class='product-image-thumb modal-img m-0 mt-1'src='$imgIn' alt='Img' data-id='$imgIn' data-toggle='modal' data-target='#modal-img'>";
                }
                $r .= "</div>";
            }
            $r .= "</div>";
            if(!IsNullOrEmptyString($data['remark_in'])){
                $remark_in = $data['remark_in'];
                $r .= "<div class='timeline-footer'><h6 class='timeline-header '>$remark_in</h6></div>";
            }
            $r .= "</div></div>";
            $r .= "<div><i class='fas fa-flag-checkered bg-green'></i></div>";
        }
        $r .= "</div>";

        return $r;
    }

    public function getHandOverData(){
        $sql  = "SELECT * ";
        $sql .= "FROM tb_handover ";
        $sql .= "WHERE ref_id_reservation = $this->id";

        $sqlIMG  = "SELECT * ";
        $sqlIMG .= "FROM tb_attachment ";
        $sqlIMG .= "WHERE ref_id_reservation = $this->id ";
        $sqlIMG .= "AND attachment_type IN (3,4,5)";

        $sql2  = "SELECT tb_expense.expense_name, tb_ref_expense.amount_expense, tb_attachment.attachment, tb_attachment.date_uploaded ";
        $sql2 .= "FROM tb_ref_expense ";
        $sql2 .= "LEFT JOIN tb_expense ON (tb_expense.id_expense = tb_ref_expense.ref_id_expense) ";
        $sql2 .= "LEFT JOIN tb_attachment ON (tb_attachment.id_attachment = tb_ref_expense.ref_id_attachment) ";
        $sql2 .= "WHERE tb_ref_expense.ref_id_reservation = $this->id";
        
        try {
            $con = connect_database();
            $obj = new CRUD($con);
        
            $h = $obj->customSelect($sql);
            $handover = array(
                'inside' => $h['condition_inside'],
                'outside'=> $h['condition_outside'],
                'fuel'   => $h['handover_fuel']
            );

            $inImg   = array();
            $outImg  = array();
            $fuelImg = array();
            $hM = $obj->fetchRows($sqlIMG);
            if(!empty($hM)){
                foreach ($hM as $k => $v){
                    switch ($v['attachment_type']){
                        case 3:
                            $inImg[]   = str_replace("-", "", $v['date_uploaded'])."/".$v['attachment'];
                            break;
                        case 4:
                            $outImg[]  = str_replace("-", "", $v['date_uploaded'])."/".$v['attachment'];
                            break;
                        case 5:
                            $fuelImg[] = str_replace("-", "", $v['date_uploaded'])."/".$v['attachment'];
                            break;
                    }
                }
            }
            $handoverImg = array(
              'inside' => $inImg,
              'outside'=> $outImg,
              'fuel'   => $fuelImg  
            );
            
            $expense = array();
            $e = $obj->fetchRows($sql2);
            if(!empty($e)){
                foreach($e as $k => $v){
                    if(empty($v['attachment'])){
                        $att = 0;
                    } else {
                        $att = str_replace("-", "", $v['date_uploaded'])."/".$v['attachment'];
                    }
                    $expense[] = [
                        'name'  => $v['expense_name'],
                        'amount'=> $v['amount_expense'],
                        'img'   => $att
                    ];
                }
            }

            return array(
                'handover'   => $handover,
                'handoverImg'=> $handoverImg,
                'expense'    => $expense
            );
        } catch (PDOException $e) {
            return "Database connection failed: " . $e->getMessage();
        
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        
        } finally {
            $con = null;
        }
    }

    public function createHandOver($data){
        $con_in  = Setting::$condition[$data['handover']['inside']];
        $con_out = Setting::$condition[$data['handover']['outside']];
        $fuel    = Setting::$fuel[$data['handover']['fuel']];
        $r  = "<div class='col-sm-12'>";
        $r .= " <h4 class='text-primary'><strong>การส่งมอบยานพาหนะ</strong></h4>";
        $r .= "     <div class='post clearfix'>";
        $r .= "         <div class='row'>";
        $r .= "             <div class='col-sm-12 col-lg-4'>";
        $r .= "                 <div class='card card-primary card-outline'>";
        $r .= "                     <div class='card-header'>";
        $r .= "                         <h3 class='card-title text-primary'>สภาพภายใน - <b>$con_in</b></h3>";
        $r .= "                     </div>";
        $r .= "                 <div class='card-body'>";
        if(!empty($data['handoverImg']['inside'])){
            foreach ($data['handoverImg']['inside'] as $v){
                $r .= "             <img class='modal-img m-0 p-0' src='dist/temp_img/$v' data-id='dist/temp_img/$v' alt='Img'  data-toggle='modal' data-target='#modal-img'>";
            }
        } else {
            $r .= "                 <div class='text-center'>ไม่มีรูปภาพ</div>";
        }
        $r .= "</div></div></div>";
        $r .= "             <div class='col-sm-12 col-lg-4'>";
        $r .= "                 <div class='card card-primary card-outline'>";
        $r .= "                     <div class='card-header'>";
        $r .= "                         <h3 class='card-title text-primary'>สภาพภายนอก - <b>$con_out</b></h3>";
        $r .= "                     </div>";
        $r .= "                 <div class='card-body'>";
        if(!empty($data['handoverImg']['outside'])){
            foreach ($data['handoverImg']['outside'] as $v){
                $r .= "             <img class='modal-img m-0 p-0' src='dist/temp_img/$v' data-id='dist/temp_img/$v' alt='Img'  data-toggle='modal' data-target='#modal-img'>";
            }
        } else {
            $r .= "                 <div class='text-center'>ไม่มีรูปภาพ</div>";
        }
        $r .= "</div></div></div>";
        $r .= "             <div class='col-sm-12 col-lg-4'>";
        $r .= "                 <div class='card card-primary card-outline'>";
        $r .= "                     <div class='card-header'>";
        $r .= "                         <h3 class='card-title text-primary'>ปริมาณน้ำมันที่เหลือ - <b>$fuel</b></h3>";
        $r .= "                     </div>";
        $r .= "                 <div class='card-body'>";
        if(!empty($data['handoverImg']['fuel'])){
            foreach ($data['handoverImg']['fuel'] as $v){
                $r .= "             <img class='modal-img m-0 p-0' src='dist/temp_img/$v' data-id='dist/temp_img/$v' alt='Img'  data-toggle='modal' data-target='#modal-img'>";
            }
        } else {
            $r .= "                 <div class='text-center'>ไม่มีรูปภาพ</div>";
        }
        $r .= "</div></div></div></div></div>";

        if(!empty($data['expense'])){
            $r .= $this->createExpense($data['expense']);
        }
        $r .= "</div></div>";
        return $r;
    }

    public function createExpense($data){
        $total = 0;
        $r  = "<div class='post clearfix'>";
        $r .= " <div class='row'>";
        $r .= "     <div class='col-sm-12'>";
        $r .= "         <h5 class='text-primary'>ค่าใช้จ่าย</h5>";
        $r .= "     </div>";
        $r .= " </div>";
        $r .= "<div class='row'>";
        $r .= " <div class='col-12'>";
        $r .= "     <table class='table table-striped table-hover'>";
        $r .= "         <thead>";
        $r .= "             <tr class='bg-light'>";
        $r .= "                 <th scope='col' style='width:2%' class='text-center'>#</th>";
        $r .= "                 <th scope='col' style='width:10%' class='text-center'>รายการค่าใช้จ่าย</th>";
        $r .= "                 <th scope='col' style='width:2%'>จำนวนเงิน</th>";
        $r .= "             </tr>";
        $r .= "         </thead>";
        $r .= "         <tbody>";
        foreach($data as $k => $v){
            $r .= "         <tr>";
            if($v['img'] != 0){
                $r .= "             <td class='text-center'><img class='modal-img m-0 p-0'src='dist/temp_img/".$v['img']."' data-id='dist/temp_img/".$v['img']."' alt='Img'  data-toggle='modal' data-target='#modal-img'></td>";
            } else {
                $r .= "             <td></td>";
            }
            $r .= "                 <td>".$v['name']."</td>";
            $r .= "                 <td>".$v['amount']."</td>";
            $r .= "         </tr>";
            $total += intval($v['amount']);
        }
        $r .= "         </tbody>";
        $r .= "         <tfoot>";
        $r .= "             <tr class='bg-light'>";
        $r .= "                 <td colspan='2' class='text-right'>รวมค่าใช้จ่ายทั้งหมด(บาท):</td>";
        $r .= "                 <td class='text-right'>";
        $r .= "                     <div class='doubleUnderline d-inline'>$total</div> บาท";
        $r .= "                 </td>";
        $r .= "                </tr>";
        $r .= "         </tfoot>";
        $r .= "        </table>";
        $r .= "     </div></div></div>";

        return $r;
    }

    public function getArrData($MD, $Name, $Acc, $TimeLine, $Handover, $Miles){
        return array(
            'status'          => $MD['reservation_status'],
            'res_id'          => $MD['id_reservation'],
            'vehicle_name'    => $MD['vehicle_name'],
            'id_vehicle'      => $MD['ref_id_vehicle'],
            'start'           => $MD['start_date'],
            'end'             => $MD['end_date'],
            'id_user'         => $MD['ref_id_user'],
            'userName'        => $Name,
            'place_Name'      => $MD['place_name'],
            'lat'             => $MD['latitude'],
            'lng'             => $MD['longitude'],
            'zm'              => $MD['zoom'],
            'companion'       => $MD['traveling_companion'],
            'reason'          => $MD['reason'],
            'acc'             => $Acc,
            'driver'          => getDriver($MD['ref_id_driver']),
            'attachment'      => $MD['attachment'],
            'date_attachment' => $MD['date_uploaded'],
            'timeline'        => $TimeLine,
            'handover'        => $Handover,
            'urgent'          => $MD['urgent'],
            'id_mile'         => $Miles['id_mile'],
            'mileIn'          => $Miles['mile_in'],
            'mileOut'         => $Miles['mile_out']
        );
    }
}

