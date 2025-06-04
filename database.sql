-- Database di MySQL
-- Berejolah 🙏

CREATE DATABASE IF NOT EXISTS e_perpustakaan;
USE e_perpustakaan;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password) VALUES ('admin@perpus.com', SHA2('admingantengbanget', 256)); -- Default Admin Password, didecode ke format "SHA2 256" biar lebih secure ajah hehe

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    description TEXT,
    cover VARCHAR(255)
);