<?php
// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'waffle';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

// Start session
session_start();

// Signup
if (isset($_POST['signup'])) {
    $username = $_POST['txt'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['pswd'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address');</script>";
        header('login.php');
        exit;
    }
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "<script>alert('Invalid phone number');</script>";
        header('Location: login.php');
        exit;
    }

    $sql = "INSERT INTO users (username, phone, email, password) VALUES ('$username', '$phone', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        //echo "New record created successfully";
    } else {
        echo"Error: ". $sql. "<br>". $conn->error;
    }
}

// Login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['pswd'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address');</script>";
        header('Location: login.php');
        exit;
    }

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful, store user information in session
        $user_data = $result->fetch_assoc();
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['email'] = $user_data['email'];

        header('Location: logedin.html');
        exit;
    } else {
        echo "<script>alert('Invalid email or password');</script>";
        header('Location: login.html');
        exit;
    }
}
if (isset($_GET['logout'])) {
    // Destroy session
    session_destroy();

    // Redirect to login page
    header('Location: login.php');
    exit;
}

$conn->close();
?>