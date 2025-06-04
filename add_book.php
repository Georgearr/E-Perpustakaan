<?php
session_start();
// kl mw bikin verif yang advanced boleh-boleh aje

// $_SESSION['logged_in'] = true;

// if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
//     header("Location: index.php");
//     exit;
// }

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"]);
    $author = $conn->real_escape_string($_POST["author"]);
    $description = $conn->real_escape_string($_POST["description"]);

    $cover_image = null;

    if (isset($_FILES["cover"]) && $_FILES["cover"]["error"] === 0) {
        $target_dir = "uploads/"; // Uploads ni isiny cover-cover buku
        $cover_image = $target_dir . basename($_FILES["cover"]["name"]);
        
        $image_file_type = strtolower(pathinfo($cover_image, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"]; // kl mw modif, boleh-boleh ae, tp aturlh sendiri yaa

        if (!in_array($image_file_type, $allowed_types)) {
            echo "Hanya file dengan format JPG, JPEG, PNG, atau GIF yang diizinkan.";
            exit;
        }

        if (!move_uploaded_file($_FILES["cover"]["tmp_name"], $cover_image)) {
            echo "Gagal mengunggah file sampul buku.";
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO books (title, author, description, cover_image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $author, $description, $cover_image);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Gagal menambahkan buku: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-add-book.css">
    <link rel="shortcut icon" href="img/book.png" type="image/x-icon">
    <title>Tambah Buku | E-Perpustakaan</title>
</head>
<body>
    <div class="navbar" style="justify-content: space-between;">
        <a href="dashboard.php" style="text-decoration: none;">
            <div class="nav-left" style="display: flex; align-items: center;">
                <img src="img/book.png" alt="icon" class="icon">
                <span class="title">E-Perpustakaan</span>
            </div>
        </a>
        <div class="nav-right" style="align-items: center;">
            <a href="" class="admin-button" style="text-decoration: none;">Admin</a>
            <a href="logout.php" class="admin-button" style="text-decoration: none;">Log Out</a>
        </div>
    </div>
    <div class="content dark-background">
        <div class="add-book-form">
            <h2>Tambah Buku</h2>
            <form action="add_book.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Judul Buku" required>
                <input type="text" name="author" placeholder="Penulis" required>
                <textarea name="description" placeholder="Deskripsi"></textarea>
                <p>Sampul/Cover buku:</p>
                <input type="file" name="cover" placeholder="Sampul / Cover Buku">
                <button type="submit" class="submit-button">Tambah Buku</button>
            </form>
        </div>
    </div>
</body>
</html>