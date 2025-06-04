<?php

// dashboard gagal guys, kl mw modif silahkan

$host = 'localhost';
$dbname = 'e_perpustakaan';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}

// Hapus buku jika ada permintaan
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    
    $query = "SELECT cover FROM books WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $delete_id);
    $stmt->execute();
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($book && !empty($book['cover']) && file_exists($book['cover'])) {
        unlink($book['cover']);
    }

    // Hapus buku dari database
    $query = "DELETE FROM books WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $delete_id);

    if ($stmt->execute()) {
        echo "Buku berhasil dihapus.";
    } else {
        echo "Gagal menghapus buku.";
    }
}

// Ambil semua data buku
$sql = "SELECT id, title, author FROM books";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// berfikirlah sendiri gimana codingan ini kerja hehe
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | E-Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .btn-delete {
            color: red;
            text-decoration: none;
        }
        .btn-delete:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <h2>Daftar Buku</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($books) > 0): ?>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($book['id']); ?></td>
                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                            <td><?php echo htmlspecialchars($book['author']); ?></td>
                            <td>
                                <a href="dashboard.php?delete_id=<?php echo $book['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Tidak ada buku yang tersedia.</td>
                    </tr>
                    <!-- nah ini jg alasan ga mw pake yg ini, pake "tr" ama "td", burik aj gitu, better pake "div" hehe -->
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>