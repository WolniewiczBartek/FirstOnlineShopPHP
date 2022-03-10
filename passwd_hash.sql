-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 06 Mar 2022, 21:14
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `passwd_hash`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(250) NOT NULL,
  `zdjecie` varchar(50) NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `ilosc_magazyn` int(11) DEFAULT NULL,
  `widoczny` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`id`, `nazwa`, `zdjecie`, `cena`, `ilosc_magazyn`, `widoczny`) VALUES
(12, 'Eurogąbkaaa', 'gabka.jpg', '34.64', 82, 1),
(18, 'gąbka w kształcie kotleta', 'kotlet.jpg', '44.99', 0, 0),
(20, 'gąbka maślana', 'maslo.jpg', '39.00', 6666, 1),
(21, 'gąbka w kształcie chleba', 'chleb.jpg', '44.33', 2433, 1),
(23, 'gąbka wiadro', 'wiadro.jpg', '34.00', 17, 1),
(29, 'gąbka jabłkowa', 'jablko.jpg', '43.00', 7, 1),
(38, 'gąbka lizak', 'lizak.jpg', '69.69', 15, 1),
(39, 'Gąbka miodowe marzenie', 'miod.jpg', '25.00', 49, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `imie` varchar(30) DEFAULT NULL,
  `nazwisko` varchar(60) DEFAULT NULL,
  `data_urodzenia` date DEFAULT NULL,
  `haslo` varchar(255) NOT NULL DEFAULT 'NULL',
  `email` varchar(60) NOT NULL,
  `rola` varchar(10) NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `imie`, `nazwisko`, `data_urodzenia`, `haslo`, `email`, `rola`) VALUES
(12, 'admin', 'admin', '2022-03-11', '$2y$10$Bn/.Cwmh3ztoCGLf8H7g1euTA60tktA.sMIQOz0odYZN4OVWO7e9m', 'admin', 'admin'),
(16, 'manager', 'manager', '2022-03-09', '$2y$10$Iz7tdYAuL7JKZ80wJ25nFORzoN0zh.56p79kG5j64Ssq/eVXzZdjG', 'manager', 'manager'),
(27, 'klient', 'klient', '2022-03-10', '$2y$10$3wApRYkf/ZwJ3gnNtQR/kuNvM9.hMJKV6vW2butxyx4lhZwMoGJFO', 'klient', 'customer'),
(29, 'k', 'k', '2022-03-15', '$2y$10$IPA/26K3PBRXs9zxxmuV4uoXTWlyZXH61NZCh.2j6hZvJHj.9iEkS', 'k', 'customer'),
(39, 'h', 'h', '2022-03-15', '$2y$10$0JAU70Qf19c3JXPjtY2BqOrKyrwxjxSk4vLS.tnizrjXRmDWlCj/i', 'h', 'customer'),
(41, 'm', 'm', '2022-03-02', '$2y$10$yDxy4qYVniYEBoO6ZLqLHetkwYailQX66BECrDZHQvqcmEmDf92T.', 'm', 'manager'),
(42, 'a', 'a', '2022-03-09', '$2y$10$bqcj/pfhCe/A6HT.aGPLYOTlR0lbZH7Jf1u4XkwmvRm4My7mcwLeS', 'a', 'admin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id` int(11) NOT NULL,
  `uzytkownik_id` int(11) NOT NULL,
  `data_zamowienia` timestamp NOT NULL DEFAULT current_timestamp(),
  `cena` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zamowienia`
--

INSERT INTO `zamowienia` (`id`, `uzytkownik_id`, `data_zamowienia`, `cena`) VALUES
(1, 39, '2022-03-04 12:30:49', '34.64'),
(2, 27, '2022-03-04 13:18:22', '124.62'),
(3, 39, '2022-03-04 17:40:50', '129.00'),
(4, 40, '2022-03-04 17:42:13', '1309.16'),
(5, 29, '2022-03-04 19:56:46', '103.92'),
(6, 29, '2022-03-04 19:57:41', '89.98'),
(7, 29, '2022-03-04 20:00:39', '172.00'),
(8, 29, '2022-03-04 21:20:16', '258.00'),
(9, 29, '2022-03-06 19:55:54', '692.80');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia_produkty`
--

CREATE TABLE `zamowienia_produkty` (
  `zamowienie_id` int(11) DEFAULT NULL,
  `produkt_id` int(11) DEFAULT NULL,
  `ilosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zamowienia_produkty`
--

INSERT INTO `zamowienia_produkty` (`zamowienie_id`, `produkt_id`, `ilosc`) VALUES
(1, 12, 1),
(2, 12, 1),
(2, 18, 2),
(3, 29, 3),
(4, 12, 31),
(4, 18, 1),
(4, 20, 2),
(4, 21, 1),
(4, 23, 2),
(5, 12, 3),
(6, 18, 2),
(7, 29, 4),
(8, 29, 6),
(9, 12, 20);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
