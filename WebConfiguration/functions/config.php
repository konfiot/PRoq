<?php
    /***********************************************************************
    *   Modifie ou donne le fichier de  configuration
    *       - Argument "categorie" = categorie du champ  (retourne json entier si vide)
    *       - Argument "champ"     = nom du champ        (retourne json entier si vide)
    *       - Argument "value"     = valeure à lui donner (retourne valeure du champ si vide)
    ***********************************************************************/
    
    include('environement.php');
    
    $path = $configuration_folder.'wake.json';     
	$json = file_get_contents($path);
	 
    if( isset($_GET["categorie"])){                                 //Categorie entree
        $json = json_decode($json, true);
        if( isset($_GET["champ"]) ){                                    //Champ entré
            if( isset($_GET["value"]) ){                                    //Valeure à definir
                $json[ $_GET["categorie"] ][ $_GET["champ"] ] = $_GET["value"];
                echo $json = json_encode($json);
                
				$fichier = fopen($path, 'w');
                fwrite($fichier, $json);
				fclose($fichier);
            }
            else{                                                           //Pas de valeure a definir
                echo $json[ $_GET["categorie"] ][ $_GET["champ"] ];
            }
        }
        else{                                                           //Le champ n'est pas entré
            if( isset($_GET["value"]) ){                                    //Une valeure à définir
                $entree = json_decode($_GET["value"], true);
                $json[ $_GET["categorie"] ] = $entree;
                echo $json = json_encode($json);
                
				$fichier = fopen($path, 'w');
                fwrite($fichier, $json);
				fclose($fichier);
            }
            else{                                                           //Retourne juste les données d'une categorie
				echo $json = json_encode($json[ $_GET["categorie"] ]);
            }
        }
    }
    else{                                                           //On retourne le contenu brut du fichier       
	   echo $json;
    }
?>