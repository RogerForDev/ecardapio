-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           5.7.24 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela ecardapio.tb_avaliacao
CREATE TABLE IF NOT EXISTS `tb_avaliacao` (
  `id_avaliacao` int(11) NOT NULL,
  `nome` varchar(55) NOT NULL,
  `nota` int(11) NOT NULL,
  `comentario` varchar(255) NOT NULL,
  `id_item` int(11) NOT NULL,
  PRIMARY KEY (`id_avaliacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela ecardapio.tb_avaliacao: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tb_avaliacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_avaliacao` ENABLE KEYS */;

-- Copiando estrutura para tabela ecardapio.tb_categoria
CREATE TABLE IF NOT EXISTS `tb_categoria` (
  `id_categoria` int(11) NOT NULL,
  `nome` varchar(55) NOT NULL,
  `icone` varchar(55) NOT NULL,
  `imagem` varchar(55) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela ecardapio.tb_categoria: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tb_categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_categoria` ENABLE KEYS */;

-- Copiando estrutura para tabela ecardapio.tb_item
CREATE TABLE IF NOT EXISTS `tb_item` (
  `id_item` int(11) NOT NULL,
  `nome` varchar(55) NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `imagem` varchar(55) NOT NULL,
  `id_avaliacao` int(11) NOT NULL,
  `id_cardapio` int(11) NOT NULL,
  PRIMARY KEY (`id_item`),
  KEY `id_cardapio` (`id_cardapio`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_avaliacao` (`id_avaliacao`),
  CONSTRAINT `tb_item_ibfk_1` FOREIGN KEY (`id_cardapio`) REFERENCES `tb_cardapio` (`id_cardapio`),
  CONSTRAINT `tb_item_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categoria` (`id_categoria`),
  CONSTRAINT `tb_item_ibfk_3` FOREIGN KEY (`id_avaliacao`) REFERENCES `tb_avaliacao` (`id_avaliacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela ecardapio.tb_item: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tb_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_item` ENABLE KEYS */;

-- Copiando estrutura para tabela ecardapio.tb_tema
CREATE TABLE IF NOT EXISTS `tb_tema` (
  `id_tema` int(11) NOT NULL,
  `cor_primaria` varchar(55) NOT NULL,
  `cor_secundaria` varchar(55) NOT NULL,
  `fonte` varchar(55) NOT NULL,
  `cor_fonte` varchar(55) NOT NULL,
  `template` int(11) NOT NULL,
  PRIMARY KEY (`id_tema`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela ecardapio.tb_tema: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tb_tema` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_tema` ENABLE KEYS */;

-- Copiando estrutura para tabela ecardapio.tb_usuario
CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(55) NOT NULL,
  `login` varchar(55) NOT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `email` varchar(55) NOT NULL,
  `ativo` tinyint(4) DEFAULT '1',
  `estabelecimento` varchar(55) DEFAULT NULL,
  `horario` varchar(55) DEFAULT NULL,
  `sobre` text,
  `categoria` varchar(55) DEFAULT NULL,
  `cidade` varchar(55) DEFAULT NULL,
  `rua` varchar(55) DEFAULT NULL,
  `bairro` varchar(55) DEFAULT NULL,
  `numero` varchar(55) DEFAULT NULL,
  `telefone` varchar(55) DEFAULT NULL,
  `whatsapp` varchar(55) DEFAULT NULL,
  `facebook` varchar(55) DEFAULT NULL,
  `instagram` varchar(55) DEFAULT NULL,
  `flag_cartao` tinyint(4) DEFAULT NULL,
  `flag_wifi` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela ecardapio.tb_usuario: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `tb_usuario` DISABLE KEYS */;
INSERT INTO `tb_usuario` (`id_usuario`, `nome`, `login`, `senha`, `email`, `ativo`, `estabelecimento`, `horario`, `sobre`, `categoria`, `cidade`, `rua`, `bairro`, `numero`, `telefone`, `whatsapp`, `facebook`, `instagram`, `flag_cartao`, `flag_wifi`) VALUES
	(1, 'Administrador', 'admin', '$2y$12$58zQvfbvUSWYtfL.y5VR7eyvQkX6E7Y3cML91nvIgLzRMTyeFJtQy', 'admin@mail.com', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(11, 'Teste', 'teste', '$2y$12$Qs0O7oDCnv083zaITSEZ..0P48GIjVn6fG7dFnjke7Av0LbpfnA..', 'teste@teste.com', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `tb_usuario` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
