<?php
require "db.php";
// Gets data from URL parameters.
if (isset($_GET['add_location'])) {
    add_location();
}
if (isset($_GET['confirm_location'])) {
    confirm_location();
}
function add_location()
{
    if(isset($_POST["submit"])) {
    $con = mysqli_connect("localhost", 'root', '', 'tree');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    // $img =$_GET['img'];
    $description = $_POST['description'];
    $img = $_POST['img'];
//    echo $img;
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["img"]["name"]);
    echo $target_file;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

// Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

// Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Inserts new row with place data.
    $query = sprintf("INSERT INTO locations1 " .
        " (id, lat, lng,img,description) " .
        " VALUES (NULL, '%s', '%s','%s','%s');",
        mysqli_real_escape_string($con, $lat),
        mysqli_real_escape_string($con, $lng),
        mysqli_real_escape_string($con, $img),
        mysqli_real_escape_string($con, $description));

    $result = mysqli_query($con, $query);
    echo "Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
}
function confirm_location()
{
    $con = mysqli_connect("localhost", 'root', '', 'tree');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $id = $_GET['id'];
    $confirmed = $_GET['confirmed'];
    // update location with confirm if admin confirm.
    $query = "update locations1 set location_status = $confirmed WHERE id = $id ";
    $result = mysqli_query($con, $query);
    echo "Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
}
function get_confirmed_locations()
{
    $con = mysqli_connect("localhost", 'root', '', 'tree');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con, "
select id ,lat,lng,description,img,location_status as isconfirmed
from locations1 WHERE  location_status = 1
  ");
    $rows = array();
    while ($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;
    }
    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);
    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}
function get_all_locations()
{
    $con = mysqli_connect("localhost", 'root', '', 'tree');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con, "
select id ,lat,lng,img,description,location_status as isconfirmed
from locations1
  ");
    $rows = array();
    while ($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;
    }
    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);
    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}
function array_flatten($array)
{
    if (!is_array($array)) {
        return false;
    }
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        } else {
            $result[$key] = $value;
        }
    }
    return $result;
}
