-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 10, 2025 alle 23:56
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webprogramming`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `carrello`
--

CREATE TABLE `carrello` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `totale` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `carrello`
--

INSERT INTO `carrello` (`id`, `id_cliente`, `totale`, `created_at`) VALUES
(1, 1, 31.80, '2025-06-10 21:42:25'),
(2, 1, 31.80, '2025-06-10 21:47:20'),
(3, 1, 59.49, '2025-06-10 21:51:26'),
(4, 1, 59.49, '2025-06-10 21:51:27');

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `icona` varchar(100) DEFAULT NULL,
  `attiva` tinyint(1) DEFAULT 1,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id`, `nome`, `descrizione`, `icona`, `attiva`, `data_creazione`) VALUES
(1, 'Fast Food', 'Ristoranti di fast food e catene internazionali', 'fas fa-hamburger', 1, '2025-06-10 17:14:58'),
(2, 'Sushi', 'Ristoranti giapponesi specializzati in sushi e cucina nipponica', 'fas fa-fish', 1, '2025-06-10 17:14:58'),
(3, 'Italiano', 'Ristoranti di cucina italiana tradizionale', 'fas fa-pizza-slice', 1, '2025-06-10 17:14:58'),
(4, 'Pizza', 'Pizzerie e ristoranti specializzati in pizza', 'fas fa-pizza-slice', 1, '2025-06-10 17:14:58'),
(5, 'Vegetariano', 'Ristoranti con opzioni vegetariane e vegane', 'fas fa-leaf', 1, '2025-06-10 17:14:58');

-- --------------------------------------------------------

--
-- Struttura della tabella `negozi`
--

CREATE TABLE `negozi` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `codice` varchar(50) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `indirizzo` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `orario_apertura` time DEFAULT NULL,
  `orario_chiusura` time DEFAULT NULL,
  `attivo` tinyint(1) DEFAULT 1,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `negozi`
--

INSERT INTO `negozi` (`id`, `nome`, `codice`, `id_categoria`, `descrizione`, `indirizzo`, `telefono`, `email`, `orario_apertura`, `orario_chiusura`, `attivo`, `data_creazione`) VALUES
(1, 'McDonald\'s', 'mcdonalds', 1, 'Catena di fast food americana famosa per hamburger e patatine', 'Via Roma 123, Catania', '095-1234567', 'catania@mcdonalds.it', '07:00:00', '24:00:00', 1, '2025-06-10 17:14:58'),
(2, 'Burger King', 'burgerking', 1, 'Catena di fast food specializzata in hamburger alla griglia', 'Via Etnea 456, Catania', '095-2345678', 'catania@burgerking.it', '10:00:00', '23:00:00', 1, '2025-06-10 17:14:58'),
(3, 'KFC', 'kfc', 1, 'Catena specializzata in pollo fritto con ricetta segreta', 'Via Umberto 789, Catania', '095-3456789', 'catania@kfc.it', '11:00:00', '23:30:00', 1, '2025-06-10 17:14:58'),
(4, 'Old Wild West', 'oldwildwest', 1, 'Ristorante tex-mex con atmosfera del Far West', 'Corso Italia 321, Catania', '095-4567890', 'catania@oldwildwest.it', '12:00:00', '24:00:00', 1, '2025-06-10 17:14:58'),
(5, 'Sushi Bar', 'sushi', 2, 'Ristorante giapponese specializzato in sushi e cucina nipponica', 'Via Crociferi 654, Catania', '095-5678901', 'info@sushibarcatania.it', '18:00:00', '23:00:00', 1, '2025-06-10 17:14:58');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
--

CREATE TABLE `prodotti` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `prezzo` decimal(8,2) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `immagine` varchar(255) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `valutazione` decimal(2,1) DEFAULT 0.0,
  `disponibile` tinyint(1) DEFAULT 1,
  `id_negozio` int(11) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`id`, `nome`, `prezzo`, `descrizione`, `immagine`, `id_categoria`, `valutazione`, `disponibile`, `id_negozio`, `data_creazione`) VALUES
(1, 'Smoky Gran Crispy McBacon® Menu', 8.64, 'Menu completo con hamburger crispy bacon, patatine e bevanda', '../img/Stroop_Test.jpg', 1, 4.5, 1, 1, '2025-06-10 17:14:58'),
(2, 'Big Mac® Menu', 7.89, 'Il classico Big Mac con patatine medie e bevanda', '../img/Stroop_Test.jpg', 1, 4.2, 1, 1, '2025-06-10 17:14:58'),
(3, 'McChicken® Menu', 6.50, 'Hamburger di pollo impanato con insalata e maionese', '../img/Stroop_Test.jpg', 1, 4.1, 1, 1, '2025-06-10 17:14:58'),
(4, 'Chicken McNuggets 9 pezzi', 5.90, '9 bocconcini di pollo dorato con salse a scelta', '../img/Stroop_Test.jpg', 1, 4.3, 1, 1, '2025-06-10 17:14:58'),
(5, 'McFlurry Oreo', 3.20, 'Gelato alla vaniglia con biscotti Oreo tritati', '../img/Stroop_Test.jpg', 1, 4.0, 1, 1, '2025-06-10 17:14:58'),
(6, 'Whopper® Menu', 8.90, 'Il famoso Whopper con patatine e bevanda', '../img/Stroop_Test.jpg', 1, 4.4, 1, 2, '2025-06-10 17:14:58'),
(7, 'Crispy Chicken Menu', 7.50, 'Pollo croccante con insalata e salsa piccante', '../img/Stroop_Test.jpg', 1, 4.2, 1, 2, '2025-06-10 17:14:58'),
(8, 'Double Whopper®', 9.50, 'Doppia carne di manzo con verdure fresche', '../img/Stroop_Test.jpg', 1, 4.6, 1, 2, '2025-06-10 17:14:58'),
(9, 'Chicken Royale', 6.80, 'Hamburger di pollo con maionese e insalata', '../img/Stroop_Test.jpg', 1, 4.1, 1, 2, '2025-06-10 17:14:58'),
(10, 'King Fries Grande', 3.50, 'Patatine croccanti formato grande', '../img/Stroop_Test.jpg', 1, 3.9, 1, 2, '2025-06-10 17:14:58'),
(11, 'Bucket 8 pezzi', 15.90, '8 pezzi di pollo fritto originale con patatine', '../img/Stroop_Test.jpg', 1, 4.5, 1, 3, '2025-06-10 17:14:58'),
(12, 'Zinger Burger Menu', 7.90, 'Hamburger piccante con patatine e bevanda', '../img/Stroop_Test.jpg', 1, 4.3, 1, 3, '2025-06-10 17:14:58'),
(13, 'Hot Wings 6 pezzi', 5.50, 'Alette di pollo piccanti', '../img/Stroop_Test.jpg', 1, 4.4, 1, 3, '2025-06-10 17:14:58'),
(14, 'Krushems Oreo', 3.90, 'Frappè cremoso ai biscotti Oreo', '../img/Stroop_Test.jpg', 1, 4.2, 1, 3, '2025-06-10 17:14:58'),
(15, 'Popcorn Chicken', 4.90, 'Bocconcini di pollo croccanti', '../img/Stroop_Test.jpg', 1, 4.1, 1, 3, '2025-06-10 17:14:58'),
(16, 'Rodeo Burger', 12.50, 'Hamburger con anelli di cipolla e salsa barbecue', '../img/Stroop_Test.jpg', 1, 4.3, 1, 4, '2025-06-10 17:14:58'),
(17, 'Tex-Mex Chicken', 11.90, 'Petto di pollo grigliato con spezie messicane', '../img/Stroop_Test.jpg', 1, 4.4, 1, 4, '2025-06-10 17:14:58'),
(18, 'Nachos Supreme', 8.50, 'Nachos con formaggio fuso, jalapeños e guacamole', '../img/Stroop_Test.jpg', 1, 4.2, 1, 4, '2025-06-10 17:14:58'),
(19, 'Buffalo Wings', 9.90, 'Alette di pollo con salsa buffalo piccante', '../img/Stroop_Test.jpg', 1, 4.5, 1, 4, '2025-06-10 17:14:58'),
(20, 'Chili con Carne', 7.50, 'Spezzatino piccante con fagioli e riso', '../img/Stroop_Test.jpg', 1, 4.1, 1, 4, '2025-06-10 17:14:58'),
(21, 'Sashimi Misto 20 pezzi', 18.50, 'Selezione di pesce crudo fresco', '../img/Stroop_Test.jpg', 2, 4.7, 1, 5, '2025-06-10 17:14:58'),
(22, 'Uramaki Speciale 8 pezzi', 12.90, 'Uramaki con salmone, avocado e salsa teriyaki', '../img/Stroop_Test.jpg', 2, 4.6, 1, 5, '2025-06-10 17:14:58'),
(23, 'Nigiri Salmone 6 pezzi', 8.50, 'Nigiri di salmone fresco su riso', '../img/Stroop_Test.jpg', 2, 4.5, 1, 5, '2025-06-10 17:14:58'),
(24, 'Temaki Tonno Piccante', 5.90, 'Cono di alga con tonno piccante e verdure', '../img/Stroop_Test.jpg', 2, 4.4, 1, 5, '2025-06-10 17:14:58'),
(25, 'Miso Soup', 3.50, 'Zuppa tradizionale giapponese', '../img/Stroop_Test.jpg', 2, 4.2, 1, 5, '2025-06-10 17:14:58'),
(26, 'Edamame', 4.50, 'Fagioli di soia bolliti e salati', '../img/Stroop_Test.jpg', 2, 4.3, 1, 5, '2025-06-10 17:14:58');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Suca', 'chiudiorata@mattia.it', '$2y$10$L20BwNxwVkion3CJZiMqduym9gaabw/QVGbnxrpec1Q2jh.2o1wdO', '2025-06-08 13:44:15'),
(2, 'saro', 'test@gmail.com', '$2y$10$iCqDY1Ju834Vbbsk6peufe4i/ONPOxf5XczlHuvV9T2HcVO1BHg6m', '2025-06-08 15:31:41'),
(3, 'chiudiorata@mattia.it', 'sdfkls@gmail.com', '$2y$10$z.wbjYTLPuME2XF6/DxN4.nGQt6gNBj8dX6.k1Z935yo7VfsLPemC', '2025-06-08 15:57:28'),
(4, 'test', 'test@prova.it', '$2y$10$Om09LgoFXJqkFh5l2B/CjO0B9QWtoxyogZ2AUEq3cYxtiLvVCoq8C', '2025-06-10 16:23:22'),
(6, 'test44', 'saro@gmail.com', '$2y$10$16.8JratCWRHAHAMjaG4W.t90iGSQ1D.GM96p5irtb/SbLVHxwuh.', '2025-06-10 16:24:39');

-- --------------------------------------------------------

--
-- Struttura della tabella `user_information`
--

CREATE TABLE `user_information` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cognome` varchar(100) DEFAULT NULL,
  `data_nascita` date DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `indirizzo` varchar(255) DEFAULT NULL,
  `citta` varchar(100) DEFAULT NULL,
  `cap` varchar(10) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `paese` varchar(100) DEFAULT 'Italia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `user_information`
--

INSERT INTO `user_information` (`id`, `id_cliente`, `nome`, `cognome`, `data_nascita`, `telefono`, `indirizzo`, `citta`, `cap`, `provincia`, `paese`, `created_at`, `updated_at`) VALUES
(1, 1, 'sadsa', 'sadsa', '0000-00-00', '', 'trstt', 'Catania', '95123', 'TG', 'Italia', '2025-06-10 15:58:10', '2025-06-10 16:17:21'),
(2, 6, 'Claudio', 'Ai', '0000-00-00', '', 'Claudio è un fenomeno', 'Catania', '98745', 'RT', 'Italia', '2025-06-10 16:25:30', '2025-06-10 16:25:30');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `carrello`
--
ALTER TABLE `carrello`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cliente` (`id_cliente`),
  ADD KEY `idx_data` (`created_at`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD KEY `idx_categorie_nome` (`nome`);

--
-- Indici per le tabelle `negozi`
--
ALTER TABLE `negozi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codice` (`codice`),
  ADD KEY `idx_negozi_categoria` (`id_categoria`),
  ADD KEY `idx_negozi_codice` (`codice`);

--
-- Indici per le tabelle `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_prodotti_negozio` (`id_negozio`),
  ADD KEY `idx_prodotti_categoria` (`id_categoria`),
  ADD KEY `idx_prodotti_prezzo` (`prezzo`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indici per le tabelle `user_information`
--
ALTER TABLE `user_information`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `carrello`
--
ALTER TABLE `carrello`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `negozi`
--
ALTER TABLE `negozi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `user_information`
--
ALTER TABLE `user_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `carrello`
--
ALTER TABLE `carrello`
  ADD CONSTRAINT `carrello_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `negozi`
--
ALTER TABLE `negozi`
  ADD CONSTRAINT `negozi_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorie` (`id`);

--
-- Limiti per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  ADD CONSTRAINT `prodotti_ibfk_1` FOREIGN KEY (`id_negozio`) REFERENCES `negozi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prodotti_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorie` (`id`);

--
-- Limiti per la tabella `user_information`
--
ALTER TABLE `user_information`
  ADD CONSTRAINT `user_information_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
