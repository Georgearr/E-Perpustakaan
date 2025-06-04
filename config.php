<?php
    // setting sesuai kebutuhan ygy

    $servername = "localhost"; // Nama Server
    $username = "root"; // Username
    $password = ""; // Pw
    $dbname = "e_perpustakaan"; // Sesuai dengan "database.sql"

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>