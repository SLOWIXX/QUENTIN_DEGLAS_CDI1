<?php

function calculerMoyenne($nombre1, $nombre2, $nombre3) {
    return ($nombre1 + $nombre2 + $nombre3) / 3;
}

function afficherResultat($nom, $moyenne) {
    if ($moyenne >= 10) {
        echo "L'élève $nom a une moyenne de $moyenne : Résultat suffisant.<br>";
    } else {
        echo "L'élève $nom a une moyenne de $moyenne : Résultat insuffisant.<br>";
    }
}

$nom = "Alice";
$moyenne = calculerMoyenne(10, 20, 15);
afficherResultat($nom, $moyenne);
?>