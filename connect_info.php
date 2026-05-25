<?php

session_start();

$base64Photo = '';

$severname = "sql304.ezyro.com";
$username = "ezyro_41858239";
$password = "ed50a9d455d79a7";
$databasename = "ezyro_41858239_id";

// Form fields from POST
$uNAME = trim($_POST['name'] ?? '');
$uLEVEL = trim($_POST['level'] ?? '');
$SEX = trim($_POST['sex'] ?? '');
$uMATRICULE = trim($_POST['matricule'] ?? '');
$uDEPARTMENT = trim($_POST['department'] ?? '');
$loggedInUser = $_SESSION['username'] ?? ''; //logged in user from session

// Ensure required fields are present
if ($uNAME === '' || $uLEVEL === '' || $SEX === '' || $uMATRICULE === '' || $uDEPARTMENT === '') {
    die("Error: All fields are required.");
}

$uLEVEL = (int)$uLEVEL;
if ($uLEVEL <= 0) {
    die("Error: Level must be a valid number.");
}

// Prepare photo upload variable
$uPHOTO = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $filetmp = $_FILES['photo']['tmp_name'];
    $fileType = $_FILES['photo']['type']; // Fixed: Defined this so Base64 knows the extension
    
    // Read the raw binary data of the image once
    $uPHOTO = file_get_contents($filetmp);
    
    // Convert the binary data into a safe Base64 string for the session
    $base64Photo = 'data:' . $fileType . ';base64,' . base64_encode($uPHOTO); // Fixed: Used correct variable names
} else {
    die("Error: Please select a valid profile photo.");
}

$conn = new mysqli($severname, $username, $password, $databasename);

// Correct mysqli connection error check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($uPHOTO === null) {
    die("Error: A photo is required to create the ID card.");
}

// Save clean text to session BEFORE escaping for SQL
$_SESSION['name'] = $uNAME;
$_SESSION['level'] = $uLEVEL;
$_SESSION['sex'] = $SEX;
$_SESSION['matricule'] = $uMATRICULE;
$_SESSION['department'] = $uDEPARTMENT;
$_SESSION['photo_base64'] = $base64Photo;

// Escape user inputs to prevent SQL injection for the database entry
$uNAME_escaped = $conn->real_escape_string($uNAME);
$SEX_escaped = $conn->real_escape_string($SEX);
$uMATRICULE_escaped = $conn->real_escape_string($uMATRICULE);
$uDEPARTMENT_escaped = $conn->real_escape_string($uDEPARTMENT);
$uPHOTO_escaped = $conn->real_escape_string($uPHOTO);

$sql = "INSERT INTO students_info (username,name, level, sex, matricule, department, photo_path) 
        VALUES ('$loggedInUser', '$uNAME_escaped', $uLEVEL, '$SEX_escaped', '$uMATRICULE_escaped', '$uDEPARTMENT_escaped', '$uPHOTO_escaped')";

if ($conn->query($sql) === TRUE) {
    header("Location: card.php");
    exit(); // Best practice: Always call exit() right after a redirect header
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
