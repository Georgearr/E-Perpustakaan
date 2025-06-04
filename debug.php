<?php
    session_start();

    if (!isset($_SESSION['logged_in'])) {
        echo "Session 'logged_in' belum diatur.";
    } elseif ($_SESSION['logged_in'] !== true) {
        echo "Session 'logged_in' salah.";
        print_r($_SESSION);
        exit;
    }
?>