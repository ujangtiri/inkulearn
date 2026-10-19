-- INKULEARN schema + demo seed (all data below is fictional).
-- Demo password for both accounts: demo1234 (hashed with PHP password_hash, PASSWORD_DEFAULT).
CREATE DATABASE IF NOT EXISTS `inkulearn` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `inkulearn`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `soal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teks_soal` varchar(255) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`nama`, `email`, `password`, `role`) VALUES
('Demo Admin', 'admin@example.com', '$2y$12$x9XywQPZDDjTOQCq./YyU.IDxKoUbmL4Ad.PlEUwQZmkAG5BkkP4q', 'admin'),
('Demo User', 'user@example.com', '$2y$12$x9XywQPZDDjTOQCq./YyU.IDxKoUbmL4Ad.PlEUwQZmkAG5BkkP4q', 'user');

INSERT INTO `feedback` (`nama`, `email`, `message`) VALUES
('Demo User', 'user@example.com', 'Contoh feedback: tampilannya mudah dipahami.');

INSERT INTO `soal` (`teks_soal`) VALUES
('Kucing melompat meja'),
('Mobil melaju cepat'),
('Anak membaca buku'),
('Burung terbang malam'),
('Ibu memasak sayur');
