<html>
<?php 
//error_reporting(-1);
//open connection to mysql sever
  $host = "localhost";
  $user = "root";
  $pass = "";
  $db = "tree";
  
  
 $con= mysqli_connect($host,$user,$pass);
   mysqli_select_db($con,$db) or die("cant connect");
  //echo "Great you are connected!!!";
?>
</html>
