-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jan 2025 pada 03.19
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_cognira`
--

DELIMITER $$
--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `generate_user_id` (`jenis_pengguna` ENUM('Admin','Moderator','User')) RETURNS VARCHAR(11) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
    DECLARE new_id VARCHAR(11);
    DECLARE prefix INT;
    DECLARE current_ym VARCHAR(4);
    DECLARE counter INT DEFAULT 1;
    DECLARE id_exists INT;

    -- Tentukan Prefix berdasarkan jenis pengguna
    IF jenis_pengguna = 'Admin' THEN
        SET prefix = 101;
    ELSEIF jenis_pengguna = 'Moderator' THEN
        SET prefix = 102;
    ELSE
        SET prefix = 201; -- Default untuk User
    END IF;

    -- Format Tanggal (YYMM)
    SET current_ym = DATE_FORMAT(CURDATE(), '%y%m');

    -- Loop untuk memastikan ID unik
    REPEAT
        SET new_id = CONCAT(prefix, current_ym, LPAD(counter, 4, '0'));
        
        -- Cek ID di tabel yang sesuai
        IF jenis_pengguna = 'Admin' OR jenis_pengguna = 'Moderator' THEN
            SELECT COUNT(*) INTO id_exists 
            FROM admin_moderator 
            WHERE pengguna_id = new_id;
        ELSE
            SELECT COUNT(*) INTO id_exists 
            FROM pengguna_cognira 
            WHERE pengguna_id = new_id;
        END IF;
        
        SET counter = counter + 1;
    UNTIL id_exists = 0 END REPEAT;

    RETURN new_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `pengguna_id` varchar(11) NOT NULL,
  `tanggal_diangkat` date NOT NULL,
  `status_admin` enum('Aktif','Tidak Aktif') NOT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`admin_id`, `pengguna_id`, `tanggal_diangkat`, `status_admin`, `catatan`) VALUES
(1, '10124120001', '2024-12-07', 'Aktif', 'Admin utama yang mengelola seluruh sistem.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_moderator`
--

CREATE TABLE `admin_moderator` (
  `pengguna_id` varchar(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `peran` enum('Admin','Moderator') NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin_moderator`
--

INSERT INTO `admin_moderator` (`pengguna_id`, `nama`, `email`, `kata_sandi`, `foto`, `peran`, `created_at`) VALUES
('10124120001', 'Nisa Kamila ', 'nisakamila@gmail.com', '$2y$10$FolwS1OPGdJ6vvwq5/b0We41xSU1y5Mvansd9pZzbtHyT4Zt3scVW', '677318a159a51-20-Siswa_2.jpeg', 'Admin', '2024-12-07 22:19:59'),
('10224120001', 'Joko', 'joko@gmail.com', 'securepassword', NULL, 'Moderator', '2024-12-07 22:19:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `pengguna_id` varchar(11) NOT NULL,
  `content` text NOT NULL,
  `answer_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `answers`
--

INSERT INTO `answers` (`answer_id`, `question_id`, `pengguna_id`, `content`, `answer_created_at`) VALUES
(72, 56, '20125010009', 'Blockchain memberikan transparansi dan keamanan tinggi dalam transaksi ', '2025-01-16 20:10:27'),
(73, 56, '20125010011', 'Kelemahannya adalah kecepatan transaksi yang lambat dibandingkan dengan sistem tradisional. ', '2025-01-16 20:19:08'),
(74, 57, '20125010013', 'AI dapat memberikan pembelajaran yang dipersonalisasi sesuai kebutuhan siswa. ', '2025-01-16 20:24:27'),
(75, 57, '20124120006', ' Guru dapat menggunakan AI untuk analisis data belajar siswa, sehingga lebih memahami kekuatan dan kelemahan mereka. ', '2025-01-16 20:31:57'),
(76, 58, '20124120010', 'Media sosial seringkali membuat remaja merasa tertekan untuk mencapai standar kecantikan yang tidak realistis. ', '2025-01-16 20:36:33'),
(77, 59, '20125010002', '5G akan meningkatkan kecepatan dan kapasitas jaringan untuk perangkat IoT. ', '2025-01-16 20:38:02'),
(78, 60, '20125010003', 'Puasa dapat membantu detoksifikasi tubuh dengan memberikan waktu istirahat pada sistem pencernaan. ', '2025-01-16 20:40:07'),
(79, 61, '20125010004', 'Tidur cukup meningkatkan konsentrasi dan kemampuan menyelesaikan masalah. ', '2025-01-16 20:41:18'),
(80, 62, '20125010004', 'Penting untuk memiliki jadwal kerja yang seimbang dengan waktu istirahat.', '2025-01-16 20:41:57'),
(81, 63, '20125010005', 'Infrastruktur pengisian daya yang masih terbatas adalah salah satu tantangan terbesar.', '2025-01-16 20:42:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `pengguna_id` varchar(11) NOT NULL,
  `content` text NOT NULL,
  `comment_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`comment_id`, `answer_id`, `pengguna_id`, `content`, `comment_created_at`) VALUES
(68, 72, '20124120006', 'Tapi biaya transaksi juga sering menjadi kendala, ya?', '2025-01-16 20:16:25'),
(69, 72, '20125010010', 'Setuju, terutama jika menggunakan jaringan seperti Ethereum.', '2025-01-16 20:17:54'),
(70, 73, '20125010012', 'Itu tergantung pada jenis blockchain yang digunakan.', '2025-01-16 20:20:23'),
(71, 73, '20125010009', 'Tapi skalabilitas memang masih jadi tantangan utama.', '2025-01-16 20:22:31'),
(72, 74, '20125010014', 'Ini sangat membantu siswa yang membutuhkan perhatian lebih.', '2025-01-16 20:26:03'),
(73, 74, '20124120005', 'Tapi bagaimana dengan siswa di daerah tanpa akses teknologi?', '2025-01-16 20:27:12'),
(74, 75, '20124120007', 'Benar, tapi pelatihannya juga penting untuk guru.', '2025-01-16 20:33:37'),
(75, 75, '20124120010', 'Peran guru tetap tidak tergantikan.', '2025-01-16 20:34:28'),
(76, 76, '20125010002', 'Ini juga akan membantu dalam pengembangan smart cities.', '2025-01-16 20:39:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `laporan_id` int(11) NOT NULL,
  `pelapor_id` varchar(11) NOT NULL,
  `tersangka_id` varchar(11) NOT NULL,
  `konten_id` int(11) NOT NULL,
  `konten_tipe` enum('Question','Answer','Comment') NOT NULL,
  `penangan_id` int(11) DEFAULT NULL,
  `status_laporan` enum('Pending','Selesai') DEFAULT 'Pending',
  `waktu_laporan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`laporan_id`, `pelapor_id`, `tersangka_id`, `konten_id`, `konten_tipe`, `penangan_id`, `status_laporan`, `waktu_laporan`) VALUES
(80, '20124120006', '20125010003', 59, 'Question', NULL, 'Selesai', '2025-01-16 21:32:25'),
(82, '20124120007', '20125010010', 70, 'Question', NULL, 'Selesai', '2025-01-16 21:34:59'),
(83, '20124120010', '20125010008', 69, 'Question', NULL, 'Selesai', '2025-01-16 21:35:39'),
(84, '20125010002', '20125010004', 79, 'Answer', NULL, 'Selesai', '2025-01-16 21:36:30'),
(86, '20125010005', '20124120007', 74, 'Comment', NULL, 'Selesai', '2025-01-16 21:39:14'),
(87, '20125010015', '20125010010', 69, 'Comment', NULL, 'Selesai', '2025-01-16 21:40:57'),
(88, '20125010011', '20124120006', 75, 'Answer', NULL, 'Selesai', '2025-01-16 21:42:18'),
(89, '20124120005', '20124120010', 66, 'Question', NULL, 'Selesai', '2025-01-16 21:45:16'),
(90, '20124120006', '20125010003', 67, 'Question', NULL, 'Selesai', '2025-01-16 21:46:27'),
(91, '20125010021', '20125010002', 58, 'Question', NULL, 'Selesai', '2025-01-16 21:48:36'),
(92, '20125010017', '20125010015', 65, 'Question', NULL, 'Selesai', '2025-01-16 21:50:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aksi_admin`
--

CREATE TABLE `log_aksi_admin` (
  `log_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `pengguna_id` varchar(11) NOT NULL,
  `aksi` varchar(255) NOT NULL,
  `waktu_aksi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `notifikasi_id` int(11) NOT NULL,
  `penerima_id` varchar(11) NOT NULL,
  `pengirim_id` varchar(11) NOT NULL,
  `pesan` text NOT NULL,
  `target_id` int(11) NOT NULL,
  `target_type` enum('answer','comment','question') DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `waktu_notifikasi` datetime DEFAULT current_timestamp(),
  `status_dibaca` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`notifikasi_id`, `penerima_id`, `pengirim_id`, `pesan`, `target_id`, `target_type`, `question_id`, `waktu_notifikasi`, `status_dibaca`) VALUES
(165, '20124120007', '20125010009', 'telah menjawab pertanyaan Anda.', 72, 'answer', 56, '2025-01-16 20:10:27', 1),
(166, '20125010009', '20124120006', 'mengomentari jawaban Anda.', 68, 'comment', 56, '2025-01-16 20:16:25', 1),
(167, '20125010009', '20125010010', 'mengomentari jawaban Anda.', 69, 'comment', 56, '2025-01-16 20:17:54', 1),
(168, '20124120007', '20125010011', 'telah menjawab pertanyaan Anda.', 73, 'answer', 56, '2025-01-16 20:19:08', 1),
(169, '20125010011', '20125010012', 'mengomentari jawaban Anda.', 70, 'comment', 56, '2025-01-16 20:20:23', 0),
(170, '20125010011', '20125010009', 'mengomentari jawaban Anda.', 71, 'comment', 56, '2025-01-16 20:22:31', 0),
(171, '20124120005', '20125010013', 'telah menjawab pertanyaan Anda.', 74, 'answer', 57, '2025-01-16 20:24:27', 1),
(172, '20125010013', '20125010014', 'mengomentari jawaban Anda.', 72, 'comment', 57, '2025-01-16 20:26:03', 0),
(173, '20125010013', '20124120005', 'mengomentari jawaban Anda.', 73, 'comment', 57, '2025-01-16 20:27:12', 0),
(174, '20124120005', '20124120006', 'telah menjawab pertanyaan Anda.', 75, 'answer', 57, '2025-01-16 20:31:57', 1),
(175, '20124120006', '20124120007', 'mengomentari jawaban Anda.', 74, 'comment', 57, '2025-01-16 20:33:37', 1),
(176, '20124120006', '20124120010', 'mengomentari jawaban Anda.', 75, 'comment', 57, '2025-01-16 20:34:28', 1),
(177, '20125010002', '20124120010', 'telah menjawab pertanyaan Anda.', 76, 'answer', 58, '2025-01-16 20:36:33', 0),
(178, '20125010003', '20125010002', 'telah menjawab pertanyaan Anda.', 77, 'answer', 59, '2025-01-16 20:38:02', 0),
(179, '20124120010', '20125010002', 'mengomentari jawaban Anda.', 76, 'comment', 58, '2025-01-16 20:39:09', 0),
(180, '20125010004', '20125010003', 'telah menjawab pertanyaan Anda.', 78, 'answer', 60, '2025-01-16 20:40:07', 0),
(181, '20125010005', '20125010004', 'telah menjawab pertanyaan Anda.', 79, 'answer', 61, '2025-01-16 20:41:18', 1),
(182, '20125010008', '20125010004', 'telah menjawab pertanyaan Anda.', 80, 'answer', 62, '2025-01-16 20:41:57', 0),
(183, '20125010009', '20125010005', 'telah menjawab pertanyaan Anda.', 81, 'answer', 63, '2025-01-16 20:42:50', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna_cognira`
--

CREATE TABLE `pengguna_cognira` (
  `pengguna_id` varchar(11) NOT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `statusblock` tinyint(1) NOT NULL DEFAULT 0,
  `blokir_hingga` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna_cognira`
--

INSERT INTO `pengguna_cognira` (`pengguna_id`, `nama_pengguna`, `email`, `kata_sandi`, `foto`, `created_at`, `statusblock`, `blokir_hingga`) VALUES
('20124120005', 'Putri Lestari', 'putri@gmail.com', '$2y$10$h7D5wwRhFFi/TSPWNdJOtOf7zNbR871Xs3PSgb9iI73Js5YsvJZf6', 'default.png', '2024-12-07 22:44:54', 0, NULL),
('20124120006', 'reva', 'reva123@gmail.com', '$2y$10$XzXCZrZgzYA6jK.9Cp8n8uvvlR7Wkce1jWPnhBRgoT7.deWRz5ajW', '6789064be2f89-733-Guru_13.jpeg', '2025-01-12 00:53:48', 0, '2025-07-11 18:53:48'),
('20124120007', 'Hanan', 'hanan@gmail.com', '$2y$10$9i96N3d9ztWhFNA3kgHmKeTMuY4Lhunkes9/f1bSp9nG7jA0ll/y2', 'default.png', '2025-01-09 18:02:17', 0, '2025-07-09 12:02:17'),
('20124120010', 'Verrel', 'verrel@gmail.com', '$2y$10$88ej1tFu0o7W8NfXdoc.gusH8xWkVvKFl48XXtjkuK.kRuGRl2HOe', '67879d14a4c35-19-Guru_11.jpeg', '2024-12-17 12:45:06', 0, NULL),
('20125010002', 'Aldi Pratama', 'aldi.pratama@gmail.com', '$2y$10$GKWcpuz0IyDdBsdd60hmGuMLkSNU2jaASZoo2EGlrH9QbzgCDEoCG', '6787cd34c7729-185-Guru_3.jpeg', '2025-01-01 10:00:00', 0, NULL),
('20125010003', 'Budi Santoso', 'budi.santoso@gmail.com', '$2y$10$lpO/qEkhNKg0vhIQ3dDXPebR3eWK1fCiTeZPI7r9WKLvI9.HPc3cS', '6787d0ee56dc2-209-Guru_1.jpeg', '2025-01-02 11:00:00', 0, NULL),
('20125010004', 'Citra Dewi', 'citra.dewi@gmail.com', '$2y$10$qSUbi9fDE89ct27JzV919OWH6cN4UB8NV7BToK3CYJI220FlMF1SG', '6787d12a68a99-172-Siswa_12.jpeg', '2025-01-03 12:00:00', 0, NULL),
('20125010005', 'Dian Permata', 'dian.permata@gmail.com', '$2y$10$vbb/01Kjm9Hy8RV0hmUS3OZ1ZKxNDsAMSwMzUmzZHOYv24Iv6ENku', '6787d15b0c9b9-182-Siswa_10.jpeg', '2025-01-04 13:00:00', 0, '2025-01-14 13:00:00'),
('20125010008', 'Eko Suryanto', 'eko.suryanto@gmail.com', '$2y$10$AYrXAV0FPoxuLdAz5PmWoObhYnWmzxp.g7M5bqH7pcx5DypyNF3C6', '6787d19245c69-408-Siswa_1.jpeg', '2025-01-05 14:00:00', 0, NULL),
('20125010009', 'Fitri Ayu', 'fitri.ayu@gmail.com', '$2y$10$okUEOyfpTP8Ii/ev17eagOnvmnaVcinnDsGaiOW0ZsCTxbQ0/Zq8K', '6787d1cb36926-198-Guru_7.jpeg', '2025-01-06 15:00:00', 0, NULL),
('20125010010', 'Gilang Ramadhan', 'gilang.ramadhan@gmail.com', '$2y$10$a5.9s7wPV/I5r1FkcdL4T.DfqkUCT9qhZksi1InjW7gm6AmeOYBZ2', '6787d2055bdf7-417-Siswa_8.jpeg', '2025-01-07 16:00:00', 0, '2025-01-17 16:00:00'),
('20125010011', 'Hadi Saputra', 'hadi.saputra@gmail.com', '$2y$10$Uy2lz6PSCNI8JGcYp4M/zuY.Ma4s2MrO6XT5oAnyEpo4Iruep4nIG', '6787d25818e8b-444-Siswa_3.jpeg', '2025-01-08 17:00:00', 0, NULL),
('20125010012', 'Indah Lestari', 'indah.lestari@gmail.com', '$2y$10$yJGIzao4m.tPnoJnJF8HP.E4Vt2yfbEOd9L5RsnVlzsYZZ8nqG0/a', '6787d2b920b32-296-Guru_10.jpeg', '2025-01-09 18:00:00', 0, NULL),
('20125010013', 'Joko Widodo', 'joko.widodo@gmail.com', '$2y$10$RiGwatvwt.EH1n3uocdy3OF0Q7mDS4FRiWw05VqMPYz7frgGnsUdC', '6787d33cf30cd-644-Guru_5.jpeg', '2025-01-10 19:00:00', 0, NULL),
('20125010014', 'Kiki Amelia', 'kiki.amelia@gmail.com', '$2y$10$81LPAFpKTYJ8qy2w/ByHauQpizfYyMNMSoqY1zC12xobnrugQ2Xpu', 'default.png', '2025-01-11 20:00:00', 0, NULL),
('20125010015', 'Lutfi Hakim', 'lutfi.hakim@gmail.com', '$2y$10$bDSCrJaDlDFn1iUDZll7jOXxAQK0ctzC3WhfpdN7js2p5wp30ng9K', 'default.png', '2025-01-12 21:00:00', 0, NULL),
('20125010016', 'Maya Sari', 'maya.sari@gmail.com', '$2y$10$YkSFFTzUfVi6pGPwhrFLJemWE0A1g6HYZZttPOXKATVg3Puhco1g6', 'default.png', '2025-01-13 22:00:00', 0, '2025-01-23 22:00:00'),
('20125010017', 'Nanda Putri', 'nanda.putri@gmail.com', '$2y$10$QnWflIZxMJychwK8o3oVguH6KCZjbll6CO0IgiY3C9pAX5ozDFEXW', 'default.png', '2025-01-14 23:00:00', 0, NULL),
('20125010018', 'Oki Pratama', 'oki.pratama@gmail.com', '$2y$10$zTEx1QdxqfeCUChA9ng5UOEubuy46RabIRyPOaBdJfe3pSezT1S7K', 'default.png', '2025-01-15 00:00:00', 0, NULL),
('20125010019', 'Putri Aulia', 'putri.aulia@gmail.com', '$2y$10$D7FyI0l0yezM7cRTuRKwJuxtKUCaycxyi8IlAsYgL5pgl/OWplZwO', 'default.png', '2025-01-16 01:00:00', 0, NULL),
('20125010020', 'Rendy Kusuma', 'rendy.kusuma@gmail.com', '$2y$10$v5z0kMPU61k55MVp/6FVKOi7CSvVYls2UuIKckkl1H9NaEkDG7gSC', 'default.png', '2025-01-17 02:00:00', 0, NULL),
('20125010021', 'Siti Rahma', 'siti.rahma@gmail.com', '$2y$10$E9gtamhJxEl7h8bN4gw9q.AeTSzHfVUjK7g2yoKIxW.BJKwDgjX.2', 'default.png', '2025-01-18 03:00:00', 0, NULL),
('20125010022', 'Tono Wijaya', 'tono.wijaya@gmail.com', 'password123', 'foto19.jpg', '2025-01-19 04:00:00', 0, NULL),
('20125010023', 'Usman Hadi', 'usman.hadi@gmail.com', 'password123', 'foto20.jpg', '2025-01-20 05:00:00', 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `pengguna_id` varchar(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `question_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `questions`
--

INSERT INTO `questions` (`question_id`, `pengguna_id`, `title`, `content`, `question_created_at`) VALUES
(56, '20124120007', 'Teknologi Blockhain', 'Apa kelebihan dan kekurangan dari teknologi blockchain dalam aplikasi keuangan ?', '2025-01-15 23:00:53'),
(57, '20124120005', 'Pengaruh AI di Sekolah', 'Bagaimana AI dapat meningkatkan pengalaman belajar di sekolah ?', '2025-01-15 23:05:04'),
(58, '20125010002', 'Kesehatan Mental Remaja', 'Apa dampak negatif dari media sosial terhadap kesehatan mental remaja ?', '2025-01-15 23:09:51'),
(59, '20125010003', 'Teknologi 5G', 'Bagaimana teknologi 5G akan memengaruhi IoT di masa depan ?', '2025-01-15 23:11:49'),
(60, '20125010004', 'Manfaat Berpuasa', 'Apa manfaat berpuasa terhadap kesehatan tubuh?', '2025-01-15 23:12:59'),
(61, '20125010005', 'Pengaruh Tidur', 'Apa pengaruh tidur yang cukup terhadap produktivitas sehari-hari?', '2025-01-15 23:14:19'),
(62, '20125010008', 'Mencegah burnout', 'Bagaimana cara mencegah burnout dalam pekerjaan?', '2025-01-15 23:16:36'),
(63, '20125010009', 'Mobil Listrik', 'Apa tantangan utama dalam mengembangkan teknologi mobil listrik?', '2025-01-15 23:17:45'),
(64, '20125010005', 'Wearable Devices dan Kesehatan', 'Apakah ada fitur tertentu pada smartwatch atau perangkat sejenis yang paling bermanfaat untuk membantu masyarakat menjaga kesehatan mereka?', '2025-01-16 20:48:13'),
(65, '20125010015', 'AI dalam Diagnosis Medis', 'Bisakah AI menggantikan peran dokter di masa depan, atau apakah AI hanya akan menjadi alat pendukung?', '2025-01-16 20:54:36'),
(66, '20124120010', 'Aplikasi Kesehatan Mental', 'Apakah aplikasi seperti meditasi atau terapi virtual benar-benar membantu, dan aplikasi apa yang menjadi favorit Anda?', '2025-01-16 20:55:51'),
(67, '20125010003', 'Telemedicine di Daerah Terpencil', 'Apa saja manfaat yang dirasakan masyarakat, dan tantangan apa yang muncul dalam implementasi telemedicine?', '2025-01-16 20:57:13'),
(68, '20125010004', 'Privasi Data Kesehatan', 'Bagaimana sebaiknya regulasi diterapkan untuk melindungi privasi pengguna dari penyalahgunaan data?', '2025-01-16 21:00:14'),
(69, '20125010008', 'IoMT untuk Pasien Kronis', 'Apakah alat monitor kesehatan berbasis Internet of Medical Things benar-benar meningkatkan kualitas perawatan pasien?', '2025-01-16 21:02:41'),
(70, '20125010010', 'Blockchain dan Data Kesehatan', 'Bagaimana blockchain dapat diterapkan untuk mengelola rekam medis elektronik secara lebih aman?', '2025-01-16 21:04:49'),
(71, '20124120006', 'Robotik di Dunia Kesehatan', 'Apakah robot untuk operasi atau asisten perawat cukup aman untuk menggantikan peran tenaga manusia di beberapa area?', '2025-01-16 21:06:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `question_tags`
--

CREATE TABLE `question_tags` (
  `question_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `question_tags`
--

INSERT INTO `question_tags` (`question_id`, `tag_id`) VALUES
(56, 41),
(57, 42),
(58, 43),
(59, 44),
(60, 45),
(61, 46),
(62, 47),
(63, 48),
(64, 49),
(65, 42),
(66, 43),
(67, 50),
(68, 51),
(69, 52),
(70, 53),
(71, 54);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`) VALUES
(41, 'keuangan'),
(42, 'Artificial Intelegen'),
(43, 'Kesehatan Mental'),
(44, '5G'),
(45, 'Puasa'),
(46, 'Kesehatan'),
(47, 'burnout'),
(48, 'Teknologi'),
(49, 'smartwatch'),
(50, 'Telemedicine'),
(51, 'Data Kesehatan'),
(52, 'loMT'),
(53, 'Blockhain'),
(54, 'Robotik');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `pengguna_id` (`pengguna_id`);

--
-- Indeks untuk tabel `admin_moderator`
--
ALTER TABLE `admin_moderator`
  ADD PRIMARY KEY (`pengguna_id`);

--
-- Indeks untuk tabel `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `pengguna_id` (`pengguna_id`),
  ADD KEY `answers_ibfk_1` (`question_id`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `pengguna_id` (`pengguna_id`),
  ADD KEY `comments_ibfk_1` (`answer_id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`laporan_id`),
  ADD KEY `pelapor_id` (`pelapor_id`);

--
-- Indeks untuk tabel `log_aksi_admin`
--
ALTER TABLE `log_aksi_admin`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `pengguna_id` (`pengguna_id`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`notifikasi_id`),
  ADD KEY `penerima_id` (`penerima_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indeks untuk tabel `pengguna_cognira`
--
ALTER TABLE `pengguna_cognira`
  ADD PRIMARY KEY (`pengguna_id`);

--
-- Indeks untuk tabel `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `pengguna_id` (`pengguna_id`);

--
-- Indeks untuk tabel `question_tags`
--
ALTER TABLE `question_tags`
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `question_tags_ibfk_1` (`question_id`);

--
-- Indeks untuk tabel `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `laporan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT untuk tabel `log_aksi_admin`
--
ALTER TABLE `log_aksi_admin`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `notifikasi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT untuk tabel `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `admin_moderator` (`pengguna_id`);

--
-- Ketidakleluasaan untuk tabel `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna_cognira` (`pengguna_id`);

--
-- Ketidakleluasaan untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`answer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna_cognira` (`pengguna_id`);

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`pelapor_id`) REFERENCES `pengguna_cognira` (`pengguna_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `log_aksi_admin`
--
ALTER TABLE `log_aksi_admin`
  ADD CONSTRAINT `log_aksi_admin_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `log_aksi_admin_ibfk_2` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna_cognira` (`pengguna_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`penerima_id`) REFERENCES `pengguna_cognira` (`pengguna_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifikasi_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna_cognira` (`pengguna_id`);

--
-- Ketidakleluasaan untuk tabel `question_tags`
--
ALTER TABLE `question_tags`
  ADD CONSTRAINT `question_tags_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
