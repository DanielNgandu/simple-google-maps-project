<?php
 include('dbc.php');
  $select=mysqli_query($con,"SELECT img FROM locations1 ");
  $i=1;
  while($rowval=mysqli_fetch_array($select))
  {
 //$id= $rowval['id'];
// $lat = $rowval ['lat'];                
 //$lng = $rowval ['lng'];
 //$description = $rowval['description'];
 //$status = $rowval ['location_status'];
 $img = $rowval ['img'];
 //$created = $rowval ['created'];
  $i=$i+1;
 //echo" error".mysqli_error($con);
?>

<?php
include_once 'header.php';
include_once 'locations_model.php';
include_once 'dbc.php';
?>


<div id="map"></div>

<!------ Include the above in your HEAD tag ---------->
<script>
    var map;
    var marker;
    var infowindow;
    var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
    var green_icon =  'http://maps.google.com/mapfiles/ms/icons/green-dot.png' ;
    var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
    var locations = <?php get_all_locations() ?>;

    function initMap() {
        var copperbelt = {lat: -13.0618638, lng: 25.6712316};
        infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(document.getElementById('map'), {
            center: copperbelt,
            zoom: 7
        });
        var i ; var confirmed = 0;
        for (i = 0; i < locations.length; i++) {

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon :   locations[i][5] === '1' ?  green_icon  : purple_icon,
                html: document.getElementById('form')
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    confirmed =  locations[i][5] === '1' ?  'checked'  :  0;
                    $("#confirmed").prop(confirmed,locations[i][5]);
                    $("#id").val(locations[i][0]);
                    $("#description").val(locations[i][3]);
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
        var url = 'locations_model.php?confirm_location&id=' + id + '&confirmed=' + confirmed ;
        downloadUrl(url, function(data, responseCode) {
            if (responseCode === 200  && data.length > 1) {
                infowindow.close();
                window.location.reload(true);
            }else{
                infowindow.setContent("<div style='color: purple; font-size: 25px;'>Inserting Errors</div>");
            }
        });
    }


    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                callback(request.responseText, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }
</script>
<div style="display: none" id="form">
    <table class="map1">
        <th>Photo</th>
        <td>
<?php echo '<img src="data:img/jpg;base64,'.base64_encode($rowval['img']).'"width="50" height="50">';
        ?></td>
        <tr>
            <input name="id" type='hidden' id='id'/>
            <td><a>Description:</a></td>
            <td><textarea disabled id='description' placeholder='Description'></textarea></td>
        </tr>
        <tr>
            <td><b>Confirm Location ?:</b></td>
            <td><input id='confirmed' type='checkbox' name='confirmed'></td>
        </tr>

        <tr><td></td><td><input type='button' value='Save' onclick='saveData()'/></td></tr>
    </table>
</div>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyBPnTnBYHZcQB7lCjzarHNyGH9ToUNPk_Y&callback=initMap">
</script>
    <!-- End iMenu -->
    <!-- Begin Left Column -->
    <div id="column_l">
        <p>Date of the Day
           <?php 
           echo date ("d.m.y");
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
