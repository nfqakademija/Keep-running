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
PRIMARY KEY (`levelId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

INSERT INTO `running_tracks_level` (`levelId`,`levelName`) VALUES
(NULL,'Lengva'),
(NULL,'Vidutinė'),
(NULL,'Sunki');
