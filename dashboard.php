<?php
session_start();
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     header('Location: index.php');
//     exit;
// }

// mwny pake config.php, tp baru teringat ada file itu waktu la slsai AKWOKAWOAWOOAKWOAKAWKWAOKWAOKAOWKAWOKOAWOAWKOK

$conn = new mysqli('localhost', 'root', '', 'e_perpustakaan');
if ($conn->connect_error) {
    die('Koneksi ke database gagal: ' . $conn->connect_error);
}

// Ambil data buku dari database
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/book.png" type="image/x-icon">
    <title>Dashboard Admin | E-Perpustakaan</title>
</head>
<body>
    <div class="navbar" style="justify-content: space-between;">
        <div class="nav-left" style="display: flex; align-items: center;">
            <img src="img/book.png" alt="icon" class="icon">
            <span class="title">E-Perpustakaan</span>
        </div>
        <div class="nav-right" style="align-items: center;">
            <a href="" class="admin-button" style="text-decoration: none;">Admin</a>
            <a href="logout.php" class="admin-button" style="text-decoration: none;">Log Out</a>
        </div>
    </div>
    <div class="content">

        <?php if ($result->num_rows > 0): ?>
            <div style="display: flex; align-items: center;">
                    <h1>Hi, Admin!</h1>
                    <a href="add_book.php" class="add-button" style="height: 18px; margin-left: 20px;">Tambah Buku</a>
            </div>
            <div class="book-list" style="display: flex; gap: 20px;">
                <?php while ($book = $result->fetch_assoc()): ?>
                    <div class="book-item">
                        <div style="background-color: #D8D8D8; text-align: center; padding: 10px 10px 10px 10px; border-radius: 15px;">
                            <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover Buku" class="book-cover" width="200px" style="border-radius: 8px;">
                            <h2 class="book-title" style="margin-top: 5px;"><?php echo htmlspecialchars($book['title']); ?></h2>
                            <p class="book-author" style="margin-top: 2px;"><?php echo htmlspecialchars($book['author']); ?></p>
                            <a href="read_books.php?id=<?php echo $book['id']; ?>" class="read-button" >
                                <button style="margin-top: -13px; padding: 5px 15px 5px 15px; border: none; background-color: #007bff; color: white; border-radius: 20px; font-family: 'CircularSTD'; font-size: 15px; cursor: pointer;">Baca</button>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-books">
                <h1>Hi, Admin!</h1>
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