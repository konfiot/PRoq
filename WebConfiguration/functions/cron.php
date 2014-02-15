<?php
    /***********************************************************************
    *                       Modification du crontab
    * - Rien : donne le cron convertis en JSON
    * - Add : pour ajouter une ligne au cron
    * - Rm : supprime la ligne du nom donné
    * - Argument "next" : retourne un json contenant : en 'ligne' : les caractéristiques de la prochaine alarme ; en 'heure' : le timestamp de la prochaine occurence
    *       example : http://[...]/functions/cron.php?next
    * - Argument "change" : entrée : {"h" : heure, "m" : minutes} change l'heure de sonnerie pour une sonnerie
    *       example : http://[...]/functions/cron.php?change={"h":7,"m":30}
    ***********************************************************************/
    
    include('environement.php');
    
    $path = $configuration_folder.'wake.cron';
    $path_temp = $configuration_folder.'wake.temp.cron';
    
    $fichier = fopen($path, 'r+');                                       // On ouvre le fichier de cron
    $cron = fread($fichier, filesize($path));                                   // On lis le contenu du cron
    fclose($fichier);
    
    $cron = parse($cron);               // On le convertis en array
    
    if( isset($_GET['change']) ) {
        changeTomorrow( json_decode($_GET['change'], true) , $configuration_folder);
        return;
    }
    
    if( isset($_GET['next']) ) {
        echo json_encode(nextRing($cron));
        return;
    }
    
    if( isset($_GET['add']) ) {         // On ajoute ce qui est dans l'argument 'add'
        $line = add( $_GET['add'] );
        $cron[ $line["name"] ] = $line;
    }
    
    if( isset($_GET['rm']) ) {          // On enlève les éventuels éléments à enlever
        unset( $cron[ $_GET['rm'] ] );
    }
    
    echo json_encode($cron);            // On retourne le tout en Json
    
    
    // Pour éditer le fichier
    
    $fichier = fopen($path, 'r+');
    
    fseek($fichier, 0);                 // on modifie le cron
    ftruncate($fichier, 0);
    fputs($fichier, toCron($cron));
    
    fclose($fichier);
    
    shell_exec("crontab $path");
    
    return;
    
    
    /* ***************************** Fonctions ****************************** */
    
    function changeTomorrow($change, $path) {
        $file = fopen($path."wake.temp.cron", 'w');
        fputs($file, $change['m']." ".$change['h']." * * * echo 'ca sonne !'  | wall \n");
        fputs($file, $change['m']." ".$change['h']." * * * crontab ".realpath($path."wake.cron")."\n");
        fclose($path."wake.temp.cron");

        shell_exec("crontab ".$path."wake.temp.cron");
    }
    
    function nextRing($json) {
        $next = array();
        foreach($json as $name => $line) {
            if($json[$name]['enable']) {
                if( (nextLineRing($next) > nextLineRing($json[$name])) || $next == array() ){// Cette ligne s'active dans moins longtemps
                    $next = $json[$name];
                }
            }
        }
        return array('heure' => nextLineRing($next),
                     'ligne' => $next);
    }
    
    // Retourne l'heure de sonnerie d'une ligne
    function nextLineRing($l) {
        if( $l == array() ) return 0;
        $t = strtotime("-1 day", mktime($l['h'], $l['m'], 0));                  // A l'heure de la sonnerie, hier
        while($t < time() || !in_array(date('N', $t), $l['dow']) ) {
            $t = strtotime("+1 day", $t);
        }
        return $t;
    }
    
    // Convertis le json de l'argument "add" en une ligne de l'array
    function add($json) {
        $j = json_decode($json, true);
        
        $r = array(
            "m" => $j['horaire']['m'],
            "h" => $j['horaire']['h'],
            "day" => '*',
            "month" => '*',
            "dow" => $j['jours'],
            "command" => '/root/proq/scripts/wakeup.py',
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
            $r .= escapeshellcmd($ligne['command']) .' ';
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
        "actif" : true
     }
    * ****************************************************/
?>
