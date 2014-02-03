SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `casasul` ;
CREATE SCHEMA IF NOT EXISTS `casasul` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `casasul` ;

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
-- Table `casasul`.`categoriaGuia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`categoriaGuia` (
  `idCategoria` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `descricao` TINYTEXT NULL,
  `dtInclusao` DATE NULL,
  `dtAlteracao` DATE NULL,
  `usrAlterou` INT NULL,
  `usrCriou` INT NULL,
  `thumb` INT ZEROFILL NOT NULL,
  PRIMARY KEY (`idCategoria`),
  UNIQUE INDEX `idCategoria_UNIQUE` (`idCategoria` ASC),
  INDEX `fk_guia_imagem_idx` (`thumb` ASC),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC),
  CONSTRAINT `fk_guia_imagem`
    FOREIGN KEY (`thumb`)
    REFERENCES `casasul`.`imagens` (`idImagens`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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
  INDEX `fk_materias_patrocinador_idx` (`patrocinador` ASC),
  INDEX `fk_materias_img_idx` (`thumb` ASC),
  INDEX `fk_materias_revista_idx` (`revista` ASC),
  CONSTRAINT `fk_materias_patrocinador`
    FOREIGN KEY (`patrocinador`)
    REFERENCES `casasul`.`patrocinador` (`idPatrocinador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_materias_img`
    FOREIGN KEY (`thumb`)
    REFERENCES `casasul`.`imagens` (`idImagens`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_materias_revista`
    FOREIGN KEY (`revista`)
    REFERENCES `casasul`.`revistas` (`idRevista`)
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

USE `casasul` ;

-- -----------------------------------------------------
-- Placeholder table for view `casasul`.`sponsor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`sponsor` (`idPatrocinador` INT, `'Patrocinador'` INT, `dtInclusao` INT, `dtAlteracao` INT, `usrAlterou` INT, `logo` INT, `idImagens` INT, `descricao` INT, `local` INT, `nome` INT, `categoria` INT);

-- -----------------------------------------------------
-- Placeholder table for view `casasul`.`guiaImagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`guiaImagem` (`idCategoria` INT, `'descCat'` INT, `'categoria'` INT, `local` INT, `descricao` INT, `nome` INT);

-- -----------------------------------------------------
-- Placeholder table for view `casasul`.`guia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `casasul`.`guia` (`idPatrocinador` INT, `'patrocinador'` INT, `tipo` INT, `site` INT, `endereco` INT, `cidade` INT, `estado` INT, `'categoria'` INT, `'telefone'` INT, `'cep'` INT, `'email'` INT, `'descLogo'` INT, `local` INT, `'logo'` INT, `'tituloCategoria'` INT, `'thumbCategoria'` INT);

-- -----------------------------------------------------
-- View `casasul`.`sponsor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `casasul`.`sponsor`;
USE `casasul`;
CREATE  OR REPLACE VIEW `sponsor` AS

select idPatrocinador, p.nome as 'Patrocinador', dtInclusao, dtAlteracao, usrAlterou, logo, i.*
from patrocinador as p
join imagens as i on p.logo = i.idImagens;

-- -----------------------------------------------------
-- View `casasul`.`guiaImagem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `casasul`.`guiaImagem`;
USE `casasul`;
CREATE  OR REPLACE VIEW `guiaImagem` AS

select cat.idCategoria,cat.descricao as 'descCat',cat.nome as 'categoria',img.local, img.descricao, img.nome 
From categoriaGuia as cat, imagens as img 
where cat.thumb = img.idImagens;

-- -----------------------------------------------------
-- View `casasul`.`guia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `casasul`.`guia`;
USE `casasul`;
CREATE  OR REPLACE VIEW `guia` AS

select p.idPatrocinador, p.nome as 'patrocinador',p.tipo, p.site, p.endereco, p.cidade, p.estado, p.categoria as 'categoria', p.telefone as 'telefone', p.cep as 'cep', p.email as 'email',
i.descricao as 'descLogo', i.local, i.nome as 'logo',
guia.nome as 'tituloCategoria', guia.thumb as 'thumbCategoria'
from patrocinador as p, imagens as i, categoriaGuia as guia
where p.logo = i.idImagens AND p.categoria = guia.idCategoria;

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
-- Data for table `casasul`.`imagens`
-- -----------------------------------------------------
START TRANSACTION;
USE `casasul`;
INSERT INTO `casasul`.`imagens` (`idImagens`, `descricao`, `local`, `nome`, `categoria`) VALUES (0000000001, 'LogoLala', '/images/', 'logo.jpg', 1);
INSERT INTO `casasul`.`imagens` (`idImagens`, `descricao`, `local`, `nome`, `categoria`) VALUES (0000000002, 'teste de envio', '/images/', 'sponsor-teste.jpg', 3);
INSERT INTO `casasul`.`imagens` (`idImagens`, `descricao`, `local`, `nome`, `categoria`) VALUES (0000000004, 'LOREM IPSUM', '/images/', 'sponsor-Baden Banho.jpg', 1);
INSERT INTO `casasul`.`imagens` (`idImagens`, `descricao`, `local`, `nome`, `categoria`) VALUES (0000000005, 'Noticia Teste', '/images/', 'noticia-1.jpg', 2);
INSERT INTO `casasul`.`imagens` (`idImagens`, `descricao`, `local`, `nome`, `categoria`) VALUES (NULL, 'Slider1', '/images/', 'slider-1.jpg', 4);

COMMIT;


-- -----------------------------------------------------
-- Data for table `casasul`.`categoriaGuia`
-- -----------------------------------------------------
START TRANSACTION;
USE `casasul`;
INSERT INTO `casasul`.`categoriaGuia` (`idCategoria`, `nome`, `descricao`, `dtInclusao`, `dtAlteracao`, `usrAlterou`, `usrCriou`, `thumb`) VALUES (1, 'Teste', 'Lorem ipsum dolor sit amet', NULL, NULL, 1, 1, 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `casasul`.`patrocinador`
-- -----------------------------------------------------
START TRANSACTION;
USE `casasul`;
INSERT INTO `casasul`.`patrocinador` (`idPatrocinador`, `nome`, `dtInclusao`, `dtAlteracao`, `usrAlterou`, `usrCriou`, `logo`, `tipo`, `site`, `email`, `endereco`, `cidade`, `estado`, `categoria`, `cep`, `telefone`) VALUES (1, 'Baden Banho', '2014-02-01', '2014-02-01', 2, 1, 4, 'empresa', 'http://www.badenbanho.com.br/', '', NULL, NULL, NULL, 1, '00000-000', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `casasul`.`materias`
-- -----------------------------------------------------
START TRANSACTION;
USE `casasul`;
INSERT INTO `casasul`.`materias` (`idMateria`, `titulo`, `descricao`, `texto`, `autor`, `dtInclusao`, `dtAlteracao`, `patrocinador`, `usrAlterou`, `tag`, `thumb`, `revista`) VALUES (1, 'Teste', 'Materia de Teste', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent varius accumsan arcu vel dictum. Aliquam blandit risus a odio convallis, pellentesque dapibus massa fringilla. Proin id venenatis sapien, vitae porttitor tortor. Quisque placerat velit velit, nec vehicula felis scelerisque quis. Nam nibh nisi, sodales varius feugiat at, tincidunt in lorem. Pellentesque sollicitudin cursus nibh eu tristique. Aenean auctor orci id odio euismod placerat. In pulvinar massa dui, eu consectetur augue pulvinar a. Nam vel aliquet dolor. Sed malesuada est vitae tristique condimentum. Curabitur eleifend enim vitae massa consectetur, eu porttitor tortor vehicula. Nulla nulla nibh, consequat eu gravida eget, ultrices eu urna. Integer tortor magna, fringilla nec lacus ut, lobortis convallis odio. Vivamus in malesuada sem. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Mauris sed erat semper, condimentum tortor ac, ultricies libero.', NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `casasul`.`programas`
-- -----------------------------------------------------
START TRANSACTION;
USE `casasul`;
INSERT INTO `casasul`.`programas` (`idPrograma`, `titulo`, `dtInclusao`, `dtAlteracao`, `patrocinador`, `descricao`, `url`, `usrAlterou`, `usrCriou`) VALUES (1, 'teste', '2014-01-01', NULL, NULL, 'Video de teste que mostra lorem ipsum dolor sit amet', 'QjBU_tPmVDM', NULL, NULL);
INSERT INTO `casasul`.`programas` (`idPrograma`, `titulo`, `dtInclusao`, `dtAlteracao`, `patrocinador`, `descricao`, `url`, `usrAlterou`, `usrCriou`) VALUES (NULL, 'Fonte', NULL, NULL, NULL, NULL, 'rEWDhUizR8E', NULL, NULL);
INSERT INTO `casasul`.`programas` (`idPrograma`, `titulo`, `dtInclusao`, `dtAlteracao`, `patrocinador`, `descricao`, `url`, `usrAlterou`, `usrCriou`) VALUES (NULL, 'Casa Sul2', NULL, NULL, NULL, NULL, '2aKnpZIzZ98', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `casasul`.`grupos`
-- -----------------------------------------------------
START TRANSACTION;
USE `casasul`;
INSERT INTO `casasul`.`grupos` (`idGrupo`, `descricao`, `dtAlteracao`, `dtInclusao`, `usrAlterou`, `usrCriou`) VALUES (1, 'Administradores', NULL, NULL, NULL, NULL);
INSERT INTO `casasul`.`grupos` (`idGrupo`, `descricao`, `dtAlteracao`, `dtInclusao`, `usrAlterou`, `usrCriou`) VALUES (NULL, 'Usuário', NULL, NULL, NULL, NULL);

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

