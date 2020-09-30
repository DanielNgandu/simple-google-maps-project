<?php
if (isset($_POST["submit"])) {
    $con = mysqli_connect("localhost", 'root', '', 'tree');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }

    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $description = $_POST['description'];
    $description_type_id = $_POST['description_type_id'];
    $target_dir = "images/";
    $name = $_FILES['img']['name'];
    //new image name+timestamp
    $img = date('Dm.d.YTh_i_sa')."_".$name;
    $temp_name = $_FILES['img']['tmp_name'];
    if (isset($name) and !empty($name)) {
        if (move_uploaded_file($temp_name, $target_dir . $img)) {
            echo 'File uploaded successfully';
        }
    } else {
        echo 'You should select a file to upload !!';
    }

// Inserts new row with place data.
    $query = sprintf("INSERT INTO locations1 " .
        " (id, lat, lng,description_type_id,img,description) " .
        " VALUES (NULL, '%s','%s', '%s','%s','%s');",
        mysqli_real_escape_string($con, $lat),
        mysqli_real_escape_string($con, $lng),
        mysqli_real_escape_string($con, $description_type_id),
        mysqli_real_escape_string($con, $img),
        mysqli_real_escape_string($con, $description));

    $result = mysqli_query($con, $query);
    echo "Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
} ?>