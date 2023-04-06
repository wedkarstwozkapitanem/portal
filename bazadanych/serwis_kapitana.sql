-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 26 Lut 2023, 08:35
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `serwis_kapitana`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `hasla`
--

CREATE TABLE `hasla` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `haslo` text NOT NULL,
  `ip` text NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `komentarze`
--

CREATE TABLE `komentarze` (
  `id` int(11) NOT NULL,
  `iduzytkownika` int(11) NOT NULL,
  `idposta` int(11) NOT NULL,
  `tresc` text NOT NULL,
  `dodanedata` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `polubienia`
--

CREATE TABLE `polubienia` (
  `id` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `id_posta` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posty`
--

CREATE TABLE `posty` (
  `idp` int(11) NOT NULL,
  `iduzytkownika` int(11) NOT NULL,
  `tresc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `foty` text NOT NULL,
  `udustepniono` int(11) NOT NULL,
  `datadodania` datetime NOT NULL DEFAULT current_timestamp(),
  `publiczny` int(11) NOT NULL,
  `usunieto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `powiadomienia`
--

CREATE TABLE `powiadomienia` (
  `id` int(11) NOT NULL,
  `id_tresci` int(11) NOT NULL,
  `id_odbiorcy` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `typ` int(11) NOT NULL,
  `datadodania` datetime NOT NULL DEFAULT current_timestamp(),
  `wyswietlono` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `imie` text NOT NULL,
  `nazwisko` text NOT NULL,
  `folder` text NOT NULL,
  `numertelefonu` int(11) NOT NULL,
  `profilowe` text NOT NULL,
  `tlo` text NOT NULL,
  `wiek` date NOT NULL,
  `miejscowosc` text NOT NULL,
  `datadoloczenia` date NOT NULL DEFAULT current_timestamp(),
  `ostatnielogowanie` tinytext NOT NULL DEFAULT current_timestamp(),
  `hobby` text NOT NULL,
  `linki` text NOT NULL,
  `praca` text NOT NULL,
  `płeć` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `znajomi`
--

CREATE TABLE `znajomi` (
  `id` int(11) NOT NULL,
  `iduzytkownika` int(11) NOT NULL,
  `iduzytkownik` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `czyprzyjeto` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `hasla`
--
ALTER TABLE `hasla`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `polubienia`
--
ALTER TABLE `polubienia`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `posty`
--
ALTER TABLE `posty`
  ADD PRIMARY KEY (`idp`);

--
-- Indeksy dla tabeli `powiadomienia`
--
ALTER TABLE `powiadomienia`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `znajomi`
--
ALTER TABLE `znajomi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `hasla`
--
ALTER TABLE `hasla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `polubienia`
--
ALTER TABLE `polubienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `posty`
--
ALTER TABLE `posty`
  MODIFY `idp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `powiadomienia`
--
ALTER TABLE `powiadomienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `znajomi`
--
ALTER TABLE `znajomi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-----------------------------------------------------------------     NOWE   ---------------------------------------


-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 06 Kwi 2023, 14:39
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `serwis_kapitana`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `hasla`
--

CREATE TABLE `hasla` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `haslo` text NOT NULL,
  `ip` text NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `komentarze`
--

CREATE TABLE `komentarze` (
  `id` int(11) NOT NULL,
  `iduzytkownika` int(11) NOT NULL,
  `idposta` int(11) NOT NULL,
  `tresc` text NOT NULL,
  `dodanedata` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `polubienia`
--

CREATE TABLE `polubienia` (
  `id` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `id_posta` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posty`
--

CREATE TABLE `posty` (
  `idp` int(11) NOT NULL,
  `iduzytkownika` int(11) NOT NULL,
  `tresc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `foty` text NOT NULL,
  `udustepniono` int(11) NOT NULL,
  `datadodania` datetime NOT NULL DEFAULT current_timestamp(),
  `publiczny` int(11) NOT NULL,
  `usunieto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `powiadomienia`
--

CREATE TABLE `powiadomienia` (
  `id` int(11) NOT NULL,
  `id_tresci` int(11) NOT NULL,
  `id_odbiorcy` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `typ` int(11) NOT NULL,
  `datadodania` datetime NOT NULL DEFAULT current_timestamp(),
  `wyswietlono` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `nazwa` text NOT NULL,
  `imie` text NOT NULL,
  `nazwisko` text NOT NULL,
  `folder` text NOT NULL,
  `numertelefonu` int(11) NOT NULL,
  `profilowe` text NOT NULL,
  `tlo` text NOT NULL,
  `wiek` date NOT NULL,
  `miejscowosc` text NOT NULL,
  `datadoloczenia` date NOT NULL DEFAULT current_timestamp(),
  `ostatnielogowanie` tinytext NOT NULL DEFAULT current_timestamp(),
  `hobby` text NOT NULL,
  `linki` text NOT NULL,
  `praca` text NOT NULL,
  `płeć` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `znajomi`
--

CREATE TABLE `znajomi` (
  `id` int(11) NOT NULL,
  `iduzytkownika` int(11) NOT NULL,
  `iduzytkownik` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `czyprzyjeto` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `hasla`
--
ALTER TABLE `hasla`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `polubienia`
--
ALTER TABLE `polubienia`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `posty`
--
ALTER TABLE `posty`
  ADD PRIMARY KEY (`idp`);

--
-- Indeksy dla tabeli `powiadomienia`
--
ALTER TABLE `powiadomienia`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `znajomi`
--
ALTER TABLE `znajomi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `hasla`
--
ALTER TABLE `hasla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `polubienia`
--
ALTER TABLE `polubienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `posty`
--
ALTER TABLE `posty`
  MODIFY `idp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `powiadomienia`
--
ALTER TABLE `powiadomienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `znajomi`
--
ALTER TABLE `znajomi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
