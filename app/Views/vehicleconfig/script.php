<script type="text/javascript">

$(document).ready(function() {
    
    $(document).on("click", "#custom-tab2", function (){    
        $('#custom-tabs-2').html();
        $('#custom-tabs-3').html();
        $('#custom-tabs-4').html();
        $('#custom-tabs-6').html();
    }); 
    
    $(document).on("click", "#custom-tab1", function () {
        $('#custom-tabs-2').empty();
        $('#custom-tabs-3').empty();
        $('#custom-tabs-4').empty();
        $('#custom-tabs-6').empty();
        $.ajax({
            url: "app/Views/vehicleconfig/vehicle/v-list.php",
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
        $('#custom-tabs-3').empty();
        $('#custom-tabs-4').empty();
        $('#custom-tabs-6').empty();
        $.ajax({
            url: "app/Views/vehicleconfig/vehicle_type/v-list.php",
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

    $(document).on("click", "#custom-tab3", function (event) {
        $('#custom-tabs-1').empty();
        $('#custom-tabs-2').empty();
        $('#custom-tabs-4').empty();
        $('#custom-tabs-6').empty();
        $.ajax({
            url: "app/Views/vehicleconfig/vehicle_brand/v-list.php",
            type: "POST",
            data: {
                "action": "getdata"
            },
            beforeSend: function () {
            },
            success: function (data) {
                //console.log(data);
                $('#custom-tabs-3').html(data);
                event.preventDefault();
            },
            error: function (jXHR, textStatus, errorThrown) {
                //console.log(data);
                alert(errorThrown);
            }
        });
    });

    $(document).on("click", "#custom-tab4", function (event) {
        $('#custom-tabs-1').empty();
        $('#custom-tabs-2').empty();
        $('#custom-tabs-3').empty();
        $('#custom-tabs-6').empty();
        $.ajax({
            url: "app/Views/vehicleconfig/vehicle_acc/v-list.php",
            type: "POST",
            data: {
                "action": "getdata"
            },
            beforeSend: function () {
            },
            success: function (data) {
                //console.log(data);
                $('#custom-tabs-4').html(data);
                event.preventDefault();
            },
            error: function (jXHR, textStatus, errorThrown) {
                //console.log(data);
                alert(errorThrown);
            }
        });
    });

    $(document).on("click", "#custom-tab6", function (event) {
        $('#custom-tabs-1').empty();
        $('#custom-tabs-2').empty();
        $('#custom-tabs-3').empty();
        $('#custom-tabs-4').empty();
        $.ajax({
            url: "app/Views/vehicleconfig/vehicle_expense/v-list.php",
            type: "POST",
            data: {
                "action": "getdata"
            },
            beforeSend: function () {
            },
            success: function (data) {
                //console.log(data);
                $('#custom-tabs-6').html(data);
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