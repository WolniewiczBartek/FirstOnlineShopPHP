-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 29 Mar 2022, 23:05
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
-- Struktura tabeli dla tabeli `adresy`
--

CREATE TABLE `adresy` (
  `id` int(11) NOT NULL,
  `kraj` varchar(50) NOT NULL,
  `miasto` varchar(50) NOT NULL,
  `kod_pocztowy` varchar(10) NOT NULL,
  `ulica` varchar(50) NOT NULL,
  `numer_domu` varchar(10) NOT NULL,
  `telefon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `adresy`
--

INSERT INTO `adresy` (`id`, `kraj`, `miasto`, `kod_pocztowy`, `ulica`, `numer_domu`, `telefon`) VALUES
(78, 'Polska', 'Koziegłowy', '62-005', 'Janikowska', '48/3', '515356896');

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
(1, 'Eurogąbkaaa', 'gabka.jpg', '34.64', 75, 1),
(2, 'gąbka w kształcie kotleta', 'kotlet.jpg', '44.99', 0, 0),
(3, 'gąbka maślana', 'maslo.jpg', '39.00', 6660, 1),
(4, 'gąbka w kształcie chleba', 'chleb.jpg', '44.33', 243, 1),
(5, 'gąbka wiadro', 'wiadro.jpg', '34.00', 13, 1),
(6, 'gąbka jabłkowa', 'jablko.jpg', '43.00', 0, 0),
(7, 'gąbka lizak', 'lizak.jpg', '69.69', 15, 1),
(8, 'Gąbka miodowe marzenie', 'miod.jpg', '25.00', 49, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `rola` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `role`
--

INSERT INTO `role` (`id`, `rola`) VALUES
(1, 'customer'),
(2, 'manager'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stany`
--

CREATE TABLE `stany` (
  `id` int(11) NOT NULL,
  `stan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `stany`
--

INSERT INTO `stany` (`id`, `stan`) VALUES
(1, 'nieaktywowany'),
(2, 'aktywowany'),
(3, 'zablokowany'),
(4, 'usunięty');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `imie` varchar(30) DEFAULT NULL,
  `nazwisko` varchar(60) DEFAULT NULL,
  `data_urodzenia` date DEFAULT NULL,
  `haslo` varchar(255) NOT NULL DEFAULT 'NULL',
  `rola_id` int(10) NOT NULL DEFAULT 1,
  `stan_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `email`, `imie`, `nazwisko`, `data_urodzenia`, `haslo`, `rola_id`, `stan_id`) VALUES
(57, 'k', 'k', 'k', '2022-03-15', '$2y$10$FoLQWshShAfEOJQRjvcjkuL69O3xkP9AmCrjzKwQJgI4cH5Eg8E2W', 1, 2),
(59, 'm', 'm', 'm', '2022-03-02', '$2y$10$yDxy4qYVniYEBoO6ZLqLHetkwYailQX66BECrDZHQvqcmEmDf92T.', 2, 2),
(60, 'a', 'a', 'a', '2022-03-09', '$2y$10$bqcj/pfhCe/A6HT.aGPLYOTlR0lbZH7Jf1u4XkwmvRm4My7mcwLeS', 3, 2),
(78, 'bartosz.wolniewicz@uczen.zsk.poznan.pl', 'a', 'a', '2022-03-09', '$2y$10$NjDEXr74d63hVC7w5g2ndOJpMpyu6el4iDV5CuZaG3pDQTUZH88Vy', 1, 2),
(79, 'wolniewiczbart8@gmail.com', 'a', 'a', '2022-03-08', '$2y$10$FRpwvFtRXEiDCD2xFvvrwemcR.K2M7K0fOXCersYsZoz1VrysxdN6', 1, 2),
(80, 'zoska2002@gmail.com', 'a', 'a', '2022-03-16', '$2y$10$ArwJRTGP6hvVnbKKxjWg8u7LdaICbLBmFHxUssW77IFzWnpBV.6nK', 1, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `weryfikacje`
--

CREATE TABLE `weryfikacje` (
  `id` int(11) NOT NULL,
  `kod` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `weryfikacje`
--

INSERT INTO `weryfikacje` (`id`, `kod`) VALUES
(78, 747887),
(79, 965744),
(57, 721849),
(80, 622840);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id` int(11) NOT NULL,
  `uzytkownik_id` int(11) NOT NULL,
  `data_zamowienia` timestamp NOT NULL DEFAULT current_timestamp(),
  `numer_wew` varchar(30) NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `dostawa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `adresy`
--
ALTER TABLE `adresy`
  ADD KEY `adresy_ibfk_1` (`id`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `stany`
--
ALTER TABLE `stany`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `uzytkownicy_ibfk_1` (`stan_id`),
  ADD KEY `uzytkownicy_ibfk_2` (`rola_id`);

--
-- Indeksy dla tabeli `weryfikacje`
--
ALTER TABLE `weryfikacje`
  ADD KEY `weryfikacje_ibfk_1` (`id`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zamowienia_ibfk_1` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `zamowienia_produkty`
--
ALTER TABLE `zamowienia_produkty`
  ADD KEY `zamowienia_produkty_ibfk_1` (`zamowienie_id`),
  ADD KEY `zamowienia_produkty_ibfk_2` (`produkt_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `stany`
--
ALTER TABLE `stany`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `adresy`
--
ALTER TABLE `adresy`
  ADD CONSTRAINT `adresy_ibfk_1` FOREIGN KEY (`id`) REFERENCES `uzytkownicy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD CONSTRAINT `uzytkownicy_ibfk_1` FOREIGN KEY (`stan_id`) REFERENCES `stany` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `uzytkownicy_ibfk_2` FOREIGN KEY (`rola_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `weryfikacje`
--
ALTER TABLE `weryfikacje`
  ADD CONSTRAINT `weryfikacje_ibfk_1` FOREIGN KEY (`id`) REFERENCES `uzytkownicy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `zamowienia_produkty`
--
ALTER TABLE `zamowienia_produkty`
  ADD CONSTRAINT `zamowienia_produkty_ibfk_1` FOREIGN KEY (`zamowienie_id`) REFERENCES `zamowienia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zamowienia_produkty_ibfk_2` FOREIGN KEY (`produkt_id`) REFERENCES `produkty` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
