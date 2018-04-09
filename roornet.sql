CREATE TABLE `roornet`.`Pontos`
(`cod_ponto` INT NOT NULL AUTO_INCREMENT ,
  `nomrua` VARCHAR(100) NOT NULL ,
  `endereco` VARCHAR(100) NOT NULL ,
  `latitude` FLOAT NOT NULL ,
  `longitude` FLOAT NOT NULL ,
  `altitude` FLOAT NOT NULL ,
  PRIMARY KEY (`cod_ponto`)
) ENGINE = InnoDB;