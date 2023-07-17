-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/07/2023 às 16:17
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sipam_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `borrowers`
--

CREATE TABLE `borrowers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `organization_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `borrowers`
--

INSERT INTO `borrowers` (`id`, `name`, `email`, `phone`, `organization_id`) VALUES
(1, 'Zezim Joinha', 'joinha@gmail.com', '9199667754', 1),
(9, 'João Divino', 'divino@doceu.com', '73645272982', 2),
(10, 'Zé Mané', 'ze@doceu.com', '56784567456', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `borrow_log`
--

CREATE TABLE `borrow_log` (
  `id` int(11) NOT NULL,
  `borrower_id` int(11) DEFAULT NULL,
  `equipment_id` int(11) DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `process_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `borrow_log`
--

INSERT INTO `borrow_log` (`id`, `borrower_id`, `equipment_id`, `borrow_date`, `return_date`, `status_id`, `process_number`) VALUES
(1, 1, 13, '2023-06-12', '2023-06-30', 1, '11111111111');

-- --------------------------------------------------------

--
-- Estrutura para tabela `components`
--

CREATE TABLE `components` (
  `id` int(11) NOT NULL,
  `equipment_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `description`, `category`, `serial_number`, `status_id`) VALUES
(13, 'DRONE', 'Equipamento de filmagem aérea', 'FOTOREGISTRO', '12222111122', 1),
(14, 'MALA 001', 'ANTENA', 'TELECOM', NULL, NULL),
(15, 'Equipamento n2', 'n2', 'drone', NULL, NULL),
(16, 'jj', 'jj', 'jjj', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `organization`
--

CREATE TABLE `organization` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `acronym` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `organization`
--

INSERT INTO `organization` (`id`, `name`, `acronym`) VALUES
(0, 'Núcleo do 2º Batalhão de Comunicações e Guerra Eletrônica de Selva                              ', '2º Bcom'),
(1, 'ACME CORPORATION', 'AAA'),
(2, 'Instituto Chico Mendes de Biodiversidade', 'ICM Bio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `status_lookup`
--

CREATE TABLE `status_lookup` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `status_lookup`
--

INSERT INTO `status_lookup` (`id`, `status`) VALUES
(1, 'emprestado'),
(2, 'disponivel');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Frederico dos Santos', 'frederico.santos@sipam.gov.br', 'abc', '2023-06-23 12:53:50');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `borrowers`
--
ALTER TABLE `borrowers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Índices de tabela `borrow_log`
--
ALTER TABLE `borrow_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_borrower_id` (`borrower_id`),
  ADD KEY `fk_equipment_id` (`equipment_id`),
  ADD KEY `fk_status_id` (`status_id`);

--
-- Índices de tabela `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_id` (`equipment_id`);

--
-- Índices de tabela `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_equipment_status_id` (`status_id`);

--
-- Índices de tabela `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `status_lookup`
--
ALTER TABLE `status_lookup`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `borrowers`
--
ALTER TABLE `borrowers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `borrow_log`
--
ALTER TABLE `borrow_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `components`
--
ALTER TABLE `components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `status_lookup`
--
ALTER TABLE `status_lookup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `borrowers`
--
ALTER TABLE `borrowers`
  ADD CONSTRAINT `borrowers_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`);

--
-- Restrições para tabelas `borrow_log`
--
ALTER TABLE `borrow_log`
  ADD CONSTRAINT `fk_borrower_id` FOREIGN KEY (`borrower_id`) REFERENCES `borrowers` (`id`),
  ADD CONSTRAINT `fk_equipment_id` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`),
  ADD CONSTRAINT `fk_status_id` FOREIGN KEY (`status_id`) REFERENCES `status_lookup` (`id`);

--
-- Restrições para tabelas `components`
--
ALTER TABLE `components`
  ADD CONSTRAINT `components_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`);

--
-- Restrições para tabelas `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `fk_equipment_status_id` FOREIGN KEY (`status_id`) REFERENCES `status_lookup` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
