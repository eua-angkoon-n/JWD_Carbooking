<?PHP
require_once (__DIR__ . '/functions/f-login-list.php');

$Call = new LoginList();
$Site = $Call->getSite();
$Dept = $Call->getDept();
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <?php include(__DIR__ . '/component/style-login.php'); ?>
</head>

<body class="hold-transition login-page" style="background:url(../dist/img/bg-img.png) no-repeat; background-position: 50% center;">

<section class="h-100">
    <div class="container h-100 col-md-12">
        <div class="row justify-content-md-center h-100">
            <div class="card-wrapper">
                <div class="brand text-center">
                    <img src="../dist/img/SCGJWDLogo.png" alt="logo" class="logo img-responsive m-0">
                </div>
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title text-center w-100 text-bold" style="line-height:1.8rem;"><?php echo Setting::$title;?>
                        </h4><br />
                        <!--ฟอร์มลงทะเบียน-->
                        <form method="POST" id="frm_register" name="frm_register" class="my-login-validation "
                            novalidate=""><br />
                            <div class="text-md text-bold text-red mt-2 mb-1 text-center">ลงทะเบียนใช้งานระบบ</div>

                            <div class="form-group">
                                <label for="no_user">รหัสพนักงาน</label>
                                <input type="text" maxlength="7" id="no_user" name="no_user" placeholder="รหัสพนักงาน"
                                    class="numberonly form-control w-10" onKeyPress="return IsNumeric(event);"
                                    aria-describedby="inputGroupPrepend" autocomplete="off" />
                                <div class="invalid-feedback">กรอกรหัสพนักงาน</div>
                            </div>

                            <div class="form-group">
                                <label for="fullname">ชื่อ-นามสกุล พนักงาน</label>
                                <input type="text" maxlength="40" id="fullname" name="fullname"
                                    placeholder="ชื่อ-นามสกุล" class="form-control w-10" autocomplete="off" />
                                <div class="invalid-feedback">กรอกชื่อ-นามสกุล พนักงาน</div>
                            </div>

                            <div class="form-group">
                                <label for="email">ระบุอีเมล์ที่ใช้งาน</label>
                                <input type="email" class="form-control" id="email_regis" name="email_regis" required
                                    autofocus>
                                <div class="invalid-feedback">Email is invalid</div>
                            </div>

                            <div class="form-group">
                                <label for="password">รหัสผ่าน</label>
                                <input id="password_regis" type="password" class="form-control" name="password_regis"
                                    autocomplete="off" required>
                                <div class="invalid-feedback">Password is required</div>
                            </div>

                            <div class="form-group">
                                <label for="slt_manage_site">ไซต์ที่งาน:</label> <br />
                                <select class="custom-select custom-select-md rounded-3" id="slt_regis_site"
                                    name="slt_regis_site" style="width:260px;">
                                    <option value="0">เลือกไซต์งาน</option>
                                    <?PHP echo $Site; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="slt_regis_dept">แผนกของคุณ:</label><br />
                                <select class="custom-select" id="slt_regis_dept" name="slt_regis_dept" required>
                                    <option value="0">เลือกแผนก</option>
                                    <?PHP echo $Dept; ?>
                                </select>
                            </div>

                            <div class="form-group m-0">
                                <button type="button" class="btn btn-success btn-block"
                                    id="chk_register">ลงทะเบียนใช้งาน</button>
                            </div>
                            <div class="mt-4 text-center"><a href="#" class="btn-back text-pimary"><i
                                        class="fas fa-undo-alt"></i> คลิกที่นี่เพื่อกลับไปหน้าล็อกอิน</a></div>
                        </form>

                        <!-------------------------------------------------------------->
                        <form method="POST" id="frm_login" name="frm_login" class="my-login-validation" novalidate="">
                            <br />
                            <div class="form-group">
                                <label for="email">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="" required
                                    autofocus>
                                <div class="invalid-feedback">Email is invalid</div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password"
                                    autocomplete="off" required>
                                <div class="invalid-feedback">Password is required</div>
                            </div>

                            <div class="form-group">
                                <label for="slt_manage_site">ไซต์ที่งาน:</label> <br />
                                <select class="custom-select custom-select-md rounded-3" id="slt_manage_site"
                                    name="slt_manage_site" style="width:260px;">
                                    <option value="0">เลือกไซต์งาน</option>
                                    <?PHP echo $Site; ?>
                                </select>
                            </div>

                            <div class="form-group m-0">
                                <button type="submit" class="btn btn-primary btn-block" id="chk_login">เข้าระบบ</button>
                            </div>
                            <!-- <div class="mt-4 text-center"><a href="#" class="btn-register text-pimary"><i
                                        class="fas fa-user-plus"></i>คลิกที่นี่เพื่อลงทะเบียนใช้งาน</a></div> -->
                        </form>
                    </div>
                </div>
                <div class="footer text-center">
                    Copyright &copy; 2024 &mdash; SCGJWD Logistics
                </div>
            </div>
        </div>
    </div>
</section>

<?php include(__DIR__ . "/component/script-login.php");?>


</body>
</html>