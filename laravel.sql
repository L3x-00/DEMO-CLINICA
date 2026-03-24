-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2026 at 12:38 AM
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
-- Database: `laravel`
--
CREATE DATABASE IF NOT EXISTS `laravel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `laravel`;

-- --------------------------------------------------------

--
-- Table structure for table `atenciones`
--

CREATE TABLE `atenciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paciente_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `servicio` varchar(255) NOT NULL,
  `costo_servicio` decimal(8,2) NOT NULL,
  `descuento` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_pagado` decimal(8,2) NOT NULL,
  `estado` enum('En Espera','Atendido','Cancelado') NOT NULL DEFAULT 'En Espera',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `atenciones`
--

INSERT INTO `atenciones` (`id`, `paciente_id`, `doctor_id`, `servicio`, `costo_servicio`, `descuento`, `total_pagado`, `estado`, `created_at`, `updated_at`) VALUES
(1, 64, 14, 'Consulta Médica', 100.00, 0.00, 100.00, 'Atendido', '2026-03-20 21:03:15', '2026-03-20 21:03:20'),
(2, 64, 14, 'Consulta Médica', 100.00, 0.00, 100.00, 'Atendido', '2026-03-20 22:04:55', '2026-03-20 22:31:55'),
(3, 62, 14, 'Consulta Médica', 100.00, 0.00, 100.00, 'Atendido', '2026-03-20 22:05:13', '2026-03-20 22:31:58'),
(4, 62, 14, 'Consulta Médica', 100.00, 0.00, 100.00, 'Atendido', '2026-03-20 22:05:14', '2026-03-20 22:32:04'),
(5, 65, 14, 'Consulta Médica', 100.00, 0.00, 100.00, 'Atendido', '2026-03-20 22:05:47', '2026-03-20 22:32:01');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `citas`
--

CREATE TABLE `citas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paciente_id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` enum('Pendiente','Concluido','No presentado','Reprogramado') NOT NULL DEFAULT 'Pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `citas`
--

INSERT INTO `citas` (`id`, `paciente_id`, `fecha`, `hora`, `motivo`, `observaciones`, `estado`, `created_at`, `updated_at`) VALUES
(17, 47, '2026-03-27', '15:28:00', 'k', NULL, 'Concluido', '2026-02-27 17:26:09', '2026-02-27 17:31:15'),
(18, 48, '2026-12-25', '08:30:00', 'viene a cambiar su cerebro', NULL, 'Concluido', '2026-02-27 20:07:16', '2026-03-01 05:26:53'),
(19, 50, '2026-03-27', '20:07:00', 'vendra para poner yeso', NULL, 'Concluido', '2026-02-27 23:05:18', '2026-03-01 05:26:46'),
(20, 55, '2026-03-02', '11:30:00', 'yesar pies', NULL, 'Pendiente', '2026-03-01 05:24:29', '2026-03-01 05:24:29'),
(21, 50, '2026-03-01', '01:26:00', 'asd', NULL, 'Concluido', '2026-03-01 05:24:47', '2026-03-01 05:26:35'),
(22, 57, '2026-03-04', '02:59:00', 'asd', NULL, 'Concluido', '2026-03-03 06:58:09', '2026-03-03 06:58:39'),
(23, 50, '2026-03-03', '07:02:00', 'asd', NULL, 'Concluido', '2026-03-03 06:58:25', '2026-03-03 06:58:36'),
(24, 48, '2026-03-03', '21:58:00', 's', NULL, 'Concluido', '2026-03-03 06:59:01', '2026-03-03 06:59:10'),
(25, 47, '2026-03-07', '10:00:00', 'tiene fractura en el pir', NULL, 'Pendiente', '2026-03-06 16:27:34', '2026-03-06 16:27:34'),
(26, 57, '2026-03-06', '05:00:00', 'asdasd', NULL, 'Pendiente', '2026-03-06 16:27:53', '2026-03-06 16:27:53'),
(27, 47, '2026-03-06', '10:55:00', 'asd', NULL, 'Pendiente', '2026-03-06 19:25:15', '2026-03-06 19:25:15'),
(28, 61, '2026-03-14', '10:00:00', 'tiene dolor en la parte del Dorso Lumbar, dificultando su caminar', '\n-- Motivo Reprogramación: se le ah indicado descansar minimo 5 horas', 'Reprogramado', '2026-03-13 20:03:38', '2026-03-13 20:04:24'),
(29, 47, '2026-03-28', '06:09:00', 'asd', NULL, 'Pendiente', '2026-03-20 21:09:36', '2026-03-20 21:09:36'),
(30, 50, '2026-03-21', '04:10:00', 'pie roto', NULL, 'Pendiente', '2026-03-20 21:10:18', '2026-03-20 21:10:18'),
(31, 47, '2026-03-20', '20:44:00', 'dsf', NULL, 'Pendiente', '2026-03-20 21:44:05', '2026-03-20 21:44:05'),
(32, 61, '2026-03-20', '19:06:00', 'dfg', NULL, 'Pendiente', '2026-03-20 22:04:12', '2026-03-20 22:04:12'),
(34, 52, '2026-03-20', '17:35:00', 'asdasd', NULL, 'Pendiente', '2026-03-20 22:14:48', '2026-03-20 22:14:48'),
(35, 48, '2026-03-20', '17:11:00', 'sadasdasd', NULL, 'Pendiente', '2026-03-20 22:21:38', '2026-03-20 22:21:38'),
(36, 52, '2026-03-20', '17:11:00', 'esta es una prueba de validacion', NULL, 'Pendiente', '2026-03-20 22:22:05', '2026-03-20 22:22:05'),
(37, 62, '2026-03-20', '14:23:00', 'asdasdasd', NULL, 'Pendiente', '2026-03-20 22:23:12', '2026-03-20 22:23:12');

-- --------------------------------------------------------

--
-- Table structure for table `consultas`
--

CREATE TABLE `consultas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paciente_id` bigint(20) UNSIGNED NOT NULL,
  `numero_consulta` int(11) NOT NULL,
  `fecha_registro` date NOT NULL,
  `hora_registro` time NOT NULL,
  `edad_momento` varchar(255) NOT NULL,
  `motivo_consulta` text DEFAULT NULL,
  `tiempo_enfermedad` varchar(255) DEFAULT NULL,
  `apetito` varchar(255) DEFAULT NULL,
  `sed` varchar(255) DEFAULT NULL,
  `sueno` varchar(255) DEFAULT NULL,
  `estado_animo` varchar(255) DEFAULT NULL,
  `orina` varchar(255) DEFAULT NULL,
  `deposiciones` varchar(255) DEFAULT NULL,
  `examen_fisico` text DEFAULT NULL,
  `temperatura` varchar(255) DEFAULT NULL,
  `presion_arterial` varchar(255) DEFAULT NULL,
  `frecuencia_respiratoria` varchar(255) DEFAULT NULL,
  `frecuencia_cardiaca` varchar(255) DEFAULT NULL,
  `peso` varchar(255) DEFAULT NULL,
  `talla` varchar(255) DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `examenes_auxiliares` text DEFAULT NULL,
  `referencia_lugar_motivo` varchar(255) DEFAULT NULL,
  `proxima_cita` date DEFAULT NULL,
  `atendido_por` varchar(255) NOT NULL,
  `doctor_apellidos` varchar(255) NOT NULL,
  `doctor_nombres` varchar(255) NOT NULL,
  `observacion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_21_001759_create_pacientes_table', 1),
(5, '2026_02_23_000228_add_fields_to_pacientes_table', 1),
(6, '2026_02_23_002126_change_dni_size_in_pacientes_table', 1),
(7, '2026_02_23_004817_create_citas_table', 1),
(8, '2026_02_23_023944_actualizar_enum_estado_en_citas', 2),
(9, '2026_02_24_235229_add_extra_fields_to_pacientes_table', 3),
(10, '2026_02_25_000952_add_evidencia_to_pacientes_table', 4),
(11, '2026_02_26_232253_remove_fields_from_pacientes_table', 5),
(12, '2026_02_26_234326_create_reporte_medicos_table', 6),
(13, '2026_03_02_204604_add_role_to_users_table', 7),
(14, '2026_03_06_003401_create_servicios_realizados_table', 8),
(15, '2026_03_16_210947_create_consultas_table', 9),
(16, '2026_03_17_012036_create_atencions_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `pacientes`
--

CREATE TABLE `pacientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `evidencia` varchar(255) DEFAULT NULL,
  `dni` varchar(20) NOT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo_documento` varchar(255) NOT NULL DEFAULT 'DNI',
  `fecha_nacimiento` date DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `nacionalidad` varchar(255) DEFAULT NULL,
  `sexo` enum('Masculino','Femenino') NOT NULL,
  `alergias` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `apellido`, `evidencia`, `dni`, `telefono`, `created_at`, `updated_at`, `tipo_documento`, `fecha_nacimiento`, `edad`, `nacionalidad`, `sexo`, `alergias`) VALUES
(47, 'alex', 'huanaco quispe', 'evidencias/Z91W4Oq1oNVTLB1PpArn86HXPEsQGYMfanb4MGXV.png', '74385642', NULL, '2026-02-27 17:22:48', '2026-02-27 17:22:48', 'DNI', '2004-07-14', 21, 'Peruana', 'Masculino', 'desgaste osoep, dolores musculares'),
(48, 'alexander', 'huanaco quispe', NULL, '73573674', '930759515', '2026-02-27 20:06:15', '2026-02-27 20:06:15', 'DNI', '2004-07-24', 21, 'chileno', 'Masculino', 'dolor articular'),
(49, 'Gardenia Fidela', 'Ruiz Mullo', 'evidencias/ioN6L8IFkXOML0vFt6zFy9QAbvTPudQgdsH3quJO.jpg', '70123046', '957653251', '2026-02-27 21:50:41', '2026-02-27 21:50:41', 'DNI', '1965-02-05', 61, 'Peruana', 'Femenino', 'tiene dolores fuertes en los huesos de la pierna izquierda'),
(50, 'alex', 'huan', 'evidencias/naGg4gGEA2deEomwn5eYF3zRDjOreBfQc6to7Em8.jpg', '123456789', NULL, '2026-02-27 23:04:29', '2026-02-27 23:04:29', 'DNI', '2000-05-14', 25, 'Peruana', 'Masculino', 'dolores de hueso de la pierna'),
(51, 'Juan Mateo', 'Robles Alafaro', 'evidencias/skGjR6mfSYBW3nqiJM0dmnPgXI6ZOS35q6ugclAc.jpg', '43902312', '930 759 515', '2026-03-01 04:25:19', '2026-03-01 04:25:19', 'DNI', '2003-09-12', 22, 'Peruana', 'Masculino', 'Tiene dolores fuertes en la parte de la pierna y la rodilla, problemas para caminar'),
(52, 'Mario Demon', 'Montes Rodriguez', 'evidencias/OPMwUPgLGhaUiCHSk7LH2hJPXPtjBIA5fSfTqtAM.jpg', '34120932', '903493131', '2026-03-01 04:37:28', '2026-03-01 05:10:41', 'DNI', '1990-09-28', 35, 'Peruana', 'Masculino', 'dolor de hueso'),
(55, 'Ronal', 'Martinez Villar', 'evidencias/9lpCMbRnJyvGWZ0PLwqVDioHIExfsa6h9ZLBXoR5.jpg', '90231209', '930874123', '2026-03-01 05:23:25', '2026-03-01 05:23:25', 'DNI', '2000-03-12', 25, 'Peruana', 'Femenino', 'dolo de huesos'),
(56, 'Maria Elle', 'Martina Orellano', 'evidencias/vyse7UHE5ytcFN0nSV8QqWKyMxPHGaW7oS1jSu2l.png', '89983218', '930829321', '2026-03-01 06:00:09', '2026-03-01 06:00:09', 'DNI', '2000-09-12', 25, 'Peruana', 'Femenino', 'cancer'),
(57, 'ales', 'hua', 'evidencias/cKm8buAnK0nR6eaue0f4rIrWKCNVXRbBTTde3GgS.jpg', '12332123', '920292129', '2026-03-03 06:57:36', '2026-03-03 06:57:36', 'DNI', '2000-12-12', 25, 'Peruana', 'Masculino', 'pie roto'),
(58, 'juan', 'ali barzola', NULL, '12365478', '987654123', '2026-03-06 19:31:02', '2026-03-06 19:31:02', 'DNI', '1958-12-25', 67, 'Peruana', 'Masculino', 'pie roto'),
(59, 'a', 'a', NULL, '23323232', '123232321', '2026-03-11 05:21:22', '2026-03-11 05:21:22', 'DNI', '2000-12-12', NULL, 'as', 'Masculino', 'asd'),
(60, 'alex', 'huanaco quispe', NULL, '34987623', '123123123', '2026-03-11 05:38:01', '2026-03-11 05:38:01', 'DNI', '2000-02-10', 26, 'Peruana', 'Masculino', '123123'),
(61, 'eluis saens', 'eulis', 'evidencias/63EG300TdnaojcUWoUbtcHgbM4BEO07SJC7GjESv.png', '8912892319', '966852299', '2026-03-13 20:01:49', '2026-03-13 20:01:49', 'CUI', '2000-09-14', 25, 'Peruana', 'Masculino', 'Rayos X Dorso Lumbar'),
(62, 'ALEX', 'QUISPE', NULL, '10205540', '123456798', '2026-03-13 20:10:58', '2026-03-13 20:10:58', 'DNI', '2004-07-14', 21, 'Peruana', 'Masculino', 'DOLOR LUMBAR'),
(63, 'alexla', 'aleslda', NULL, '12345678', '930579515', '2026-03-20 20:47:12', '2026-03-20 20:47:12', 'DNI', '2000-12-25', 25, 'Peruana', 'Masculino', 'sad'),
(64, 'w', 'w', NULL, '21321321321', '5', '2026-03-20 20:47:47', '2026-03-20 20:47:47', 'CUI', '2000-12-15', 25, '2', 'Masculino', 'qwe'),
(65, 'eqweq', 'qwe', NULL, 'qweqwewq', '2', '2026-03-20 20:51:22', '2026-03-20 20:51:22', 'CUI', '2000-02-05', 26, '2', 'Masculino', '2'),
(66, 'a', 'a', NULL, '123123123', '64', '2026-03-20 21:06:28', '2026-03-20 21:06:28', 'DNI', '2000-10-20', 25, 'Peruana', 'Masculino', 'sad'),
(67, 'ABEL', 'PILAR', NULL, '45678978', '123456789', '2026-03-20 22:47:20', '2026-03-20 22:47:20', 'DNI', '2000-02-02', 26, 'Peruana', 'Masculino', 'asd'),
(68, 'q', 'q', NULL, '33322244', '654987987', '2026-03-20 23:23:57', '2026-03-20 23:23:57', 'DNI', '2000-12-15', 25, 'Peruana', 'Masculino', 'asdsa');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reportes_medicos`
--

CREATE TABLE `reportes_medicos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paciente_id` bigint(20) UNSIGNED NOT NULL,
  `examen_fisico_preferencial` text DEFAULT NULL,
  `examen_auxiliar` text DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `cie_10` varchar(255) DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `evolucion` text DEFAULT NULL,
  `recomendaciones` text DEFAULT NULL,
  `fecha` date NOT NULL,
  `doctor` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reportes_medicos`
--

INSERT INTO `reportes_medicos` (`id`, `paciente_id`, `examen_fisico_preferencial`, `examen_auxiliar`, `diagnostico`, `cie_10`, `tratamiento`, `evolucion`, `recomendaciones`, `fecha`, `doctor`, `created_at`, `updated_at`) VALUES
(6, 47, NULL, NULL, 'b', NULL, NULL, NULL, NULL, '2026-02-27', 'Fidel Ramirez Torres', '2026-02-27 17:23:27', '2026-02-27 17:23:27'),
(7, 48, 'tiene dolor', 'se ve un hueso roto', 'huesos rotos', NULL, 'pastillas', 'necesita un cerebro nuevo', 'necesita un cambio de cerebro', '2026-02-27', 'Melchor Poma Diana Sofia', '2026-02-27 20:09:50', '2026-02-27 20:09:50'),
(8, 49, 'se hizo el examen de las partes blandas, pero no se ah encontrado algun sintoma relacionado a los problemas presentados.', 'Laboratorio de rayos X, en la parte lumbar de la espalda, sin embargo no se ha mostrado alguna anomalía.', 'Cancer a los Huesos', 'M45.22', 'Tomar leche 1 litro cada 3 dias y comer comitas altas en fibras y vitaminas, asi mismo tomar vitamimas y suplementos ricos en calcio.', 'se ah estado analizando el estado de progreso del paciente pero no se ah demostrado avance.', 'llevas a cabo tratamientos que requieran alguna avance significativo.', '2026-02-27', 'jjjjjiuug', '2026-02-27 21:58:43', '2026-02-27 21:58:43'),
(9, 51, NULL, 'Rayos X', 'cancer a los huesos', '21', NULL, NULL, NULL, '2026-02-28', 'ALEX', '2026-03-01 04:26:58', '2026-03-01 04:26:58'),
(10, 55, NULL, NULL, 'asd', NULL, 'asd', NULL, NULL, '2026-03-03', 'Fidel Ramirez Torres', '2026-03-03 06:56:37', '2026-03-03 06:56:37'),
(11, 57, NULL, NULL, 'sad', NULL, 'asd', NULL, NULL, '2026-03-03', 'Fidel Ramirez Torres', '2026-03-03 06:57:51', '2026-03-03 06:57:51'),
(12, 66, 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', '2026-03-20', 'ALEX', '2026-03-20 21:06:49', '2026-03-20 21:06:49');

-- --------------------------------------------------------

--
-- Table structure for table `servicios_realizados`
--

CREATE TABLE `servicios_realizados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paciente_id` bigint(20) UNSIGNED NOT NULL,
  `servicio` varchar(255) NOT NULL,
  `observacion` text DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL,
  `comision` decimal(10,2) NOT NULL DEFAULT 0.00,
  `jaladora` varchar(255) DEFAULT NULL,
  `asistente_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `servicios_realizados`
--

INSERT INTO `servicios_realizados` (`id`, `paciente_id`, `servicio`, `observacion`, `costo`, `comision`, `jaladora`, `asistente_id`, `created_at`, `updated_at`) VALUES
(1, 47, 'Rayos X', NULL, 100.00, 15.00, 'maria', 13, '2026-03-06 05:59:58', '2026-03-06 05:59:58'),
(2, 47, 'Rayos X', 'dolor del pie', 0.00, 0.00, 'Ninguna', 13, '2026-03-06 06:21:23', '2026-03-06 06:21:23'),
(3, 48, 'Rayos X', 'dolor de cabeza', 100.00, 19.00, 'alex', 13, '2026-03-06 06:24:29', '2026-03-06 06:24:29'),
(4, 55, 'Traumatología', 'tiene problemas con la respiracion, bronco y derrame cerebral', 100.00, 15.00, 'alexisis', 14, '2026-03-06 18:06:05', '2026-03-06 18:06:05'),
(5, 47, 'Rayos X', 'jj', 50.00, 15.00, 'maria', 14, '2026-03-06 18:21:10', '2026-03-06 18:21:10'),
(6, 47, 'Rayos X', 'pie roto', 100.00, 15.00, 'diana', 16, '2026-03-06 20:11:48', '2026-03-06 20:11:48'),
(7, 59, 'Rayos X', 'pie roto', 100.00, 10.00, 'diana', 14, '2026-03-11 05:29:49', '2026-03-11 05:29:49'),
(8, 60, 'Rayos X', 'pier deslocado', 1000.00, 230.00, 'alex', 14, '2026-03-11 05:38:22', '2026-03-11 05:38:22'),
(9, 61, 'Rayos X', 'tiene problemas el caminar, dolor en toda la cintura', 100.00, 10.00, 'javier', 14, '2026-03-13 20:02:34', '2026-03-13 20:02:34'),
(10, 62, 'Rayos X', 'DOLOR LUMBAR DESCARTE DE PINZAMIENTO', 80.00, 20.00, 'ZARA', 14, '2026-03-13 20:11:58', '2026-03-13 20:11:58');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8WrsByqc4ZKDDK3RrwFkYj2nW02f3Og4yf5yPULU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUHpMaWQxWWd0SllMbHJNRUhoZVdHd1RrcDZ0Y2VBc0g0Mks3c1IwayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774039495),
('xMrOWvX7wzjDmq0pWCDyLjirZ0bRw7DpAiCsX5pO', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSU9zY1BXS3h0MmlvdGpuTGZ4MndvQ2dVaVZiQkVTWGVLMW45Y3ExUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYWphIjtzOjU6InJvdXRlIjtzOjEwOiJjYWphLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTQ7fQ==', 1774049524);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'asistente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(9, 'Fidel Ramirez Torres', 'Ramirez2026@gmail.com', NULL, '$2y$12$OGHIgM739Hc9tkZ/Uw2j9uRDZaie25qaOSTV9azrEdsJ8zqFD6jSm', NULL, '2026-02-27 17:06:01', '2026-03-03 05:56:51', 'doctor'),
(10, 'Melchor Poma Diana Sofia', 'melchorpomad@gmail.com', NULL, '$2y$12$wdbP3/0Fbm2EB7SOY5Jx7uAw12G/ZQzdvu7FH6/9EbCUXAlBiZ86W', NULL, '2026-02-27 20:00:32', '2026-02-27 20:00:32', 'asistente'),
(11, 'jjjjjiuug', 'j@h.cim', NULL, '$2y$12$pBt52Riv8Qhi0dnxiMKUCOJLLt8xtgWiMnpudw.sTUbSW0DKCJSo2', NULL, '2026-02-27 20:44:46', '2026-02-27 20:44:46', 'asistente'),
(12, 'Yuri Meza Orellana', 'yuri@gmail.com', NULL, '$2y$12$OZha4/20IeXS6AKp0eXTTulUe3ql/kZZIu3.5AUqF1SkBgirWJoh.', NULL, '2026-02-27 23:00:02', '2026-02-27 23:00:02', 'asistente'),
(13, 'ALEX', 'ales2022@hotmail.com', NULL, '$2y$12$Kaw1R1xHZi.O9w2mD.aTeehFgxMqOETNUgqO9P6COvO5PVteLXVOa', NULL, '2026-03-01 03:47:43', '2026-03-01 03:47:43', 'asistente'),
(14, 'ALEX', 'ales_2_@hotmail.com', NULL, '$2y$12$KZrzWEzQXgDjRQhZT5g83.WuX5tFmP12TlUjmb/dybrYX39knjd0y', NULL, '2026-03-03 05:58:27', '2026-03-03 05:58:27', 'asistente'),
(15, 'leo pio', 'leo@gmail.com', NULL, '$2y$12$pXjbuhYoR4rGMzMmE4fljeUv.HLPgCwdPHgLXSa2NOrN9NZxfx4jC', NULL, '2026-03-06 20:08:06', '2026-03-06 20:08:06', 'asistente'),
(16, 'diana melchor', 'diana@gmail.com', NULL, '$2y$12$.gcZ09aQAwWBo6vuo5OsauUnsvQimDYQ/ovYT9cMxo/Pn/Z4t7l7q', NULL, '2026-03-06 20:10:10', '2026-03-06 20:10:10', 'asistente');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atenciones`
--
ALTER TABLE `atenciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `atenciones_paciente_id_foreign` (`paciente_id`),
  ADD KEY `atenciones_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citas_paciente_id_foreign` (`paciente_id`);

--
-- Indexes for table `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultas_paciente_id_foreign` (`paciente_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pacientes_dni_unique` (`dni`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `reportes_medicos`
--
ALTER TABLE `reportes_medicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reportes_medicos_paciente_id_foreign` (`paciente_id`);

--
-- Indexes for table `servicios_realizados`
--
ALTER TABLE `servicios_realizados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servicios_realizados_paciente_id_foreign` (`paciente_id`),
  ADD KEY `servicios_realizados_asistente_id_foreign` (`asistente_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atenciones`
--
ALTER TABLE `atenciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `citas`
--
ALTER TABLE `citas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `reportes_medicos`
--
ALTER TABLE `reportes_medicos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `servicios_realizados`
--
ALTER TABLE `servicios_realizados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `atenciones`
--
ALTER TABLE `atenciones`
  ADD CONSTRAINT `atenciones_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `atenciones_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reportes_medicos`
--
ALTER TABLE `reportes_medicos`
  ADD CONSTRAINT `reportes_medicos_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `servicios_realizados`
--
ALTER TABLE `servicios_realizados`
  ADD CONSTRAINT `servicios_realizados_asistente_id_foreign` FOREIGN KEY (`asistente_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `servicios_realizados_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
