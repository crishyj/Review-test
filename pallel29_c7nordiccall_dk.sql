-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Vært: localhost:3306
-- Genereringstid: 25. 11 2019 kl. 19:20:25
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
-- Database: `pallel29_c7nordiccall_dk`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `queue_calls`
--

CREATE TABLE `queue_calls` (
  `id` int(11) NOT NULL,
  `queue_name` varchar(100) DEFAULT NULL,
  `caller_id` varchar(100) DEFAULT NULL,
  `unique_id` varchar(100) DEFAULT NULL,
  `call_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(20) NOT NULL,
  `agent` varchar(200) NOT NULL DEFAULT '110',
  `queue_time` varchar(200) NOT NULL,
  `queue_name2` varchar(30) DEFAULT NULL,
  `SMS_Smileyrating` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `tagwall`
--

CREATE TABLE `tagwall` (
  `id` int(10) NOT NULL,
  `userRefID` int(10) NOT NULL COMMENT 'Secretary id',
  `companyFBRefID` int(10) NOT NULL COMMENT 'Franchiser',
  `text` text COLLATE latin1_danish_ci NOT NULL,
  `metaTimeCreated` datetime NOT NULL,
  `MetaDeleted` enum('yes','no') COLLATE latin1_danish_ci NOT NULL DEFAULT 'no',
  `MetaTimeDeleted` datetime NOT NULL,
  `confirmation_id` varchar(20) COLLATE latin1_danish_ci NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_danish_ci;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `queue_calls`
--
ALTER TABLE `queue_calls`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `tagwall`
--
ALTER TABLE `tagwall`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userRefID` (`userRefID`),
  ADD KEY `companyFBRefID` (`companyFBRefID`,`metaTimeCreated`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `queue_calls`
--
ALTER TABLE `queue_calls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5063;
--
-- Tilføj AUTO_INCREMENT i tabel `tagwall`
--
ALTER TABLE `tagwall`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153695;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
