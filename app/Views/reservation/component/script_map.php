<script>
var map; // กำหนดตัวแปร map ไว้ด้านนอกฟังก์ชัน เพื่อให้สามารถเรียกใช้งาน จากส่วนอื่นได้
var GGM; // กำหนดตัวแปร GGM ไว้เก็บ google.maps Object จะได้เรียกใช้งานได้ง่ายขึ้น
var my_Marker1; // กำหนดตัวแปรเก็บ marker ตำแหน่งปัจจุบัน หรือที่ระบุ
var infowindow = []; // กำหนดตัวแปรสำหรับเก็บตัว popup แสดงรายละเอียดสถานที่
var infowindowTmp; // กำหนดตัวแปรสำหรับเก็บลำดับของ infowindow ที่เปิดล่าสุด
var my_Marker = []; // กำหนดตัวแปรสำหรับเก็บตัว marker เป็นตัวแปร array
function initialize() { // ฟังก์ชันแสดงแผนที่

    GGM = new Object(google.maps); // เก็บตัวแปร google.maps Object ไว้ในตัวแปร GGM

    // กำหนดจุดเริ่มต้นของแผนที่
    var my_Latlng = new GGM.LatLng(13.584586432868923, 100.29150401289502);

    var my_mapTypeId = GGM.MapTypeId.ROADMAP; // กำหนดรูปแบบแผนที่ที่แสดง
    // กำหนด DOM object ที่จะเอาแผนที่ไปแสดง ที่นี้คือ div id=map_canvas
    var my_DivObj = $("#map_canvas")[0];

    // กำหนด Option ของแผนที่
    var myOptions = {
        zoom: 10, // กำหนดขนาดการ zoom
        center: my_Latlng, // กำหนดจุดกึ่งกลาง
        mapTypeId: my_mapTypeId // กำหนดรูปแบบแผนที่
    };

    map = new GGM.Map(my_DivObj, myOptions); // สร้างแผนที่และเก็บตัวแปรไว้ในชื่อ map

    map.markers = []; // กำหนด property ของ object map ชื่อ markers ไว้เก็บ marker เป็น array
    $.ajax({
        url: "app/Views/reservation/component/marker.xml", // ใช้ ajax ใน jQuery เรียกใช้ไฟล์ xml 
        dataType: "xml",
        success: function (xml) {
            $(xml).find('marker').each(function (i) { // วนลูปดึงค่าข้อมูลมาสร้าง marker  
                var markerID = $(this).find("id").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน    
                var markerName = $(this).find("name").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน    
                var markerLat = $(this).find("latitude").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน    
                var markerLng = $(this).find("longitude").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน  

                // ส่วนสำหรับสร้างลิ้งค์ใน sidebar
                var navi_link = "<li><a href='javascript:showInfo(" + i + ")'>" + markerName + "</a></li>";
                $("#navigator_link").prepend(navi_link); // นำลิ้สรายการ พร้อมลิ้งค์ไปแสดงใน sidebar            

                var markerLatLng = new GGM.LatLng(markerLat, markerLng);
                my_Marker[i] = new GGM.Marker({ // สร้างตัว marker เป็นแบบ array
                    position: markerLatLng, // กำหนดไว้ที่เดียวกับจุดกึ่งกลาง
                    map: map, // กำหนดว่า marker นี้ใช้กับแผนที่ชื่อ instance ว่า map
                    title: markerName // แสดง title เมื่อเอาเมาส์มาอยู่เหนือ
                });
                map.markers.push(my_Marker[i]); // เก็บ object marker ไว้ในตัวแปร

                //  กรณีตัวอย่าง ดึง title ของตัว marker มาแสดง
                infowindow[i] = new GGM.InfoWindow({ // สร้าง infowindow ของแต่ละ marker เป็นแบบ array
                    content: my_Marker[i].getTitle() // ดึง title ในตัว marker มาแสดงใน infowindow
                });
                //              //  กรณีนำไปประยุกต์ ดึงข้อมูลจากฐานข้อมูลมาแสดง
                //              infowindow[i] = new GGM.InfoWindow({   
                //                  content:$.ajax({   
                //                      url:'placeDetail.php',//ใช้ ajax ใน jQuery ดึงข้อมูล   
                //                      data:'placeID='+markerID,// ส่งค่าตัวแปร ไปดึงข้อมูลจากฐานข้อมูล
                //                      async:false   
                //                  }).responseText   
                //              });             

                GGM.event.addListener(my_Marker[i], 'click', function () { // เมื่อคลิกตัว marker แต่ละตัว

                    if (infowindowTmp) { // ให้ตรวจสอบว่ามี infowindow ตัวไหนเปิดอยู่หรือไม่
                        infowindow[infowindowTmp].close(); // ถ้ามีให้ปิด infowindow ที่เปิดอยู่
                    }
                    infowindow[i].open(map, my_Marker[i]); // แสดง infowindow ของตัว marker ที่คลิก
                    infowindowTmp = i; // เก็บ infowindow ที่เปิดไว้อ้างอิงใช้งาน
                    // alert(markerName);

                    var latClick = markerLat; // e.latLng.lat().toFixed(6);
                    var lonClick = markerLng;
                    var latlonClck = new GGM.LatLng(latClick, lonClick);
                    my_Marker1.setPosition(latlonClck);
                    var my_Point = my_Marker1.getPosition(); // หาตำแหน่งของตัว marker เมื่อกดลากแล้วปล่อย
                    map.panTo(my_Point); // ให้แผนที่แสดงไปที่ตัว marker       
                    $("#map_lat").val(my_Point.lat()); // เอาค่า latitude ตัว marker แสดงใน textbox id=lat_value
                    $("#map_lon").val(my_Point.lng()); // เอาค่า longitude ตัว marker แสดงใน textbox id=lon_value 
                    $("#map_zoom").val(map.getZoom());
                    $("#map_place").val(markerName);
                    getAddressFromGeocode(my_Point.lat(), my_Point.lng(), function (placeID) {
                        $("#map_place_id").val(placeID);
                    });
                });
            });
        }
    });

    my_Marker1 = new GGM.Marker({ // สร้างตัว marker
        position: my_Latlng, // กำหนดไว้ที่เดียวกับจุดกึ่งกลาง
        map: map, // กำหนดว่า marker นี้ใช้กับแผนที่ชื่อ instance ว่า map
        icon: "dist/img/car.svg",
        draggable: true, // กำหนดให้สามารถลากตัว marker นี้ได้
        title: "คลิกลากเพื่อหาตำแหน่งจุดที่ต้องการ!" // แสดง title เมื่อเอาเมาส์มาอยู่เหนือ
    });


    // กำหนด event ให้กับตัว marker เมื่อสิ้นสุดการลากตัว marker ให้ทำงานอะไร
    GGM.event.addListener(my_Marker1, "dragend", function (e) {
        var latClick = e.latLng.lat(); // e.latLng.lat().toFixed(6);
        var lonClick = e.latLng.lng();
        var latlonClck = new GGM.LatLng(latClick, lonClick);
        my_Marker1.setPosition(latlonClck);
        var my_Point = my_Marker1.getPosition(); // หาตำแหน่งของตัว marker เมื่อกดลากแล้วปล่อย
        map.panTo(my_Point); // ให้แผนที่แสดงไปที่ตัว marker       
        $("#map_lat").val(my_Point.lat()); // เอาค่า latitude ตัว marker แสดงใน textbox id=lat_value
        $("#map_lon").val(my_Point.lng()); // เอาค่า longitude ตัว marker แสดงใน textbox id=lon_value 
        $("#map_zoom").val(map.getZoom()); // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_value  

        getAddressFromGeocode(latClick, lonClick, function (placeID) {
            // console.log(placeID);
            getNameOfPlaceFromPlaceID(placeID, map, function (name) {
                $("#map_place").val(name);
                $("#map_place_id").val(placeID);
                // console.log(name);
            });
        });
    });
    // กำหนด event ให้กับตัวแผนที่ เมื่อมีการเปลี่ยนแปลงการ zoom
    GGM.event.addListener(map, "zoom_changed", function () {
        $("#map_zoom").val(map.getZoom()); // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_value  
    });

    // กำหนด event ให้กับตัวแผนที่ เมื่อมีการเปลี่ยนแปลงการ zoom
    GGM.event.addListener(map, "click", function (e) {
        // เรียกใช้ฟังก์ชันหาตำแหน่งใกล้เคียง        
        // find_closest_marker(e);              
        var latClick = e.latLng.lat(); // e.latLng.lat().toFixed(6);
        var lonClick = e.latLng.lng();
        var latlonClck = new GGM.LatLng(latClick, lonClick);
        my_Marker1.setPosition(latlonClck);
        var my_Point = my_Marker1.getPosition(); // หาตำแหน่งของตัว marker เมื่อกดลากแล้วปล่อย
        map.panTo(my_Point); // ให้แผนที่แสดงไปที่ตัว marker       
        $("#map_lat").val(my_Point.lat()); // เอาค่า latitude ตัว marker แสดงใน textbox id=lat_value
        $("#map_lon").val(my_Point.lng()); // เอาค่า longitude ตัว marker แสดงใน textbox id=lon_value 
        $("#map_zoom").val(map.getZoom()); // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_value 

        getAddressFromGeocode(latClick, lonClick, function (placeID) {
            // console.log(placeID);
            getNameOfPlaceFromPlaceID(placeID, map, function (name) {
                $("#map_place").val(name);
                $("#map_place_id").val(placeID);
                // console.log(name);
            });
        });

    });
}

function getAddressFromGeocode(lat, lng, callback) {
    var latlng = new GGM.LatLng(lat, lng);
    var geocoder = new GGM.Geocoder();

    geocoder.geocode({
        'latLng': latlng
    }, function (results, status) {
        if (status == GGM.GeocoderStatus.OK) {
            if (results[0]) {
                callback(results[0].place_id);
            } else {
                callback("ไม่มีชื่อ");
            }
        } else {
            callback("Geocoder failed due to: " + status);
        }
    });
}

function getNameOfPlaceFromPlaceID(placeID, map, callback) {

    const request = {
        placeId: placeID,
        fields: ["name", "formatted_address", "place_id", "geometry"],
    };
    const service = new google.maps.places.PlacesService(map);

    service.getDetails(request, (place, status) => {
        if (status === google.maps.places.PlacesServiceStatus.OK && place) {
            callback(place.name);
        } else {
            callback("Place details not found");
        }
    });
}

function rad(x) {
    return x * Math.PI / 180;
} // ฟังก์ชั่นที่กี่ยวข้อง
// function find_closest_marker(event) { // ฟังก์ชั่นหาตำแหน่งใกล้เคียง
//     var lat = event.latLng.lat(); // ตำแหน่ง lat ที่เราเลือก
//     var lng = event.latLng.lng(); // ตำแหน่ง lng ที่เราเลือก
//     var R = 6371; // รัศมีของโลกเป็น กิโลเมตร
//     var distances = []; // กำหนดตัวแปร array ไว้เก็บระยะห่าง เทียบกับ marker แต่ละตัว
//     var closest = -1; // กำหนดค่าไว้เก็บตำแหน่าง key ของ marker ที่ใกล้ที่สุด
//     for (i = 0; i < map.markers.length; i++) { // วนลูป marker
//         // เริ่มต้นส่วนของสูตรการคำนวณหาระยะทาง
//         var mlat = map.markers[i].position.lat();
//         var mlng = map.markers[i].position.lng();
//         var dLat = rad(mlat - lat);
//         var dLong = rad(mlng - lng);
//         var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
//             Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
//         var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
//         var d = R * c; // ได้ตัวแปร d คือระยะยทาง
//         // สิ้นสุด ส่วนของสูตรการคำนวณหาระยะทาง
//         distances[i] = d; // เก็บระยะทางไว้ใน ตัวแปร array
//         if (closest == -1 || d < distances[closest]) { // เทียบระยะทางหาค่าที่น้ยอ หรือใกล้ที่สุด
//             closest = i; // เก็บ key ของ marker ที่ใกล้ที่สุด
//         }
//     }
//     // แสดง title ของ marker ที่ใกล้เคียง
//     alert(map.markers[closest].title);
// }

// Function to update map_olv with coordinates and zoom
function updateMapOlv(lat, lng, zoom) {
    var mapOlv = new google.maps.Map($("#map_olv")[0], {
        center: { lat: parseFloat(lat), lng: parseFloat(lng) },
        zoom: parseInt(zoom),
        draggable: false, // Disable dragging
        scrollwheel: false, // Disable scrollwheel
        disableDoubleClickZoom: true, // Disable double click zoom
        disableDefaultUI: true // Disable default UI controls
    });

    // Add a marker to map_olv if needed
    var markerOlv = new google.maps.Marker({
        position: { lat: parseFloat(lat), lng: parseFloat(lng) },
        map: mapOlv
    });
}

$(function () {
    // โหลด สคริป google map api เมื่อเว็บโหลดเรียบร้อยแล้ว
    // ค่าตัวแปร ที่ส่งไปในไฟล์ google map api
    // v=3.2&sensor=false&language=th&callback=initialize
    //  v เวอร์ชัน่ 3.2
    //  sensor กำหนดให้สามารถแสดงตำแหน่งทำเปิดแผนที่อยู่ได้ เหมาะสำหรับมือถือ ปกติใช้ false
    //  language ภาษา th ,en เป็นต้น
    //  callback ให้เรียกใช้ฟังก์ชันแสดง แผนที่ initialize
    $("<script/>", {
        "type": "text/javascript",
        //    src: "//maps.google.com/maps/api/js?v=3.2&key=AIzaSyDK0J3fhDvmz99vcudgZI8KxEC7zlAl0JI&sensor=false&language=th&callback=initialize
        src: "//maps.google.com/maps/api/js?key=AIzaSyD_3uR-M8yPx3Tv8DAgbenP2-vJfxzxSD8&language=th&libraries=places&callback=initialize"
    }).appendTo("body");
});

</script>

<!-- //src: "https://maps.google.com/maps/api/js?v=3.2&sensor=false&language=th&callback=initialize"
        src: "//maps.google.com/maps/api/js?v=3.2&key=AIzaSyDK0J3fhDvmz99vcudgZI8KxEC7zlAl0JI&sensor=false&language=th&callback=initialize"
        //src: "https://maps.google.com/maps/api/js?v=3.2&sensor=false&language=th&callback=initialize&_=1700194845323" -->