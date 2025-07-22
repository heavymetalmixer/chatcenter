-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2025 at 10:54 PM
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
(1, 'superadmin@chatcenter.com', '$2a$07$azybxcags23425sdg23sdeanQZqjaf6Birm2NvcYTNtJw24CsO5uq', 'superadmin', '{\"todo\":\"on\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NTMxOTE3OTcsImV4cCI6MTc1MzI3ODE5NywiZGF0YSI6eyJpZCI6MSwiZW1haWwiOiJzdXBlcmFkbWluQGNoYXRjZW50ZXIuY29tIn19.U64cKVPrXkIcJMj7FV-KeCFiWlXWCEeTcUIH8GrIynA', '1753278197', 1, 'ChatCenter', '<i class=\"fa-solid fa-robot\"></i>', '', '#11a222', 'http://cms-chatcenter.com/views/assets/files/685afb5e89e3b14.PNG', NULL, NULL, '2025-06-24', '2025-07-22 13:43:17'),
(2, 'editor-archivos@chatcenter.com', '$2a$07$azybxcags23425sdg23sdeanQZqjaf6Birm2NvcYTNtJw24CsO5uq', 'editor', '%7B%22archivos%22%3A%22ON%22%7D', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NTEzNzg3OTEsImV4cCI6MTc1MTQ2NTE5MSwiZGF0YSI6eyJpZCI6MiwiZW1haWwiOiJlZGl0b3ItYXJjaGl2b3NAY2hhdGNlbnRlci5jb20ifX0.EAiZjGDINuNnL_rWL0qWHP0yEHykW_SG-GwuznQGhPE', '1751465191', 1, '', '', '', '', '', '', '%7B%7D', '2025-07-01', '2025-07-01 14:06:31');

-- --------------------------------------------------------

--
-- Table structure for table `bots`
--

CREATE TABLE `bots` (
  `id_bot` int(11) NOT NULL,
  `title_bot` text DEFAULT NULL,
  `type_bot` text DEFAULT NULL,
  `header_text_bot` text DEFAULT NULL,
  `header_image_bot` text DEFAULT NULL,
  `header_video_bot` text DEFAULT NULL,
  `body_text_bot` text DEFAULT NULL,
  `footer_text_bot` text DEFAULT NULL,
  `interactive_bot` text DEFAULT NULL,
  `buttons_bot` text DEFAULT '{}',
  `list_bot` text DEFAULT '[]',
  `date_created_bot` date DEFAULT NULL,
  `date_updated_bot` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bots`
--

INSERT INTO `bots` (`id_bot`, `title_bot`, `type_bot`, `header_text_bot`, `header_image_bot`, `header_video_bot`, `body_text_bot`, `footer_text_bot`, `interactive_bot`, `buttons_bot`, `list_bot`, `date_created_bot`, `date_updated_bot`) VALUES
(1, 'conversation', 'text', '', '', '', 'En instantes un agente se comunicará para conversar contigo.', '', 'none', '{}', '[]', '2025-07-22', '2025-07-22 14:58:10');

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
(1, 2, 'rol_admin', 'rol', 'select', 'superadmin,admin,editor', 1, '2025-06-24', '2025-06-24 18:05:47'),
(2, 2, 'permissions_admin', 'permisos', 'object', '', 1, '2025-06-24', '2025-06-24 18:05:47'),
(3, 2, 'email_admin', 'email', 'email', '', 1, '2025-06-24', '2025-06-24 18:05:47'),
(4, 2, 'password_admin', 'pass', 'password', '', 0, '2025-06-24', '2025-06-24 18:05:47'),
(5, 2, 'token_admin', 'token', 'text', '', 0, '2025-06-24', '2025-06-24 18:05:47'),
(6, 2, 'token_exp_admin', 'expiración', 'text', '', 0, '2025-06-24', '2025-06-24 18:05:47'),
(7, 2, 'status_admin', 'estado', 'boolean', '', 1, '2025-06-24', '2025-06-24 18:05:47'),
(8, 2, 'title_admin', 'título', 'text', '', 0, '2025-06-24', '2025-06-24 18:05:47'),
(9, 2, 'symbol_admin', 'simbolo', 'text', '', 0, '2025-06-24', '2025-06-24 18:05:47'),
(10, 2, 'font_admin', 'tipografía', 'text', '', 0, '2025-06-24', '2025-06-24 18:05:48'),
(11, 2, 'color_admin', 'color', 'text', '', 0, '2025-06-24', '2025-06-24 18:05:48'),
(12, 2, 'back_admin', 'fondo', 'text', '', 0, '2025-06-24', '2025-06-24 18:05:48'),
(13, 2, 'scode_admin', 'seguridad', 'text', '', 0, '2025-06-24', '2025-06-24 18:05:48'),
(14, 2, 'chatgpt_admin', 'chatgpt', 'object', '', 0, '2025-06-24', '2025-06-24 18:05:48'),
(20, 8, 'number_whatsapp', 'Número', 'text', NULL, 1, '2025-07-22', '2025-07-22 14:23:16'),
(21, 8, 'id_number_whatsapp', 'Id Número', 'text', NULL, 1, '2025-07-22', '2025-07-22 14:23:16'),
(22, 8, 'id_app_whatsapp', 'Id App', 'text', NULL, 1, '2025-07-22', '2025-07-22 14:23:16'),
(23, 8, 'token_whatsapp', 'Token', 'text', NULL, 1, '2025-07-22', '2025-07-22 14:23:16'),
(24, 8, 'status_whatsapp', 'Estado', 'boolean', NULL, 1, '2025-07-22', '2025-07-22 14:23:16'),
(25, 8, 'ai_whatsapp', 'Asistente IA', 'boolean', NULL, 1, '2025-07-22', '2025-07-22 14:23:16'),
(26, 10, 'id_conversation_message', 'Conversación', 'text', NULL, 1, '2025-07-22', '2025-07-22 14:33:03'),
(27, 10, 'type_message', 'Tipo', 'select', NULL, 1, '2025-07-22', '2025-07-22 14:33:03'),
(28, 10, 'id_whatsapp_message', 'API-WS', 'relations', NULL, 1, '2025-07-22', '2025-07-22 14:33:03'),
(29, 10, 'client_message', 'Cliente', 'code', NULL, 1, '2025-07-22', '2025-07-22 14:33:03'),
(30, 10, 'business_message', 'Negocio', 'code', NULL, 1, '2025-07-22', '2025-07-22 14:33:04'),
(31, 10, 'template_message', 'Plantilla', 'object', NULL, 1, '2025-07-22', '2025-07-22 14:35:07'),
(32, 10, 'expiration_message', 'Expiración', 'datetime', NULL, 1, '2025-07-22', '2025-07-22 14:35:07'),
(33, 10, 'order_message', 'Orden', 'int', NULL, 1, '2025-07-22', '2025-07-22 14:35:07'),
(34, 10, 'initial_message', 'Asistencia Manual', 'int', NULL, 1, '2025-07-22', '2025-07-22 14:35:07'),
(35, 10, 'phone_message', 'Teléfono', 'text', NULL, 1, '2025-07-22', '2025-07-22 14:37:01'),
(36, 12, 'title_bot', 'Título', 'text', NULL, 1, '2025-07-22', '2025-07-22 14:54:52'),
(37, 12, 'type_bot', 'Tipo', 'select', 'text,interactive', 1, '2025-07-22', '2025-07-22 14:56:44'),
(38, 12, 'header_text_bot', 'Header text', 'text', NULL, 1, '2025-07-22', '2025-07-22 14:54:52'),
(39, 12, 'header_image_bot', 'Header Image', 'image', NULL, 1, '2025-07-22', '2025-07-22 14:54:52'),
(40, 12, 'header_video_bot', 'Header Video', 'video', NULL, 1, '2025-07-22', '2025-07-22 14:54:52'),
(41, 12, 'body_text_bot', 'Body Text', 'textarea', NULL, 1, '2025-07-22', '2025-07-22 14:54:52'),
(42, 12, 'footer_text_bot', 'Footer Text', 'text', NULL, 1, '2025-07-22', '2025-07-22 14:54:52'),
(43, 12, 'interactive_bot', 'Tipo de Interacción', 'select', 'none,button,list', 1, '2025-07-22', '2025-07-22 14:58:08'),
(44, 12, 'buttons_bot', 'Botones', 'object', NULL, 1, '2025-07-22', '2025-07-22 14:54:52'),
(45, 12, 'list_bot', 'Lista', 'json', NULL, 1, '2025-07-22', '2025-07-22 14:54:52'),
(46, 14, 'phone_contact', 'Teléfono', 'text', NULL, 1, '2025-07-22', '2025-07-22 15:41:51'),
(47, 14, 'name_contact', 'Nombre', 'text', NULL, 1, '2025-07-22', '2025-07-22 15:41:51'),
(48, 14, 'ai_contact', 'Asistente IA', 'boolean', NULL, 1, '2025-07-22', '2025-07-22 15:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id_contact` int(11) NOT NULL,
  `phone_contact` text DEFAULT NULL,
  `name_contact` text DEFAULT NULL,
  `ai_contact` int(11) DEFAULT 1,
  `date_created_contact` date DEFAULT NULL,
  `date_updated_contact` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id_contact`, `phone_contact`, `name_contact`, `ai_contact`, `date_created_contact`, `date_updated_contact`) VALUES
(1, '573014115327', NULL, 0, '2025-07-22', '2025-07-22 16:53:05');

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
(1, 1, 'Captura', 'JPG', 'image/jpeg', 115477, 'http://cms-chatcenter.com/views/assets/files/685af23da4ff117.JPG', NULL, NULL, '2025-06-24', '2025-06-24 18:45:17'),
(2, 1, 'Snow', 'PNG', 'image/png', 1654733, 'http://cms-chatcenter.com/views/assets/files/685afb5e89e3b14.PNG', NULL, NULL, '2025-06-24', '2025-06-24 19:24:14'),
(3, 1, '6812890bcf30915', 'png', 'image/png', 544340, 'http://cms-chatcenter.com/views/assets/files/687fe56ad61c926.png', NULL, NULL, '2025-07-22', '2025-07-22 19:24:26');

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
(1, 'Server', '200000000000', 2314550, '500000000', 'http://cms-chatcenter.com', NULL, '2025-06-24', '2025-07-22 19:24:26');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL,
  `id_conversation_message` text DEFAULT NULL,
  `type_message` text DEFAULT NULL,
  `id_whatsapp_message` int(11) DEFAULT 0,
  `client_message` longtext DEFAULT NULL,
  `business_message` longtext DEFAULT NULL,
  `template_message` text DEFAULT '{}',
  `expiration_message` datetime DEFAULT NULL,
  `order_message` int(11) DEFAULT 0,
  `initial_message` int(11) DEFAULT 0,
  `phone_message` text DEFAULT NULL,
  `date_created_message` date DEFAULT NULL,
  `date_updated_message` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id_message`, `id_conversation_message`, `type_message`, `id_whatsapp_message`, `client_message`, `business_message`, `template_message`, `expiration_message`, `order_message`, `initial_message`, `phone_message`, `date_created_message`, `date_updated_message`) VALUES
(1, NULL, 'client', 1, 'Hola, buenos días', NULL, '{}', NULL, 0, 0, '573014115327', '2025-07-22', '2025-07-22 16:53:05'),
(2, '190e2062d9c5db5e78c60432ff342093', 'business', 1, NULL, 'En instantes un agente se comunicará para conversar contigo.', '{\"type\":\"bot\",\"title\":\"conversation\"}', '2025-07-22 16:52:20', 1, 0, '573014115327', '2025-07-22', '2025-07-22 16:53:07');

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
(1, 2, 'breadcrumbs', 'Administradores', NULL, NULL, 100, 1, '2025-06-24', '2025-06-24 18:05:47'),
(2, 2, 'tables', 'admins', 'admin', NULL, 100, 0, '2025-06-24', '2025-06-24 18:05:47'),
(7, 6, 'breadcrumbs', 'api de whatsapp', '', '', 100, 1, '2025-07-22', '2025-07-22 14:20:22'),
(8, 6, 'tables', 'whatsapps', 'whatsapp', '', 100, 1, '2025-07-22', '2025-07-22 14:23:16'),
(9, 7, 'breadcrumbs', 'mensajes', '', '', 100, 1, '2025-07-22', '2025-07-22 14:29:05'),
(10, 7, 'tables', 'messages', 'message', '', 100, 1, '2025-07-22', '2025-07-22 14:33:03'),
(11, 8, 'breadcrumbs', 'bots', '', '', 100, 1, '2025-07-22', '2025-07-22 14:38:50'),
(12, 8, 'tables', 'bots', 'bot', '', 100, 1, '2025-07-22', '2025-07-22 14:54:52'),
(13, 9, 'breadcrumbs', 'contactos', '', '', 100, 1, '2025-07-22', '2025-07-22 15:39:24'),
(14, 9, 'tables', 'contacts', 'contact', '', 100, 1, '2025-07-22', '2025-07-22 15:41:51');

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
(1, 'Chat', 'chat', 'bi bi-chat-dots-fill', 'custom', 1, '2025-06-24', '2025-07-22 19:16:42'),
(2, 'Admins', 'admins', 'bi bi-person-fill-gear', 'modules', 2, '2025-06-24', '2025-06-24 18:05:47'),
(3, 'Archivos', 'archivos', 'bi bi-file-earmark-image', 'custom', 3, '2025-06-24', '2025-06-24 18:05:47'),
(6, 'API-WS', 'api-ws', 'bi bi-whatsapp', 'modules', 1000, '2025-07-22', '2025-07-22 14:20:15'),
(7, 'Mensajes', 'mensajes', 'bi bi-chat-square-text', 'modules', 1000, '2025-07-22', '2025-07-22 14:28:59'),
(8, 'Bots', 'bots', 'bi bi-card-list', 'modules', 1000, '2025-07-22', '2025-07-22 14:38:44'),
(9, 'Contactos', 'contactos', 'bi bi-person-lines-fill', 'modules', 1000, '2025-07-22', '2025-07-22 15:39:18');

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
  `status_whatsapp` int(11) DEFAULT 1,
  `ai_whatsapp` int(11) DEFAULT 1,
  `date_created_whatsapp` date DEFAULT NULL,
  `date_updated_whatsapp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `whatsapps`
--

INSERT INTO `whatsapps` (`id_whatsapp`, `number_whatsapp`, `id_number_whatsapp`, `id_app_whatsapp`, `token_whatsapp`, `status_whatsapp`, `ai_whatsapp`, `date_created_whatsapp`, `date_updated_whatsapp`) VALUES
(1, '15556588621', '661536270384648', '1435203277506567', 'EAAKblDMrXZB8BPMZCrnpqHYu9O8qTpnrDXv6ZBL9mxdql4YaRp5ZCkuwXmmxPaabOvfOcCrVPNLtNMMe2ueJgabtGSmV0XcaOfHcrx6kBrsrmDRg9ZCBdiwWysF3BmbNIShMK8MLB8GGCsmylZCHz1uZCUuCp9FTbtTgiK4kS6uB3bJteuqStZB2Dd5cZBI0ul6u3dwZDZD', 1, 0, '2025-07-22', '2025-07-22 14:25:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `bots`
--
ALTER TABLE `bots`
  ADD PRIMARY KEY (`id_bot`);

--
-- Indexes for table `columns`
--
ALTER TABLE `columns`
  ADD PRIMARY KEY (`id_column`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id_contact`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`);

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
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bots`
--
ALTER TABLE `bots`
  MODIFY `id_bot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `columns`
--
ALTER TABLE `columns`
  MODIFY `id_column` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id_folder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id_module` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id_page` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `whatsapps`
--
ALTER TABLE `whatsapps`
  MODIFY `id_whatsapp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
