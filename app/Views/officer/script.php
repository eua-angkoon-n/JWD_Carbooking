<script type="text/javascript">

$(document).ready(function() {
    
    $(document).on("click", "#custom-tab2", function (){    
        $('#custom-tabs-2').html();
    }); 
    
    $(document).on("click", "#custom-tab1", function () {
        $('#custom-tabs-2').empty();
        $.ajax({
            url: "app/Views/officer/vehicle_driver/v-list.php",
            type: "POST",
            data: {
                "action": "getdata"
            },
            beforeSend: function () {
            },
            success: function (data) {
                // console.log(data);
                $('#custom-tabs-1').html(data);
                event.preventDefault();
            },
            error: function (jXHR, textStatus, errorThrown) {
                //console.log(data);
                alert(errorThrown);
            }
        });
    });

    $(document).on("click", "#custom-tab2", function (event) {
        $('#custom-tabs-1').empty();
        $.ajax({
            url: "app/Views/officer/security/v-list.php",
            type: "POST",
            data: {
                "action": "getdata"
            },
            beforeSend: function () {
            },
            success: function (data) {
                // console.log(data);
                $('#custom-tabs-2').html(data);
                event.preventDefault();
            },
            error: function (jXHR, textStatus, errorThrown) {
                //console.log(data);
                alert(errorThrown);
            }
        });
    });

});
</script>