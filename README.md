# tchat
Tchat responsive en ajax Webdev CF2m 2018

## 30/04/218
! modification de structure de la table theuser

DROP TABLE IF EXISTS `theuser`;
CREATE TABLE IF NOT EXISTS `theuser` (
  `idutil` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `themail` varchar(255) NOT NULL,
  `thelogin` varchar(50) NOT NULL,
  `thepwd` varchar(64) NOT NULL,
  `thekey` varchar(64) DEFAULT NULL,
  `thevalidate` tinyint(3) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`idutil`),
  UNIQUE KEY `thelogin_UNIQUE` (`thelogin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

## Travail colaboratif de la classe web 2018 du CF2m
Nous noterons ici le cahier des charges et la répartition des tâches (voir dans Projects pour celle-ci et dans Issues pour la gestion des bugs)
