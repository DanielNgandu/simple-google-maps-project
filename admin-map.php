<?php
include('dbc.php');
$select = mysqli_query($con, "SELECT img FROM locations1 ");
$i = 1;
while ($rowval = mysqli_fetch_array($select)) {
    //$id= $rowval['id'];
// $lat = $rowval ['lat'];                
    //$lng = $rowval ['lng'];
    //$description = $rowval['description'];
    //$status = $rowval ['location_status'];
    $img = $rowval ['img'];
    //$created = $rowval ['created'];
    $i = $i + 1;
    //echo" error".mysqli_error($con);
    ?>

    <?php
    include_once 'header.php';
    include_once 'locations_model.php';
    include_once 'dbc.php';
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div id="map"></div>

    <!------ Include the above in your HEAD tag ---------->
    <script>
        var map;
        var marker;
        var infowindow;
        var red_icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        var green_icon = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
        var purple_icon = 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
        var locations = <?php get_all_locations() ?>;

        function initMap() {
            var copperbelt = {lat: -13.0618638, lng: 25.6712316};
            infowindow = new google.maps.InfoWindow();
            map = new google.maps.Map(document.getElementById('map'), {
                center: copperbelt,
                zoom: 7
            });
            /**
             * loop through (Mysql) dynamic locations to add markers to map.
             */
            var i;
            var confirmed = 0;
            for (i = 0; i < locations.length; i++) {
                var image = locations[i][4];
                var lat = locations[i][1];
                var lng = locations[i][2];

                marker = new google.maps.Marker({

                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: locations[i][5] === '1' ? green_icon  : purple_icon,
                    html: "<form onsubmit='postData()'> <div id='info'>"
                        +
                        "<div class='form-group'><label>Uploaded Photo:</label>" +
                        "<img src ='images/" + image.replace(/C:\\fakepath\\/i, '') + "' height='150' width= '150'/></div><hr/>" +
                        "<div class='form-group'><label for='exampleFormControlSelect1'>Description Type</label>" +
                        "<input disabled='disabled' id='description_type' value=" + locations[i][6] + "><hr/></div>" +
                        "<input hidden='hidden' id='id' value=" + locations[i][0] + "><hr/></div>" +
                        "<div class='form-group'><br><label>Enter Description:</label>" +
                        "<textarea disabled='disabled' class ='form-control' required='required'  id='description' placeholder='Description...........'>" + locations[i][3] + " </textarea></div>" +
                        "<input  id='lat'   value=" + lat + " placeholder='lat' disabled='disabled'>" +
                        "<input   id='lng' value=" + lng + " placeholder='lat' disabled='disabled'><hr/></div>" +
                        "<button id='approve' class ='btn btn-lg btn-success form-control'  type='submit' value='1'>Approve</button>" +
                        "<button id='approve' class ='btn btn-lg btn-danger form-control'  type='submit' value='0'>Reject</button>" +
                        "</div></form>"
                });

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow = new google.maps.InfoWindow();
                        confirmed = locations[i][5] === '1' ? 'checked' : 0;
                        $("#confirmed").prop(confirmed, locations[i][5]);
                        $("#id").val(locations[i][0]);
                        $("#description").val(locations[i][3]);
                        $("#description_type").val(locations[i][6]);
                        $("#img").val(locations[i][4]);
                        $("#form").show();
                        infowindow.setContent(marker.html);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
        }

            function saveData() {
            var confirmed = document.getElementById('confirmed').checked ? 1 : 0;
            var id = document.getElementById('id').value;
            var url = 'approve_locations.php?confirm_location&id=' + id + '&confirmed=' + confirmed;
            downloadUrl(url, function (data, responseCode) {
                if (responseCode === 200 && data.length > 1) {
                    infowindow.close();
                    window.location.reload(true);
                } else {
                    infowindow.setContent("<div style='color: purple; font-size: 25px;'>Inserting Errors</div>");
                }
            });
        }

        function postData() {

            event.preventDefault();
            var a = $('#approve').val();
            var id = $('#id').val();
            if (a === 1) {
                var confirmed = $('#approve').val();
                $.ajax({
                    url: 'approve_locations.php',
                    data: {'confirmed':confirmed, 'id':id},
                    type: 'GET',
                    success: function (data) {
                        infowindow.close();
                        infowindow.setContent("<div style=' color: purple; font-size: 25px;'> Approved Successfully.</div>");
                        alert('Approved Successfully.');
                        location.reload();
                        console.log(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(thrownError + " " + xhr.statusText + " " + xhr.responseText);
                        console.log(data);
                        infowindow.setContent("<div style='color: red; font-size: 25px;'>Failed to Approve!</div>");
                    }
                });
            } else
            {

                 // alert('0');
                var notConfirmed = 0;
                $.ajax({
                    url: 'approve_locations.php',
                    data: {'confirmed':notConfirmed, 'id':id},
                    type: 'GET',
                    success: function (data) {
                        infowindow.close();
                        infowindow.setContent("<div style=' color: purple; font-size: 25px;'> Rejected Successfully.</div>");
                        alert('Rejected Successfully.');
                        location.reload();
                        console.log(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(thrownError + " " + xhr.statusText + " " + xhr.responseText);
                        console.log(data);
                        infowindow.setContent("<div style='color: red; font-size: 25px;'>Failed to Approve!</div>");
                    }
                });
            }
        }
    </script>


    <script async defer
            src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyBPnTnBYHZcQB7lCjzarHNyGH9ToUNPk_Y&callback=initMap">
    </script>
    <!-- End iMenu -->
    <!-- Begin Left Column -->
    <div id="column_l">
        <p>Date of the Day
            <?php
            echo date("d.m.y");
            ?>
        </p>
    </div>
<?php } ?>
<!-- Begin Footer -->
<div id="footer">

</div>
<!-- End Footer --></div>
<!-- End Container -->
</div>
</body>
</html>
