<?php
session_start();
include 'config.php';

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = hash('sha256', $password);

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$hashed_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-home.css">
    <link rel="shortcut icon" href="img/book.png" type="image/x-icon">
    <title>E-Perpustakaan | Login</title>
</head>
<body>
    <section class="main">
        <div class="form">
            <p>E-Perpustakaan</p>
            <h2>Login</h2>
            <form action="index.php" method="POST">
                <input type="text" name="username" placeholder="Username" required> <br>
                <input type="password" name="password" placeholder="Password" required> <br>
                <button type="submit">Login</button> <br>
                <a href="register.php">
                    <button class="signup" type="button">Belum punya Akun? Daftar sini!</button>
                </a>
            </form>
        </div>
    </section>
</body>
</html>