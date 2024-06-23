<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.html');
    exit;
}

// If the user is logged in, allow them to make a reservation
if (isset($_POST['t1']) && isset($_POST['t2']) && isset($_POST['t3']) && isset($_POST['t4']) && isset($_POST['t5']) && isset($_POST['t6'])) {
    $name = $_POST['t1'];
    $email = $_POST['t2'];
    $phone = $_POST['t3'];
    $date = $_POST['t4'];
    $time = $_POST['t5'];
    $party_size = $_POST['t6'];

    // Insert the reservation into the database
    $conn = mysqli_connect("localhost", "username", "password", "database");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO reservations (name, email, phone, date, time, party_size) VALUES ('$name', '$email', '$phone', '$date', '$time', '$party_size')";
    if (mysqli_query($conn, $sql)) {
        echo "Reservation made successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Please fill in all the fields";
}
?>