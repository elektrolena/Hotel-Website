-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 15. Jan 2023 um 14:59
-- Server-Version: 10.4.27-MariaDB
-- PHP-Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `hotelhelenadb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `anrede`
--

CREATE TABLE `anrede` (
  `AnredeID` int(255) NOT NULL,
  `Bezeichnung` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `anrede`
--

INSERT INTO `anrede` (`AnredeID`, `Bezeichnung`) VALUES
(1, 'Divers'),
(2, 'Frau'),
(3, 'Herr');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `newsbeitraege`
--

CREATE TABLE `newsbeitraege` (
  `Datum` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `AutorID_FK` int(255) NOT NULL,
  `Titel` varchar(255) NOT NULL,
  `Text` text NOT NULL,
  `Thumbnail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `newsbeitraege`
--

INSERT INTO `newsbeitraege` (`Datum`, `AutorID_FK`, `Titel`, `Text`, `Thumbnail`) VALUES
('2023-01-13 12:13:18.417774', 1, 'Ein Sommerurlaub im Salzburger Land', 'Exklusiver Urlaub in Österreich: Über 400 km Wander- und Bikewege, liebevoll angelegte Attraktionen für den Familienurlaub und spannende Themenwege fügen sich perfekt in die alpine Landschaft von Saalbach Hinterglemm ein. Die Bergdörfer im Salzburger Land sind bekannt für die tollen Wander- und Freizeitmöglichkeiten und beliebt für Aktivurlaub. Saftig grüne Almwiesen, sanfte Bergrücken und majestätische Gipfel prägen das Landschaftsbild und umgeben das Apartment. Hochwertige Ausstattung, private Atmosphäre und die inkludierte Joker Card machen Ihren Sommerurlaub im Boutique Apartment Astergut perfekt. Besuchen Sie uns auch gerne im Winter.', 'Resized_Image_17'),
('2023-01-13 12:15:49.742237', 1, 'Frühstück &amp; Abendessen', 'Lassen Sie sich kulinarisch verwöhnen während Ihres Urlaubs im Hotel Helena. Starten Sie mit dem vielfältigen Frühstücksangebot gut in den Tag welches von unserer Küchenchefin Elena Steigberger und ihrem Team vorbereitet wird. Es ich wichtig, sich zu stärken wenn ein aktiver Urlaubstag geplant ist. \r\n\r\nDamit Sie dann nicht hungrig ins Bett müssen, können Sie am Abend im Restaurant von Hotel Helena Ihre Batterien wieder aufladen und sich ein 4-Gang Gourmetmenü schmecken lassen. Ein perfekter Abschluss eines perfekten Tages. \r\n\r\nAber auch die Tagesgäste kommen im Restaurant vom Hotel Helena nicht zu kurz. Egal ob Frühstück, Mittag- oder Abendessen - im à la carte Restaurant ist für jeden Geschmack etwas dabei!', 'Resized_Image_55'),
('2023-01-13 12:15:58.114189', 1, 'Unser neuer Pool', 'Nehmen Sie sich Zeit zum Glücklichsein – in unserem Wellnessbereich können Sie so richtig abschalten und entspannen. Die Saunalandschaft mit Außenwhirlpool können Sie als Hotel-, aber auch als Tagesgast auf rund 200 m² genießen und eine Auszeit für Körper &amp; Geist nehmen.', 'Resized_Image_19'),
('2023-01-15 01:50:56.000000', 2, 'Skifahren macht glücklich', 'In wissenschaftlichen Studien konnten die positiven Auswirkungen des Skisports auf die mentale Gesundheit nachgewiesen werden. Skifahren macht in der Tat glücklich. Wie es am Tag nach dem Apres Ski mit der guten Laune aussieht, wurde allerdings noch nicht untersucht.', 'Resized Image_73'),
('2023-01-15 01:54:04.000000', 2, 'Unser neuer Spielplatz', 'Kinderfreundlichkeit hat bei uns im Hotel Helena einen hohen Stellenwert. Was sich Kinder von einem tollen Urlaub erwarten, dafür ist in unserem Familienhotel gesorgt. Dazu gehören der 500 m² große Außenspielplatz und die abwechslungsreichen Kinderspielräume im Hotel: langweilig wird es dort ganz bestimmt nicht.\r\nBei Schönwetter ist der hoteleigene, 500 m² große Außenspielplatz das Highlight. Mit Schaukeln, einer Hüpfburg, Seilbahn, Rutschen und Klettergerüsten ist für viele tolle Urlaubsstunden gesorgt, während nebenbei frische Bergluft und Sonne getankt wird. Hier können Ihre Kinder ungehindert ihrem Bewegungsdrang freien Lauf lassen, mit Gleichaltrigen spielen und Urlaubsfreunde finden. Das gesamte Gelände haben Sie von der Terrasse und vom Swimmingpool aus gut im Überblick. So können Sie stets ein Auge auf Ihre Sprösslinge haben, während Sie auf der Sonnenliege relaxen oder sich bei Kaffee und Kuchen verwöhnen lassen.', 'Resized Image_25');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `personen`
--

CREATE TABLE `personen` (
  `PersonenID` int(255) NOT NULL,
  `AnredeID_FK` int(255) NOT NULL,
  `Vorname` varchar(100) NOT NULL,
  `Nachname` varchar(100) NOT NULL,
  `Email` text NOT NULL,
  `Benutzername` text NOT NULL,
  `Passwort` text NOT NULL,
  `Usertyp_FK` int(1) NOT NULL DEFAULT 2,
  `ProfilbildPath` varchar(255) NOT NULL DEFAULT 'profilbildStandard',
  `AktivID_FK` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `personen`
--

INSERT INTO `personen` (`PersonenID`, `AnredeID_FK`, `Vorname`, `Nachname`, `Email`, `Benutzername`, `Passwort`, `Usertyp_FK`, `ProfilbildPath`, `AktivID_FK`) VALUES
(1, 2, 'Elena', 'Steigberger', 'elena@hotelhelena.at', 'elena', '$2y$10$rjEe4UnlU/HNZ.ZKLdn/qO6PbR3m4.Yd868cNSiQ6qlCQV7VUWhva', 1, 'Resized Image_92', 1),
(2, 2, 'Helene', 'Harrer', 'helene@hotelhelena.at', 'helene', '$2y$10$pnI8K4HspUGZAWqdghc9qOVqgsLQT1sTKiIhyehjZ7TrFHcF7AtuS', 1, 'Resized Image_41', 1),
(10, 2, 'Maxine', 'Musterfrau', 'maxine@technikum.at', 'maxine', '$2y$10$6SvjD9v3TQFIvBiUWz35je5R1DVwTi7Nce.AtpCFTqSnw8vsyIdTW', 2, 'profilbildStandard', 1),
(15, 1, 'Max', 'Muster', 'max@technikum.at', 'max', '$2y$10$kzmFUClrgGkkkysFlVMTNOdopkBEaTjhvdhKIqXFOfQb4GmSTCysy', 2, 'profilbildStandard', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reservierungen`
--

CREATE TABLE `reservierungen` (
  `ResID` int(255) NOT NULL,
  `Anreisedatum` date NOT NULL,
  `Abreisedatum` date NOT NULL,
  `Zimmer` int(255) NOT NULL,
  `Frühstück` varchar(255) NOT NULL,
  `Parkplatz` varchar(255) NOT NULL,
  `Haustiere` varchar(255) NOT NULL,
  `StatusID_FK` int(11) NOT NULL DEFAULT 1,
  `Preis` float NOT NULL,
  `PersonenID_FK` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `status`
--

CREATE TABLE `status` (
  `StatusID` int(255) NOT NULL,
  `Bezeichnung` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `status`
--

INSERT INTO `status` (`StatusID`, `Bezeichnung`) VALUES
(2, 'bestätigt'),
(1, 'neu'),
(3, 'storniert');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `useraktiv`
--

CREATE TABLE `useraktiv` (
  `AktivID` int(11) NOT NULL,
  `aktiv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `useraktiv`
--

INSERT INTO `useraktiv` (`AktivID`, `aktiv`) VALUES
(1, 'aktiv'),
(2, 'inaktiv');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `usertyp`
--

CREATE TABLE `usertyp` (
  `TypID` int(1) NOT NULL,
  `Bezeichnung` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `usertyp`
--

INSERT INTO `usertyp` (`TypID`, `Bezeichnung`) VALUES
(1, 'Admin'),
(2, 'User');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `anrede`
--
ALTER TABLE `anrede`
  ADD PRIMARY KEY (`AnredeID`),
  ADD UNIQUE KEY `Geschlecht` (`Bezeichnung`);

--
-- Indizes für die Tabelle `newsbeitraege`
--
ALTER TABLE `newsbeitraege`
  ADD PRIMARY KEY (`Datum`),
  ADD KEY `FK_news_personen` (`AutorID_FK`);

--
-- Indizes für die Tabelle `personen`
--
ALTER TABLE `personen`
  ADD PRIMARY KEY (`PersonenID`),
  ADD UNIQUE KEY `e-mail` (`Email`) USING HASH,
  ADD UNIQUE KEY `benutzername` (`Benutzername`) USING HASH,
  ADD KEY `FK_Anrede_Person` (`AnredeID_FK`),
  ADD KEY `FK_Usertyp` (`Usertyp_FK`);

--
-- Indizes für die Tabelle `reservierungen`
--
ALTER TABLE `reservierungen`
  ADD PRIMARY KEY (`ResID`),
  ADD KEY `StatusID_FK` (`StatusID_FK`),
  ADD KEY `PersonenID_FK` (`PersonenID_FK`);

--
-- Indizes für die Tabelle `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`StatusID`),
  ADD UNIQUE KEY `Bezeichnung` (`Bezeichnung`);

--
-- Indizes für die Tabelle `useraktiv`
--
ALTER TABLE `useraktiv`
  ADD PRIMARY KEY (`AktivID`);

--
-- Indizes für die Tabelle `usertyp`
--
ALTER TABLE `usertyp`
  ADD PRIMARY KEY (`TypID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `anrede`
--
ALTER TABLE `anrede`
  MODIFY `AnredeID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `personen`
--
ALTER TABLE `personen`
  MODIFY `PersonenID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `reservierungen`
--
ALTER TABLE `reservierungen`
  MODIFY `ResID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `newsbeitraege`
--
ALTER TABLE `newsbeitraege`
  ADD CONSTRAINT `FK_news_personen` FOREIGN KEY (`AutorID_FK`) REFERENCES `personen` (`PersonenID`) ON DELETE NO ACTION;

--
-- Constraints der Tabelle `personen`
--
ALTER TABLE `personen`
  ADD CONSTRAINT `FK_Anrede_Person` FOREIGN KEY (`AnredeID_FK`) REFERENCES `anrede` (`AnredeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Usertyp` FOREIGN KEY (`Usertyp_FK`) REFERENCES `usertyp` (`TypID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `reservierungen`
--
ALTER TABLE `reservierungen`
  ADD CONSTRAINT `reservierungen_ibfk_1` FOREIGN KEY (`StatusID_FK`) REFERENCES `status` (`StatusID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `reservierungen_ibfk_2` FOREIGN KEY (`PersonenID_FK`) REFERENCES `personen` (`PersonenID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
