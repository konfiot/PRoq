<?php
    /***********************************************************************
    *   
    ***********************************************************************/
    
    $cron = shell_exec("crontab -l");
    echo toJson($cron);
    
    // Pour éditer
    //shell_exec("echo '5 3 * * * http ls' >> ../../conf/wake.cron");
    //shell_exec("crontab ../../conf/wake.cron");
    
    //echo shell_exec("crontab -l");
    
    function toJson($cron) {
        $cron = split("\n", $cron);
        $json = array();
        
        foreach($cron as $j) {                      // Lignes
            if( $j[0] == "#" ) {                    // Si ca c'est commenté
                $disabled = true;
                $j = substr($j, 1);
            }
            else $disabled = false;
            
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
                    "disabled" => $disabled
                );
                $json[$name] = $line;
            }
        }
        
        return json_encode($json, true);
    }
?>