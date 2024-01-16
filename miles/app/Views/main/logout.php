<?php
session_destroy(); //เคลียร์ค่า session
header('Location:./'); //Logout เรียบร้อยและกระโดดไปหน้าตามที่ต้องการ
?>