 -- CREATE DATABASE `KeepRunning`;

CREATE TABLE IF NOT EXISTS `running_tracks`(
`trackId` INTEGER(10) NOT NULL AUTO_INCREMENT, 
`trackStartPointLongtitude` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL, 
`trackStartPointLatitude` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
`trackPoints` TEXT CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
`trackDistance` INTEGER(10) UNSIGNED NOT NULL,
`trackLevelId` INTEGER(4) NOT NULL,
`trackName` TEXT CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
PRIMARY KEY (`trackId`)
)ENGINE=InnoDb  DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

CREATE TABLE IF NOT EXISTS `running_tracks_level`(
`levelId` INTEGER(10) NOT NULL AUTO_INCREMENT,
`levelName`  VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL UNIQUE,
`levelDescription` TEXT CHARACTER SET utf8 COLLATE utf8_lithuanian_ci,
PRIMARY KEY (`levelId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

INSERT INTO `running_tracks_level` (`levelId`,`levelName`,`levelDescription`) VALUES
(NULL,'Lengva','Šios trasos skirtos pradedantiesiems bėgikams, kurie nori pradėti bėgioti, bet nežino kur bėgti. Šio lygio trasos yra nesunkiai įveikiamos ir nereikalaujančios itin gero sportinio pasirošimo.'),
(NULL,'Vidutinė','Vidutinio lygio trasos skirtos bėgikams, kurie bėga ne pirmą kartą ir žino savo bėgimo galimybes. Šio lygio trasos reikalauja pasiruošimo ir ypač geros nuotaikos bėgant pasirinkus vieną iš trasų.'),
(NULL,'Sunki','Sunki trasa skirta bėgikams, kurie nori tikro iššukio. Šio lygio trasa reikalauja ištvernės, ryžto ir gero pasirošimo. Įveikus vieną iš šio lygio trasų galėsite save vadinti tikru bėgimo meistru.');
