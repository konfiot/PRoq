<?php
    /***********************************************************************
    *                       Modification du crontab
    ***********************************************************************/
    
    $file_adress = "../conf/wake.cron";
    
    $cron = shell_exec("crontab -l");   // On lis le contenu du cron
    $cron = parse($cron);               // On le convertis en array
    
    
    if( isset($_GET['add']) ) {         // On ajoute ce qui est dans l'argument 'add'
        $line = add( $_GET['add'] );
        $cron[ $line["name"] ] = $line;
    }
    
    if( isset($_GET['rm']) ) {          // On enlève les éventuels éléments à enlever
        unset( $cron[ $_GET['rm'] ] );
    }

    echo json_encode($cron);            // On retourne le tout en Json
    
    
    // Pour éditer le fichier
    
    $fichier = fopen($file_adress, 'r+');   // On modifie le cron
    
    fseek($fichier, 0);
    ftruncate($fichier, 0);
    fputs($fichier, toCron($cron));
    
    fclose($fichier);
    
    //echo shell_exec("crontab -l");
    
    
    
    
    /* ***************************** Fonctions ****************************** */
    
    // Convertis le json de l'argument "add" en une ligne de l'array
    function add($json) {
        $j = json_decode($json, true);
        
        $r = array(
            "m" => $j['horaire']['m'],
            "h" => $j['horaire']['h'],
            "day" => '*',
            "month" => '*',
            "dow" => $j['jours'],
            "command" => '/root/proq/scripts/wakeup.py '.$j['sonnerie'],
            "enable" => $j['actif'],
            "name" => $j['nom']
        );
        
        return $r;
    }
    
    
    // Convertis l'array dans un format lisible par crontab
    function toCron($array) {
        $r = '';
        foreach($array as $name => $ligne) {
            if( ! $ligne['enable'] )
                $r .= '#';
            $r .= $ligne['m'] .' '. $ligne['h'] .' '. $ligne['day'] .' '. $ligne['month'] .' ';
            $r .= implode(',', $ligne['dow']) .' ';
            $r .= $ligne['command'] .' ';
            $r .= '#'.$name;
            $r .= "\n";
        }
        return $r;
    }
    
    
    // Convertis le cron en array
    function parse($cron) {
        $cron = split("\n", $cron);
        $json = array();
        
        foreach($cron as $j) {                      // Lignes
            if( $j[0] == "#" ) {                    // Si ca c'est commenté
                $enable = false;
                $j = substr($j, 1);
            }
            else $enable = true;
            
            $j = split("#", $j);
            $i = $j[0];
            $name = $j[1];                          // Commentaire donnant le nom
            
            if( $i != null ) {
                $i = split(" ", $i, 6);             // La fin est la commande entière, il y a donc 6 arguments
                
                $line = array(
                    "m" => $i[0],
                    "h" => $i[1],
                    "day" => $i[2],
                    "month" => $i[3],
                    "dow" => split(",", $i[4]),
                    "command" => $i[5],
                    "enable" => $enable,
                    "name" => $name
                );
                $json[$name] = $line;
            }
        }
        
        return $json;
    }
    
    /* ******************** Exemples ********************
    Argument add :
     {
       "nom" : "test",
       "horaire" : {
            "h" : 9,
            "m" : 30
        },
        "jours" : [ 1, 2, 3, 4, 5, 6, 7 ],
        "actif" : true,
        "sonnerie" : "adresse_sonnerie"
     }
    * ****************************************************/
?>