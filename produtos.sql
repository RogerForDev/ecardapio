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

-- Copiando estrutura para tabela ecardapio.tb_produto
CREATE TABLE IF NOT EXISTS `tb_produto` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(99) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `preco` decimal(4,2) NOT NULL DEFAULT '0.00',
  `ativo` int(11) DEFAULT '1',
  PRIMARY KEY (`id_produto`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela ecardapio.tb_produto: ~53 rows (aproximadamente)
/*!40000 ALTER TABLE `tb_produto` DISABLE KEYS */;
INSERT INTO `tb_produto` (`id_produto`, `nome`, `descricao`, `id_categoria`, `imagem`, `preco`, `ativo`) VALUES
	(1, 'X-Salada', 'Hambúrguer - Maionese - Alface - Tomate Milho - Queijo e Presunto - Batata-palha', 1, 'uploads/produto/2020/05/26/15904529895ecc62fd01185/arquivo207209ca59b97766e744782e819e8e2e.jpg', 7.50, 1),
	(2, 'X – EGG', 'Hambúrguer - Maionese - Alface – Tomate - Milho - Queijo e Presunto - Batata-palha – Ovo Frito', 1, 'uploads/produto/2020/05/26/15905107295ecd448904e66/arquivo21fa1227b45a89babcdabb9d4f9c8ea0.png', 8.00, 1),
	(3, 'HOT-DOG PRENSADO', 'Salsicha Defumada - Maionese - Alface - Tomate - Milho - Batata-palha – Catchup', 1, 'uploads/produto/2020/05/26/64c3fa6d31a69abc2b4f530c70026517.jpg', 8.00, 1),
	(4, 'X – BACON', 'Hambúrguer - Maionese - Alface – Tomate Milho - Queijo e Presunto – Bacon - Batata-palha', 1, '', 9.00, 1),
	(5, 'X – CALABRESA', 'Hambúrguer – Maionese - Alface Batata-palha - Tomate - Milho - Queijo e Presunto –Calabresa', 1, '', 9.00, 1),
	(6, 'X – FRANGO', 'Hambúrguer – Filé de Frango - Maionese Alface - Tomate - Milho - Queijo e Presunto', 1, '', 12.00, 1),
	(7, 'X – TUDO', 'Hambúrguer - Maionese - Alface - Tomate Milho - Queijo e Presunto - Batata-palha – Ovo Frito - Calabresa – Bacon', 1, '', 15.00, 1),
	(8, 'Refrigerante Lata', 'Coca Cola – Guaraná Antártica\nFanta Laranja/Uva - Sprite', 2, '', 4.00, 1),
	(9, 'Refrigerante 1 Litro', 'Coca Cola - Guaraná Antártica', 2, '', 6.00, 1),
	(10, 'Refrigerante 1.5 Litros', 'Guaraná Antártica', 2, '', 7.00, 1),
	(11, 'Refrigerante 2 Litros', 'Guaraná Itaubaiana', 2, '', 6.00, 1),
	(12, 'Refrigerante 2 Litros', 'Coca Cola - Guaraná Antártica Sprite – Fanta Laranja', 2, '', 9.00, 1),
	(13, 'Refrigerante 600ml', 'Coca Cola/Sprite/Fanta Laranja/Guarana Antartica', 2, '', 5.00, 1),
	(14, 'Suco Prat’s 330ml', 'Suco de laranja integral', 2, '', 4.50, 1),
	(15, 'Suco Prat’s 990ml', 'Suco de laranja integral', 2, '', 9.50, 1),
	(16, 'Suco Dell Valle Lata', 'Pessego - Maracuja - Uva', 2, '', 4.00, 1),
	(17, 'Suco Tilly 450ml', 'Pessego - Laranja', 2, '', 2.50, 1),
	(18, 'Água sem gás', '', 2, '', 2.00, 1),
	(19, 'Água com gás', '', 2, '', 3.00, 1),
	(20, 'Crepe Suiço de queijo', 'recheio de cubos de queijo mussarela', 3, '', 4.50, 1),
	(21, 'Crepe Suiço de frango', 'recheio de cubos de queijo mussarela e peito frango', 3, '', 4.50, 1),
	(22, 'Crepe Suiço de presunto', 'recheio de cubos de queijo mussarela e presunto', 3, '', 4.50, 1),
	(23, 'Crepe Suiço de salsicha', 'recheio de cubos de queijo mussarela e salsicha', 3, '', 4.50, 1),
	(24, 'Crepe Suiço de bacon', 'recheio de cubos de queijo mussarela e bacon', 3, '', 4.50, 1),
	(25, 'Crepe Suiço de calabresa', 'recheio de cubos de queijo mussarela e linguica calabresa', 3, '', 4.50, 1),
	(26, 'Crepe Suiço de Chocolate branco', 'recheio de chocolate branco', 3, '', 4.50, 1),
	(27, 'Crepe Suiço de Chocolate preto', 'recheio de chocolate ao leite preto', 3, '', 4.50, 1),
	(28, 'Crepe Suiço de Chocolate branco e preto', 'recheio de chocolate ao leite branco e preto', 3, '', 4.50, 1),
	(29, 'Crepe Suiço de Romeu e Julieta', 'recheio de cubos de queijo e goiabada', 3, '', 4.50, 1),
	(30, 'Tapioca de queijo', 'recheio de queijo mussarela', 4, '', 6.00, 1),
	(31, 'Tapioca de calabresa', 'recheio de queijo mussarela e linguiça calabresa desfiada', 4, '', 8.00, 1),
	(32, 'Tapioca de presunto', 'recheio de queijo mussarela e presunto', 4, '', 8.00, 1),
	(33, 'Tapioca de requeijão', 'recheio de queijo mussarela e requeijão', 4, '', 8.00, 1),
	(34, 'Tapioca de bacon', 'recheio de queijo mussarela e bacon', 4, '', 8.00, 1),
	(35, 'Tapioca de manteiga', 'recheio de manteiga', 4, '', 3.00, 1),
	(36, 'Tapioca de frango ', 'recheio de queijo mussarela e frango desfiado e catupiry', 4, '', 9.00, 1),
	(37, 'Tapioca de frango e tomate', 'recheio de queijo mussarela e frango desfiado e tomate', 4, '', 10.00, 1),
	(38, 'Tapioca de pizza', 'recheio de queijo mussarela, presunto, tomate e orégano', 4, '', 10.00, 1),
	(39, 'Tapioca de carne de sol ', 'recheio de queijo mussarela e carne de sol desfiado', 4, '', 12.00, 1),
	(43, 'X- Burguer', 'Hámburguer(carne ou frango) - maionese - queijo e presunto', 1, '', 5.00, 1),
	(44, 'Tapioca chocolate com coco', '', 11, '', 7.50, 1),
	(46, 'Tapioca de chocolate branco', '', 11, '', 7.50, 1),
	(47, 'Tapioca de chocolate preto', '', 11, '', 7.50, 1),
	(48, 'Tapioca de Chocolate com morango', '', 11, '', 10.00, 1),
	(49, 'Tapioca de chocolate branco com preto', '', 11, '', 9.00, 1),
	(50, 'Tapioca de brigadeiro', '', 11, '', 7.00, 1),
	(51, 'Tapioca de doce de leite', '', 11, '', 7.00, 1),
	(52, 'Tapioca de doce de leite com coco', '', 11, '', 7.50, 1),
	(53, 'Tapioca de doce de leite com amendoim', '', 11, '', 8.00, 1),
	(54, 'Tapioca de queijo com goiabada', '', 11, '', 8.00, 1),
	(55, 'Tapioca de leite condensado com coco', '', 11, '', 8.00, 1),
	(56, 'Camadinha 400ml', 'Açaí em camadas de leite ninho com leite condensado', 12, '', 15.00, 1),
	(57, 'Açaí 300ml', 'Açaí puro', 12, '', 8.00, 1),
	(63, 'asasas', 'asasas', 1, 'uploads/produto/2020/05/26/18eaa731540b41a262a912bfc3cd403f.jpg', 0.00, 1),
	(64, 'ccacaca', 'cacac', 1, 'uploads/produto/2020/05/26/e4ee86a26ac107a4e580535ddc5f3260.jpg', 0.00, 1);
/*!40000 ALTER TABLE `tb_produto` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
