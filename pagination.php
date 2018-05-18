<?php


function maPagination($nombre_elements_total, $page_actuelle, $nom_variable_get = "pg", $nb_elements_par_pg = 5) {
    // on calcul ne nb de pages en divisant le nb total par le nombre par page en arrondissant à l'entier supérieur (ceil)
    $nb_pg = ceil($nombre_elements_total / $nb_elements_par_pg);
    // si on a qu'une seule page
    if ($nb_pg < 2) {
        // on renvoie la page 1 non cliquable, ce qui arrête la fonction
        return "<div>page 1</div>";
    }
    // ouverture de la variable de sortie (string)
    $sortie = "<div>";
    // tant qu'on a des pages
    for ($i = 1; $i <= $nb_pg; $i++) {
        // si on est au premier tour de boucle
        if ($i == 1) {
            // si c'est la page actuelle
            if ($page_actuelle == $i) {
                $sortie .= "|<< ";
                $sortie .= "<<&nbsp;&nbsp; ";
                $sortie .= "$i ";
                // retour en arrière pour page 2
            } elseif($page_actuelle == 2) {
                $sortie .= "<a href='./' title='First'>|<<</a> ";
                $sortie .= "<a href='./'><<</a>&nbsp;&nbsp; ";
                // pas de variable GET de pagination sur l'accueil
                $sortie .= "<a href='./'>$i</a> ";
                // on est sur une autre page
            }else {
                $sortie .= "<a href='./' title='First'>|<<</a> ";
                $sortie .= "<a href='?$nom_variable_get=" . ($page_actuelle - 1) . "'><<</a>&nbsp;&nbsp; ";
                // pas de variable GET de pagination sur l'accueil
                $sortie .= "<a href='./'>$i</a> ";
            }
            // sinon si on est au dernier tour
        } elseif ($i == $nb_pg) {
            // si c'est la page actuelle
            if ($page_actuelle == $i) {
                $sortie .= "$i ";
                $sortie .= "&nbsp;&nbsp; >> ";
                $sortie .= " >>|";
                // on est sur une autre page
            } else {
                $sortie .= "<a href='?$nom_variable_get=$i'>$i</a> ";
                $sortie .= "&nbsp;&nbsp;<a href='?$nom_variable_get=" . ($page_actuelle + 1) . "'>>></a> ";
                $sortie .= " <a href='?$nom_variable_get=$nb_pg' title='Final'>>>|</a>";
            }
            // sinon (tous les autres tours)
        } else {
            if ($page_actuelle == $i) {
                $sortie .= " $i ";
            } else {
                // affichage de la variable GET et de sa valeur en lien
                $sortie .= "<a href='?$nom_variable_get=$i'>$i</a> ";
            }
        }
    }
    $sortie .= "</div>";
    return $sortie;

    //return $nombre_elements_total."|".$page_actuelle."|".$nom_variable_get."|".$nb_elements_par_pg;
}