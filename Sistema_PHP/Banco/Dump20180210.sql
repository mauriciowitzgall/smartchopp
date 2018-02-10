-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: smartchopp
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `atendimentos`
--

DROP TABLE IF EXISTS `atendimentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atendimentos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `consumidor` int(11) NOT NULL,
  `cartao` int(11) NOT NULL,
  `modalidade` tinyint(2) NOT NULL,
  `situacao` tinyint(2) NOT NULL DEFAULT '1',
  `valtot` float DEFAULT NULL,
  `datahora_finalizacao` datetime DEFAULT NULL,
  `totcreditos` float DEFAULT NULL,
  `totconsumo` float DEFAULT NULL,
  `saldo` float DEFAULT NULL,
  `saldo_devolvido` float DEFAULT NULL,
  `saldo_diferenca` float DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_consumo_cartoes1_idx` (`cartao`),
  KEY `fk_consumo_consumidores1_idx` (`consumidor`),
  KEY `fk_atendimentos_modalidades_atendimentos1_idx` (`modalidade`),
  CONSTRAINT `fk_atendimentos_modalidades_atendimentos1` FOREIGN KEY (`modalidade`) REFERENCES `modalidades_atendimentos` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_consumo_cartoes1` FOREIGN KEY (`cartao`) REFERENCES `cartoes` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_consumo_consumidores1` FOREIGN KEY (`consumidor`) REFERENCES `consumidores` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atendimentos`
--

LOCK TABLES `atendimentos` WRITE;
/*!40000 ALTER TABLE `atendimentos` DISABLE KEYS */;
INSERT INTO `atendimentos` VALUES (1,'2018-02-06 19:44:01',1,1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'2018-02-06 19:44:01',2,2,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'2018-02-06 20:06:47',1,3,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'2018-02-08 21:31:59',24,2,2,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'2018-02-09 06:42:48',1,7,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,'2018-02-09 06:43:33',1,8,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,'2018-02-09 06:46:34',1,8,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,'2018-02-09 06:50:36',35,9,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,'2018-02-09 06:51:08',35,9,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,'2018-02-09 06:51:51',36,8,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,'2018-02-09 17:55:16',36,8,1,0,NULL,'2018-02-09 18:55:16',23,0,23,20,23),(17,'2018-02-09 13:35:08',37,10,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,'2018-02-09 19:13:31',38,11,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(19,'2018-02-10 00:56:18',39,3,1,0,NULL,'2018-02-10 01:56:18',15,0,15,0,15);
/*!40000 ALTER TABLE `atendimentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atendimentos_creditos`
--

DROP TABLE IF EXISTS `atendimentos_creditos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atendimentos_creditos` (
  `atendimento` int(11) NOT NULL,
  `item` int(11) NOT NULL AUTO_INCREMENT,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `valor` float NOT NULL,
  PRIMARY KEY (`item`,`atendimento`),
  KEY `fk_atendimentos_creditos_atendimentos1_idx` (`atendimento`),
  CONSTRAINT `fk_atendimentos_creditos_atendimentos1` FOREIGN KEY (`atendimento`) REFERENCES `atendimentos` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atendimentos_creditos`
--

LOCK TABLES `atendimentos_creditos` WRITE;
/*!40000 ALTER TABLE `atendimentos_creditos` DISABLE KEYS */;
INSERT INTO `atendimentos_creditos` VALUES (1,1,'2018-02-06 19:22:13',50),(2,1,'2018-02-06 19:22:13',45),(3,1,'2018-02-06 19:22:13',60),(4,1,'2018-02-06 19:22:13',15),(1,2,'2018-02-06 19:22:13',15),(4,2,'2018-02-06 19:22:13',15),(1,3,'2018-02-06 19:22:13',10),(1,4,'2018-02-06 21:55:00',20),(1,5,'2018-02-06 22:40:03',50),(1,16,'2018-02-09 04:43:12',10),(11,17,'2018-02-09 06:46:34',11.11),(13,18,'2018-02-09 06:50:36',12),(14,19,'2018-02-09 06:51:08',0.22),(15,20,'2018-02-09 06:51:51',12),(16,21,'2018-02-09 06:52:48',23),(17,22,'2018-02-09 13:35:08',100),(18,23,'2018-02-09 19:13:31',50),(1,24,'2018-02-10 00:42:03',10),(19,25,'2018-02-10 00:46:42',15);
/*!40000 ALTER TABLE `atendimentos_creditos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atendimentos_itens`
--

DROP TABLE IF EXISTS `atendimentos_itens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atendimentos_itens` (
  `atendimento` int(11) NOT NULL,
  `item` int(11) NOT NULL AUTO_INCREMENT,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `quantidade` float NOT NULL,
  `valor_unitario` float NOT NULL,
  `chopeira` varchar(45) NOT NULL,
  `chope` varchar(45) NOT NULL,
  `valor_total` float NOT NULL,
  `chope_codigo` int(11) DEFAULT NULL,
  `chopeira_codigo` int(11) DEFAULT NULL,
  PRIMARY KEY (`item`,`atendimento`),
  KEY `fk_atendimentos_itens_atendimentos1_idx` (`atendimento`),
  CONSTRAINT `fk_atendimentos_itens_atendimentos1` FOREIGN KEY (`atendimento`) REFERENCES `atendimentos` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atendimentos_itens`
--

LOCK TABLES `atendimentos_itens` WRITE;
/*!40000 ALTER TABLE `atendimentos_itens` DISABLE KEYS */;
INSERT INTO `atendimentos_itens` VALUES (1,1,'2018-02-08 22:44:44',0.351,30,'Balcão Torneira 1','IPA Agape',10.53,3,2),(1,2,'2018-02-08 22:44:44',0.342,30,'Balcão Torneira 1','IPA Agape',10.26,3,2),(1,3,'2018-02-08 22:44:44',0.35,30,'Balcão Torneira 1','IPA Agape',10.5,3,2),(1,4,'2018-02-08 22:44:44',0.348,30,'Balcão Torneira 1','IPA Agape',10.44,3,2),(1,5,'2018-02-08 22:44:44',0.318,24,'Balcão Torneira 2','Pilsen Agape',7.63,2,3),(1,6,'2018-02-08 22:44:44',0.322,24,'Balcão Torneira 2','Pilsen Agape',7.728,2,3),(1,7,'2018-02-08 22:44:44',0.5,22,'Chopeira Inox 22','Pilsen Hunstrick',11,1,1),(1,8,'2018-02-08 22:44:44',0.342,22,'Chopeira Inox 22','Pilsen Hunstrick',7.524,1,1),(1,9,'2018-02-08 22:44:44',0.342,22,'Chopeira Inox 22','Pilsen Hunstrick',7.524,1,1),(1,10,'2018-02-08 22:44:44',0.342,22,'Chopeira Inox 22','Pilsen Hunstrick',7.524,1,1),(1,11,'2018-02-08 22:44:44',0.1,22,'Chopeira Inox 22','Pilsen Hunstrick',2.2,1,1),(1,12,'2018-02-08 22:44:44',0.5,22,'Chopeira Inox 22','Pilsen Hunstrick',11,1,1),(1,13,'2018-02-08 22:44:44',0.5,22,'Chopeira Inox 22','Pilsen Hunstrick',11,1,1),(1,14,'2018-02-08 22:44:44',0.5,22,'Chopeira Inox 22','Pilsen Hunstrick',11,1,1),(1,15,'2018-02-08 22:44:44',0.5,22,'Chopeira Inox 22','Pilsen Hunstrick',11,1,1);
/*!40000 ALTER TABLE `atendimentos_itens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cartoes`
--

DROP TABLE IF EXISTS `cartoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cartoes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `rfid` varchar(20) NOT NULL,
  `referencia` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `rfid_UNIQUE` (`rfid`),
  UNIQUE KEY `referencia_UNIQUE` (`referencia`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cartoes`
--

LOCK TABLES `cartoes` WRITE;
/*!40000 ALTER TABLE `cartoes` DISABLE KEYS */;
INSERT INTO `cartoes` VALUES (1,'ED 78 03 CA','111'),(2,'AB 12 85 AC','112'),(3,'FE 85 11 DB','113'),(4,'AA 11 ZZ 22','123'),(5,'WW 33 DS 43','2285'),(7,'as dd ss aa',NULL),(8,'aa aa aa aa',NULL),(9,'bb bb bb bb',NULL),(10,'KJUYFYITDFUYF',NULL),(11,'06 89 16 9E',NULL);
/*!40000 ALTER TABLE `cartoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chopeiras`
--

DROP TABLE IF EXISTS `chopeiras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chopeiras` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `chope` int(11) NOT NULL,
  `capacidade` float NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `equipamento` int(11) NOT NULL,
  `quantidade` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`codigo`),
  KEY `fk_chopeiras_chopes_idx` (`chope`),
  KEY `fk_chopeiras_equipamentos_idx` (`equipamento`),
  CONSTRAINT `fk_chopeiras_chopes` FOREIGN KEY (`chope`) REFERENCES `chopes` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_chopeiras_equipamentos` FOREIGN KEY (`equipamento`) REFERENCES `equipamentos` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chopeiras`
--

LOCK TABLES `chopeiras` WRITE;
/*!40000 ALTER TABLE `chopeiras` DISABLE KEYS */;
INSERT INTO `chopeiras` VALUES (1,'Chopeira Inox 22',1,50,1,1,33.654),(2,'Balcão Torneira 1',3,30,1,2,9.547),(3,'Balcão Torneira 2',2,30,1,3,30),(4,'Chopeira Gelo 8',4,10,1,4,0.65),(5,'Chopeira do Miguel',1,30,1,1,30);
/*!40000 ALTER TABLE `chopeiras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chopes`
--

DROP TABLE IF EXISTS `chopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chopes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `valunivenda` float NOT NULL,
  `descricao` text,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chopes`
--

LOCK TABLES `chopes` WRITE;
/*!40000 ALTER TABLE `chopes` DISABLE KEYS */;
INSERT INTO `chopes` VALUES (1,'Pilsen Hunstrick',22,NULL,1),(2,'Pilsen Agape',24,NULL,1),(3,'IPA Agape',30,NULL,1),(4,'Weiss Agape',30,NULL,1),(6,'Strong Golden Ale',21.55,'Cerveja feita na Agape de Erechim/RS por Valmor Bandiera',1),(7,'Bock Agape',19.54,'Cerveja do Valmor de Erechim',1),(8,'Pilsen Imigração',9,'validacao',1);
/*!40000 ALTER TABLE `chopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuracoes`
--

DROP TABLE IF EXISTS `configuracoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracoes` (
  `codigo` int(11) NOT NULL,
  `versao` varchar(45) NOT NULL,
  `dataversao` datetime NOT NULL,
  `modalidade` tinyint(2) NOT NULL,
  `paginacao` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`codigo`),
  KEY `fk_configuracoes_modalidades_atendimentos1_idx` (`modalidade`),
  CONSTRAINT `fk_configuracoes_modalidades_atendimentos1` FOREIGN KEY (`modalidade`) REFERENCES `modalidades_atendimentos` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracoes`
--

LOCK TABLES `configuracoes` WRITE;
/*!40000 ALTER TABLE `configuracoes` DISABLE KEYS */;
INSERT INTO `configuracoes` VALUES (1,'v.1.0dev','2018-02-06 00:00:00',1,10);
/*!40000 ALTER TABLE `configuracoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consumidores`
--

DROP TABLE IF EXISTS `consumidores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consumidores` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(70) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `senha` varchar(30) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL,
  `email` varchar(70) DEFAULT NULL,
  `datahora_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumidores`
--

LOCK TABLES `consumidores` WRITE;
/*!40000 ALTER TABLE `consumidores` DISABLE KEYS */;
INSERT INTO `consumidores` VALUES (1,'Mauricio Witzgall','(51) 98517-1790','009.331.150-83','123',1,'mauwitz@icloud.com','2018-02-09 05:53:24'),(2,'Eloir José Rockenbach','','',NULL,1,'eloirjr@gmail.com','2018-02-07 22:27:49'),(24,'Amigo Do Tito','(54) 98798-7987','',NULL,0,'','2018-02-07 19:50:26'),(25,'Cliente 1','','',NULL,0,'','2018-02-09 02:17:26'),(26,'Cliente 2','','',NULL,0,'','2018-02-09 02:17:30'),(27,'Cliente 3','','',NULL,0,'','2018-02-09 02:17:34'),(28,'Cliente 4','','',NULL,0,'','2018-02-09 02:17:38'),(29,'Cliente 5','','',NULL,0,'','2018-02-09 02:17:42'),(30,'Cliente 6','','',NULL,0,'','2018-02-09 02:17:46'),(31,'Cliente 7','','',NULL,0,'','2018-02-09 02:17:50'),(32,'Cliente 8','','',NULL,0,'','2018-02-09 02:17:56'),(35,'Teste','(51) 11111-1111',NULL,NULL,0,NULL,'2018-02-09 06:50:36'),(36,'Paulinho','(54) 99999-9999','',NULL,0,'','2018-02-09 06:52:08'),(37,'Eloir José','(51) 3564-3685',NULL,NULL,0,NULL,'2018-02-09 13:35:08'),(38,'Thiago Sirio','(51) 99658-6783',NULL,NULL,0,NULL,'2018-02-09 19:13:31'),(39,'Fulano Teste','(51) 98989-8898',NULL,NULL,0,NULL,'2018-02-10 00:46:42');
/*!40000 ALTER TABLE `consumidores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipamentos`
--

DROP TABLE IF EXISTS `equipamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipamentos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `referencia` varchar(45) NOT NULL,
  `nome` varchar(70) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipamentos`
--

LOCK TABLES `equipamentos` WRITE;
/*!40000 ALTER TABLE `equipamentos` DISABLE KEYS */;
INSERT INTO `equipamentos` VALUES (1,'box1','Box 1'),(2,'box2','Box 2'),(3,'box3','Box 3'),(4,'box4','Box 4');
/*!40000 ALTER TABLE `equipamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modalidades_atendimentos`
--

DROP TABLE IF EXISTS `modalidades_atendimentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modalidades_atendimentos` (
  `codigo` tinyint(2) NOT NULL,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modalidades_atendimentos`
--

LOCK TABLES `modalidades_atendimentos` WRITE;
/*!40000 ALTER TABLE `modalidades_atendimentos` DISABLE KEYS */;
INSERT INTO `modalidades_atendimentos` VALUES (1,'Pré-Pago'),(2,'Pós-Pago');
/*!40000 ALTER TABLE `modalidades_atendimentos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-10 10:10:26
