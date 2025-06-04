<?php
// gausah lah ya, ga guna juga
session_start();

// Username dan password yang valid
$valid_username = "admin@perpus.com";
$valid_password = "admingantengbanget";

// Memeriksa apakah form telah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Memeriksa apakah username dan password cocok
    if ($username === $valid_username && $password === $valid_password) {
        // Jika cocok, simpan informasi login ke session dan redirect ke dashboard
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        // Jika tidak cocok, kembali ke halaman login dengan pesan error
        $_SESSION["error"] = "Username atau password salah!";
        header("Location: index.php"); // Ubah `index.php` jika Anda menggunakan nama file lain untuk login
        exit;
    }
}
?>
