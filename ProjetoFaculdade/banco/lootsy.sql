-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/11/2025 às 16:52
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
(1, 'Administrador Do Lootsy', '13006464787', 'Masculino', 'rua engenheiro alberto rocha , 348 , vila da penha', '21220420', 'Admin12@gmail.com', '21998802757', 'Admin12@gmail.com', '12345678', '2002-01-09', 'Mãe Do Admin', '2025-11-08 14:51:12', 'master');

-- --------------------------------------------------------

--
-- Estrutura para tabela `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `data_login` datetime NOT NULL DEFAULT current_timestamp(),
  `segunda_autenticacao` varchar(100) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `log`
--

INSERT INTO `log` (`id_log`, `data_login`, `segunda_autenticacao`, `id_usuario`) VALUES
(1, '2025-11-08 00:00:00', 'Mãe Do Admin', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cadastro`
--
ALTER TABLE `cadastro`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`logins`);

--
-- Índices de tabela `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastro`
--
ALTER TABLE `cadastro`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `cadastro` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
