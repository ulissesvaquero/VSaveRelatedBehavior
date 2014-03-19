# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.15)
# Database: vrelatedBh
# Generation Time: 2014-03-19 22:21:38 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table cor_cabelo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cor_cabelo`;

CREATE TABLE `cor_cabelo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cor_cabelo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `cor_cabelo` WRITE;
/*!40000 ALTER TABLE `cor_cabelo` DISABLE KEYS */;

INSERT INTO `cor_cabelo` (`id`, `cor_cabelo`)
VALUES
	(1,'Preto'),
	(2,'Amarelo'),
	(3,'Vermelho');

/*!40000 ALTER TABLE `cor_cabelo` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table filho
# ------------------------------------------------------------

DROP TABLE IF EXISTS `filho`;

CREATE TABLE `filho` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `id_pessoa` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_filho_pessoa1_idx` (`id_pessoa`),
  CONSTRAINT `fk_filho_pessoa1` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pessoa
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pessoa`;

CREATE TABLE `pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `id_cor_cabelo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pessoa_cor_cabelo_idx` (`id_cor_cabelo`),
  CONSTRAINT `fk_pessoa_cor_cabelo` FOREIGN KEY (`id_cor_cabelo`) REFERENCES `cor_cabelo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table qualidade
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qualidade`;

CREATE TABLE `qualidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qualidade` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qualidade` WRITE;
/*!40000 ALTER TABLE `qualidade` DISABLE KEYS */;

INSERT INTO `qualidade` (`id`, `qualidade`)
VALUES
	(1,'Bonito'),
	(2,'Inteligente'),
	(3,'Alto'),
	(4,'Forte'),
	(5,'Magro');

/*!40000 ALTER TABLE `qualidade` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qualidade_pessoa
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qualidade_pessoa`;

CREATE TABLE `qualidade_pessoa` (
  `id_qualidade` int(11) NOT NULL,
  `id_pessoa` int(11) NOT NULL,
  PRIMARY KEY (`id_qualidade`,`id_pessoa`),
  KEY `fk_qualidade_has_pessoa_pessoa1_idx` (`id_pessoa`),
  KEY `fk_qualidade_has_pessoa_qualidade1_idx` (`id_qualidade`),
  CONSTRAINT `fk_qualidade_has_pessoa_qualidade1` FOREIGN KEY (`id_qualidade`) REFERENCES `qualidade` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_qualidade_has_pessoa_pessoa1` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
