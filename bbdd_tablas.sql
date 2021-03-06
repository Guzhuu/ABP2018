-- MySQL Script generated by MySQL Workbench
-- Thu Oct 25 16:33:59 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema AWGP
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema AWGP
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `AWGP`;
CREATE SCHEMA IF NOT EXISTS `AWGP` DEFAULT CHARACTER SET ucs2;
USE `AWGP` ;

-- -----------------------------------------------------
-- `AWGP`.`Deportista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Deportista` (
  `DNI` VARCHAR(9) NOT NULL,
  `Edad` INT NULL,
  `Nombre` VARCHAR(45) NULL,
  `Apellidos` VARCHAR(45) NULL,
  `Sexo` VARCHAR(6) NULL,
  `Contrasenha` VARCHAR(128) NOT NULL,
  `Cuota_Socio` INT NULL,
  `rolAdmin` TINYINT NULL,
  `rolEntrenador` TINYINT NULL,
  PRIMARY KEY (`DNI`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Pareja`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Pareja` (
  `codPareja` VARCHAR(18) NOT NULL,
  `DNI_Capitan` VARCHAR(9) NOT NULL,
  `DNI_Companhero` VARCHAR(9) NOT NULL,
  PRIMARY KEY (`codPareja`),
  INDEX `fk_Pareja_Deportista1_idx` (`DNI_Capitan` ASC),
  INDEX `fk_Pareja_Deportista2_idx` (`DNI_Companhero` ASC),
  CONSTRAINT `fk_Pareja_Deportista1`
    FOREIGN KEY (`DNI_Capitan`)
    REFERENCES `AWGP`.`Deportista` (`DNI`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Pareja_Deportista2`
    FOREIGN KEY (`DNI_Companhero`)
    REFERENCES `AWGP`.`Deportista` (`DNI`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
COMMENT = '	';


-- -----------------------------------------------------
-- `AWGP`.`Horario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Horario` (
  `Horario` INT NOT NULL AUTO_INCREMENT,
  `HoraInicio` DATETIME NULL,
  `HoraFin` DATETIME NULL,
  PRIMARY KEY (`Horario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Pista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Pista` (
  `codigoPista` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  PRIMARY KEY (`codigoPista`))
ENGINE = InnoDB
COMMENT = '										';


-- -----------------------------------------------------
-- `AWGP`.`Partido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Partido` (
  `Partido` INT NOT NULL AUTO_INCREMENT,
  `codigoHorario` INT NOT NULL,
  `codigoPista` INT NOT NULL,
  PRIMARY KEY (`Partido`),
  INDEX `fk_Partido_Horario1_idx` (`codigoHorario` ASC),
  INDEX `fk_Partido_Pista1_idx` (`codigoPista` ASC),
  CONSTRAINT `fk_Partido_Horario1`
    FOREIGN KEY (`codigoHorario`)
    REFERENCES `AWGP`.`Horario` (`Horario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Partido_Pista1`
    FOREIGN KEY (`codigoPista`)
    REFERENCES `AWGP`.`Pista` (`codigoPista`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Campeonato`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Campeonato` (
  `Campeonato` INT NOT NULL AUTO_INCREMENT,
  `FechaInicio` DATETIME NULL,
  `FechaFinal` DATETIME NULL,
  `Nombre` VARCHAR(45) NULL,
  `Comenzado` TINYINT DEFAULT 0,
  PRIMARY KEY (`Campeonato`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Categoria` (
  `Categoria` INT NOT NULL AUTO_INCREMENT,
  `Nivel` VARCHAR(45) NOT NULL,
  `Sexo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Categoria`),
  CONSTRAINT `NivelySexoUnicos` 
    UNIQUE(`Nivel`, `Sexo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Campeonato_consta_de_categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Campeonato_consta_de_categorias` (
  `constadeCategorias` INT NOT NULL AUTO_INCREMENT,
  `Campeonato_Campeonato` INT NOT NULL,
  `Categoria_Categoria` INT NOT NULL,
  INDEX `fk_Campeonato_consta_de_categorias_Categoria1_idx` (`Categoria_Categoria` ASC),
  PRIMARY KEY (`constadeCategorias`),
  CONSTRAINT `fk_Campeonato_consta_de_categorias_Campeonato1`
    FOREIGN KEY (`Campeonato_Campeonato`)
    REFERENCES `AWGP`.`Campeonato` (`Campeonato`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Campeonato_consta_de_categorias_Categoria1`
    FOREIGN KEY (`Categoria_Categoria`)
    REFERENCES `AWGP`.`Categoria` (`Categoria`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `CampeonatoyCategoriaUnicos` 
    UNIQUE(`Campeonato_Campeonato`, `Categoria_Categoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Pareja_pertenece_categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Pareja_pertenece_categoria` (
  `perteneceCategoria` INT NOT NULL AUTO_INCREMENT,
  `Pareja_codPareja` VARCHAR(18) NOT NULL,
  `Categoria_Categoria` INT NOT NULL,
  PRIMARY KEY (`perteneceCategoria`),
  INDEX `fk_Pareja_pertenece_categoria_Categoria1_idx` (`Categoria_Categoria` ASC),
  CONSTRAINT `fk_Pareja_pertenece_categoria_Pareja1`
    FOREIGN KEY (`Pareja_codPareja`)
    REFERENCES `AWGP`.`Pareja` (`codPareja`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Pareja_pertenece_categoria_Categoria1`
    FOREIGN KEY (`Categoria_Categoria`)
    REFERENCES `AWGP`.`Categoria` (`Categoria`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Pareja_pertenece_categoria_de_campeonato`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Pareja_pertenece_categoria_de_campeonato` (
  `parejaCategoriaCampeonato` INT NOT NULL AUTO_INCREMENT,
  `CampeonatoConstadeCategorias` INT NOT NULL,
  `ParejaPerteneceCategoria` INT NOT NULL,
  PRIMARY KEY (`parejaCategoriaCampeonato`),
  CONSTRAINT `fk_Pareja_pertenece_categoria_de_campeonato_Campeonato1`
    FOREIGN KEY (`CampeonatoConstadeCategorias`)
    REFERENCES `AWGP`.`Campeonato_consta_de_categorias` (`constadeCategorias`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Pareja_pertenece_categoria_de_campeonato_Pareja1`
    FOREIGN KEY (`ParejaPerteneceCategoria`)
    REFERENCES `AWGP`.`Pareja_pertenece_categoria` (`perteneceCategoria`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



-- -----------------------------------------------------
-- `AWGP`.`Grupo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Grupo` (
  `nombre` VARCHAR(45) NOT NULL,
  `CampeonatoCategoria` INT NOT NULL,
  `ParejaCategoria` INT NOT NULL,
  PRIMARY KEY (`nombre`,`CampeonatoCategoria`,`ParejaCategoria`),
  INDEX `fk_Grupo_Campeonato_consta_de_categorias1_idx` (`CampeonatoCategoria` ASC),
  INDEX `fk_Grupo_Pareja_pertenece_categoria1_idx` (`ParejaCategoria` ASC),
  CONSTRAINT `fk_Grupo_Campeonato_consta_de_categorias1`
    FOREIGN KEY (`CampeonatoCategoria`)
    REFERENCES `AWGP`.`Campeonato_consta_de_categorias` (`constadeCategorias`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Grupo_Pareja_pertenece_categoria1`
    FOREIGN KEY (`ParejaCategoria`)
    REFERENCES `AWGP`.`Pareja_pertenece_categoria` (`perteneceCategoria`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Enfrentamiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Enfrentamiento` (
  `Enfrentamiento` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `CampeonatoCategoria` INT NOT NULL,
  `Pareja1` VARCHAR(18) NOT NULL,
  `Pareja2` VARCHAR(18) NOT NULL,
  `set1` VARCHAR(3) NOT NULL,
  `set2` VARCHAR(3) NOT NULL,
  `set3` VARCHAR(3) NOT NULL,
  `SegundaRonda` TINYINT DEFAULT 0,
  PRIMARY KEY (`Enfrentamiento`),
  INDEX `fk_Enfrentamiento_Grupo1_idx` (`CampeonatoCategoria` ASC),
  INDEX `fk_Enfrentamiento_Pareja1_idx` (`Pareja1` ASC),
  INDEX `fk_Enfrentamiento_Pareja2_idx` (`Pareja2` ASC),
  CONSTRAINT `fk_Enfrentamiento_Grupo1`
    FOREIGN KEY (`nombre`, `CampeonatoCategoria`)
    REFERENCES `AWGP`.`Grupo` (`nombre`, `CampeonatoCategoria`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Enfrentamiento_Pareja1`
    FOREIGN KEY (`Pareja1`)
    REFERENCES `AWGP`.`Pareja` (`codPareja`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Enfrentamiento_Pareja2`
    FOREIGN KEY (`Pareja2`)
    REFERENCES `AWGP`.`Pareja` (`codPareja`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `enfrentamientoUnicoPara2ParejasEnUnCampeonatoEnUnGrupo` 
    UNIQUE(`nombre`, `CampeonatoCategoria`, `Pareja1`, `Pareja2`),
  CONSTRAINT `enfrentamientoUnicoPara2ParejasEnUnCampeonatoEnCuartos` 
    UNIQUE(`CampeonatoCategoria`, `Pareja1`, `Pareja2`, `SegundaRonda`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Reserva`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Reserva` (
  `Reserva` INT NOT NULL AUTO_INCREMENT,
  `codigoPistayHorario` INT UNIQUE NOT NULL,
  `DNI_Deportista` VARCHAR(9) NOT NULL,
  PRIMARY KEY (`Reserva`),
  INDEX `fk_Reserva_Horario1_idx` (`codigoPistayHorario` ASC),
  INDEX `fk_Reserva_Deportista1_idx` (`DNI_Deportista` ASC),
  CONSTRAINT `fk_Reserva_codigoPistayHorario`
    FOREIGN KEY (`codigoPistayHorario`)
    REFERENCES `AWGP`.`Pista_tiene_horario` (`codigoPistayHorario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Reserva_Deportista1`
    FOREIGN KEY (`DNI_Deportista`)
    REFERENCES `AWGP`.`Deportista` (`DNI`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Escuela`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Escuela` (
  `codigoEscuela` INT NOT NULL AUTO_INCREMENT,
  `nombreEscuela` VARCHAR(45) NULL,
  PRIMARY KEY (`codigoEscuela`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Clase`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Clase` (
  `Clase` INT NOT NULL AUTO_INCREMENT,
  `Reserva_Reserva` INT NOT NULL,
  `codigoEscuela` INT NOT NULL,
  `Entrenador` VARCHAR(9) NOT NULL,
  `Curso` VARCHAR(45) NOT NULL,
  `Particulares` BOOLEAN DEFAULT FALSE,
  PRIMARY KEY (`Clase`),
  INDEX `fk_Clase_Reserva1_idx` (`Reserva_Reserva` ASC),
  INDEX `fk_Clase_Escuela1_idx` (`codigoEscuela` ASC),
  INDEX `fk_Clase_Deportista1_idx` (`Entrenador` ASC),
  CONSTRAINT `fk_Clase_Reserva1`
    FOREIGN KEY (`Reserva_Reserva`)
    REFERENCES `AWGP`.`Reserva` (`Reserva`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Clase_Escuela1`
    FOREIGN KEY (`codigoEscuela`)
    REFERENCES `AWGP`.`Escuela` (`codigoEscuela`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Clase_Deportista1`
    FOREIGN KEY (`Entrenador`)
    REFERENCES `AWGP`.`Deportista` (`DNI`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Clase`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Deportista_inscrito_clase` (
  `Clase` INT NOT NULL,
  `DNI_Deportista` VARCHAR(9) NOT NULL,
  PRIMARY KEY (`Clase`, `DNI_Deportista`),
  INDEX `fk_Deportista_inscrito_clase_Clase_idx` (`Clase` ASC),
  INDEX `fk_Deportista_inscrito_clase_DNI_Deportista_idx` (`DNI_Deportista` ASC),
  CONSTRAINT `fk_Deportista_inscrito_clase_Clase`
    FOREIGN KEY (`Clase`)
    REFERENCES `AWGP`.`Clase` (`Clase`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Deportista_inscrito_clase_DNI_Deportista`
    FOREIGN KEY (`DNI_Deportista`)
    REFERENCES `AWGP`.`Deportista` (`DNI`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Pista_tiene_horario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Pista_tiene_horario` (
  `codigoPistayHorario` INT NOT NULL AUTO_INCREMENT,
  `Horario_Horario` INT NOT NULL,
  `Pista_codigoPista` INT NOT NULL,
  INDEX `fk_Pista_tiene_horario_Horario1_idx` (`Horario_Horario` ASC),
  INDEX `fk_Pista_tiene_horario_Pista1_idx` (`Pista_codigoPista` ASC),
  PRIMARY KEY (`codigoPistayHorario`),
  CONSTRAINT `fk_Pista_tiene_horario_Horario1`
    FOREIGN KEY (`Horario_Horario`)
    REFERENCES `AWGP`.`Horario` (`Horario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Pista_tiene_horario_Pista1`
    FOREIGN KEY (`Pista_codigoPista`)
    REFERENCES `AWGP`.`Pista` (`codigoPista`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `pistayHorarioUnicos` 
    UNIQUE(`Horario_Horario`, `Pista_codigoPista`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- `AWGP`.`Deportista_juega_partido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `AWGP`.`Deportista_juega_partido` (
  `DNI_Deportista1` VARCHAR(9) NOT NULL,
  `DNI_Deportista2` VARCHAR(9) NOT NULL,
  `DNI_Deportista3` VARCHAR(9) NOT NULL,
  `DNI_Deportista4` VARCHAR(9) NOT NULL,
  `Partido_Partido` INT NOT NULL,
  INDEX `fk_Deportista_juega_partido_Deportista1_idx` (`DNI_Deportista1` ASC),
  INDEX `fk_Deportista_juega_partido_Deportista2_idx` (`DNI_Deportista2` ASC),
  INDEX `fk_Deportista_juega_partido_Deportista3_idx` (`DNI_Deportista3` ASC),
  INDEX `fk_Deportista_juega_partido_Deportista4_idx` (`DNI_Deportista4` ASC),
  PRIMARY KEY (`Partido_Partido`, `DNI_Deportista4`, `DNI_Deportista3`, `DNI_Deportista2`, `DNI_Deportista1`),
  CONSTRAINT `fk_Deportista_juega_partido_Deportista1`
    FOREIGN KEY (`DNI_Deportista1`)
    REFERENCES `AWGP`.`Deportista` (`DNI`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Deportista_juega_partido_Deportista2`
    FOREIGN KEY (`DNI_Deportista2`)
    REFERENCES `AWGP`.`Deportista` (`DNI`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Deportista_juega_partido_Deportista3`
    FOREIGN KEY (`DNI_Deportista3`)
    REFERENCES `AWGP`.`Deportista` (`DNI`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Deportista_juega_partido_Deportista4`
    FOREIGN KEY (`DNI_Deportista4`)
    REFERENCES `AWGP`.`Deportista` (`DNI`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Deportista_juega_partido_Partido1`
    FOREIGN KEY (`Partido_Partido`)
    REFERENCES `AWGP`.`Partido` (`Partido`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
COMMENT = '			';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

/*TODOS LOS USUARIOS TIENEN DE CONTRASEÑA 12345*/
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('000000000', 1, 'ADMIN', 'ADMIN ADMIN', 'Hombre', '827ccb0eea8a706c4c34a16891f84e7b', '0', true, true);
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('111111111', 1, 'USUARIO', 'DE PRUEBAS', 'Hombre', '827ccb0eea8a706c4c34a16891f84e7b', '0', false, false);
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('222222222', 1, 'ENTRENADOR', 'DE PRUEBAS', 'Mujer', '827ccb0eea8a706c4c34a16891f84e7b', '0', false, true);

GRANT ALL PRIVILEGES ON awgp.* to AWGPusr@localhost identified by "AWGPass";
