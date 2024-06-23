<?php
// Configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waffle";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

// Get the form data
$name = $_POST['t1'];
$email = $_POST['t2'];
$phone = $_POST['t3'];
$date = $_POST['t4'];
$time = $_POST['t5'];
$party_size = $_POST['t6'];

// Validate the form data
if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
    echo "Error: Only letters and spaces are allowed in the name field";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Error: Invalid email address";
    exit;
}

if (!preg_match("/^[0-9]{10}+$/", $phone)) {
    echo "Error: Invalid phone number. Please enter a 10-digit phone number";
    exit;
}

if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}+$/", $date)) {
    echo "Error: Invalid date format. Please enter the date in YYYY-MM-DD format";
    exit;
}

if (!preg_match("/^[0-9]{2}:[0-9]{2}+$/", $time)) {
    echo "Error: Invalid time format. Please enter the time in HH:MM format";
    exit;
}

if (!preg_match("/^[1-9][0-9]?$/", $party_size)) {
    echo "Error: Invalid party size. Please enter a number between 1 and 99";
    exit;
}
$datetime = strtotime("$date $time");
if ($datetime < time()) {
    echo "Error: Date and time cannot be in the past";
    exit;
}

// Insert the data into the database
$sql = "INSERT INTO reservation (name, email, phone, date, time, party_size) VALUES ('$name', '$email', '$phone', '$date', '$time', '$party_size')";

if ($conn->query($sql) === TRUE) {
    echo "Reservation successfully made!";
    header('Location: p1.html');

} else {
    echo "Error: ". $sql. "<br>". $conn->error;
}

// Close the connection
$conn->close();
?>