<?php
session_start();
include 'config.php';

if (!$conn) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    die("ID buku tidak ditemukan.");
}

$id = intval($_GET['id']);

$query = $conn->prepare("SELECT * FROM books WHERE id = ?");
if (!$query) {
    die("Error pada query: " . $conn->error);
}
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    die("Buku tidak ditemukan.");
}

$book = $result->fetch_assoc();

// Fungsi hapus buku jika tombol "Hapus" diklik
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $delete_query = $conn->prepare("DELETE FROM books WHERE id = ?");
    if (!$delete_query) {
        die("Error pada query hapus: " . $conn->error);
    }
    $delete_query->bind_param("i", $id);
    if ($delete_query->execute()) {
        if (!empty($book['cover_image']) && file_exists($book['cover_image'])) {
            unlink($book['cover_image']);
        }
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Gagal menghapus buku: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/book.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <style>
        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
            gap: 50px;
        }
        .main img {
            width: 300px;
            border-radius: 10px;
        }
        .ket {
            align-items: normal;
        }
        .smth {
            display: flex;
            gap: 50px;
        }
    </style>
    <title>Baca Buku | E-Perpustakaan</title>
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
    <section class="main">
        <div class="smth">
        <div class="img">
            <?php if (!empty($book['cover_image'])): ?>
                <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover Buku">
            <?php endif; ?>
        </div>
        <div class="ket"> 
            <h1><?php echo htmlspecialchars($book['title']); ?></h1>
            <h3 style="margin-top: -20px;">Penulis: <?php echo htmlspecialchars($book['author']); ?></h3>
            <hr>
            <p>
                Deskripsi: <br>
                <?php echo nl2br(htmlspecialchars($book['description'])); ?>
            </p>

            <hr>
            <div>
                <button style="background-color: #007AFF; height: 40px; width: 150px; border: none; border-radius: 20px; cursor: pointer;">
                    <a href="downloads/<?php echo $book['id']; ?>.pdf" style="text-decoration: none; color: white; font-weight: bolder;" download >Download PDF</a>
                </button>
                <button style="margin-left: 15px; background-color: #007AFF; height: 40px; width: 150px; border: none; border-radius: 20px; cursor: pointer;">
                    <a href="downloads/<?php echo $book['id']; ?>.html" style="text-decoration: none; color: white; font-weight: bolder;" download>Download HTML</a>
                </button>
            </div>
            <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                <button type="submit" name="delete" style="background-color: #FF3B30; height: 40px; width: 150px; border: none; border-radius: 20px; cursor: pointer; color: white; font-weight: bolder; margin-top: 10px;">Hapus Buku</button>
            </form>
        </div>
        </div>
    </section>
</body>
</html>