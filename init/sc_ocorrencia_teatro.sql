-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23-Jan-2025 às 14:37
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bartira_novo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_ocorrencia_teatro`
--

CREATE TABLE `sc_ocorrencia_teatro` (
  `idOcorrencia` int(8) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `linguagem` int(11) NOT NULL,
  `tipo_evento` int(11) NOT NULL,
  `nomeResponsavel` int(11) NOT NULL,
  `suplente` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `local` int(3) DEFAULT NULL,
  `segunda` int(1) DEFAULT NULL,
  `terca` int(1) DEFAULT NULL,
  `quarta` int(1) DEFAULT NULL,
  `quinta` int(1) DEFAULT NULL,
  `sexta` int(1) DEFAULT NULL,
  `sabado` int(1) DEFAULT NULL,
  `domingo` int(1) DEFAULT NULL,
  `dataInicio` date DEFAULT NULL,
  `dataFinal` date DEFAULT NULL,
  `horaInicio` time DEFAULT NULL,
  `horaFinal` time DEFAULT NULL,
  `duracao` int(4) DEFAULT NULL,
  `publicado` int(1) DEFAULT NULL,
  `observacao` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `sc_ocorrencia_teatro`
--
ALTER TABLE `sc_ocorrencia_teatro`
  ADD PRIMARY KEY (`idOcorrencia`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `sc_ocorrencia_teatro`
--
ALTER TABLE `sc_ocorrencia_teatro`
  MODIFY `idOcorrencia` int(8) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
