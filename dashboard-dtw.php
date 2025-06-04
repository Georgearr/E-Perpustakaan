<?php

// dashboard gagal guys, kl mw modif silahkan


// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     header('Location: index.php');
//     exit;
// }
// $_SESSION['logged_in'] = true;

$conn = new mysqli('localhost', 'root', '', 'e_perpustakaan');
if ($conn->connect_error) {
    die('Koneksi ke database gagal: ' . $conn->connect_error);
}

$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard Admin | E-Perpustakaan</title>
</head>
<body>
    <div class="navbar">
        <img src="img/book.png" alt="icon" class="icon">
        <span class="title">E-Perpustakaan</span>
        <a href="add_book.php" class="admin-button">Tambah Buku</a>
    </div>
    <div class="content">
        <h1>Hi, Admin!</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="book-list">
                <?php while ($book = $result->fetch_assoc()): ?>
                    <div class="book-item">
                        <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover Buku" class="book-cover">
                        <h2 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h2>
                        <p class="book-author"><?php echo htmlspecialchars($book['author']); ?></p>
                        <a href="book_detail.php?id=<?php echo $book['id']; ?>" class="read-button">Baca</a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-books">
                <img src="img/no-book.png" alt="No Books Icon" class="no-books-icon">
                <p>Belum Ada Buku Disini</p>
                <a href="add_book.php" class="add-button">Tambah Buku</a>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>

<?php
$conn->close();
?>