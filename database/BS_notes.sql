-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bs_notes`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `amicizia`
--

CREATE TABLE `amicizia` (
  `id` int(11) NOT NULL,
  `id_utente1` int(11) NOT NULL,
  `id_utente2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `amicizia`
--

INSERT INTO `amicizia` (`id`, `id_utente1`, `id_utente2`) VALUES
(3, 3, 1),
(14, 4, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `appunto`
--

CREATE TABLE `appunto` (
  `id` int(11) NOT NULL,
  `titolo` varchar(100) NOT NULL,
  `body` mediumtext DEFAULT NULL,
  `percorso` varchar(100) DEFAULT NULL,
  `dataAllocazione` date DEFAULT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `id_utente` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `visibilita` enum('pubblico','privato', 'solo_amici') NOT NULL DEFAULT 'pubblico'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `appunto`
--

INSERT INTO `appunto` (`id`, `titolo`, `body`, `percorso`, `dataAllocazione`, `id_materia`, `id_utente`, `id_categoria`) VALUES
(4, 'Apparato riproduttore', 'L apparato riproduttivo consente all uomo e alla donna di riprodursi. Molto diverso nel genere maschile e in quello femminile, risulta formato nel primo caso dal pene, dalla prostata, dai testicoli, dalle vescicole seminali e dalle vie spermatiche, mentre nel secondo caso è formato dall ovaio, dalle salpingi, dall utero, dalla vagina e dalla vulva.Che cos è l apparato riproduttivo? L apparato riproduttivo, mediante la funzione dei suoi diversi organi, consente al genere umano di riprodursi.', NULL, '2024-02-08', 3, 2, 2),
(5, 'vita di manzioni', 'Alessandro Manzoni, nato nel 1785 a Milano, è uno degli scrittori più importanti della letteratura italiana. Cresciuto in un ambiente culturale illuminista, si distinse per la sua attività di poeta, drammaturgo e romanziere. Nel 1827, si convertì al cattolicesimo, influenzando profondamente la sua produzione letteraria.La sua opera più celebre è \"I Promessi Sposi\", capolavoro del romanticismo italiano, pubblicato tra il 1827 e il 1829. Il romanzo offre una profonda riflessione sulla società e la fede, con un ambientazione storica nel Seicento milanese. Manzoni contribuì significativamente anche al dibattito linguistico, partecipando alla stesura di norme linguistiche italiane', NULL, '2022-02-01', 1, 2, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `avatar`
--

CREATE TABLE `avatar` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `estensione` varchar(10) NOT NULL,
  `percorso` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `avatar`
--

INSERT INTO `avatar` (`id`, `nome`, `estensione`, `percorso`) VALUES
(4, 'avatar_acquaman', '.png', '../images/avatar'),
(5, 'avatar_batman', '.png', '../images/avatar'),
(6, 'avatar_black_panther', '.png', '../images/avatar'),
(7, 'avatar_capitan_america', '.png', '../images/avatar'),
(8, 'avatar_green_lantern', '.png', '../images/avatar'),
(9, 'avatar_hulk', '.png', '../images/avatar'),
(10, 'avatar_ironman', '.png', '../images/avatar'),
(11, 'avatar_man_anonimous', '.png', '../images/avatar'),
(12, 'avatar_spiderman', '.png', '../images/avatar'),
(13, 'avatar_woman_anonimous', '.png', '../images/avatar');

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

insert into categoria (id, tipo) values 
(1, 'mappa concettuale'), (2, 'riassunto');

-- --------------------------------------------------------

--
-- Struttura della tabella `materia`
--

CREATE TABLE `materia` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `materia`
--

INSERT INTO `materia` (`id`, `nome`) VALUES
(1, 'Matematica'),
(2, 'Scienze'),
(3, 'Storia'),
(4, 'Italiano'),
(5, 'Geografia'),
(6, 'Arte'),
(7, 'Musica'),
(8, 'Educazione Fisica'),
(9, 'Religione'),
(10, 'Tecnologia'),
(11, 'Informatica'),
(12, 'Filosofia'),
(13, 'Inglese'),
(14, 'Spagnolo'),
(15, 'Francese'),
(16, 'Tedesco'),
(17, 'Chimica'),
(18, 'Fisica'),
(19, 'Biologia'),
(20, 'Scienze della Terra'),
(21, 'Economia'),
(22, 'Diritto'),
(23, 'Sociologia'),
(24, 'Psicologia'),
(25, 'Letteratura'),
(26, 'Teatro'),
(27, 'Cucina'),
(28, 'Giornalismo'),
(29, 'Elettronica'),
(30, 'Robotica'),
(31, 'Programmazione'),
(32, 'Disegno Tecnico'),
(33, 'Grafica'),
(34, 'Antropologia'),
(35, "Storia dell'Arte"),
(36, 'Architettura'),
(37, 'Fotografia'),
(38, 'Cinema'),
(39, 'Geologia'),
(40, 'Meteorologia'),
(41, 'Astronomia'),
(42, 'Criminologia'),
(43, 'Cucina Molecolare'),
(44, 'Difesa Personale'),
(45, 'Ecologia'),
(46, 'Scienze Politiche'),
(47, 'Studi di Genere'),
(48, 'Storia della Musica'),
(49, 'Filologia'),
(50, 'Paleontologia'),
(51, 'Antropologia Culturale'),
(52, 'Teoria Musicale'),
(53, 'Cucina Internazionale'),
(54, 'Fisica Quantistica'),
(55, 'Biologia Marina'),
(56, 'Linguistica'),
(57, 'Geopolitica'),
(58, 'Scienze Cognitive'),
(59, 'Economia Politica'),
(60, "Storia dell'Antichità"),
(61, 'Etica'),
(62, 'Criminologia Forense'),
(63, 'Chimica Organica'),
(64, 'Meccanica Quantistica'),
(65, 'Psicologia dello Sviluppo'),
(66, 'Ingegneria del Software'),
(67, 'Neuroscienze'),
(68, 'Economia Ambientale'),
(69, 'Filosofia Politica'),
(70, 'Fotografia Digitale');

CREATE TABLE `lingua` (
  `id` int(11) NOT NULL,
  `language` varchar(100) NOT NULL,
  `code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `lingua`
--

INSERT INTO `lingua` (`id`, `language`, `code`) VALUES
(1, 'English', 'en'),
(2, 'Spanish', 'es'),
(3, 'Mandarin Chinese', 'zh'),
(4, 'Hindi', 'hi'),
(5, 'Arabic', 'ar'),
(6, 'Bengali', 'bn'),
(7, 'Portuguese', 'pt'),
(8, 'Russian', 'ru'),
(9, 'Japanese', 'ja'),
(10, 'German', 'de'),
(11, 'French', 'fr'),
(12, 'Urdu', 'ur'),
(13, 'Indonesian', 'id'),
(14, 'Italian', 'it'),
(15, 'Turkish', 'tr'),
(16, 'Thai', 'th'),
(17, 'Korean', 'ko'),
(18, 'Vietnamese', 'vi'),
(19, 'Tamil', 'ta'),
(20, 'Filipino', 'fil'),
(21, 'Telugu', 'te'),
(22, 'Marathi', 'mr'),
(23, 'Javanese', 'jv'),
(24, 'Western Punjabi', 'pnb'),
(25, 'Wu Chinese', 'wuu'),
(26, 'Yue Chinese', 'yue'),
(27, 'Eastern Punjabi', 'pa'),
(28, 'Persian', 'fa'),
(29, 'Swahili', 'sw'),
(30, 'Dutch', 'nl'),
(31, 'Greek', 'el'),
(32, 'Czech', 'cs'),
(33, 'Swedish', 'sv'),
(34, 'Haitian Creole', 'ht'),
(35, 'Danish', 'da'),
(36, 'Finnish', 'fi'),
(37, 'Hebrew', 'he'),
(38, 'Norwegian', 'no'),
(39, 'Hungarian', 'hu'),
(40, 'Ukrainian', 'uk'),
(41, 'Kannada', 'kn'),
(42, 'Malayalam', 'ml'),
(43, 'Zulu', 'zu'),
(44, 'Burmese', 'my'),
(45, 'Amharic', 'am'),
(46, 'Croatian', 'hr'),
(47, 'Serbian', 'sr'),
(48, 'Slovak', 'sk'),
(49, 'Sinhala', 'si'),
(50, 'Uzbek', 'uz'),
(51, 'Lithuanian', 'lt'),
(52, 'Slovene', 'sl'),
(53, 'Latvian', 'lv'),
(54, 'Estonian', 'et'),
(55, 'Tajik', 'tg'),
(56, 'Tigrinya', 'ti'),
(57, 'Albanian', 'sq'),
(58, 'Georgian', 'ka'),
(59, 'Armenian', 'hy'),
(60, 'Malagasy', 'mg'),
(61, 'Mongolian', 'mn'),
(62, 'Afrikaans', 'af'),
(63, 'Nepali', 'ne'),
(64, 'Kurdish', 'ku'),
(65, 'Igbo', 'ig'),
(66, 'Sesotho', 'st'),
(67, 'Somali', 'so'),
(68, 'Kyrgyz', 'ky'),
(69, 'Malay', 'ms'),
(70, 'Kinyarwanda', 'rw'),
(71, 'Cebuano', 'ceb'),
(72, 'Hausa', 'ha'),
(73, 'Azerbaijani', 'az'),
(74, 'Fula', 'ff'),
(75, 'Shona', 'sn'),
(76, 'Khmer', 'km'),
(77, 'Kazakh', 'kk'),
(78, 'Uyghur', 'ug'),
(79, 'Bosnian', 'bs'),
(80, 'Xhosa', 'xh'),
(81, 'Belarusian', 'be'),
(82, 'Igbo', 'ig'),
(83, 'Kirundi', 'rn'),
(84, 'Kongo', 'kg'),
(85, 'Luxembourgish', 'lb'),
(86, 'Ganda', 'lg'),
(87, 'Sinhala', 'si'),
(88, 'Sotho', 'st'),
(89, 'Chichewa', 'ny'),
(90, 'Tswana', 'tn'),
(91, 'Tsonga', 'ts'),
(92, 'Wolof', 'wo'),
(93, 'Kinyarwanda', 'rw'),
(94, 'Lingala', 'ln'),
(95, 'Chewa', 'ny'),
(96, 'Kirundi', 'rn'),
(97, 'Sesotho', 'st'),
(98, 'Swati', 'ss'),
(99, 'Tigrinya', 'ti'),
(100, 'Yoruba', 'yo');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `lingua`
--
ALTER TABLE `lingua`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `lingua`
--
ALTER TABLE `lingua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `username` varchar(70) NOT NULL,
  `email` varchar(100) NOT NULL,
  `userPassword` varchar(30) NOT NULL,
  `id_avatar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `nome`, `cognome`, `username`, `email`, `userPassword`, `id_avatar`) VALUES
(1, 'mattia', 'saccani', 'mattiasaccani', 'mattiasaccani1@gmail.com', 'Mattia!123', 13),
(2, 'antonio', 'battigaglia', 'antoniobattigaglia', 'antoniorocco.battigaglia@studenti.iispascal.it', 'Choppa2@', 4),
(3, 'daniele', 'pio', 'danipio', 'daniele.titopio@studenti.isspascal.it', 'Daniele!123', 12),
(4, 'remo', 'felice', 'rambo', 'remofelice@gmail.com', 'Romrom1234*', 10),
(10, 'abbo', 'nahasse', 'tobba', 'gnsbh@gmail.com', 'Choppa1@', 9),
(12, 'szz', 'ksd', 'hamza', 'dcdvw@djbhwg.com', 'Choppa1@', 6);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `amicizia`
--
ALTER TABLE `amicizia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_utente1` (`id_utente1`,`id_utente2`),
  ADD KEY `id_utente2` (`id_utente2`);

--
-- Indici per le tabelle `appunto`
--
ALTER TABLE `appunto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indici per le tabelle `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`,`estensione`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_avatar` (`id_avatar`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `amicizia`
--
ALTER TABLE `amicizia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `appunto`
--
ALTER TABLE `appunto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `avatar`
--
ALTER TABLE `avatar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `materia`
--
ALTER TABLE `materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `amicizia`
--
ALTER TABLE `amicizia`
  ADD CONSTRAINT `amicizia_ibfk_1` FOREIGN KEY (`id_utente1`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `amicizia_ibfk_2` FOREIGN KEY (`id_utente2`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `appunto`
--
ALTER TABLE `appunto`
  ADD CONSTRAINT `appunto_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `appunto_ibfk_2` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appunto_ibfk_3` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`id_avatar`) REFERENCES `avatar` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
