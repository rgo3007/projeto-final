-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11-Out-2017 às 04:50
-- Versão do servidor: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u649696891_isa2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivo`
--

CREATE TABLE `arquivo` (
  `codigo` int(11) NOT NULL,
  `cod_turma` int(11) DEFAULT NULL,
  `cod_disciplina` int(11) DEFAULT NULL,
  `cod_usuario_professor` int(11) DEFAULT NULL,
  `caminho` varchar(20) DEFAULT NULL,
  `assunto` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(30) DEFAULT NULL,
  `carga_horaria` int(11) DEFAULT NULL,
  `cod_usuario_coordenador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina`
--

CREATE TABLE `disciplina` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(30) DEFAULT NULL,
  `carga_horaria` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `duvida`
--

CREATE TABLE `duvida` (
  `codigo` int(11) NOT NULL,
  `cod_turma` int(11) DEFAULT NULL,
  `cod_disciplina` int(11) DEFAULT NULL,
  `cod_usuario_professor` int(11) DEFAULT NULL,
  `assunto` varchar(20) DEFAULT NULL,
  `pergunta` longtext,
  `resposta` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE `log` (
  `codigo` int(11) NOT NULL,
  `chave` varchar(30) DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log` text,
  `nome_tabela` varchar(30) DEFAULT NULL,
  `cod_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `periodo`
--

CREATE TABLE `periodo` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `serie`
--

CREATE TABLE `serie` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_sistema`
--

CREATE TABLE `tipo_sistema` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`codigo`, `descricao`) VALUES
(1, 'Aluno'),
(2, 'Professor'),
(3, 'Coordenador'),
(4, 'Administrador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma`
--

CREATE TABLE `turma` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(30) DEFAULT NULL,
  `cod_curso` int(11) DEFAULT NULL,
  `data_turma` timestamp NULL DEFAULT NULL,
  `cod_periodo` int(11) DEFAULT NULL,
  `cod_serie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma_disciplina`
--

CREATE TABLE `turma_disciplina` (
  `cod_turma` int(11) NOT NULL,
  `cod_disciplina` int(11) NOT NULL,
  `cod_usuario_professor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `sobrenome` varchar(60) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `data_registro` timestamp NULL DEFAULT NULL,
  `cod_tipo_usuario` int(11) DEFAULT NULL,
  `data_atualizacao` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`codigo`, `nome`, `sobrenome`, `email`, `senha`, `status`, `data_registro`, `cod_tipo_usuario`, `data_atualizacao`) VALUES
(1, 'Rogério', NULL, '0', '10470c3b4b1fed12c3baac014be15fac67c6e815', 1, NULL, 4, NULL),
(2, 'Rogério', 'Galdino de Oliveira', 'rgo3007@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '0000-00-00 00:00:00', 1, NULL),
(3, 'Marcos', 'Vinicios da Silva', 'tatau@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '0000-00-00 00:00:00', 2, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_aluno_turma`
--

CREATE TABLE `usuario_aluno_turma` (
  `cod_usuario_aluno` int(11) NOT NULL,
  `cod_turma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_tipo_sistema`
--

CREATE TABLE `usuario_tipo_sistema` (
  `cod_usuario` int(11) NOT NULL,
  `cod_tipo_sistema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ws_siteviews`
--

CREATE TABLE `ws_siteviews` (
  `siteviews_id` int(11) NOT NULL,
  `siteviews_date` date NOT NULL,
  `siteviews_users` decimal(10,0) NOT NULL,
  `siteviews_views` decimal(10,0) NOT NULL,
  `siteviews_pages` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ws_siteviews_agent`
--

CREATE TABLE `ws_siteviews_agent` (
  `agent_id` int(11) NOT NULL,
  `agent_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `agent_views` decimal(10,0) NOT NULL,
  `agent_lastview` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ws_siteviews_online`
--

CREATE TABLE `ws_siteviews_online` (
  `online_id` int(11) NOT NULL,
  `online_session` varchar(255) CHARACTER SET latin1 NOT NULL,
  `online_startview` timestamp NULL DEFAULT NULL,
  `online_endview` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `online_ip` varchar(255) CHARACTER SET latin1 NOT NULL,
  `online_url` varchar(255) CHARACTER SET latin1 NOT NULL,
  `online_agent` varchar(255) CHARACTER SET latin1 NOT NULL,
  `agent_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ws_siteviews_online`
--

INSERT INTO `ws_siteviews_online` (`online_id`, `online_session`, `online_startview`, `online_endview`, `online_ip`, `online_url`, `online_agent`, `agent_name`) VALUES
(10, 'r9013n1hkfmsfsbg7hsni77rrb', '2017-10-08 15:27:30', '2017-10-08 16:25:40', '::1', '/projeto-final/', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36', 'Chrome');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arquivo`
--
ALTER TABLE `arquivo`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cod_turma` (`cod_turma`),
  ADD KEY `cod_disciplina` (`cod_disciplina`),
  ADD KEY `cod_usuario_professor` (`cod_usuario_professor`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `duvida`
--
ALTER TABLE `duvida`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cod_turma` (`cod_turma`),
  ADD KEY `cod_disciplina` (`cod_disciplina`),
  ADD KEY `cod_usuario_professor` (`cod_usuario_professor`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indexes for table `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `serie`
--
ALTER TABLE `serie`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `tipo_sistema`
--
ALTER TABLE `tipo_sistema`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cod_curso` (`cod_curso`),
  ADD KEY `cod_periodo` (`cod_periodo`),
  ADD KEY `cod_serie` (`cod_serie`);

--
-- Indexes for table `turma_disciplina`
--
ALTER TABLE `turma_disciplina`
  ADD PRIMARY KEY (`cod_turma`,`cod_disciplina`,`cod_usuario_professor`),
  ADD KEY `cod_disciplina` (`cod_disciplina`),
  ADD KEY `cod_usuario_professor` (`cod_usuario_professor`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cod_tipo_usuario` (`cod_tipo_usuario`);

--
-- Indexes for table `usuario_aluno_turma`
--
ALTER TABLE `usuario_aluno_turma`
  ADD PRIMARY KEY (`cod_usuario_aluno`,`cod_turma`),
  ADD KEY `cod_turma` (`cod_turma`);

--
-- Indexes for table `usuario_tipo_sistema`
--
ALTER TABLE `usuario_tipo_sistema`
  ADD PRIMARY KEY (`cod_usuario`,`cod_tipo_sistema`),
  ADD KEY `cod_tipo_sistema` (`cod_tipo_sistema`);

--
-- Indexes for table `ws_siteviews`
--
ALTER TABLE `ws_siteviews`
  ADD PRIMARY KEY (`siteviews_id`),
  ADD KEY `idx_1` (`siteviews_date`);

--
-- Indexes for table `ws_siteviews_agent`
--
ALTER TABLE `ws_siteviews_agent`
  ADD PRIMARY KEY (`agent_id`),
  ADD KEY `idx_1` (`agent_name`);

--
-- Indexes for table `ws_siteviews_online`
--
ALTER TABLE `ws_siteviews_online`
  ADD PRIMARY KEY (`online_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ws_siteviews`
--
ALTER TABLE `ws_siteviews`
  MODIFY `siteviews_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ws_siteviews_agent`
--
ALTER TABLE `ws_siteviews_agent`
  MODIFY `agent_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ws_siteviews_online`
--
ALTER TABLE `ws_siteviews_online`
  MODIFY `online_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `arquivo`
--
ALTER TABLE `arquivo`
  ADD CONSTRAINT `arquivo_ibfk_1` FOREIGN KEY (`cod_turma`) REFERENCES `turma` (`codigo`),
  ADD CONSTRAINT `arquivo_ibfk_2` FOREIGN KEY (`cod_disciplina`) REFERENCES `disciplina` (`codigo`),
  ADD CONSTRAINT `arquivo_ibfk_3` FOREIGN KEY (`cod_usuario_professor`) REFERENCES `usuario` (`codigo`);

--
-- Limitadores para a tabela `duvida`
--
ALTER TABLE `duvida`
  ADD CONSTRAINT `duvida_ibfk_1` FOREIGN KEY (`cod_turma`) REFERENCES `turma` (`codigo`),
  ADD CONSTRAINT `duvida_ibfk_2` FOREIGN KEY (`cod_disciplina`) REFERENCES `disciplina` (`codigo`),
  ADD CONSTRAINT `duvida_ibfk_3` FOREIGN KEY (`cod_usuario_professor`) REFERENCES `usuario` (`codigo`);

--
-- Limitadores para a tabela `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`codigo`);

--
-- Limitadores para a tabela `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `turma_ibfk_1` FOREIGN KEY (`cod_curso`) REFERENCES `curso` (`codigo`),
  ADD CONSTRAINT `turma_ibfk_2` FOREIGN KEY (`cod_periodo`) REFERENCES `periodo` (`codigo`),
  ADD CONSTRAINT `turma_ibfk_3` FOREIGN KEY (`cod_serie`) REFERENCES `serie` (`codigo`);

--
-- Limitadores para a tabela `turma_disciplina`
--
ALTER TABLE `turma_disciplina`
  ADD CONSTRAINT `turma_disciplina_ibfk_1` FOREIGN KEY (`cod_turma`) REFERENCES `turma` (`codigo`),
  ADD CONSTRAINT `turma_disciplina_ibfk_2` FOREIGN KEY (`cod_disciplina`) REFERENCES `disciplina` (`codigo`),
  ADD CONSTRAINT `turma_disciplina_ibfk_3` FOREIGN KEY (`cod_usuario_professor`) REFERENCES `usuario` (`codigo`);

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`cod_tipo_usuario`) REFERENCES `tipo_usuario` (`codigo`);

--
-- Limitadores para a tabela `usuario_aluno_turma`
--
ALTER TABLE `usuario_aluno_turma`
  ADD CONSTRAINT `usuario_aluno_turma_ibfk_1` FOREIGN KEY (`cod_usuario_aluno`) REFERENCES `usuario` (`codigo`),
  ADD CONSTRAINT `usuario_aluno_turma_ibfk_2` FOREIGN KEY (`cod_turma`) REFERENCES `turma` (`codigo`);

--
-- Limitadores para a tabela `usuario_tipo_sistema`
--
ALTER TABLE `usuario_tipo_sistema`
  ADD CONSTRAINT `usuario_tipo_sistema_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`codigo`),
  ADD CONSTRAINT `usuario_tipo_sistema_ibfk_2` FOREIGN KEY (`cod_tipo_sistema`) REFERENCES `tipo_sistema` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
