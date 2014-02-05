SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `casasul`.`categoriaImagens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`categoriaImagens` (
  `idCategoria` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NULL,
  `dtInclusao` DATE NULL,
  `dtAlteracao` DATE NULL,
  `usrAlterou` INT NULL,
  `usrCriou` INT NULL,
  PRIMARY KEY (`idCategoria`),
  UNIQUE INDEX `idCategoria_UNIQUE` (`idCategoria` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `casasul`.`imagens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`imagens` (
  `idImagens` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  `local` TEXT NOT NULL,
  `nome` VARCHAR(45) NULL,
  `categoria` INT ZEROFILL NOT NULL,
  PRIMARY KEY (`idImagens`),
  UNIQUE INDEX `idSlider_UNIQUE` (`idImagens` ASC),
  INDEX `fk_imagem_categoria_idx` (`categoria` ASC),
  CONSTRAINT `fk_imagem_categoria`
    FOREIGN KEY (`categoria`)
    REFERENCES `casasul`.`categoriaImagens` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `casasul`.`materias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`materias` (
  `idMateria` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `texto` LONGTEXT NOT NULL,
  `autor` INT NULL,
  `dtInclusao` DATE NULL,
  `dtAlteracao` DATE NULL,
  `patrocinador` INT NULL,
  `usrAlterou` INT NULL,
  `tag` VARCHAR(45) NULL,
  `thumb` INT ZEROFILL NULL,
  `revista` INT ZEROFILL NULL,
  PRIMARY KEY (`idMateria`),
  UNIQUE INDEX `idMateria_UNIQUE` (`idMateria` ASC),
  INDEX `fk_materias_img_idx` (`thumb` ASC),
  CONSTRAINT `fk_materias_img`
    FOREIGN KEY (`thumb`)
    REFERENCES `casasul`.`imagens` (`idImagens`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `casasul`.`categoriaGuia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`categoriaGuia` (
  `idCategoria` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `descricao` TINYTEXT NULL,
  `thumb` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idCategoria`),
  UNIQUE INDEX `idCategoria_UNIQUE` (`idCategoria` ASC),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `casasul`.`patrocinador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`patrocinador` (
  `idPatrocinador` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `dtInclusao` DATE NULL,
  `dtAlteracao` DATE NULL,
  `usrAlterou` INT NULL,
  `usrCriou` INT NULL,
  `logo` INT ZEROFILL NOT NULL,
  `tipo` VARCHAR(45) NULL,
  `site` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `endereco` VARCHAR(45) NULL,
  `cidade` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NULL,
  `categoria` INT ZEROFILL NOT NULL,
  `cep` VARCHAR(9) NULL,
  `telefone` VARCHAR(45) NULL,
  UNIQUE INDEX `idPatrocinador_UNIQUE` (`idPatrocinador` ASC),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC),
  INDEX `fk_patrocinador_logo_idx` (`logo` ASC),
  UNIQUE INDEX `logo_UNIQUE` (`logo` ASC),
  INDEX `fk_patrocinador_catGuia_idx` (`categoria` ASC),
  CONSTRAINT `fk_patrocinador_logo`
    FOREIGN KEY (`logo`)
    REFERENCES `casasul`.`imagens` (`idImagens`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_patrocinador_catGuia`
    FOREIGN KEY (`categoria`)
    REFERENCES `casasul`.`categoriaGuia` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `casasul`.`programas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`programas` (
  `idPrograma` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NOT NULL,
  `dtInclusao` DATE NULL,
  `dtAlteracao` DATE NULL,
  `patrocinador` INT NULL,
  `descricao` TEXT NULL,
  `url` TEXT NULL,
  `usrAlterou` INT NULL,
  `usrCriou` INT NULL,
  PRIMARY KEY (`idPrograma`),
  UNIQUE INDEX `idProgramas_UNIQUE` (`idPrograma` ASC),
  INDEX `fk_programa_patrocinador_idx` (`patrocinador` ASC),
  CONSTRAINT `fk_programa_patrocinador`
    FOREIGN KEY (`patrocinador`)
    REFERENCES `casasul`.`patrocinador` (`idPatrocinador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `casasul`.`grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`grupos` (
  `idGrupo` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  `dtAlteracao` TIMESTAMP NULL,
  `dtInclusao` TIMESTAMP NULL,
  `usrAlterou` INT NULL,
  `usrCriou` INT NULL,
  PRIMARY KEY (`idGrupo`),
  UNIQUE INDEX `idGrupo_UNIQUE` (`idGrupo` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `casasul`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`usuarios` (
  `idUsuario` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NULL,
  `nome` VARCHAR(45) NOT NULL,
  `grupo` INT ZEROFILL NOT NULL,
  `dtAlteracao` TIMESTAMP NULL,
  `dtInclusao` TIMESTAMP NULL,
  `usrAlterou` INT NULL,
  `usrCriou` INT NULL,
  `status` TINYINT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `idUsuario_UNIQUE` (`idUsuario` ASC),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC),
  INDEX `fk_usr_grupo_idx` (`grupo` ASC),
  CONSTRAINT `fk_usr_grupo`
    FOREIGN KEY (`grupo`)
    REFERENCES `casasul`.`grupos` (`idGrupo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `casasul`.`categoriaTag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`categoriaTag` (
  `idCategoria` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NULL,
  `dtInclusao` TIMESTAMP NULL,
  `dtAlteracao` TIMESTAMP NULL,
  `usrAlterou` INT NULL,
  `usrCriou` INT NULL,
  PRIMARY KEY (`idCategoria`),
  UNIQUE INDEX `idCategoria_UNIQUE` (`idCategoria` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `casasul`.`tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`tag` (
  `idTag` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  `dtInclusao` TIMESTAMP NULL,
  `dtAlteracao` DATE NULL,
  `usrCriou` INT NULL,
  `usrAlterou` INT NULL,
  `categoria` INT ZEROFILL NOT NULL,
  PRIMARY KEY (`idTag`, `categoria`),
  UNIQUE INDEX `descricao_UNIQUE` (`descricao` ASC),
  UNIQUE INDEX `idTag_UNIQUE` (`idTag` ASC),
  INDEX `fk_tag_categoria_idx` (`categoria` ASC),
  CONSTRAINT `fk_tag_categoria`
    FOREIGN KEY (`categoria`)
    REFERENCES `casasul`.`categoriaTag` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `casasul`.`materiaTag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`materiaTag` (
  `idMateria` INT ZEROFILL NOT NULL,
  `idTag` INT ZEROFILL NOT NULL,
  PRIMARY KEY (`idMateria`, `idTag`),
  INDEX `fk_link_tag_idx` (`idTag` ASC),
  CONSTRAINT `fk_link_tag`
    FOREIGN KEY (`idTag`)
    REFERENCES `casasul`.`tag` (`idTag`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_link_materia`
    FOREIGN KEY (`idMateria`)
    REFERENCES `casasul`.`materias` (`idMateria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `casasul`.`logo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`logo` (
  `diretorio` VARCHAR(45) NOT NULL,
  `titulo` VARCHAR(45) NULL,
  `corFundo` VARCHAR(45) NULL,
  `nome` VARCHAR(45) NULL,
  `dtAlteracao` TIMESTAMP NULL,
  PRIMARY KEY (`diretorio`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `casasul`.`revistas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`revistas` (
  `idRevista` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NOT NULL,
  `edicao` VARCHAR(45) NOT NULL,
  `capa` INT ZEROFILL NULL,
  `ano` INT(4) NULL,
  `dtInclusao` TIMESTAMP NULL,
  `dtAlteracao` TIMESTAMP NULL,
  `descricao` TINYTEXT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idRevista`),
  UNIQUE INDEX `titulo_UNIQUE` (`titulo` ASC),
  UNIQUE INDEX `idRevista_UNIQUE` (`idRevista` ASC),
  UNIQUE INDEX `edicao_UNIQUE` (`edicao` ASC),
  UNIQUE INDEX `capa_UNIQUE` (`capa` ASC),
  CONSTRAINT `fk_revistas_imagens`
    FOREIGN KEY (`capa`)
    REFERENCES `casasul`.`imagens` (`idImagens`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE USER 'appCasaSul' IDENTIFIED BY '123mudar';

GRANT ALL ON `casasul`.* TO 'appCasaSul';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `casasul`.`categoriaImagens`
-- -----------------------------------------------------
START TRANSACTION;
USE `casasul`;
INSERT INTO `casasul`.`categoriaImagens` (`idCategoria`, `descricao`, `dtInclusao`, `dtAlteracao`, `usrAlterou`, `usrCriou`) VALUES (NULL, 'sponsor', NULL, NULL, NULL, NULL);
INSERT INTO `casasul`.`categoriaImagens` (`idCategoria`, `descricao`, `dtInclusao`, `dtAlteracao`, `usrAlterou`, `usrCriou`) VALUES (NULL, 'noticia', NULL, NULL, NULL, NULL);
INSERT INTO `casasul`.`categoriaImagens` (`idCategoria`, `descricao`, `dtInclusao`, `dtAlteracao`, `usrAlterou`, `usrCriou`) VALUES (NULL, 'guia', NULL, NULL, NULL, NULL);
INSERT INTO `casasul`.`categoriaImagens` (`idCategoria`, `descricao`, `dtInclusao`, `dtAlteracao`, `usrAlterou`, `usrCriou`) VALUES (NULL, 'slider', NULL, NULL, NULL, NULL);
INSERT INTO `casasul`.`categoriaImagens` (`idCategoria`, `descricao`, `dtInclusao`, `dtAlteracao`, `usrAlterou`, `usrCriou`) VALUES (NULL, 'capaRevista', NULL, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `casasul`.`categoriaGuia`
-- -----------------------------------------------------
START TRANSACTION;
USE `casasul`;
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (1, 'Acessório para Banheiro', 'Acessório para Banheiro', '/images/guia/banheiro.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (2, 'Banheira', 'Banheira', '/images/guia/banheira.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (3, 'Beleza e Estética', 'Beleza e Estética', '/images/guia/beleza.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Colchões', 'Colchões', '/images/guia/colchoes.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Construção', 'Construção', '/images/guia/construcao.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Cortinas', 'Cortinas', '/images/guia/cortinas.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Decoração', 'Decoração', '/images/guia/decoracao.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Mármore', 'Mármore', '/images/guia/marmore.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Convênios', 'Convênios', '/images/guia/convenios.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Divisórias', 'Divisórias', '/images/guia/divisorias.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Entretenimento', 'Entretenimento', '/images/guia/entretenimento.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Esquadrias', 'Esquadrias', '/images/guia/esquadrias.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Fotografia', 'Fotografia', '/images/guia/fotografia.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Gas Natural', 'Gas Natural', '/images/guia/gas_natural.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Iluminação', 'Iluminação', '/images/guia/iluminacao.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Móveis', 'Móveis', '/images/guia/moveis.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Pisos', 'Pisos', '/images/guia/pisos.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Tapetes e Carpetes', 'Tapetes e Carpetes', '/images/guia/tapetes_carpetes.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Decoradores', 'Decoradores', '/images/guia/decoradores.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Persianas', 'Persianas', '/images/guia/persianas.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Revestimento', 'Revestimento', '/images/guia/revestimento.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Arquitetos', 'Arquitetos', '/images/guia/arquitetos.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Design Interiores', 'Design Interiores', '/images/guia/design_interiores.png');
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `thumb`) VALUES (NULL, 'Móveis Corporativos', 'Móveis Corporativos', '/images/guia/moveis_corporativos.png');

COMMIT;


-- -----------------------------------------------------
-- Data for table `casasul`.`grupos`
-- -----------------------------------------------------
START TRANSACTION;
USE `casasul`;
INSERT INTO `casasul`.`grupos` (`idGrupo`, `descricao`, `dtAlteracao`, `dtInclusao`, `usrAlterou`, `usrCriou`) VALUES (1, 'Administradores', NULL, '2014-02-01', 1, 1);
INSERT INTO `casasul`.`grupos` (`idGrupo`, `descricao`, `dtAlteracao`, `dtInclusao`, `usrAlterou`, `usrCriou`) VALUES (NULL, 'Usuário', NULL, '2014-02-01', 1, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `casasul`.`usuarios`
-- -----------------------------------------------------
START TRANSACTION;
USE `casasul`;
INSERT INTO `casasul`.`usuarios` (`idUsuario`, `login`, `senha`, `email`, `nome`, `grupo`, `dtAlteracao`, `dtInclusao`, `usrAlterou`, `usrCriou`, `status`) VALUES (1, 'admin', '698dc19d489c4e4db73e28a713eab07b', NULL, 'Administrador', 1, 'NULL', 'NULL', 1, 1, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `casasul`.`logo`
-- -----------------------------------------------------
START TRANSACTION;
USE `casasul`;
INSERT INTO `casasul`.`logo` (`diretorio`, `titulo`, `corFundo`, `nome`, `dtAlteracao`) VALUES ('./placeholders/', 'Logo', 'blue', 'logo.png', NULL);

COMMIT;

