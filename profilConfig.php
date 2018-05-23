<?php
// constante pour les thumbs (100 px L comme H)
define("THUMB_SIZE",50);

// constantes pour les grandes (800 px L max sur 600 px H max)
define("LARGE_WIDTH",800);
define("LARGE_HEIGHT",600);

// définition de la qualité pour les images .jpg
define("QUALITY_JPG_THUMB",85);
define("QUALITY_JPG_LARGE",90);


// chemin du dossier original (vers lequel sont chargé les fichiers originaux)
$oriDest = "img/profil/ori/";

// chemin du dossier des miniatures (vers lequel sont chargé les fichiers de 100px sur 100px)
$thumbDest = "img/profil/thumbs/";

// chemin du dossier des grandes images pour la galerie (vers lequel sont chargé les fichiers qui garde les proportions de maximum 800px de large  sur maximum 600px de haut)
$galleryDest = "img/profil/large/";

// extensions acceptées
$extAut = [".jpg",".jpeg"];