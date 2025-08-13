-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2025 at 03:11 AM
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

CREATE DATABASE IF NOT EXISTS chatcenter;
USE chatcenter;

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
(1, 'superadmin@chatcenter.com', '$2a$07$azybxcags23425sdg23sdeanQZqjaf6Birm2NvcYTNtJw24CsO5uq', 'superadmin', '{\"todo\":\"on\"}', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NTQ5NTI2NDMsImV4cCI6MTc1NTAzOTA0MywiZGF0YSI6eyJpZCI6MSwiZW1haWwiOiJzdXBlcmFkbWluQGNoYXRjZW50ZXIuY29tIn19.k5B2J0tm6xHikJDR5fCM2KMxAvxVnY1Cg-77M-4uV50', '1755039043', 1, 'ChatCenter', '<i class=\"bi bi-robot\"></i>', '', '#37ab34', 'http://cms-chatcenter.com/views/assets/files/687bbdcfc9ff623.jpg', NULL, NULL, '2025-07-18', '2025-08-11 22:50:43'),
(2, 'admin@chatcenter.com', '$2a$07$azybxcags23425sdg23sdeanQZqjaf6Birm2NvcYTNtJw24CsO5uq', 'admin', '%7B%22TODO%22%3A%22ON%22%7D', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NTI5NDAzNTgsImV4cCI6MTc1MzAyNjc1OCwiZGF0YSI6eyJpZCI6MiwiZW1haWwiOiJhZG1pbkBjaGF0Y2VudGVyLmNvbSJ9fQ.kdI0m7f72epdAmUKily4MA_fkgIl9_PguHFav4JoeWg', '1753026758', 1, '', '', '', '', '', '', '%7B%7D', '2025-07-19', '2025-07-19 15:52:38'),
(3, 'editor-archivos@chatcenter.com', '$2a$07$azybxcags23425sdg23sdeanQZqjaf6Birm2NvcYTNtJw24CsO5uq', 'editor', '%7B%22archivos%22%3A%22ON%22%7D', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NTI5NDA1MzgsImV4cCI6MTc1MzAyNjkzOCwiZGF0YSI6eyJpZCI6MywiZW1haWwiOiJlZGl0b3ItYXJjaGl2b3NAY2hhdGNlbnRlci5jb20ifX0.WHrSQo3sIUhoo-PWN3PO7fCcNDFW9Ccq3aiZPEvdexs', '1753026938', 1, '', '', '', '', '', '', '%7B%7D', '2025-07-19', '2025-07-19 15:55:38');

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
  `title_list_bot` text DEFAULT NULL,
  `date_created_bot` date DEFAULT NULL,
  `date_updated_bot` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bots`
--

INSERT INTO `bots` (`id_bot`, `title_bot`, `type_bot`, `header_text_bot`, `header_image_bot`, `header_video_bot`, `body_text_bot`, `footer_text_bot`, `interactive_bot`, `buttons_bot`, `list_bot`, `title_list_bot`, `date_created_bot`, `date_updated_bot`) VALUES
(2, 'conversation', 'text', '', '', '', 'En unos instantes un agente se comunicará para conversar contigo.', '', 'none', '{}', '[]', NULL, '2025-07-26', '2025-08-03 19:13:16'),
(4, 'welcome', 'interactive', '', 'http://res.cloudinary.com/dixojpt7d/image/upload/v1754236646/restaurant_slrzea.jpg', '', 'Bienvenido a *Restaurant*, soy el asistente virtual que te atenderá hoy, estoy muy entusiasmado por servirte. *¿Qué deseas realizar hoy?*', '', 'button', '{\"1\":\"Realizar un pedido\",\"2\":\"Reservar mesa\",\"3\":\"Servicio al cliente\"}', '[]', NULL, '2025-08-03', '2025-08-04 00:36:09'),
(5, 'reservation', 'text', '', '', '', 'Perfecto, vamos a reservar una mesa\\nPor favor indícame la siguiente información:\\nFecha:\\nHora:\\nNúmero de personas:\\nTu nombre y número de contacto:', '', 'none', '{}', '[]', NULL, '2025-08-04', '2025-08-04 22:27:55'),
(7, 'menu', 'interactive', '', '', '', '¡Qué rico! Te comparto nuestro menú', '', 'list', '{}', '[{\"id\":\"1\",\"title\":\"Entradas\",\"description\":\"Quiero una deliciosa entrada\"},{\"id\":\"2\",\"title\":\"Platos Fuertes\",\"description\":\"Quiero una deliciosa receta\"},{\"id\":\"3\",\"title\":\"Postres\",\"description\":\"Quiero un delicioso postre\"},{\"id\":\"4\",\"title\":\"Bebidas\",\"description\":\"Quiero una deliciosa bebida\"},{\"id\":\"contactar\",\"title\":\"Contactar un asistente\",\"description\":\"Atención Personalizada\"}]', 'Menú', '2025-08-05', '2025-08-08 14:52:58'),
(8, 'listMenu', 'interactive', '', '', '', 'Selecciona una de nuestras delicias:', 'O regresa al Menú Principal escribiendo la palabra *menu*', 'none', '{}', '[]', '', '2025-08-05', '2025-08-08 14:05:46'),
(9, 'reset', 'interactive', '', '', '', '*Elige entre las siguientes opciones:*\\n- Otra delicia de nuestro menú\\n- Contactar a un asistente\\n- Ya está listo mi pedido', '', 'list', '{}', '[{\"id\":\"1\",\"title\":\"Entradas\",\"description\":\"Quiero una deliciosa entrada\"},{\"id\":\"2\",\"title\":\"Platos Fuertes\",\"description\":\"Quiero una deliciosa receta\"},{\"id\":\"3\",\"title\":\"Postres\",\"description\":\"Quiero un delicioso postre\"},{\"id\":\"4\",\"title\":\"Bebidas\",\"description\":\"Quiero una deliciosa bebida\"},{\"id\":\"contactar\",\"title\":\"Contactar un asistente\",\"description\":\"Atención Personalizada\"},{\"id\":\"domicilio\",\"title\":\"Ya está listo mi pedido\",\"description\":\"Dar mis datos para el domicilio\"}]', 'Menú', '2025-08-08', '2025-08-08 15:31:29'),
(10, 'delivery', 'text', '', '', '', '¡Qué buena elección! 👍\\nA cotinuación comenzaré a pedirte la siguiente información', '', 'none', '{}', '[]', '', '2025-08-09', '2025-08-09 22:15:40'),
(11, 'name', 'text', '', '', '', 'Escribe+tu+nombre+y+apellido+en+un+mismo+regl%C3%B3n', '', 'none', '%7B%7D', '%5B%5D', '', '2025-08-10', '2025-08-10 19:47:24'),
(12, 'phone', 'text', '', '', '', 'Escribe+tu+n%C3%BAmero+celular+sin+espacios+ni+s%C3%ADmbolos%2C+solo+n%C3%BAmeros', '', 'none', '%7B%7D', '%5B%5D', '', '2025-08-10', '2025-08-10 19:49:18'),
(13, 'email', 'text', '', '', '', 'Escribe+tu+correo+electr%C3%B3nico', '', 'none', '%7B%7D', '%5B%5D', '', '2025-08-10', '2025-08-10 19:50:38'),
(14, 'address', 'text', '', '', '', 'Escribe+tu+direcci%C3%B3n+en+un+solo+rengl%C3%B3n%2C+agrega+datos+como+barrio%2C+apto%2C+bloque+o+urbanizaci%C3%B3n+si+es+necesario', '', 'none', '%7B%7D', '%5B%5D', '', '2025-08-10', '2025-08-10 19:52:36'),
(15, 'process', 'text', '', '', '', 'Espera+un+momento%2C+estamos+procesando+tu+pedido', '', 'none', '%7B%7D', '%5B%5D', '', '2025-08-10', '2025-08-10 20:26:41'),
(16, 'confirmation', 'interactive', 'Confirma tu pedido', '', '', '', '¿Está bien tu pedido?', 'button', '{\"1\":\"Si\",\"2\":\"No, corregir\"}', '[]', '', '2025-08-10', '2025-08-10 20:50:14'),
(17, 'checkout', 'text', '', '', '', 'Continúa con nuestra *pasarela de pagos* para finalizar el pedido. ¡Finalizado el pago *envía el comprobante* para despachar el pedido!\\n\\nHaz el pago acá: https://paypal.me/juanunat/', '', 'none', '{}', '[]', '', '2025-08-11', '2025-08-12 00:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `title_category` text DEFAULT NULL,
  `date_created_category` date DEFAULT NULL,
  `date_updated_category` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_category`, `title_category`, `date_created_category`, `date_updated_category`) VALUES
(1, 'Entradas', '2025-08-05', '2025-08-05 19:07:50'),
(2, 'Platos+Fuertes', '2025-08-05', '2025-08-05 19:08:36'),
(3, 'Postres', '2025-08-05', '2025-08-05 19:08:45'),
(4, 'Bebidas', '2025-08-05', '2025-08-05 19:09:15');

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
(1, 2, 'rol_admin', 'rol', 'select', 'superadmin,admin,editor', 1, '2025-07-18', '2025-07-18 22:34:25'),
(2, 2, 'permissions_admin', 'permisos', 'object', '', 1, '2025-07-18', '2025-07-18 22:34:25'),
(3, 2, 'email_admin', 'email', 'email', '', 1, '2025-07-18', '2025-07-18 22:34:25'),
(4, 2, 'password_admin', 'pass', 'password', '', 0, '2025-07-18', '2025-07-18 22:34:25'),
(5, 2, 'token_admin', 'token', 'text', '', 0, '2025-07-18', '2025-07-18 22:34:25'),
(6, 2, 'token_exp_admin', 'expiración', 'text', '', 0, '2025-07-18', '2025-07-18 22:34:25'),
(7, 2, 'status_admin', 'estado', 'boolean', '', 1, '2025-07-18', '2025-07-18 22:34:25'),
(8, 2, 'title_admin', 'título', 'text', '', 0, '2025-07-18', '2025-07-18 22:34:25'),
(9, 2, 'symbol_admin', 'simbolo', 'text', '', 0, '2025-07-18', '2025-07-18 22:34:25'),
(10, 2, 'font_admin', 'tipografía', 'text', '', 0, '2025-07-18', '2025-07-18 22:34:25'),
(11, 2, 'color_admin', 'color', 'text', '', 0, '2025-07-18', '2025-07-18 22:34:25'),
(12, 2, 'back_admin', 'fondo', 'text', '', 0, '2025-07-18', '2025-07-18 22:34:25'),
(13, 2, 'scode_admin', 'seguridad', 'text', '', 0, '2025-07-18', '2025-07-18 22:34:25'),
(14, 2, 'chatgpt_admin', 'chatgpt', 'object', '', 0, '2025-07-18', '2025-07-18 22:34:25'),
(46, 14, 'number_whatsapp', 'Número', 'text', NULL, 1, '2025-07-25', '2025-07-25 21:36:38'),
(47, 14, 'id_number_whatsapp', 'ID Número', 'text', NULL, 1, '2025-07-25', '2025-07-25 21:36:38'),
(48, 14, 'id_app_whatsapp', 'ID App', 'text', NULL, 1, '2025-07-25', '2025-07-25 21:36:38'),
(49, 14, 'token_whatsapp', 'Token', 'text', NULL, 1, '2025-07-25', '2025-07-25 21:36:38'),
(50, 14, 'status_whatsapp', 'Estado', 'boolean', NULL, 1, '2025-07-25', '2025-07-25 21:36:38'),
(51, 14, 'ai_whatsapp', 'Asistente IA', 'boolean', NULL, 1, '2025-07-25', '2025-07-25 21:36:38'),
(52, 16, 'id_conversation_message', 'Conversación', 'text', NULL, 1, '2025-07-25', '2025-07-25 21:52:09'),
(53, 16, 'type_message', 'Tipo', 'select', NULL, 1, '2025-07-25', '2025-07-25 21:52:09'),
(54, 16, 'id_whatsapp_message', 'API-WS', 'relations', NULL, 1, '2025-07-25', '2025-07-25 21:52:09'),
(55, 16, 'client_message', 'Cliente', 'code', NULL, 1, '2025-07-25', '2025-07-25 21:52:09'),
(56, 16, 'business_message', 'Negocio', 'code', NULL, 1, '2025-07-25', '2025-07-25 21:52:09'),
(57, 16, 'template_message', 'Plantilla', 'object', NULL, 1, '2025-07-25', '2025-07-25 21:52:09'),
(58, 16, 'expiration_message', 'Expiración', 'datetime', NULL, 1, '2025-07-25', '2025-07-25 21:52:09'),
(59, 16, 'order_message', 'Orden', 'int', NULL, 1, '2025-07-25', '2025-07-25 21:52:09'),
(60, 16, 'initial_message', 'Asistencia Manual', 'int', NULL, 1, '2025-07-25', '2025-07-25 21:52:09'),
(61, 16, 'phone_message', 'Teléfono', 'text', NULL, 1, '2025-07-25', '2025-07-25 22:11:34'),
(62, 18, 'title_bot', 'Título', 'text', NULL, 1, '2025-07-25', '2025-07-25 22:43:01'),
(63, 18, 'type_bot', 'Tipo', 'select', 'text,interactive', 1, '2025-07-25', '2025-07-25 22:50:07'),
(64, 18, 'header_text_bot', 'Header Text', 'text', NULL, 1, '2025-07-25', '2025-07-25 22:43:01'),
(65, 18, 'header_image_bot', 'Header Image', 'image', NULL, 1, '2025-07-25', '2025-07-25 22:43:01'),
(66, 18, 'header_video_bot', 'Header Video', 'video', NULL, 1, '2025-07-25', '2025-07-25 22:43:01'),
(67, 18, 'body_text_bot', 'Body Text', 'textarea', NULL, 1, '2025-07-25', '2025-07-25 22:43:01'),
(68, 18, 'footer_text_bot', 'Footer Text', 'text', NULL, 1, '2025-07-25', '2025-07-25 22:43:01'),
(69, 18, 'interactive_bot', 'Tipo de Interacción', 'select', 'none,button,list', 1, '2025-07-25', '2025-07-25 22:51:32'),
(70, 18, 'buttons_bot', 'Botones', 'object', NULL, 1, '2025-07-25', '2025-07-25 22:43:01'),
(71, 18, 'list_bot', 'Lista', 'json', NULL, 1, '2025-07-25', '2025-07-25 22:43:01'),
(72, 20, 'phone_contact', 'Teléfono', 'text', NULL, 1, '2025-07-26', '2025-07-26 22:06:11'),
(73, 20, 'name_contact', 'Nombre', 'text', NULL, 1, '2025-07-26', '2025-07-26 22:06:11'),
(74, 20, 'ai_contact', 'Asistente IA', 'boolean', NULL, 1, '2025-07-26', '2025-07-26 22:06:11'),
(75, 18, 'title_list_bot', 'Título Lista', 'text', NULL, 1, '2025-08-04', '2025-08-04 23:31:17'),
(76, 22, 'title_category', 'Título', 'text', NULL, 1, '2025-08-05', '2025-08-05 19:07:19'),
(77, 24, 'title_product', 'Título', 'text', NULL, 1, '2025-08-05', '2025-08-05 19:18:00'),
(78, 24, 'id_category_product', 'Categoría', 'relations', 'categories', 1, '2025-08-05', '2025-08-05 19:19:21'),
(79, 24, 'price_product', 'Precio', 'money', NULL, 1, '2025-08-05', '2025-08-05 19:18:01'),
(80, 24, 'code_product', 'Código', 'text', NULL, 1, '2025-08-05', '2025-08-05 19:18:01'),
(81, 26, 'conversation_order', 'Conversación', 'text', NULL, 1, '2025-08-11', '2025-08-11 22:58:21'),
(82, 26, 'products_order', 'Productos', 'text', NULL, 1, '2025-08-11', '2025-08-11 22:58:21'),
(83, 26, 'phone_order', 'Celular', 'text', NULL, 1, '2025-08-11', '2025-08-11 22:58:22'),
(84, 26, 'name_order', 'Nombre', 'text', NULL, 1, '2025-08-11', '2025-08-11 22:58:22'),
(85, 26, 'email_order', 'Email', 'email', NULL, 1, '2025-08-11', '2025-08-11 22:58:23'),
(86, 26, 'address_order', 'Dirección', 'text', NULL, 1, '2025-08-11', '2025-08-11 22:58:23'),
(87, 26, 'contact_order', 'Contacto', 'text', NULL, 1, '2025-08-11', '2025-08-11 22:58:23'),
(88, 26, 'total_order', 'Total', 'money', NULL, 1, '2025-08-11', '2025-08-11 22:58:24'),
(89, 26, 'status_order', 'Estado', 'select', 'Pendiente,En Preparación,En Domicilio,Entregado', 1, '2025-08-11', '2025-08-11 23:20:50');

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
(1, '573014115327', NULL, 0, '2025-08-12', '2025-08-13 01:08:00');

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
(1, 1, '685afb5e89e3b14', 'PNG', 'image/png', 1654733, 'http://cms-chatcenter.com/views/assets/files/687ad1c6863e518.PNG', NULL, NULL, '2025-07-19', '2025-07-18 22:59:18'),
(2, 1, '68004d2030bd548', 'jpg', 'image/jpeg', 204485, 'http://cms-chatcenter.com/views/assets/files/687bbdcfc9ff623.jpg', NULL, NULL, '2025-07-19', '2025-07-19 15:46:23'),
(3, 1, '687fe56ad61c926', 'png', 'image/png', 544340, 'http://cms-chatcenter.com/views/assets/files/6885741eb071f38.png', NULL, NULL, '2025-07-27', '2025-07-27 00:34:38'),
(4, 1, '67fd7513f335a27', 'mp3', 'audio/mpeg', 10046, 'http://cms-chatcenter.com/views/assets/files/688d33f412fbd0.mp3', NULL, NULL, '2025-08-01', '2025-08-01 21:39:00'),
(5, 1, '67fd7513f39e427', 'mp3', 'audio/mpeg', 1946, 'http://cms-chatcenter.com/views/assets/files/688d3a9c482e924.mp3', NULL, NULL, '2025-08-02', '2025-08-01 22:07:24'),
(6, 1, '67fd7513f345f27', 'mp3', 'audio/mpeg', 2126, 'http://cms-chatcenter.com/views/assets/files/688d3afbe841559.mp3', NULL, NULL, '2025-08-02', '2025-08-01 22:08:59');

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
(1, 'Server', '200000000000', 2417676, '500000000', 'http://cms-chatcenter.com', NULL, '2025-07-18', '2025-08-01 22:08:59');

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
(1, '', 'client', 1, 'Hola, buenas noches', NULL, '', '0000-00-00 00:00:00', 0, 1, '573014115327', '2025-08-12', '2025-08-13 00:53:27'),
(2, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'Bienvenido a *Restaurant*, soy el asistente virtual que te atenderá hoy, estoy muy entusiasmado por servirte. *¿Qué deseas realizar hoy?*', '{\"type\":\"bot\",\"title\":\"welcome\"}', '2025-08-13 00:53:45', 1, 1, '573014115327', '2025-08-12', '2025-08-13 00:53:34'),
(3, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '{\"id\":\"1\",\"text\":\"Realizar un pedido\"}', NULL, '{\"type\":\"bot\",\"title\":\"welcome\"}', '2025-08-13 00:53:45', 2, 1, '573014115327', '2025-08-12', '2025-08-13 00:54:03'),
(4, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, '¡Qué rico! Te comparto nuestro menú', '{\"type\":\"bot\",\"title\":\"menu\"}', '2025-08-13 00:53:45', 3, 1, '573014115327', '2025-08-12', '2025-08-13 00:54:10'),
(5, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '{\"id\":\"1\",\"text\":\"Entradas\"}', NULL, '{\"type\":\"bot\",\"title\":\"menu\"}', '2025-08-13 00:53:45', 4, 1, '573014115327', '2025-08-12', '2025-08-13 00:54:39'),
(6, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'Selecciona una de nuestras delicias:', '{\"type\":\"bot\",\"title\":\"listMenu\"}', '2025-08-13 00:53:45', 5, 1, '573014115327', '2025-08-12', '2025-08-13 00:54:46'),
(7, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '{\"id\":\"sku003\",\"text\":\"Mazorca Gratinada\"}', NULL, '{\"type\":\"bot\",\"title\":\"listMenu\"}', '2025-08-13 00:53:45', 6, 1, '573014115327', '2025-08-12', '2025-08-13 00:54:48'),
(8, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, '*Elige entre las siguientes opciones:*\\n- Otra delicia de nuestro menú\\n- Contactar a un asistente\\n- Ya está listo mi pedido', '{\"type\":\"bot\",\"title\":\"reset\"}', '2025-08-13 00:53:45', 7, 1, '573014115327', '2025-08-12', '2025-08-13 00:54:55'),
(9, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '{\"id\":\"2\",\"text\":\"Platos Fuertes\"}', NULL, '{\"type\":\"bot\",\"title\":\"reset\"}', '2025-08-13 00:53:45', 8, 1, '573014115327', '2025-08-12', '2025-08-13 00:55:45'),
(10, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'Selecciona una de nuestras delicias:', '{\"type\":\"bot\",\"title\":\"listMenu\"}', '2025-08-13 00:53:45', 9, 1, '573014115327', '2025-08-12', '2025-08-13 00:55:52'),
(11, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '{\"id\":\"sku006\",\"text\":\"Spaghetti Alfredo\"}', NULL, '{\"type\":\"bot\",\"title\":\"listMenu\"}', '2025-08-13 00:53:45', 10, 1, '573014115327', '2025-08-12', '2025-08-13 00:55:57'),
(12, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, '*Elige entre las siguientes opciones:*\\n- Otra delicia de nuestro menú\\n- Contactar a un asistente\\n- Ya está listo mi pedido', '{\"type\":\"bot\",\"title\":\"reset\"}', '2025-08-13 00:53:45', 11, 1, '573014115327', '2025-08-12', '2025-08-13 00:56:03'),
(13, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '{\"id\":\"3\",\"text\":\"Postres\"}', NULL, '{\"type\":\"bot\",\"title\":\"reset\"}', '2025-08-13 00:53:45', 12, 1, '573014115327', '2025-08-12', '2025-08-13 00:56:27'),
(14, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'Selecciona una de nuestras delicias:', '{\"type\":\"bot\",\"title\":\"listMenu\"}', '2025-08-13 00:53:45', 13, 1, '573014115327', '2025-08-12', '2025-08-13 00:56:34'),
(15, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '{\"id\":\"sku008\",\"text\":\"Flan de Caramelo\"}', NULL, '{\"type\":\"bot\",\"title\":\"listMenu\"}', '2025-08-13 00:53:45', 14, 1, '573014115327', '2025-08-12', '2025-08-13 00:56:36'),
(16, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, '*Elige entre las siguientes opciones:*\\n- Otra delicia de nuestro menú\\n- Contactar a un asistente\\n- Ya está listo mi pedido', '{\"type\":\"bot\",\"title\":\"reset\"}', '2025-08-13 00:53:45', 15, 1, '573014115327', '2025-08-12', '2025-08-13 00:56:43'),
(17, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '{\"id\":\"4\",\"text\":\"Bebidas\"}', NULL, '{\"type\":\"bot\",\"title\":\"reset\"}', '2025-08-13 00:53:45', 16, 1, '573014115327', '2025-08-12', '2025-08-13 00:57:12'),
(18, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'Selecciona una de nuestras delicias:', '{\"type\":\"bot\",\"title\":\"listMenu\"}', '2025-08-13 00:53:45', 17, 1, '573014115327', '2025-08-12', '2025-08-13 00:57:19'),
(19, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '{\"id\":\"sku0012\",\"text\":\"Agua sin Gas\"}', NULL, '{\"type\":\"bot\",\"title\":\"listMenu\"}', '2025-08-13 00:53:45', 18, 1, '573014115327', '2025-08-12', '2025-08-13 00:57:22'),
(20, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, '*Elige entre las siguientes opciones:*\\n- Otra delicia de nuestro menú\\n- Contactar a un asistente\\n- Ya está listo mi pedido', '{\"type\":\"bot\",\"title\":\"reset\"}', '2025-08-13 00:53:45', 19, 1, '573014115327', '2025-08-12', '2025-08-13 00:57:29'),
(21, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '{\"id\":\"domicilio\",\"text\":\"Ya está listo mi pedido\"}', NULL, '{\"type\":\"bot\",\"title\":\"reset\"}', '2025-08-13 00:53:45', 20, 1, '573014115327', '2025-08-12', '2025-08-13 00:57:53'),
(22, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, '¡Qué buena elección! 👍\\nA cotinuación comenzaré a pedirte la siguiente información', '{\"type\":\"bot\",\"title\":\"delivery\"}', '2025-08-13 00:53:45', 21, 1, '573014115327', '2025-08-12', '2025-08-13 00:58:00'),
(23, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'Escribe+tu+nombre+y+apellido+en+un+mismo+regl%C3%B3n', '{\"type\":\"bot\",\"title\":\"name\"}', '2025-08-13 00:53:45', 22, 1, '573014115327', '2025-08-12', '2025-08-13 00:58:05'),
(24, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, 'Luis Calle', NULL, '{\"type\":\"bot\",\"title\":\"name\"}', '2025-08-13 00:53:45', 23, 1, '573014115327', '2025-08-12', '2025-08-13 00:58:38'),
(25, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'Escribe+tu+n%C3%BAmero+celular+sin+espacios+ni+s%C3%ADmbolos%2C+solo+n%C3%BAmeros', '{\"type\":\"bot\",\"title\":\"phone\"}', '2025-08-13 00:53:45', 24, 1, '573014115327', '2025-08-12', '2025-08-13 00:58:44'),
(26, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '3234567890', NULL, '{\"type\":\"bot\",\"title\":\"phone\"}', '2025-08-13 00:53:45', 25, 1, '573014115327', '2025-08-12', '2025-08-13 00:58:50'),
(27, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'Escribe+tu+correo+electr%C3%B3nico', '{\"type\":\"bot\",\"title\":\"email\"}', '2025-08-13 00:53:45', 26, 1, '573014115327', '2025-08-12', '2025-08-13 00:58:57'),
(28, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, 'luis@gmail.com', NULL, '{\"type\":\"bot\",\"title\":\"email\"}', '2025-08-13 00:53:45', 27, 1, '573014115327', '2025-08-12', '2025-08-13 00:59:41'),
(29, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'Escribe+tu+direcci%C3%B3n+en+un+solo+rengl%C3%B3n%2C+agrega+datos+como+barrio%2C+apto%2C+bloque+o+urbanizaci%C3%B3n+si+es+necesario', '{\"type\":\"bot\",\"title\":\"address\"}', '2025-08-13 00:53:45', 28, 1, '573014115327', '2025-08-12', '2025-08-13 00:59:48'),
(30, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, 'Calle 23 #44-55 Apto 202', NULL, '{\"type\":\"bot\",\"title\":\"address\"}', '2025-08-13 00:53:45', 29, 1, '573014115327', '2025-08-12', '2025-08-13 01:00:00'),
(31, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'Espera+un+momento%2C+estamos+procesando+tu+pedido', '{\"type\":\"bot\",\"title\":\"process\"}', '2025-08-13 00:53:45', 30, 1, '573014115327', '2025-08-12', '2025-08-13 01:00:07'),
(32, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'Mazorca Gratinada - $5 USD\nSpaghetti Alfredo - $15 USD\nFlan de Caramelo - $5 USD\nAgua sin Gas - $3 USD\n\n*Nombre:* Luis Calle\n*Celular:* 3234567890\n*Email:* luis@gmail.com\n*Dirección:* Calle 23 #44-55 Apto 202\n\n*Total Pedido: $28 USD*\n', '{\"type\":\"bot\",\"title\":\"confirmation\"}', '2025-08-13 00:53:45', 31, 1, '573014115327', '2025-08-12', '2025-08-13 01:00:15'),
(33, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '{\"id\":\"1\",\"text\":\"Si\"}', NULL, '{\"type\":\"bot\",\"title\":\"confirmation\"}', '2025-08-13 00:53:45', 32, 1, '573014115327', '2025-08-12', '2025-08-13 01:00:45'),
(34, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'Continúa con nuestra *pasarela de pagos* para finalizar el pedido. ¡Finalizado el pago *envía el comprobante* para despachar el pedido!\\n\\nHaz el pago acá: https://paypal.me/juanunat/28', '{\"type\":\"bot\",\"title\":\"checkout\"}', '2025-08-13 00:53:45', 33, 1, '573014115327', '2025-08-12', '2025-08-13 01:00:53'),
(35, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, '{\"type\":\"image\",\"mime\":\"image/jpeg\",\"id\":\"2190350578151592\",\"caption\":\"\"}', NULL, '{\"type\":\"bot\",\"title\":\"checkout\"}', '2025-08-13 00:53:45', 34, 1, '573014115327', '2025-08-12', '2025-08-13 01:01:33'),
(36, 'af11fdbee39d06d3042f83ee344f2eb3', 'business', 1, NULL, 'En unos instantes un agente se comunicará para conversar contigo.', '{\"type\":\"bot\",\"title\":\"conversation\"}', '2025-08-13 00:53:45', 35, 1, '573014115327', '2025-08-12', '2025-08-13 01:01:39'),
(37, 'af11fdbee39d06d3042f83ee344f2eb3', 'client', 1, 'Hola?', NULL, '{\"type\":\"bot\",\"title\":\"conversation\"}', '2025-08-13 00:53:45', 36, 1, '573014115327', '2025-08-12', '2025-08-13 01:08:00');

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
(1, 2, 'breadcrumbs', 'Administradores', NULL, NULL, 100, 1, '2025-07-18', '2025-07-18 22:34:25'),
(2, 2, 'tables', 'admins', 'admin', NULL, 100, 0, '2025-07-18', '2025-07-18 22:34:25'),
(13, 9, 'breadcrumbs', 'api-ws', '', '', 100, 1, '2025-07-25', '2025-07-25 21:31:21'),
(14, 9, 'tables', 'whatsapps', 'whatsapp', '', 100, 1, '2025-07-25', '2025-07-25 21:36:38'),
(15, 10, 'breadcrumbs', 'mensajes', '', '', 100, 1, '2025-07-25', '2025-07-25 21:46:09'),
(16, 10, 'tables', 'messages', 'message', '', 100, 1, '2025-07-25', '2025-07-25 21:52:09'),
(17, 11, 'breadcrumbs', 'bots', '', '', 100, 1, '2025-07-25', '2025-07-25 22:34:39'),
(18, 11, 'tables', 'bots', 'bot', '', 100, 1, '2025-07-25', '2025-07-25 22:43:01'),
(19, 12, 'breadcrumbs', 'contactos', '', '', 100, 1, '2025-07-26', '2025-07-26 22:04:34'),
(20, 12, 'tables', 'contacts', 'contact', '', 100, 1, '2025-07-26', '2025-07-26 22:06:11'),
(21, 14, 'breadcrumbs', 'categorías', '', '', 100, 1, '2025-08-05', '2025-08-05 19:06:20'),
(22, 14, 'tables', 'categories', 'category', '', 100, 1, '2025-08-05', '2025-08-05 19:07:19'),
(23, 15, 'breadcrumbs', 'productos', '', '', 100, 1, '2025-08-05', '2025-08-05 19:14:23'),
(24, 15, 'tables', 'products', 'product', '', 100, 1, '2025-08-05', '2025-08-05 19:18:00'),
(25, 16, 'breadcrumbs', 'Órdenes', '', '', 100, 1, '2025-08-11', '2025-08-11 22:52:11'),
(26, 16, 'tables', 'orders', 'order', '', 100, 1, '2025-08-11', '2025-08-11 22:58:20');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `conversation_order` text DEFAULT NULL,
  `products_order` text DEFAULT NULL,
  `phone_order` text DEFAULT NULL,
  `name_order` text DEFAULT NULL,
  `email_order` text DEFAULT NULL,
  `address_order` text DEFAULT NULL,
  `contact_order` text DEFAULT NULL,
  `total_order` double DEFAULT 0,
  `status_order` text DEFAULT NULL,
  `date_created_order` date DEFAULT NULL,
  `date_updated_order` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id_order`, `conversation_order`, `products_order`, `phone_order`, `name_order`, `email_order`, `address_order`, `contact_order`, `total_order`, `status_order`, `date_created_order`, `date_updated_order`) VALUES
(1, 'defed0312e27d68966aae0a486d42023', 'Nachos de la Casa - $5 USD\nCostillas BBQ - $15 USD\nTiramisú - $5 USD\nLimonada - $3 USD\n', '3013456789', 'Julio Perez', 'julio@gmail.com', 'Calle 12 #44', '573014115327', 28, 'Pendiente', '2025-08-11', '2025-08-11 23:55:15'),
(2, '1f473afbc45b60678762ccb1f2c8b8cf', 'Nachos de la Casa - $5 USD\nCostillas BBQ - $15 USD\nTiramisú - $5 USD\nLimonada - $3 USD\n', '3013456789', 'Julio Perez', 'julio@gmail.com', 'Calle 23 #44', '573014115327', 28, 'Pendiente', '2025-08-11', '2025-08-12 00:04:35'),
(3, 'af11fdbee39d06d3042f83ee344f2eb3', 'Mazorca Gratinada - $5 USD\nSpaghetti Alfredo - $15 USD\nFlan de Caramelo - $5 USD\nAgua sin Gas - $3 USD\n', '3234567890', 'Luis Calle', 'luis@gmail.com', 'Calle 23 #44-55 Apto 202', '573014115327', 28, 'Pendiente', '2025-08-12', '2025-08-13 01:00:10');

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
(1, 'Chat', 'chat', 'bi bi-chat-dots-fill', 'custom', 1, '2025-07-18', '2025-07-27 00:27:06'),
(2, 'Admins', 'admins', 'bi bi-person-fill-gear', 'modules', 2, '2025-07-18', '2025-07-18 22:34:25'),
(3, 'Archivos', 'archivos', 'bi bi-file-earmark-image', 'custom', 3, '2025-07-18', '2025-07-18 22:34:25'),
(9, 'API-WS', 'api-ws', 'bi bi-whatsapp', 'modules', 1000, '2025-07-25', '2025-07-25 21:31:12'),
(10, 'Mensajes', 'mensajes', 'bi bi-chat-square-text', 'modules', 1000, '2025-07-25', '2025-07-25 21:46:02'),
(11, 'Bots', 'bots', 'bi bi-three-dots-vertical', 'modules', 1000, '2025-07-25', '2025-07-25 22:36:31'),
(12, 'Contactos', 'contactos', 'bi bi-person-lines-fill', 'modules', 1000, '2025-07-26', '2025-07-26 22:04:28'),
(14, 'Categorías', 'categorias', 'bi bi-card-checklist', 'modules', 1000, '2025-08-05', '2025-08-05 19:06:11'),
(15, 'Productos', 'productos', 'fas fa-utensils', 'modules', 1000, '2025-08-05', '2025-08-05 19:14:14'),
(16, 'Órdenes', 'ordenes', 'bi bi-receipt', 'modules', 1000, '2025-08-11', '2025-08-11 22:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `title_product` text DEFAULT NULL,
  `id_category_product` int(11) DEFAULT 0,
  `price_product` double DEFAULT 0,
  `code_product` text DEFAULT NULL,
  `date_created_product` date DEFAULT NULL,
  `date_updated_product` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_product`, `title_product`, `id_category_product`, `price_product`, `code_product`, `date_created_product`, `date_updated_product`) VALUES
(1, 'Papas+R%C3%BAsticas', 1, 5, 'sku001', '2025-08-05', '2025-08-05 19:19:53'),
(2, 'Nachos+de+la+Casa', 1, 5, 'sku002', '2025-08-05', '2025-08-05 19:21:00'),
(3, 'Mazorca+Gratinada', 1, 5, 'sku003', '2025-08-05', '2025-08-05 19:21:58'),
(4, 'Lomo+a+la+Parilla', 2, 15, 'sku004', '2025-08-05', '2025-08-05 19:23:18'),
(5, 'Costillas+BBQ', 2, 15, 'sku005', '2025-08-05', '2025-08-05 19:24:11'),
(6, 'Spaghetti+Alfredo', 2, 15, 'sku006', '2025-08-05', '2025-08-05 19:24:53'),
(7, 'Lasagna', 2, 15, 'sku007', '2025-08-05', '2025-08-05 19:25:38'),
(8, 'Flan+de+Caramelo', 3, 5, 'sku008', '2025-08-05', '2025-08-05 19:27:01'),
(9, 'Tiramis%C3%BA', 3, 5, 'sku009', '2025-08-05', '2025-08-05 19:27:24'),
(10, 'Tres+Leches', 3, 5, 'sku0010', '2025-08-05', '2025-08-05 19:27:58'),
(11, 'Ensalada+de+Frutas', 3, 5, 'sku0011', '2025-08-05', '2025-08-05 19:28:40'),
(12, 'Agua+sin+Gas', 4, 3, 'sku0012', '2025-08-05', '2025-08-05 19:30:18'),
(13, 'Limonada', 4, 3, 'sku0013', '2025-08-05', '2025-08-05 19:30:30'),
(14, 'Coca+Cola', 4, 3, 'sku0014', '2025-08-05', '2025-08-05 19:30:56');

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
(1, '15556588621', '661536270384648', '1435203277506567', 'EAAKblDMrXZB8BPMZCrnpqHYu9O8qTpnrDXv6ZBL9mxdql4YaRp5ZCkuwXmmxPaabOvfOcCrVPNLtNMMe2ueJgabtGSmV0XcaOfHcrx6kBrsrmDRg9ZCBdiwWysF3BmbNIShMK8MLB8GGCsmylZCHz1uZCUuCp9FTbtTgiK4kS6uB3bJteuqStZB2Dd5cZBI0ul6u3dwZDZD', 1, 0, '2025-07-25', '2025-07-25 22:09:46');

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id_page`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`);

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
-- AUTO_INCREMENT for table `bots`
--
ALTER TABLE `bots`
  MODIFY `id_bot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `columns`
--
ALTER TABLE `columns`
  MODIFY `id_column` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id_folder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id_module` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id_page` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `whatsapps`
--
ALTER TABLE `whatsapps`
  MODIFY `id_whatsapp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
