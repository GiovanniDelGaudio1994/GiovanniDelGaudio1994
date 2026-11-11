-- FitZone schema-only: no user records, hashed passwords, personal data, or accounts.
-- Source: structure of supplied MySQL project; demo records intentionally excluded.
-- MySQL dump 10.13  Distrib 8.0.40, for macos14 (x86_64)
--
-- Host: 127.0.0.1    Database: fitzone_db
-- ------------------------------------------------------
-- Server version	9.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `abbonamenti`
--

DROP TABLE IF EXISTS `abbonamenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `abbonamenti` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utente_id` int NOT NULL,
  `tipo_id` int NOT NULL,
  `data_inizio` date NOT NULL,
  `data_fine` date NOT NULL,
  `data_pagamento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `utente_id` (`utente_id`),
  KEY `tipo_id` (`tipo_id`),
  CONSTRAINT `abbonamenti_ibfk_1` FOREIGN KEY (`utente_id`) REFERENCES `utenti` (`id`) ON DELETE CASCADE,
  CONSTRAINT `abbonamenti_ibfk_2` FOREIGN KEY (`tipo_id`) REFERENCES `tipi_abbonamento` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categorie_corsi`
--

DROP TABLE IF EXISTS `categorie_corsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorie_corsi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descrizione` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contatti`
--

DROP TABLE IF EXISTS `contatti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contatti` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `messaggio` text NOT NULL,
  `data_invio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `letto` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `corsi`
--

DROP TABLE IF EXISTS `corsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `corsi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descrizione` text NOT NULL,
  `categoria_id` int NOT NULL,
  `istruttore` varchar(100) NOT NULL,
  `max_partecipanti` int NOT NULL,
  `immagine` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `corsi_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorie_corsi` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq` (
  `id` int NOT NULL AUTO_INCREMENT,
  `domanda` varchar(255) NOT NULL,
  `risposta` text NOT NULL,
  `ordine` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `galleria`
--

DROP TABLE IF EXISTS `galleria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `galleria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `percorso` varchar(255) NOT NULL,
  `descrizione` varchar(255) DEFAULT NULL,
  `ordine` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `info_palestra`
--

DROP TABLE IF EXISTS `info_palestra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `info_palestra` (
  `id` int NOT NULL DEFAULT '1',
  `nome` varchar(100) NOT NULL,
  `indirizzo` varchar(255) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `descrizione` text NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `iscrizioni_corsi`
--

DROP TABLE IF EXISTS `iscrizioni_corsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `iscrizioni_corsi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `corso_id` int NOT NULL,
  `utente_id` int NOT NULL,
  `data_iscrizione` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `corso_id` (`corso_id`),
  KEY `utente_id` (`utente_id`),
  CONSTRAINT `iscrizioni_corsi_ibfk_1` FOREIGN KEY (`corso_id`) REFERENCES `corsi` (`id`) ON DELETE CASCADE,
  CONSTRAINT `iscrizioni_corsi_ibfk_2` FOREIGN KEY (`utente_id`) REFERENCES `utenti` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `istruttori`
--

DROP TABLE IF EXISTS `istruttori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `istruttori` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `specializzazione` varchar(100) NOT NULL,
  `descrizione` text,
  `biografia` text,
  `immagine` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `data_registrazione` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notifiche`
--

DROP TABLE IF EXISTS `notifiche`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifiche` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utente_id` int NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `messaggio` text NOT NULL,
  `data_notifica` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `letta` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `utente_id` (`utente_id`),
  CONSTRAINT `notifiche_ibfk_1` FOREIGN KEY (`utente_id`) REFERENCES `utenti` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orari`
--

DROP TABLE IF EXISTS `orari`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orari` (
  `id` int NOT NULL AUTO_INCREMENT,
  `giorno` varchar(20) NOT NULL,
  `orario` varchar(50) NOT NULL,
  `corsi` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prenotazioni`
--

DROP TABLE IF EXISTS `prenotazioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prenotazioni` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utente_id` int NOT NULL,
  `corso_id` int NOT NULL,
  `sessione_id` int NOT NULL,
  `data_ora` datetime NOT NULL,
  `data_prenotazione` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stato` enum('confermata','cancellata') NOT NULL DEFAULT 'confermata',
  PRIMARY KEY (`id`),
  KEY `utente_id` (`utente_id`),
  KEY `corso_id` (`corso_id`),
  KEY `sessione_id` (`sessione_id`),
  CONSTRAINT `prenotazioni_ibfk_1` FOREIGN KEY (`utente_id`) REFERENCES `utenti` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prenotazioni_ibfk_2` FOREIGN KEY (`corso_id`) REFERENCES `corsi` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `prenotazioni_ibfk_3` FOREIGN KEY (`sessione_id`) REFERENCES `sessioni_corsi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recensioni`
--

DROP TABLE IF EXISTS `recensioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recensioni` (
  `id` int NOT NULL AUTO_INCREMENT,
  `corso_id` int NOT NULL,
  `user_id` int NOT NULL,
  `voto` int DEFAULT NULL,
  `commento` text,
  `data_recensione` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `corso_id` (`corso_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `recensioni_ibfk_1` FOREIGN KEY (`corso_id`) REFERENCES `corsi` (`id`),
  CONSTRAINT `recensioni_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `utenti` (`id`),
  CONSTRAINT `recensioni_chk_1` CHECK ((`voto` between 1 and 5))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `servizi`
--

DROP TABLE IF EXISTS `servizi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servizi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titolo` varchar(100) NOT NULL,
  `descrizione` text NOT NULL,
  `immagine` varchar(255) NOT NULL,
  `ordine` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sessioni_corsi`
--

DROP TABLE IF EXISTS `sessioni_corsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessioni_corsi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `corso_id` int NOT NULL,
  `data_ora` datetime NOT NULL,
  `durata_minuti` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `corso_id` (`corso_id`),
  CONSTRAINT `sessioni_corsi_ibfk_1` FOREIGN KEY (`corso_id`) REFERENCES `corsi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `testimonianze`
--

DROP TABLE IF EXISTS `testimonianze`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonianze` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `commento` text NOT NULL,
  `ordine` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipi_abbonamento`
--

DROP TABLE IF EXISTS `tipi_abbonamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipi_abbonamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descrizione` text NOT NULL,
  `durata_mesi` int NOT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `attivo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `utenti`
--

DROP TABLE IF EXISTS `utenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utenti` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `data_registrazione` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ruolo` enum('utente','admin') NOT NULL DEFAULT 'utente',
  `foto_profilo` varchar(255) DEFAULT NULL,
  `cognome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-10 12:29:25
