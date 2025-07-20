-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2025 at 12:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatcenter`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL,
  `email_admin` text DEFAULT NULL,
  `password_admin` text DEFAULT NULL,
  `rol_admin` text DEFAULT NULL,
  `permissions_admin` text DEFAULT NULL,
  `token_admin` text DEFAULT NULL,
  `token_exp_admin` text DEFAULT NULL,
  `status_admin` int(11) DEFAULT 1,
  `title_admin` text DEFAULT NULL,
  `symbol_admin` text DEFAULT NULL,
  `font_admin` text DEFAULT NULL,
  `color_admin` text DEFAULT NULL,
  `back_admin` text DEFAULT NULL,
  `scode_admin` text DEFAULT NULL,
  `chatgpt_admin` text DEFAULT NULL,
  `date_created_admin` date DEFAULT NULL,
  `date_updated_admin` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id_admin`, `email_admin`, `password_admin`, `rol_admin`, `permissions_admin`, `token_admin`, `token_exp_admin`, `status_admin`, `title_admin`, `symbol_admin`, `font_admin`, `color_admin`, `back_admin`, `scode_admin`, `chatgpt_admin`, `date_created_admin`, `date_updated_admin`) VALUES
(1, 'superadmin@chatcenter.com', '', 'superadmin', '{\"todo\":\"on\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NTEzMTcxODMsImV4cCI6MTc1MTQwMzU4MywiZGF0YSI6eyJpZCI6MSwiZW1haWwiOiJzdXBlcmFkbWluQGNoYXRjZW50ZXIuY29tIn19.GpVLlU5nKnC36thvrH6wNGEwagv0nLk8v2sRlJxYGrY', '1751403583', 1, 'ChatCenter', '<i class=\"fa-solid fa-robot\"></i>', '', '#008000', 'http://cms-chatcenter.com/views/assets/files/6862f6e5f013217.jpg', '', '', '2025-06-30', '2025-06-30 20:59:43'),
(2, 'admin@chatcenter.com', '', 'admin', '{\"TODO\":\"ON\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NTEzMTY4OTksImV4cCI6MTc1MTQwMzI5OSwiZGF0YSI6eyJpZCI6MiwiZW1haWwiOiJhZG1pbkBjaGF0Y2VudGVyLmNvbSJ9fQ.y0GjxPqzO8skRwGql94j8ssNXARIUBcDSBPH8QX1wrY', '1751403299', 1, '', '', '', '', '', '', '{}', '2025-06-30', '2025-06-30 20:54:59'),
(3, 'editor-archivos@chatcenter.com', '$2a$07$azybxcags23425sdg23sdeanQZqjaf6Birm2NvcYTNtJw24CsO5uq', 'editor', '%7B%22archivos%22%3A%22ON%22%7D', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NTEzMTcxNTgsImV4cCI6MTc1MTQwMzU1OCwiZGF0YSI6eyJpZCI6MywiZW1haWwiOiJlZGl0b3ItYXJjaGl2b3NAY2hhdGNlbnRlci5jb20ifX0.PQFUIeDCg5Sg7Ho0n-lxKvkwDcx1zzhLmrCrZAUs-E4', '1751403558', 1, '', '', '', '', '', '', '%7B%7D', '2025-06-30', '2025-06-30 20:59:18');

-- --------------------------------------------------------

--
-- Table structure for table `columns`
--

CREATE TABLE `columns` (
  `id_column` int(11) NOT NULL,
  `id_module_column` int(11) DEFAULT 0,
  `title_column` text DEFAULT NULL,
  `alias_column` text DEFAULT NULL,
  `type_column` text DEFAULT NULL,
  `matrix_column` text DEFAULT NULL,
  `visible_column` int(11) DEFAULT 1,
  `date_created_column` date DEFAULT NULL,
  `date_updated_column` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `columns`
--

INSERT INTO `columns` (`id_column`, `id_module_column`, `title_column`, `alias_column`, `type_column`, `matrix_column`, `visible_column`, `date_created_column`, `date_updated_column`) VALUES
(1, 2, 'rol_admin', 'rol', 'select', 'admin,editor', 1, '2025-06-30', '2025-06-30 20:57:11'),
(2, 2, 'permissions_admin', 'permisos', 'object', '', 1, '2025-06-30', '2025-06-30 15:44:21'),
(3, 2, 'email_admin', 'email', 'email', '', 1, '2025-06-30', '2025-06-30 15:44:21'),
(4, 2, 'password_admin', 'pass', 'password', '', 0, '2025-06-30', '2025-06-30 15:44:21'),
(5, 2, 'token_admin', 'token', 'text', '', 0, '2025-06-30', '2025-06-30 15:44:21'),
(6, 2, 'token_exp_admin', 'expiración', 'text', '', 0, '2025-06-30', '2025-06-30 15:44:21'),
(7, 2, 'status_admin', 'estado', 'boolean', '', 1, '2025-06-30', '2025-06-30 15:44:21'),
(8, 2, 'title_admin', 'título', 'text', '', 0, '2025-06-30', '2025-06-30 15:44:21'),
(9, 2, 'symbol_admin', 'simbolo', 'text', '', 0, '2025-06-30', '2025-06-30 15:44:21'),
(10, 2, 'font_admin', 'tipografía', 'text', '', 0, '2025-06-30', '2025-06-30 15:44:21'),
(11, 2, 'color_admin', 'color', 'text', '', 0, '2025-06-30', '2025-06-30 15:44:21'),
(12, 2, 'back_admin', 'fondo', 'text', '', 0, '2025-06-30', '2025-06-30 15:44:21'),
(13, 2, 'scode_admin', 'seguridad', 'text', '', 0, '2025-06-30', '2025-06-30 15:44:21'),
(14, 2, 'chatgpt_admin', 'chatgpt', 'object', '', 0, '2025-06-30', '2025-06-30 15:44:21'),
(17, 8, 'number_whatsapp', 'Número', 'text', NULL, 1, '2025-06-30', '2025-06-30 21:15:29'),
(18, 8, 'id_number_whatsapp', 'Id Número', 'text', NULL, 1, '2025-06-30', '2025-06-30 21:15:29'),
(19, 8, 'id_app_whatsapp', 'Id App', 'text', NULL, 1, '2025-06-30', '2025-06-30 21:15:29'),
(20, 8, 'token_whatsapp', 'Token', 'text', NULL, 1, '2025-06-30', '2025-06-30 21:15:29'),
(21, 8, 'status_whasapp', 'Estado', 'boolean', NULL, 1, '2025-06-30', '2025-06-30 21:15:29'),
(22, 8, 'ai_whatsapp', 'Asistente IA', 'boolean', NULL, 1, '2025-06-30', '2025-06-30 21:15:29');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id_file` int(11) NOT NULL,
  `id_folder_file` int(11) DEFAULT 0,
  `name_file` text DEFAULT NULL,
  `extension_file` text DEFAULT NULL,
  `type_file` text DEFAULT NULL,
  `size_file` double DEFAULT 0,
  `link_file` text DEFAULT NULL,
  `thumbnail_vimeo_file` text DEFAULT NULL,
  `id_mailchimp_file` text DEFAULT NULL,
  `date_created_file` date DEFAULT NULL,
  `date_updated_file` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id_file`, `id_folder_file`, `name_file`, `extension_file`, `type_file`, `size_file`, `link_file`, `thumbnail_vimeo_file`, `id_mailchimp_file`, `date_created_file`, `date_updated_file`) VALUES
(1, 1, 'Meeting-Driven Development', 'jpg', 'image/jpeg', 35183, 'http://cms-chatcenter.com/views/assets/files/6862cab0bec7740.jpg', NULL, NULL, '2025-06-30', '2025-06-30 17:34:40');

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id_folder` int(11) NOT NULL,
  `name_folder` text DEFAULT NULL,
  `size_folder` text DEFAULT NULL,
  `total_folder` double DEFAULT 0,
  `max_upload_folder` text DEFAULT NULL,
  `url_folder` text DEFAULT NULL,
  `keys_folder` text DEFAULT NULL,
  `date_created_folder` date DEFAULT NULL,
  `date_updated_folder` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id_folder`, `name_folder`, `size_folder`, `total_folder`, `max_upload_folder`, `url_folder`, `keys_folder`, `date_created_folder`, `date_updated_folder`) VALUES
(1, 'Server', '200000000000', 35183, '500000000', 'http://cms-chatcenter.com', NULL, '2025-06-30', '2025-06-30 21:58:54');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id_module` int(11) NOT NULL,
  `id_page_module` int(11) DEFAULT 0,
  `type_module` text DEFAULT NULL,
  `title_module` text DEFAULT NULL,
  `suffix_module` text DEFAULT NULL,
  `content_module` text DEFAULT NULL,
  `width_module` int(11) DEFAULT 100,
  `editable_module` int(11) DEFAULT 1,
  `date_created_module` date DEFAULT NULL,
  `date_updated_module` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id_module`, `id_page_module`, `type_module`, `title_module`, `suffix_module`, `content_module`, `width_module`, `editable_module`, `date_created_module`, `date_updated_module`) VALUES
(1, 2, 'breadcrumbs', 'Administradores', NULL, NULL, 100, 1, '2025-06-30', '2025-06-30 15:44:21'),
(2, 2, 'tables', 'admins', 'admin', NULL, 100, 0, '2025-06-30', '2025-06-30 15:44:21'),
(3, 4, 'breadcrumbs', 'categorías', '', '', 100, 1, '2025-06-30', '2025-06-30 17:25:07'),
(7, 5, 'breadcrumbs', 'api whatasapp', '', '', 100, 1, '2025-06-30', '2025-06-30 21:11:16'),
(8, 5, 'tables', 'whatsapps', 'whatsapp', '', 100, 1, '2025-06-30', '2025-06-30 21:15:29');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id_page` int(11) NOT NULL,
  `title_page` text DEFAULT NULL,
  `url_page` text DEFAULT NULL,
  `icon_page` text DEFAULT NULL,
  `type_page` text DEFAULT NULL,
  `order_page` int(11) DEFAULT 1,
  `date_created_page` date DEFAULT NULL,
  `date_updated_page` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id_page`, `title_page`, `url_page`, `icon_page`, `type_page`, `order_page`, `date_created_page`, `date_updated_page`) VALUES
(1, 'Inicio', 'inicio', 'bi bi-house-door-fill', 'modules', 1, '2025-06-30', '2025-06-30 15:44:21'),
(2, 'Admins', 'admins', 'bi bi-person-fill-gear', 'modules', 2, '2025-06-30', '2025-06-30 15:44:21'),
(3, 'Archivos', 'archivos', 'bi bi-file-earmark-image', 'custom', 3, '2025-06-30', '2025-06-30 15:44:21'),
(4, 'Categorías', 'categorias', 'bi bi-card-list', 'modules', 1000, '2025-06-30', '2025-06-30 17:23:31'),
(5, 'API-WS', 'api-ws', 'bi bi-whatsapp', 'modules', 1000, '2025-06-30', '2025-06-30 21:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `whatsapps`
--

CREATE TABLE `whatsapps` (
  `id_whatsapp` int(11) NOT NULL,
  `number_whatsapp` text DEFAULT NULL,
  `id_number_whatsapp` text DEFAULT NULL,
  `id_app_whatsapp` text DEFAULT NULL,
  `token_whatsapp` text DEFAULT NULL,
  `status_whasapp` int(11) DEFAULT 1,
  `ai_whatsapp` int(11) DEFAULT 1,
  `date_created_whatsapp` date DEFAULT NULL,
  `date_updated_whatsapp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `columns`
--
ALTER TABLE `columns`
  ADD PRIMARY KEY (`id_column`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id_file`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id_folder`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id_module`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id_page`);

--
-- Indexes for table `whatsapps`
--
ALTER TABLE `whatsapps`
  ADD PRIMARY KEY (`id_whatsapp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `columns`
--
ALTER TABLE `columns`
  MODIFY `id_column` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id_folder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id_module` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id_page` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `whatsapps`
--
ALTER TABLE `whatsapps`
  MODIFY `id_whatsapp` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
