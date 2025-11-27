-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/11/2025 às 06:48
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lootsy`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro`
--

CREATE TABLE `cadastro` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` char(11) NOT NULL,
  `sexo` enum('Masculino','Feminino','Outro') NOT NULL,
  `endereco` text NOT NULL,
  `cep` char(9) NOT NULL,
  `email` varchar(80) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `logins` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `nome_materno` varchar(60) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `tipo` enum('comum','master') DEFAULT 'comum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cadastro`
--

INSERT INTO `cadastro` (`id_usuario`, `nome`, `cpf`, `sexo`, `endereco`, `cep`, `email`, `celular`, `logins`, `senha`, `data_nascimento`, `nome_materno`, `data_cadastro`, `tipo`) VALUES
(1, 'Administrador Do Lootsy', '13006464787', 'Masculino', 'rua engenheiro alberto rocha , 348 , vila da penha', '21220420', 'Admin10@gmail.com', '21998802757', 'Admin12@gmail.com', '12345678', '2002-01-09', 'Mãe Do Admin', '2025-11-08 14:51:12', 'master'),
(2, 'isabella da conceição honorio', '18830593728', 'Feminino', 'Avenida Sargento de Milícias, Pavuna, Rio de Janeiro - RJ', '21532-290', 'isabellahonorio123@gmail.com', '21971184658', 'iscrvg', '$2y$10$wWLdWwz5v/aFqPXZGlXsnO5o0keEbwm03N2diy0c74mIZN9dg626q', '2003-09-25', 'luciana da conceição', '2025-11-25 23:46:40', 'comum'),
(4, 'Maria Rita', '20625167708', 'Feminino', 'Rua Carmela Dutra, Bonsucesso, Rio de Janeiro - RJ', '21043160', 'mariaritabarros83@gmail.com', '21985080932', 'Mariaa', '$2y$10$9N4v7F4q3kXeARpngdzayOX.IXSdmth1ZKQqx1qUWOZPSa1fkOzx6', '2000-07-31', 'Maiara Barros', '2025-11-26 19:45:16', 'comum'),
(5, 'carol souza', '', 'Masculino', '', '', 'carol@gmail.com', '', '', '$2y$10$BbusjFrVJajGU.uTIANKGefoqZ8muO2tovTdriUrRYh3kf5DTJtdi', '1997-02-10', '', '2025-11-26 21:19:50', 'comum'),
(10, 'Raissa Oliveira', '20627898808', 'Feminino', 'Rua Carmela Dutra, Bonsucesso, Rio de Janeiro - RJ', '21043160', 'raissa01@gmail.com', '21093209088', 'Raissa', '$2y$10$wpa3OqDNAT0/.8t2vHHaSOJfrc3ToY9mHTt.BReV2xN2y21h5ddh2', '2010-09-30', 'Luiza Oliveira', '2025-11-27 00:48:39', 'comum');

-- --------------------------------------------------------

--
-- Estrutura para tabela `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `data_login` datetime DEFAULT current_timestamp(),
  `segunda_autenticacao` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `log`
--

INSERT INTO `log` (`id_log`, `cpf`, `data_login`, `segunda_autenticacao`, `status`, `ip`) VALUES
(1, '13006464787', '2025-11-25 20:46:53', 'Pergunta teste 2FA', 'sucesso', '127.0.0.1'),
(2, '13006464787', '2025-11-25 20:48:32', 'Pergunta teste 2FA', 'sucesso', '127.0.0.1'),
(4, '18830593728', '2025-11-26 00:25:47', 'Teste manual', 'sucesso', '127.0.0.1'),
(5, '18830593728', '2025-11-26 06:26:52', 'Login normal (sem 2FA)', 'sucesso', '::1'),
(6, '18830593728', '2025-11-26 06:44:35', 'Login normal (sem 2FA)', 'sucesso', '::1'),
(7, '18830593728', '2025-11-26 06:45:02', 'Login normal (sem 2FA)', 'sucesso', '::1'),
(8, '18830593728', '2025-11-26 06:50:17', 'Login normal (sem 2FA)', 'sucesso', '::1'),
(9, '18830593728', '2025-11-26 06:56:07', 'Login normal (sem 2FA)', 'sucesso', '::1'),
(10, '20625167708', '2025-11-26 19:45:23', 'Login normal (sem 2FA)', 'sucesso', '::1'),
(11, '20625167708', '2025-11-26 19:56:03', 'Login normal (sem 2FA)', 'sucesso', '::1'),
(12, '20625167708', '2025-11-26 20:33:51', 'Login normal (sem 2FA)', 'sucesso', '::1'),
(13, '20625167708', '2025-11-26 21:36:54', 'Login normal (sem 2FA)', 'sucesso', '::1'),
(15, '20625167708', '2025-11-26 21:49:41', 'Login normal (sem 2FA)', 'sucesso', '::1'),
(17, '20625167708', '2025-11-26 21:52:22', 'Login normal (sem 2FA)', 'sucesso', '::1'),
(18, '20627898808', '2025-11-27 00:48:57', 'Login normal (sem 2FA)', 'sucesso', '::1');

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_log`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_log` (
`id_log` int(11)
,`cpf` varchar(14)
,`nome_usuario` varchar(100)
,`data_login` datetime
,`segunda_autenticacao` varchar(255)
,`status` varchar(20)
,`ip` varchar(45)
);

-- --------------------------------------------------------

--
-- Estrutura para view `vw_log`
--
DROP TABLE IF EXISTS `vw_log`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_log`  AS SELECT `l`.`id_log` AS `id_log`, `l`.`cpf` AS `cpf`, `c`.`nome` AS `nome_usuario`, `l`.`data_login` AS `data_login`, `l`.`segunda_autenticacao` AS `segunda_autenticacao`, `l`.`status` AS `status`, `l`.`ip` AS `ip` FROM (`log` `l` left join `cadastro` `c` on(`l`.`cpf` = `c`.`cpf`)) ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cadastro`
--
ALTER TABLE `cadastro`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `log_ibfk_1` (`cpf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastro`
--
ALTER TABLE `cadastro`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`cpf`) REFERENCES `cadastro` (`cpf`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
