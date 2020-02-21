-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 14 Sty 2020, 22:41
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
-- Struktura tabeli dla tabeli `artykuly_tytuly`
--

CREATE TABLE `artykuly_tytuly` (
  `id` int(11) NOT NULL,
  `artykul_id` int(11) NOT NULL,
  `tytul_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `artykuly_tytuly`
--

INSERT INTO `artykuly_tytuly` (`id`, `artykul_id`, `tytul_id`) VALUES
(1, 1, 1),
(2, 2, 2);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `artykuly_tytuly`
--
ALTER TABLE `artykuly_tytuly`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `artykul_id` (`artykul_id`),
  ADD KEY `tytul_id` (`tytul_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `artykuly_tytuly`
--
ALTER TABLE `artykuly_tytuly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `artykuly_tytuly`
--
ALTER TABLE `artykuly_tytuly`
  ADD CONSTRAINT `artykuly_tytuly_ibfk_1` FOREIGN KEY (`artykul_id`) REFERENCES `artykuly` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `artykuly_tytuly_ibfk_2` FOREIGN KEY (`tytul_id`) REFERENCES `tytuly` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
