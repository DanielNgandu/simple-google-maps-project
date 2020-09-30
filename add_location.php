<?php
if (isset($_POST["submit"])) {
    $con = mysqli_connect("localhost", 'root', '', 'tree');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }

//print_r($_POST["submit"]);
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
// $img =$_GET['img'];
    $description = $_POST['description'];
//    $img = $_FILES['img'];
//    echo $img;
    $target_dir = "images/";
    $name = $_FILES['img']['name'];
    $temp_name = $_FILES['img']['tmp_name'];
    if (isset($name) and !empty($name)) {
//        $location = '../uploads/';
        if (move_uploaded_file($temp_name, $target_dir . $name)) {
            echo 'File uploaded successfully';
        }
    } else {
        echo 'You should select a file to upload !!';
    }

// Inserts new row with place data.
    $query = sprintf("INSERT INTO locations1 " .
        " (id, lat, lng,img,description) " .
        " VALUES (NULL, '%s', '%s','%s','%s');",
        mysqli_real_escape_string($con, $lat),
        mysqli_real_escape_string($con, $lng),
        mysqli_real_escape_string($con, $name),
        mysqli_real_escape_string($con, $description));

    $result = mysqli_query($con, $query);
    echo "Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
} ?>