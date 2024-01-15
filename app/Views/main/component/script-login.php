<script>

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

$(document).ready(function () { //When the page has loaded

  $('form#frm_register').hide();
  
  $('.btn-back').click(function(){
        $("form#frm_register").trigger("reset");
        $('form#frm_login').fadeIn(1000).show();
        $('form#frm_register').fadeOut(1000).hide();
  });

  $('.btn-register').click(function(){
        $('form#frm_login').fadeOut(1000).hide();
        $('form#frm_register').fadeIn(1000).show();
  });


  $(document).on('click','#chk_register',function(e){    
    if($("#no_user").val()==""){
      sweetAlert("ผิดพลาด...", "กรุณากรอกรหัสพนักงาน", "error"); //The error will display
      return false;
    }else if($("#no_user").val().length<5){
      sweetAlert("ผิดพลาด...", "รหัสพนักงานไม่ถูกต้อง", "error"); //The error will display
      return false;
    }else if (!isEmail($("#email_regis").val())){
      sweetAlert("ผิดพลาด...", "รูปแบบอีเมล์ไม่ถูกต้อง!", "error"); //The error will display
      return false;
    }else if($("#password_regis").val()==""){
      sweetAlert("ผิดพลาด...", "กรุณากรอกรหัสผ่าน", "error"); //The error will display
      return false;
    }else if($("#fullname").val()==""){
      sweetAlert("ผิดพลาด...", "กรุณากรอกชื่อ-นามสกุล", "error"); //The error will display
      return false;
    }else if($('#slt_regis_site option:selected').val()<=0){
      sweetAlert("ผิดพลาด...", "เลือกไซต์งานของคุณ", "error"); //The error will display
      return false;
    }else if($('#slt_regis_dept option:selected').val()<=0){
      sweetAlert("ผิดพลาด...", "เลือกแผนกของคุณ", "error"); //The error will display
      return false;
    }else{
        var frmData = $("form#frm_register").serialize();
        $.ajax({
        url: "app/Views/main/functions/f-login.php",
        type: "POST",
        data: {'action':'regis', data:frmData},
        success: function (data) {
          console.log(data); 
          data = $.trim(data.replace(/\s+/g," "));
          if(data=='mail_dup'){           
            sweetAlert("อีเมล์นี้ถูกใช้งานแล้ว!", "อีเมล์ "+($('#email_regis').val())+" \r\n ถูกใช้งานแล้ว", "error");
            return false;
          }
          if ($.isNumeric(data)) {
            swal({
              title: "ลงทะเบียนสำเร็จ!",
              text: "กรุณารออนุมัติการใช้งาน. หรือแจ้งอีเมล์ที่ใช้ลงทะเบียน \r\n ในไลน์กลุ่มเพื่อเปิดใช้งาน",
              type: "success",
              //timer: 3000
            }, 
            function(){
              window.location.href = "./";
            })
          }
        },
        error: function (response) {
          console.log("ไม่สำเร็จ! มีบางอย่างผิดพลาด!"+response);
          sweetAlert("ไม่สำเร็จ!", 'กรุณาติดต่อฝ่าย IT', "error");
          return false;
        },
      });
    }
    e.preventDefault();
});

 //sweetAlert("ผิดพลาด...", "รูปแบบอีเมล์ไม่ถูกต้อง!", "error"); //The error will display

  $("#chk_login").click(function(){
  if (!isEmail($("#email").val())){
    sweetAlert("ผิดพลาด...", "รูปแบบอีเมล์ไม่ถูกต้อง!", "error"); //The error will display
		return false;
 	}else if($("#password").val()==""){
    sweetAlert("ผิดพลาด...", "กรุณากรอกรหัสผ่าน", "error"); //The error will display
		return false;
  }else if($('#slt_manage_site option:selected').val()<=0){
    sweetAlert("ผิดพลาด...", "เลือกไซต์งานของคุณ", "error"); //The error will display
		return false;
  } else {
      var frmData = $("form#frm_login").serialize();
    //   alert(frmData);
      $.ajax({
          url: "app/Views/main/functions/f-login.php",
          type: "POST",
          data: {
            'action': 'login',
            data: frmData
          },
          success: function (data) {
              console.log(data);
            //   return false;
              if (data == 0) {
                sweetAlert("ผิดพลาด...", "ไม่พบชื่อผู้ใช้งานตามที่ระบุ", "error");
                  return false;
              } 
              window.location.href = "./";

          },
          error: function (response) {
              console.log("ไม่สำเร็จ! มีบางอย่างผิดพลาด!" + response);
              sweetAlert("ไม่สำเร็จ!", 'กรุณาติดต่อฝ่าย IT', "error");
              return false;
          },
      });
      return false;
  }

  });

});

</script>


<?PHP
    // if(isset($_POST['email']) && isset($_POST['password']) ){
    //     $GetLogin = $Call->getLogin($_POST['email'],$_POST['password'],$_POST['slt_manage_site']);
    //     if(!is_string($GetLogin)){
    //         header('Location:./');
    //     } else {
    //         echo $GetLogin;
    //         exit;
    //     }
    // }
?>