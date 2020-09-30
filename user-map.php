<?php
include_once 'header.php';
include 'locations_model.php';
//get_unconfirmed_locations();exit;
?>
<?php
include 'dbc.php';
$select = mysqli_query($con, "SELECT img FROM locations1 ");

while ($rowval = mysqli_fetch_array($select)) {
    //$id= $rowval['id'];
    // $lat = $rowval ['lat'];
    //$lng = $rowval ['lng'];
    //$description = $rowval['description'];
    //$status = $rowval ['location_status'];
    $img = $rowval['img'];
    //$created = $rowval ['created'];

    //echo" error".mysqli_error($con);
    ?>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyBPnTnBYHZcQB7lCjzarHNyGH9ToUNPk_Y">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div id="map"></div>
    <script>
        /**
         * Create new map
         */
        var infowindow;
        var map;
        var red_icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        var purple_icon = 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
        var locations = <?php get_confirmed_locations()?>;
        var myOptions = {
            zoom: 7,
            center: new google.maps.LatLng(-13.0618638, 25.6712316),
            mapTypeId: 'roadmap'
        };
        map = new google.maps.Map(document.getElementById('map'), myOptions);

        /**
         * Global marker object that holds all markers.
         * @type {Object.<string, google.maps.LatLng>}
         */
        var markers = {};

        /**
         * Concatenates given lat and lng with an underscore and returns it.
         * This id will be used as a key of marker to cache the marker in markers object.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {string} Concatenated marker id.
         */
        var getMarkerUniqueId = function (lat, lng) {
            return lat + '_' + lng;
        };

        /**
         * Creates an instance of google.maps.LatLng by given lat and lng values and returns it.
         * This function can be useful for getting new coordinates quickly.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {google.maps.LatLng} An instance of google.maps.LatLng object
         */
        var getLatLng = function (lat, lng) {
            return new google.maps.LatLng(lat, lng);
        };
        /**
         * Binds click event to given map and invokes a callback that appends a new marker to clicked location.
         */
        var addMarker = google.maps.event.addListener(map, 'click', function (e) {
            var lat = e.latLng.lat(); // lat of clicked point
            var lng = e.latLng.lng(); // lng of clicked point
            var markerId = getMarkerUniqueId(lat, lng); // an that will be used to cache this marker in markers object.
            var marker = new google.maps.Marker({
                position: getLatLng(lat, lng),
                map: map,
                animation: google.maps.Animation.DROP,
                id: 'marker_' + markerId,
                html: "   <form id='addNewMarkerForm' name='addNewMarkerForm' method='post' onsubmit='postData()'> <div id='info_" + markerId + "'>\n" +
                    "        <table class=\"map1\">\n" +
                    "            <tr>\n" +
                    "           <tr><a>Attach Photo:</a></tr>\n" +
                    "           <td><input type='file' id='img' name='htmlFileUpload'/></td>" +
                    "                <td><label>Description:</label></td>\n" +
                    "                <td><textarea  id='description' placeholder='Description'></textarea></td></tr>\n" +
                    "                <td>" +
                    "<input  id='lat' hidden='hidden'  value="+lat+" placeholder='lat'></td></tr>\n" +
                    "<input hidden='hidden'  id='lng' value="+lng+" placeholder='lat'></td></tr>\n" +
                    "            <tr><td></td><td><input type='submit' value='Save' /></td></tr>\n" +
                    "        </table>\n" +
                    "    </div></form>"
            });
            markers[markerId] = marker; // cache marker in markers object
            bindMarkerEvents(marker); // bind right click event to marker
            bindMarkerinfo(marker); // bind infowindow with click event to marker
        });

        /**
         * Binds  click event to given marker and invokes a callback function that will remove the marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
         */
        var bindMarkerinfo = function (marker) {
            google.maps.event.addListener(marker, "click", function (point) {
                var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
                var marker = markers[markerId]; // find marker
                var img = document.createElement('img');
                img.src = 'img/200.jpg';
                img.style.with = '50px';
                infowindow = new google.maps.InfoWindow();
                infowindow.setContent(marker.html);
                infowindow.open(map, marker, img);
                // removeMarker(marker, markerId); // remove it
            });
        };

        /**
         * Binds right click event to given marker and invokes a callback function that will remove the marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
         */
        var bindMarkerEvents = function (marker) {
            google.maps.event.addListener(marker, "rightclick", function (point) {
                var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
                var marker = markers[markerId]; // find marker
                removeMarker(marker, markerId); // remove it
            });
        };

        /**
         * Removes given marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that will be removed.
         * @param {!string} markerId Id of marker.
         */
        var removeMarker = function (marker, markerId) {
            marker.setMap(null); // set markers setMap to null to remove it from map
            delete markers[markerId]; // delete marker instance from markers object
        };
        /**
         * loop through (Mysql) dynamic locations to add markers to map.
         */
        var i;
        var confirmed = 0;
        for (i = 0; i < locations.length; i++) {
            var image = '<?php echo $img; ?>';

            marker = new google.maps.Marker({

                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon: locations[i][5] === '1' ? red_icon : purple_icon,
                html: "<div>\n" +
                    "<table class=\"map1\">\n" +
                    "<th>Photo:</th>\n" +
                    "<td style=width='100'><img src ='images/"+ image.replace(/C:\\fakepath\\/i, '') + "' height='150' width= '150'/></td>\n" +
                    "<tr>\n" +
                    "<td><a>Description:</a></td>\n" +
                    "<td><textarea disabled id='manual_description' placeholder='Description'>" + locations[i][3] + "</textarea></td></tr>\n" +
                    "</table>\n" +
                    "</div>"
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow = new google.maps.InfoWindow();
                    confirmed = locations[i][5] === '1' ? 'checked' : 0;
                    $("#confirmed").prop(confirmed, locations[i][5]);
                    $("#id").val(locations[i][0]);
                    $("#description").val(locations[i][3]);
                    $("#img").val(locations[i][4]);
                    $("#form").show();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }

        /**
         * SAVE save marker from map.
         * @param lat  A latitude of marker.
         * @param lng A longitude of marker.
         */
        function saveData(lat, lng) {
            var description = document.getElementById('description').value;
            var img = document.getElementById('img').value;
            var url = 'locations_model.php';
            downloadUrl(url, description, img, lat, lng, function (data, responseCode) {
                // if (responseCode === 200 && data.length === 4) {
                    var markerId = getMarkerUniqueId(lat, lng); // get marker id by using clicked point's coordinate
                    var manual_marker = markers[markerId]; // find marker
                    manual_marker.setIcon(purple_icon);
                    infowindow.close();
                    infowindow.setContent("<div style=' color: purple; font-size: 25px;'> Waiting for admin to confirm!!</div>");
                    infowindow.open(map, manual_marker);

                // } else {
                //     console.log(responseCode);
                //     console.log(data);
                //     infowindow.setContent("<div style='color: red; font-size: 25px;'>Inserting Errors</div>");
                // }
            });
        }

        function downloadUrl(url, description, img, lat, lng, callback) {
            var formData = new FormData();
            formData.append("description", description);
            formData.append("img", img.replace(/C:\\fakepath\\/, ''));
            formData.append("lat", lat);
            formData.append("lng", lng);
            formData.append("submit", 'true');


            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    callback(this.readyState, this.status);
                }
            };
            xhttp.open("POST", "add_location.php", true);
            xhttp.send(formData);
        }
        
        function postData() {
            event.preventDefault();
        // alert("Hellow");
        //     alert(document.getElementById('lat').value);
        //     var form = $('form').serialize();
            // window.alert(form);
            // console.log(form.val);
            var file = $('#img').prop('files')[0];
            var description = $('#description').val();
            var lat = $('#lat').val();
            var lng = $('#lng').val();
            // var submit = 'true';
            var formData = new FormData();
            formData.append("description", description);
            formData.append("img", file);
            formData.append("lat", lat);
            formData.append("lng", lng);
            formData.append("submit", 'true');

            $.ajax({
                url: 'add_location.php',
                    contentType: false, // important
                    processData: false, // important

                    data: formData,
                method: 'post',
                success: function(data) {
                    var markerId = getMarkerUniqueId(lat, lng); // get marker id by using clicked point's coordinate
                    var manual_marker = markers[markerId]; // find marker
                    manual_marker.setIcon(purple_icon);
                    infowindow.close();
                    infowindow.setContent("<div style=' color: purple; font-size: 25px;'> Waiting for admin to confirm!!</div>");
                    infowindow.open(map, manual_marker);
                    console.log(data);
                }
            });

        }
        // $('#addNewMarkerForm').submit(function(e) {
        //     e.preventDefault();
        //     // get all the inputs into an array.
        //     var $inputs = $('#addNewMarkerForm :input');
        //    console.log($inputs);
        //     // not sure if you wanted this, but I thought I'd add it.
        //     // get an associative array of just the values.
        //     var values = {};
        //     $inputs.each(function() {
        //         values[this.name] = $(this).val();
        //     });
        //
        // });
    </script>
    <?php
    include_once 'footer.php';
    ?>
    </div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    </div>
    <!-- end #content -->
    <!-- end #sidebar -->
    <div style="clear: both;">&nbsp;</div>
    </div>
    </div>
    </div>
<?php } ?>
<!-- end #page -->
</div>