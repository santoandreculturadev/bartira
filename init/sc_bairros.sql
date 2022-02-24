-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Fev-2022 às 21:03
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
-- Banco de dados: `santoandre`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `sc_bairros`
--

CREATE TABLE `sc_bairros` (
  `id_tipo` int(7) NOT NULL,
  `tipo` varchar(77) DEFAULT NULL,
  `descricao` varchar(32) DEFAULT NULL,
  `abreviatura` varchar(11) DEFAULT NULL,
  `publicado` varchar(9) DEFAULT NULL,
  `ano_base` varchar(8) DEFAULT NULL,
  `bairro` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sc_bairros`
--

INSERT INTO `sc_bairros` (`id_tipo`, `tipo`, `descricao`, `abreviatura`, `publicado`, `ano_base`, `bairro`) VALUES
(202, 'Museu de Santo André Dr. Octaviano Armando  Gaiarsa', '{\"mapas\":\"3\"}', 'local', '1', '', 'Centro'),
(203, 'Casa do Olhar Luiz Sacilotto', '{\"mapas\":\"5\"}', 'local', '1', '', 'Centro'),
(204, 'ELD - Centro de Dança de Santo André', '{\"mapas\":\"6\"}', 'local', '1', '', 'Jardim Bela Vista'),
(205, 'Emia Aron Feldman - Escola Municipal de Iniciação Artística', '{\"mapas\":\"226\"}', 'local', '1', '', 'Vila Curuca'),
(206, 'ELCV - Escola Livre de Cinema e Vídeo', '{\"mapas\":\"8\"}', 'local', '1', '', 'Vila Metalurgica'),
(207, 'Teatro Conchita de Moraes', '{\"mapas\":\"9\"}', 'local', '1', '', 'Santa Teresinha'),
(208, 'Espaço Permanente do Acervo de Arte Contemporânea de Santo André - Pinacoteca', '{\"mapas\":\"10\"}', 'local', '1', '', 'Centro'),
(209, 'Salão de Exposições', '{\"mapas\":\"11\"}', 'local', '1', '', 'Centro'),
(210, 'Teatro Municipal de Santo André Maestro Flavio Florence', '{\"mapas\":\"12\"}', 'local', '1', '', 'Centro'),
(211, 'Saguão do Teatro Municipal de Santo André', '{\"mapas\":\"13\"}', 'local', '1', '', 'Centro'),
(212, 'Auditório Heleny Guariba', '{\"mapas\":\"14\"}', 'local', '1', '', 'Centro'),
(213, 'Concha Acústica da Praça do Carmo', '{\"mapas\":\"15\"}', 'local', '1', '', 'Centro'),
(214, 'Feira de Artesanato - Paço Municipal', '{\"mapas\":\"16\"}', 'local', '1', '', 'Centro'),
(215, 'Feira de Artesanato - Rua Cesário Mota', '{\"mapas\":\"17\"}', 'local', '1', '', 'Centro'),
(216, 'Feira de Artesanato - Praça do Carmo', '{\"mapas\":\"18\"}', 'local', '1', '', 'Centro'),
(217, 'Feira de Artesanato - Ipiranguinha', '{\"mapas\":\"19\"}', 'local', '1', '', 'Vila Alzira'),
(218, 'Feira de Artesanato - Jaçatuba', '{\"mapas\":\"20\"}', 'local', '1', '', 'Parque Jaçatuba'),
(219, 'Biblioteca Nair Lacerda', '{\"mapas\":\"21\",\"estado\":\"1689\"}', 'local', '1', '', 'Centro'),
(220, 'Biblioteca Distrital Cecília Meireles', '{\"mapas\":\"22\",\"estado\":\"1644\"}', 'local', '1', '', 'Parque das Nações'),
(221, 'Biblioteca Cata Preta', '{\"mapas\":\"23\",\"estado\":\"115\"}', 'local', '1', '', 'Vila João Ramalho'),
(222, 'Biblioteca Parque Erasmo', '{\"mapas\":\"24\",\"estado\":\"erasmo\"}', 'local', '1', '', 'Parque Erasmo Assunção'),
(223, 'Biblioteca Praça Internacional', '{\"mapas\":\"25\",\"estado\":\"1579\"}', 'local', '1', '', 'Parque Novo Oratório'),
(224, 'Biblioteca Vila Humaitá', '{\"mapas\":\"27\"}', 'local', '1', '', 'Vila Humaitá'),
(225, 'Biblioteca de Paranapiacaba Ábia Ferreira Francisco', '{\"mapas\":\"28\",\"estado\":\"1114\"}', 'local', '1', '', 'Paranapiacaba'),
(226, 'Biblioteca Vila Floresta', '{\"mapas\":\"30\",\"estado\":\"1583\"}', 'local', '1', '', 'Vila Floresta'),
(227, 'Biblioteca Vila Linda', '{\"mapas\":\"31\",\"estado\":\"1586\"}', 'local', '1', '', 'Vila Linda'),
(228, 'Biblioteca Vila Palmares', '{\"mapas\":\"32\",\"estado\":\"1589\"}', 'local', '1', '', 'Vila Palmares'),
(229, 'Espaço Infantil (Biblioteca Nair Lacerda)', '{\"mapas\":\"35\"}', 'local', '1', '', 'Centro'),
(230, 'Espaço dos Escritores da Região', '{\"mapas\":\"36\"}', 'local', '1', '', 'Centro'),
(231, 'Espaço Permanente de Fotografia João Colovatti', '{\"mapas\":\"37\"}', 'local', '1', '', 'Centro'),
(232, 'Espaço Reflexos', '{\"mapas\":\"38\"}', 'local', '1', '', 'Centro'),
(233, 'Gibiteca Municipal', '{\"mapas\":\"39\"}', 'local', '1', '', 'Centro'),
(234, 'Salão Nobre Burle Marx', '{\"mapas\":\"41\"}', 'local', '1', '', 'Centro'),
(235, 'Palco do Saguão do Teatro Municipal de Santo André', '{\"mapas\":\"46\"}', 'local', '1', '', 'Centro'),
(236, 'Biblioteca do Museu de Santo André', '{\"mapas\":\"48\"}', 'local', '1', '', 'Centro'),
(237, 'Palco do Parque Central', '{\"mapas\":\"50\"}', 'local', '1', '', 'Vila Assunção'),
(238, 'Palco do Parque da Juventude', '{\"mapas\":\"51\"}', 'local', '1', '', 'Jardim Ipanema'),
(239, 'Espaço da Cantina do Parque Pref. Celso Daniel', '{\"mapas\":\"52\"}', 'local', '1', '', 'Jardim'),
(240, 'Coreto da Chácara Pignatari', '{\"mapas\":\"53\"}', 'local', '1', '', 'Vila Metalúrgica'),
(241, 'Palco da SEDE DA BANDA LIRA, Parque Ipiranguinha', '{\"mapas\":\"54\"}', 'local', '1', '', 'Vila Alzira'),
(242, 'Calçadão da Oliveira Lima', '{\"mapas\":\"55\"}', 'local', '1', '', 'Centro'),
(243, 'Calçadão da Rua Eliza Fláquer', '{\"mapas\":\"56\"}', 'local', '1', '', 'Centro'),
(244, 'Travessa Diana', '{\"mapas\":\"57\"}', 'local', '1', '', 'Centro'),
(245, 'Estacionamento do Paço Municipal de Santo André', '{\"mapas\":\"58\"}', 'local', '1', '', 'Centro'),
(246, 'Parlatório do Paço Municipal de Santo André', '{\"mapas\":\"60\"}', 'local', '1', '', 'Centro'),
(247, 'Vila de Paranapiacaba', '{\"mapas\":\"65\"}', 'local', '1', '', 'Paranapiacaba'),
(248, 'Praça do Antigo Mercado', '{\"mapas\":\"66\"}', 'local', '1', '', 'Paranapiacaba'),
(249, 'Largo dos Padeiros', '{\"mapas\":\"67\"}', 'local', '1', '', 'Paranapiacaba'),
(250, 'Bar do Campo', '{\"mapas\":\"68\"}', 'local', '1', '', 'Paranapiacaba'),
(251, 'Clube União Lyra Serrano', '{\"mapas\":\"71\"}', 'local', '1', '', 'Paranapiacaba'),
(252, 'Sala Especial do Museu de Santo André', '{\"mapas\":\"73\"}', 'local', '1', '', 'Centro'),
(253, 'BIBLIOTECA DO CENTRO DE DANÇA - BCD', '{\"mapas\":\"75\"}', 'local', '1', '', 'Jardim Bela Vista'),
(254, 'Estação Prefeito Celso Daniel', '{\"mapas\":\"76\"}', 'local', '1', '', 'Centro'),
(255, 'Figueira  Ficus macrophilla Desfontaines ex persoon\"', '{\"mapas\":\"79\"}', 'local', '1', '', 'Jardim'),
(256, 'Residência de Bernardino Queiroz dos Santos  Casa do Olhar Luiz Sacilotto', '{\"mapas\":\"80\"}', 'local', '1', '', 'Centro'),
(257, 'Residência de Dona Paulina Isabel de Queiroz  Casa da Palavra Mário Quintana', '{\"mapas\":\"81\"}', 'local', '1', '', 'Centro'),
(258, 'Biblioteca Vila Sá', '{\"mapas\":\"84\",\"estado\":\"1591\"}', 'local', '1', '', 'Utinga'),
(259, 'CESA Vila Humaitá - Sala Multiuso', '{\"mapas\":\"90\",\"estado\":\"1584\"}', 'local', '1', '', 'Vila Humaitá'),
(260, 'CESA Vila Floresta - Sala Multiuso', '{\"mapas\":\"91\"}', 'local', '1', '', 'Vila Floresta'),
(261, 'CESA Cata Preta - Sala Multiuso', '{\"mapas\":\"92\"}', 'local', '1', '', 'Vila João Ramalho'),
(262, 'CESA Jardim Santo André - Sala Multiuso', '{\"mapas\":\"93\"}', 'local', '1', '', 'Jardim Santo André'),
(263, 'CESA Jardim Santo Alberto - Sala Multiuso', '{\"mapas\":\"94\"}', 'local', '1', '', 'Jardim Santo Alberto'),
(264, 'CESA Parque Andreense - Sala Multiuso', '{\"mapas\":\"98\"}', 'local', '1', '', 'Parque Andreense'),
(265, 'CESA Vila Sá - Sala Multiuso', '{\"mapas\":\"99\"}', 'local', '1', '', 'Utinga'),
(266, 'CESA Parque Erasmo - Sala Multiuso', '{\"mapas\":\"101\"}', 'local', '1', '', 'Parque Erasmo Assunção'),
(267, 'CESA Parque Novo Oratório - Sala Multiuso', '{\"mapas\":\"102\"}', 'local', '1', '', 'Parque Oratório'),
(268, 'Associação dos Moradores Jardim Ana Maria - Sala Multiuso', '{\"mapas\":\"103\"}', 'local', '1', '', 'Jardim Ana Maria'),
(269, 'Feira Livre do Vinil - FIP 2016', '{\"mapas\":\"104\"}', 'local', '1', '', 'Centro'),
(270, 'Biblioteca Santo Alberto', '{\"mapas\":\"105\",\"estado\":\"1581\"}', 'local', '1', '', 'Jardim Santo Alberto'),
(271, 'CEU das Artes Jd. Marek', '{\"mapas\":\"109\"}', 'local', '1', '', 'Jardim Marek'),
(272, 'Sala de Reuniões da SCT', '{\"mapas\":\"112\"}', 'local', '1', '', 'Centro'),
(273, 'Cine-Theatro de Variedades Carlos Gomes', '{\"mapas\":\"117\"}', 'local', '1', '', 'Centro'),
(274, 'Casa da Palavra Mário Quintana', '{\"mapas\":\"135\"}', 'local', '1', '', 'Centro'),
(275, 'Parque Prefeito Celso Daniel', '{\"mapas\":\"136\"}', 'local', '1', '', 'Jardim'),
(276, 'PARQUE JAÇATUBA - PARQUE REGIONAL DA CRIANÇA PALHAÇO ESTREMILIQUE', '{\"mapas\":\"137\"}', 'local', '1', '', 'Parque Jaçatuba'),
(277, 'CHÁCARA PIGNATARI - Parque Regional Prof. Antônio Pezzolo', '{\"mapas\":\"138\"}', 'local', '1', '', 'Vila Metalúrgica'),
(278, 'Biblioteca CEU MAREK', '{\"mapas\":\"142\"}', 'local', '1', '', 'Jardim Marek'),
(279, 'Departamento de Cultura', '{\"mapas\":\"145\"}', 'local', '1', '', 'Centro'),
(280, 'BRINQUEDOTECA', '{\"mapas\":\"146\"}', 'local', '1', '', 'Vila Metalúrgica'),
(281, 'LUDOTECA', '{\"mapas\":\"148\"}', 'local', '1', '', 'Jardim'),
(282, 'Casa Fox (Casa da Memória)', '{\"mapas\":\"163\"}', 'local', '1', '', 'Paranapiacaba'),
(283, 'ELT - ESCOLA LIVRE DE TEATRO', '{\"mapas\":\"170\"}', 'local', '1', '', 'Santa Teresinha'),
(284, 'GINÁSIO NOÊMIA ASSUNÇÃO', '{\"mapas\":\"184\"}', 'local', '1', '', 'Jardim Santo Antônio'),
(285, 'Biblioteca Vila Floresta', '{\"mapas\":\"30\",\"estado\":\"1583\"}', 'local', '1', '', 'Vila Floresta'),
(398, 'Parque Natural Municipal do Pedroso\n', '{\"mapas\":\"204\"}\n', 'local', '1', '', 'Parque Miami'),
(401, 'Parque da Juventude Ana Maria Brandão\n', '{\"mapas\":\"205\"}\n', 'local', '1', '', 'Jardim Ipanema'),
(542, 'Rua Cuiabá\n', '{\"mapas\":\"214\"}\n', 'local', '1', '', 'Vila Alzira'),
(550, 'Plataforma Expresso Turístico', '{\"mapas\":\"234\"}', 'local', '1', '', 'Paranapiacaba'),
(551, 'Rua Campo Salles', '{\"mapas\":\"235\"}', 'local', '1', '', 'Centro'),
(552, 'Alambrado Rua Schnoor', '{\"mapas\":\"237\"}', 'local', '1', '', 'Paranapiacaba'),
(553, 'Palco Rua Fox', '{\"mapas\":\"238\"}', 'local', '1', '', 'Paranapiacaba'),
(554, 'Escola Estadual Senador Lacerda Franco', '{\"mapas\":\"177\"}', 'local', '1', '', 'Paranapiacaba'),
(555, 'Igreja Bom Jesus de Paranapiacaba', '{\"mapas\":\"239\"}', 'local', '1', '', 'Paranapiacaba'),
(556, 'Palco Rua Direita', '{\"mapas\":\"241\"}', 'local', '1', '', 'Paranapiacaba'),
(557, 'Palco Mercado', '{\"mapas\":\"242\"}', 'local', '1', '', 'Paranapiacaba'),
(558, 'Rua da Estação (Pau da Missa)', '{\"mapas\":\"243\"}', 'local', '1', '', 'Paranapiacaba'),
(559, 'Centro de Informações Turísticas (CIT)', '{\"mapas\":\"240\"}', 'local', '1', '', 'Paranapiacaba'),
(560, 'Espaço Locobreque', '{\"mapas\":\"244\"}', 'local', '1', '', 'Paranapiacaba'),
(565, 'Coreto / Espaço Externo do Clube ULS', '{\"mapas\":\"248\"}', 'local', '1', '', 'Paranapiacaba'),
(566, 'Parte Alta - Estacionamento (Paranapiacaba)', '{\"mapas\":\"249\"}', 'local', '1', '', 'Paranapiacaba'),
(567, 'Campus UFABC Santo André', '{\"mapas\":\"62\"}', 'local', '1', '', 'Bangú'),
(695, 'Espelho d\'água do Paço Municipal de Santo André', '{\"mapas\":\"59\"}', 'local', '1', '', 'Centro'),
(696, 'CESA Vila Linda - Sala Multiuso', '{\"mapas\":\"96\"}', 'local', '1', '', 'Jardim Alvorada'),
(697, 'Parque Ipiranguinha', '{\"mapas\":\"174\"}', 'local', '1', '', 'Vila Alzira'),
(698, 'PARQUE ESCOLA', '{\"mapas\":\"182\"}', 'local', '1', '', 'Vila Valparaíso'),
(701, 'Casa Da Lagartixa Preta', '{\"mapas\":\"255\"}', 'local', '1', '', 'Casa Branca'),
(702, 'Casamira', '{\"mapas\":\"203\"}', 'local', '1', '', 'Vila Assunção'),
(703, 'Outros', '{\"mapas\":\"\"}', 'local', '1', '', ''),
(705, 'CESA Jardim Irene - Sala Multiuso', '{\"mapas\":\"218\"}', 'local', '1', '', 'Jardim Irene'),
(706, 'Rua Galileia altura do 211', '{\"mapas\":\"261\"}', 'local', '1', '', 'Jardim Santo André'),
(707, 'Sociedade Esportiva Jardim Ana Maria - SEJAM', '{\"mapas\":\"264\"}', 'local', '1', '', 'Jardim Ana Maria'),
(708, 'Biblioteca Viva Sacadura Cabral', '{\"mapas\":\"212\"}', 'local', '1', '', 'Vila Sacadura Cabral'),
(709, 'Biblioteca Viva Semear', '{\"mapas\":\"211\"}', 'local', '1', '', 'Cata Preta'),
(711, 'CEU das Artes Jd. Ana Maria', '{\"mapas\":\"259\"}', 'local', '1', '', 'Jardim Ana Maria'),
(712, 'Passarela Luis Melito', '{\"mapas\":\"251\"}', 'local', '1', '', 'Centro'),
(855, 'Parque Central de Santo André', '{\"mapas\":\"309\"}', 'local', '1', '', 'Vila Assunção'),
(857, 'EMEIEF Elaine Cena Chaves', '', 'local', '1', '', 'Jardim Santo Alberto'),
(859, 'EMEIEF Chico Mendes', '{\"mapas\":\"100\"}', 'local', '1', '', 'Recreio da Borda do Campo'),
(862, 'Passarela Paranapiacaba', '{\"mapas\":\"314\"}', 'local', '1', '', 'Paranapiacaba'),
(863, 'EMEIEF Paranapiacaba', '{\"mapas\":\"178\"}', 'local', '1', '', 'Paranapiacaba'),
(885, 'Biblioteca Jardim Ana Maria', '{\"mapas\":\"315\"}', 'local', '1', '', 'Jardim Ana Maria'),
(887, 'Câmara Municipal de Santo André', '{\"mapas\":\"213\"}', 'local', '1', '', 'Centro'),
(895, 'Paróquia São Judas Tadeu', '{\"mapas\":\"313\"}', 'local', '1', '', 'Campestre'),
(999, 'Praça Lamartine ', '{\"mapas\":\"427\"}', 'local', '1', '2019', 'Jardim Santo André'),
(1176, 'Evento Digital ', '{\"mapas\":\"\"}', 'local', '1', '', ''),
(1187, 'Anhaguera Senador Flaquer', '{\"mapas\":\"500\"}', 'local', '1', '2021', 'Centro');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `sc_bairros`
--
ALTER TABLE `sc_bairros`
  ADD PRIMARY KEY (`id_tipo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `sc_bairros`
--
ALTER TABLE `sc_bairros`
  MODIFY `id_tipo` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1188;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
