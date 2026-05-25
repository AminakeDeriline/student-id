<?php
session_start();

$severname = "sql304.ezyro.com";
$username = "ezyro_41858239";
$password = "ed50a9d455d79a7";
$databasename = "ezyro_41858239_id";

$uNAME = $_POST["username"];
$uPASSWORD = $_POST["password"];
$uPASSWORD = password_hash($uPASSWORD, PASSWORD_DEFAULT);
$_SESSION['username'] = $uNAME;

$conn = mysqli_connect($severname, $username, $password, $databasename);
if(!$conn){
    die("connection failed".mysqli_connect_error());
}
// Checks that no username is the same.
$check_sql = "SELECT * FROM `students` WHERE username='$uNAME'";
$check_query = mysqli_query($conn, $check_sql);

if (!$check_query) {
    die("query failed: " . mysqli_error($conn));
}


if(mysqli_num_rows($check_query) > 0){
    header("Location: dashboard.html");
    exit();
}
else{

$sql = "INSERT INTO `students` (`id`, `username`, `password`) VALUES ('', '$uNAME', '$uPASSWORD')";
$query = mysqli_query($conn, $sql);

if (!$query) {
    die("insert failed: " . mysqli_error($conn));
}
 
header("Location: dashboard.html");
exit();

}
?>
