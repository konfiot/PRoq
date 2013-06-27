<?php
    /***********************************************************************
    *   Vérifie l'existance d'une ville dans la base de donnée météo
    *       - Argument "city" = nom de la ville à vérifier
    ***********************************************************************/
    $json = file_get_contents("http://api.openweathermap.org/data/2.5/find?mode=json&q=" . $_GET["city"]);
    $json = json_decode($json, true);
    
    if( $json["count"] > 0 )
        echo "true";
    else
        echo "false";
    
?>