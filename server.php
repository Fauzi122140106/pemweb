<?php
require_once 'connection.php'; // Koneksi ke database

// mulai sesi
session_start();

// Create an instance of the Connection class
$db = new Connection();
$conn = $db->getConnection();

// Handle different actions based on the "action" parameter
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'signup') {
    // Handle user registration
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Validate inputs
    if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        header('Location: register.php?error=All fields are required.');
        exit;
    }

    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: register.php?error=Invalid email format.');
        exit;
    }

    // Check if password matches confirm password
    if ($password !== $confirmPassword) {
        header('Location: register.php?error=Passwords do not match.');
        exit;
    }

    // Check if the password is strong enough (e.g., minimum 8 characters)
    if (strlen($password) < 8) {
        header('Location: register.php?error=Password must be at least 8 characters long.');
        exit;
    }

    // Check if the username or email is already taken
    $checkQuery = "SELECT * FROM users WHERE username = ? OR email = ?";
    $existingUser = $db->fetchOne($checkQuery, [$username, $email], 'ss');

    if ($existingUser) {
        header('Location: register.php?error=Username or email already exists.');
        exit;
    }

    // Hash the password and insert the user into the database
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $insertQuery = "INSERT INTO users (fullname, username, email, password) VALUES (?, ?, ?, ?)";
    $db->executeQuery($insertQuery, [$fullname, $username, $email, $hashedPassword], 'ssss');

    header('Location: register.php?success=Registration successful! Please log in.');
    exit;

} elseif ($action === 'login') {
    // Handle user login
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($username) || empty($password)) {
        header('Location: login.php?error=Username and password are required.');
        exit;
    }

    // Fetch the user from the database
    $loginQuery = "SELECT * FROM users WHERE username = ?";
    $user = $db->fetchOne($loginQuery, [$username], 's');

    if (!$user || !password_verify($password, $user['password'])) {
        header('Location: login.php?error=Invalid username or password.');
        exit;
    }
    // Set session variables for logged-in user
    $_SESSION['user'] = $user;

    header('Location: index.php'); // Redirect to a index or home page
    exit;

} elseif ($action === 'logout') {
    // Handle user logout
    session_unset();
    session_destroy();

    header('Location: login.php?success=You have been logged out.');
    exit;

} else if ($action === 'add') {
    $nama = trim($_POST['nama']);
    $nim = trim($_POST['nim']);
    $email = trim($_POST['email']);
    $status = trim($_POST['status']);
    $semester = trim($_POST['semester']);

    // Validate inputs
    if (empty($nama) || empty($nim) || empty($email) || empty($status) || empty($semester)) {
        header('Location: index.php?error=All fields are required.');
        exit;
    }

    // Check if the NIM already exists
    $checkNimQuery = "SELECT * FROM tblMahasiswa WHERE nim = ?";
    $existingNim = $db->fetchOne($checkNimQuery, [$nim], 's');

    if ($existingNim) {
        header('Location: index.php?error=NIM already exists.');
        exit;
    }

    // Insert into database
    $insertQuery = "INSERT INTO tblMahasiswa (nama, nim, email, status, semester) VALUES (?, ?, ?, ?, ?)";
    $db->executeQuery($insertQuery, [$nama, $nim, $email, $status, $semester], 'ssssi');

    header('Location: index.php');
    exit;

} else if ($action === 'update') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $semester = $_POST['semester'];

    // Validate inputs
    if (empty($nama) || empty($nim) || empty($email) || empty($status) || empty($semester)) {
        header('Location: index.php?error=All fields are required.');
        exit;
    }

    // Update query
    $updateQuery = "UPDATE tblMahasiswa SET nama = ?, nim = ?, email = ?, status = ?, semester = ? WHERE id = ?";
    $db->executeQuery($updateQuery, [$nama, $nim, $email, $status, $semester, $id], 'ssssii');

    header('Location: index.php');
    exit;

} else if ($action === 'delete') {
    $id = $_POST['id'];

    // Validate the ID exists
    $checkQuery = "SELECT * FROM tblMahasiswa WHERE id = ?";
    $student = $db->fetchOne($checkQuery, [$id], 'i');

    if (!$student) {
        header('Location: index.php?error=Student not found.');
        exit;
    }

    // Delete query
    $deleteQuery = "DELETE FROM tblMahasiswa WHERE id = ?";
    $db->executeQuery($deleteQuery, [$id], 'i');

    header('Location: index.php');
    exit;
}

// Close the connection
$db->closeConnection();
?>
