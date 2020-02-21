-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 14 Sty 2020, 22:42
-- Wersja serwera: 10.1.37-MariaDB
-- Wersja PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `blog`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `uzytkownik` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rola` enum('Author','Admin') DEFAULT NULL,
  `pass` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `uzytkownik`, `email`, `rola`, `pass`, `created_at`, `updated_at`) VALUES
(1, 'Awa', 'info@codewithawa.com', 'Admin', 'mypassword', '2018-01-08 11:52:58', '2018-01-08 11:52:58'),
(2, 'Francuz', 'zaba@gmail.com', 'Admin', '$2y$10$O9kU4qY4UOQ.Z1f51tqwROrBBpIGM60sOrV67Gez0M44g3zbX2kwe', '2018-01-08 11:52:58', '2018-01-08 11:52:58'),
(3, 'Beczka', 'beczka@gmail.com', NULL, '$2y$10$YS97NziBDLWm7vXJae4oOeYACVjyv6XR5n0ZWWBQDf9DdwxhpKVmS', '2018-01-08 11:52:58', '2018-01-08 11:52:58'),
(4, 'Kamil', 'kamil@o2.com', NULL, '$2y$10$RgJg1Nu6Xw4B4ljhsFtSMemBfIYxY0qw.9DUeIDXtp2vlSaBGjvpy', '2018-01-08 11:52:58', '2018-01-08 11:52:58'),
(5, 'gosc', 'gosc@gmail.com', NULL, '$2y$10$9XM9kjOJoMCrggNDEisCBOFcw2E/sW9AlPvXsgFowO5.YaMAaMMTu', '2018-01-08 11:52:58', '2018-01-08 11:52:58'),
(6, 'bobo', 'bobo@gmail.com', NULL, '$2y$10$aCjbDxcwJu3UryD.pK9IIukiOySa6s7rQj3Yq23r2IJ931ijBjOk.', '2018-01-08 11:52:58', '2018-01-08 11:52:58'),
(7, 'zenek', 'zenek@wp.pl', NULL, '$2y$10$r3uxB5SEaazKQBKyQI7VpeWqBuIvVtm9s9R6OyS9FVrn5GN8pbn1i', '2018-01-08 11:52:58', '2018-01-08 11:52:58'),
(8, 'Aladin', 'alladyn@wp.pl', NULL, '$2y$10$4DunDpnqxiL1iRydDZYXyO1hmchXNG.8.Bihv3047J5TOTRutyolK', '2018-01-08 11:52:58', '2018-01-08 11:52:58'),
(9, 'adi', 'adi@gmail.com', NULL, '$2y$10$SqWwzspbloQFjlJVjdndkO2oGVsnsS2Dqe1IVjSBFxeF4vbLPAvwW', '2018-01-08 11:52:58', '2018-01-08 11:52:58'),
(10, 'czaja', 'czaja123@o2.pl', NULL, '$2y$10$/LC0M0f2PtBxBlRpODlY1eDcy/VPpiAQ8OiTbSKXyYEVwBCYpEyt6', '2018-01-08 11:52:58', '2018-01-08 11:52:58'),
(11, 'bobo1', 'bono2@o2.com', NULL, '$2y$10$C1Y/.uIOU48FTFymPjMm7uj0.UQV6I8L5jCK7vXp5IGFqVSH1yLP6', '2018-01-08 11:52:58', '2018-01-08 11:52:58');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
