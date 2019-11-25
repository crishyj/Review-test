-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Vært: localhost:3306
-- Genereringstid: 25. 11 2019 kl. 04:31:55
-- Serverversion: 5.6.36-82.1-log
-- PHP-version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pallel29_smileyrating`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_title` varchar(200) NOT NULL,
  `must_send_customer` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `must_send_reminder_1` enum('Yes','No') NOT NULL DEFAULT 'No',
  `reminder_phone_1` varchar(20) NOT NULL,
  `must_send_reminder_2` enum('Yes','No') NOT NULL DEFAULT 'No',
  `reminder_phone_2` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `email_frequency` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `brands`
--

INSERT INTO `brands` (`id`, `brand_title`, `must_send_customer`, `must_send_reminder_1`, `reminder_phone_1`, `must_send_reminder_2`, `reminder_phone_2`, `email`, `email_frequency`) VALUES
(1, 'Brand 1', 'Yes', 'No', '', 'No', '', '', ''),
(2, 'Brand 2', 'Yes', 'Yes', '', 'No', '', '', ''),
(3, 'NordicCall', 'Yes', 'No', '', 'No', '', 'palle@klinikker.dk', 'New Review');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` int(11) NOT NULL,
  `time_register` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `brand_title` varchar(200) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_country` enum('Denmark','Sweden','Norway') NOT NULL DEFAULT 'Denmark',
  `must_send_customer` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `is_sent_customer` enum('Yes','No') NOT NULL DEFAULT 'No',
  `time_sent_customer` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reminder_phone_1` varchar(20) NOT NULL,
  `must_send_reminder_1` enum('Yes','No') NOT NULL DEFAULT 'No',
  `is_sent_reminder_1` enum('Yes','No') NOT NULL DEFAULT 'No',
  `time_sent_reminder_1` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reminder_phone_2` varchar(20) NOT NULL,
  `must_send_reminder_2` enum('Yes','No') NOT NULL DEFAULT 'No',
  `is_sent_reminder_2` enum('Yes','No') NOT NULL DEFAULT 'No',
  `time_sent_reminder_2` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_receive_feedback` enum('Yes','No') NOT NULL DEFAULT 'No',
  `feedback_score` enum('Smile','Sad') NOT NULL,
  `feedback_text` varchar(500) NOT NULL,
  `time_receive_feedback` datetime NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_frequency` enum('New Review','Daily','Weekly') NOT NULL DEFAULT 'New Review',
  `is_sent_email` enum('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `sms_logs`
--

INSERT INTO `sms_logs` (`id`, `time_register`, `brand_title`, `customer_phone`, `customer_country`, `must_send_customer`, `is_sent_customer`, `time_sent_customer`, `reminder_phone_1`, `must_send_reminder_1`, `is_sent_reminder_1`, `time_sent_reminder_1`, `reminder_phone_2`, `must_send_reminder_2`, `is_sent_reminder_2`, `time_sent_reminder_2`, `is_receive_feedback`, `feedback_score`, `feedback_text`, `time_receive_feedback`, `email`, `email_frequency`, `is_sent_email`) VALUES
(4, '2019-11-20 18:39:40', 'Brand 2', '+4528282835', 'Denmark', 'Yes', 'Yes', '2019-11-20 19:03:46', '+4528282835', 'Yes', 'Yes', '2019-11-20 21:26:53', '+4528282835', 'Yes', 'Yes', '2019-11-20 21:29:54', 'Yes', 'Smile', 'Good feedback', '2019-11-15 05:23:17', 'palle@klinikker.dk', 'New Review', 'Yes'),
(5, '2019-11-20 22:34:15', 'Brand 1', '4528282835', 'Denmark', 'Yes', 'Yes', '2019-11-20 22:34:15', '', 'No', 'No', '0000-00-00 00:00:00', '', 'No', 'No', '0000-00-00 00:00:00', 'No', 'Smile', '', '0000-00-00 00:00:00', '', '', 'No'),
(6, '2019-11-20 22:56:05', 'Brand 2', '4528282835', 'Denmark', 'Yes', 'Yes', '2019-11-20 22:56:05', '', 'Yes', 'No', '0000-00-00 00:00:00', '', 'No', 'No', '0000-00-00 00:00:00', 'No', 'Smile', '', '0000-00-00 00:00:00', '', '', 'No'),
(7, '2019-11-20 22:59:51', 'Brand 1', '4528282835', 'Denmark', 'Yes', 'Yes', '2019-11-20 22:59:51', '', 'No', 'No', '0000-00-00 00:00:00', '', 'No', 'No', '0000-00-00 00:00:00', 'Yes', 'Smile', 'asdfasdf', '0000-00-00 00:00:00', 'palle@klinikker.dk', 'New Review', 'Yes'),
(8, '2019-11-20 23:03:36', 'Brand 1', '4528282835', 'Denmark', 'Yes', 'Yes', '2019-11-20 23:05:02', '', 'No', 'No', '0000-00-00 00:00:00', '', 'No', 'No', '0000-00-00 00:00:00', 'Yes', 'Smile', 'test', '0000-00-00 00:00:00', '', '', 'No'),
(9, '2019-11-20 23:04:09', 'Brand 1', '4528282835', 'Denmark', 'Yes', 'Yes', '2019-11-20 23:05:02', '', 'No', 'No', '0000-00-00 00:00:00', '', 'No', 'No', '0000-00-00 00:00:00', 'No', 'Smile', '', '0000-00-00 00:00:00', '', '', 'No'),
(10, '2019-11-20 23:04:38', 'Brand 1', '4528282835', 'Denmark', 'Yes', 'Yes', '2019-11-20 23:05:02', '', 'No', 'No', '0000-00-00 00:00:00', '', 'No', 'No', '0000-00-00 00:00:00', 'No', 'Smile', '', '0000-00-00 00:00:00', '', '', 'No'),
(11, '2019-11-20 23:05:02', 'Brand 1', '4528282835', 'Denmark', 'Yes', 'Yes', '2019-11-20 23:05:02', '', 'No', 'No', '0000-00-00 00:00:00', '', 'No', 'No', '0000-00-00 00:00:00', 'No', 'Smile', '', '0000-00-00 00:00:00', '', '', 'No'),
(12, '2019-11-20 23:05:36', 'Brand 1', '4528282835', 'Denmark', 'Yes', 'Yes', '2019-11-20 23:06:02', '', 'No', 'No', '0000-00-00 00:00:00', '', 'No', 'No', '0000-00-00 00:00:00', 'No', 'Smile', '', '0000-00-00 00:00:00', '', '', 'No'),
(14, '2019-11-21 20:05:19', 'Brand 1', '4528282835', 'Denmark', 'Yes', 'Yes', '2019-11-21 20:05:20', '', 'No', 'No', '0000-00-00 00:00:00', '', 'No', 'No', '0000-00-00 00:00:00', 'No', 'Smile', '', '0000-00-00 00:00:00', '', '', 'No'),
(20, '2019-11-22 18:38:44', 'Brand 2', '4528282836', 'Denmark', 'Yes', 'Yes', '2019-11-22 18:49:52', '', 'No', 'No', '0000-00-00 00:00:00', '', 'No', 'No', '0000-00-00 00:00:00', 'Yes', 'Smile', 'Palle er super sej', '0000-00-00 00:00:00', '', '', 'No'),
(21, '2019-11-22 19:17:09', 'Brand 1', '4528282836', 'Denmark', 'Yes', 'Yes', '2019-11-22 19:18:01', '', 'No', 'No', '0000-00-00 00:00:00', '', 'No', 'No', '0000-00-00 00:00:00', 'Yes', 'Sad', 'Palle sov', '0000-00-00 00:00:00', '', '', 'No'),
(22, '2019-11-22 19:51:31', 'Brand 1', '4528282836', 'Denmark', 'Yes', 'Yes', '2019-11-22 19:52:03', '4528282836', 'No', 'No', '0000-00-00 00:00:00', '4528282836', 'No', 'No', '0000-00-00 00:00:00', 'Yes', 'Sad', 'asd', '0000-00-00 00:00:00', '', '', 'No'),
(23, '2019-11-23 11:16:06', 'NordicCall', '4520995357', 'Denmark', 'Yes', 'Yes', '2019-11-23 11:17:02', '4520995357', 'No', 'No', '0000-00-00 00:00:00', '4520995357', 'No', 'No', '0000-00-00 00:00:00', 'Yes', 'Smile', 'Det fungerer godt :)', '0000-00-00 00:00:00', '', 'New Review', 'No'),
(24, '2019-11-24 18:31:09', 'NordicCall', '4528282836', 'Denmark', 'Yes', 'Yes', '2019-11-24 18:32:01', '', 'No', 'No', '0000-00-00 00:00:00', '', 'No', 'No', '0000-00-00 00:00:00', 'No', '', '', '0000-00-00 00:00:00', '', 'New Review', 'No');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `sms_templates`
--

CREATE TABLE `sms_templates` (
  `id` int(11) NOT NULL,
  `country` enum('Denmark','Sweden','Norway') NOT NULL,
  `brand_title` varchar(200) NOT NULL,
  `template` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `sms_templates`
--

INSERT INTO `sms_templates` (`id`, `country`, `brand_title`, `template`) VALUES
(1, 'Denmark', '_Global', 'The global sms template for Denmark'),
(2, 'Sweden', '_Global', 'The global sms template for Sweden'),
(3, 'Norway', '_Global', 'The global sms template for Norway'),
(5, 'Sweden', 'Brand 1', 'SMS template for Brand 1 at Sweden'),
(6, 'Norway', 'Brand 1', 'SMS template for Brand 1 at Norway'),
(7, 'Denmark', 'Brand 2', 'SMS template for Brand 2 at Denmark'),
(8, 'Sweden', 'Brand 2', 'SMS template for Brand 2 at Sweden'),
(9, 'Norway', 'Brand 2', 'SMS template for Brand 2 at Norway'),
(10, 'Denmark', 'Brand 1', 'Tak for dit opkald til Brand 1.\r\nDu kan hjælpe os med at blive bedre ved at bruge ca 10 sek. \r\nTryk her:\r\n');

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brand_title` (`brand_title`);

--
-- Indeks for tabel `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `sms_templates`
--
ALTER TABLE `sms_templates`
  ADD PRIMARY KEY (`id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Tilføj AUTO_INCREMENT i tabel `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Tilføj AUTO_INCREMENT i tabel `sms_templates`
--
ALTER TABLE `sms_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
