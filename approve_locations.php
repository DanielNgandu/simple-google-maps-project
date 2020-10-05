<?php
    $con = mysqli_connect("localhost", 'root', '', 'tree');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }

// Inserts new row with place data.

    $id = $_GET['id'];
    $confirmed = $_GET['confirmed'];
//    echo $confirmed;

    if($confirmed == 1) {
        $query = "UPDATE locations1 SET location_status = $confirmed WHERE id = $id";

        $result = mysqli_query($con, $query);
        if (!$result) {
            die('Invalid query: ' . mysqli_error($con));
        }else{
            echo "Approved Successfully.";

        }
    }else{
        $query = "UPDATE locations1 SET location_status = $confirmed WHERE id = $id";

        $result = mysqli_query($con, $query);
        if (!$result) {
            die('Invalid query: ' . mysqli_error($con));
        }else{
            echo "Rejected Successfully.";

        }
    }

 ?>