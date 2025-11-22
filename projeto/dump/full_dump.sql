-- Full MySQL dump for Modex project
-- Generated: 2025-11-22 00:00:00

-- Create and select the database so this script can be run directly
CREATE DATABASE IF NOT EXISTS `modexdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `modexdb`;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `pedidos`;
DROP TABLE IF EXISTS `avaliacoes`;
DROP TABLE IF EXISTS `produtos`;
DROP TABLE IF EXISTS `enderecos`;
DROP TABLE IF EXISTS `categorias`;
DROP TABLE IF EXISTS `usuarios`;

-- Table structure for table `usuarios`
CREATE TABLE `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `perfil` VARCHAR(50) NOT NULL DEFAULT 'User',
  `email` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `categorias`
CREATE TABLE `categorias` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `categoria` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `produtos`
CREATE TABLE `produtos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(100) NOT NULL,
  `nome` VARCHAR(255) NOT NULL,
  `descricao` TEXT,
  `preco` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `categoria_id` INT DEFAULT NULL,
  `imagem` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_categoria` (`categoria_id`),
  CONSTRAINT `fk_produtos_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `avaliacoes`
CREATE TABLE `avaliacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `produto_id` INT NOT NULL,
  `usuario_id` INT DEFAULT NULL,
  `nota` TINYINT NOT NULL DEFAULT 0,
  `comentario` TEXT,
  `data_registro` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_av_produto` (`produto_id`),
  KEY `idx_av_usuario` (`usuario_id`),
  CONSTRAINT `fk_avaliacoes_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_avaliacoes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `enderecos`
CREATE TABLE `enderecos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `rua` VARCHAR(255) NOT NULL,
  `numero` VARCHAR(50) NOT NULL,
  `complemento` VARCHAR(255) DEFAULT NULL,
  `cidade` VARCHAR(255) NOT NULL,
  `estado` VARCHAR(100) NOT NULL,
  `cep` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_end_usuario` (`usuario_id`),
  CONSTRAINT `fk_enderecos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `pedidos`
CREATE TABLE `pedidos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `produto_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  `endereco_id` INT DEFAULT NULL,
  `quantidade` INT NOT NULL DEFAULT 1,
  `total` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `data_registro` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ped_produto` (`produto_id`),
  KEY `idx_ped_endereco` (`endereco_id`),
  KEY `idx_ped_usuario` (`usuario_id`),
  CONSTRAINT `fk_pedidos_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
  ,CONSTRAINT `fk_pedidos_endereco` FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample data
-- usuarios: password hashes are examples (replace passwords as needed)
INSERT INTO `usuarios` (`nome`, `perfil`, `email`, `senha`) VALUES
('Admin', 'Admin', 'modex@admin.com', '$2y$10$p1Yx/EDD4Fkdiq0MmKg0huyQP8zId1MfdJwbT375WWbL34tW896uu'),
('Cliente Exemplo', 'User', 'cliente@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- categorias
INSERT INTO `categorias` (`categoria`) VALUES
('Vestuário'),
('Acessórios');

-- produtos
INSERT INTO `produtos` (`tipo`,`nome`,`descricao`,`preco`,`categoria_id`,`imagem`) VALUES
('Vestuário','Camiseta Básica','Camiseta 100% algodão, corte reto.',49.90,1,'camiseta-baby-look.png'),
('Vestuário','Camiseta Oversized','Camiseta de modelagem oversized.',69.90,1,'camiseta-oversized.png'),
('Vestuário','Calça Slim','Calça slim fit, tecido confortável.',129.90,1,'calca-slim.png');

-- avaliacoes (exemplo)
INSERT INTO `avaliacoes` (`produto_id`,`usuario_id`,`nota`,`comentario`,`data_registro`) VALUES
(1, 2, 4, 'Boa qualidade. Recomendo.', NOW()),
(2, 2, 5, 'Perfeita no caimento.', NOW());

-- enderecos (exemplo)
INSERT INTO `enderecos` (`usuario_id`,`rua`,`numero`,`complemento`,`cidade`,`estado`,`cep`) VALUES
(2,'Rua Exemplo','123','','Cidade Exemplo','SP','01234-567');

-- pedidos (exemplo)
INSERT INTO `pedidos` (`produto_id`,`usuario_id`,`endereco_id`,`quantidade`,`total`,`data_registro`) VALUES
(1, 2, 1, 2, 99.80, NOW());

SET FOREIGN_KEY_CHECKS = 1;
