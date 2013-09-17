<?php
    /***************************************************************************
    * Pour éditer et lire la liste des webradios
    ***************************************************************************/
    
    // Lecture du Json
    $path = "../../conf/webradios.json";
    
    $fichier = fopen($path, 'r+');
    $json = fread($fichier, filesize($path));
    $p_json = json_decode($json, true);
    
    if ( isset($_GET["add"]) ) {
        $p_add = json_decode($_GET["add"], true);
        $json = rmRadio($p_json, $p_add["name"] );             // Pour éviter les doublés
        echo $json = addRadio(json_decode($json, true), $p_add);
        
        fseek($fichier, 0);
        ftruncate($fichier, 0);
        fputs($fichier, $json);
    }
    
    else if ( isset($_GET["remove"]) ) {
        echo $json = rmRadio($p_json, $_GET["remove"]);
        
        fseek($fichier, 0);
        ftruncate($fichier, 0);
        fputs($fichier, $json);
    }
    
    else {
        
        if( $_GET["format"] == "html" )
            echo toHtmlTable($p_json);
            
        else if( $_GET["format"] == "json" )
            echo $json;
        
    }
    
    fclose($fichier);
    

    /* ********************************************************************** */

    // Pour enlever une radio (deux arrays)
    function rmRadio ($json, $name) {
        foreach( $json["list"] as $key => $i ) {
            if( $i["name"] == $name )
                unset($json["list"][$key]);
        }
        return json_encode($json);
    }
    
    // Pour ajouter une radio (deux arrays)
    function addRadio ($json, $radio) {
        array_push($json["list"], $radio);
        return json_encode($json);
    }

    // Pour réduire l'adresse
    function shortUrl($fullUrl) {
        if( strpos($fullUrl, "//") != 0 )
            $fullUrl = substr($fullUrl, strpos($fullUrl, "//")+2);
        if( strpos($fullUrl, "/", 1) != 0 )
            $fullUrl = substr($fullUrl, 0 , strpos($fullUrl, "/", 1));
            
            return $fullUrl;
    }
    
    
    function toHtmlTable($json) {
        $r = "<!-- ---------------------- Liste des webradios ----------------------!>\n";
        
        foreach( $json["list"] as $i ) {
            
            $r .= '
                <tr class="radio-desc" >
                    <td><img src="' .$i["icon"]. '" class="icon" /></td>
                    <td class="name" >' .$i["name"]. '</td>
                    <td class="adresse">
                        <a target="_blank" href="' .$i["adress"]. '" >' .shortUrl($i["adress"]). '</a>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-sm"><i class="icon-pencil"></i> Modifier</button>
                            <button type="button" class="btn btn-danger btn-sm"><i class="icon-remove"></i> Supprimer</button>
                        </div>
                    </td>
                </tr>
            ';
        }
        
        $r .= "\n<!-- -----------------------------------------------------------------!>";
        return $r;
    }

?>