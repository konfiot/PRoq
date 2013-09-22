<?php
    /***************************************************************************
    * Pour chercher des webradios
    ***************************************************************************/
    
    if( !isset($_GET["format"]) ) $_GET["format"] = "html";
    
    $json = file_get_contents("http://opml.radiotime.com/Search.ashx?render=json&query=" . $_GET["q"]);
    $json = json_decode($json, true);
    $json = changeJson($json);
    
    if( $_GET["format"] == "json" )
        echo json_encode($json);
        
    else if( $_GET["format"] == "html" )
        echo toHtml(array_slice($json, 0, 10));
    
    
    /* ********************************************************************** */
    
    
    function changeJson($before) {
        $after = array();
        foreach($before["body"] as $i ) {
            if($i["type"] == "audio") {
                $r["name"] = $i["text"];
                $r["adress"] = $i["URL"];
                $r["icon"] = $i["image"];
                
                $after[] = $r;
            }
        }
        return $after;
    }

    // Pour réduire l'adresse
    function shortUrl($fullUrl) {
        if( strpos($fullUrl, "//") != 0 )
            $fullUrl = substr($fullUrl, strpos($fullUrl, "//")+2);
        if( strpos($fullUrl, "/", 1) != 0 )
            $fullUrl = substr($fullUrl, 0 , strpos($fullUrl, "/", 1));
            
            return $fullUrl;
    }
    
    function toHtml($json) {
        $r = "<!-- ---------------------- Resultat de recherche ----------------------!>\n";
        foreach( $json as $i ) {
            $r .= '
                <tr class="radio-desc" title="Ajouter" >
                    <td><img src="' .$i["icon"]. '" class="icon" /></td>
                    <td class="name" >' .$i["name"]. '</td>
                    <td class="adresse">
                        <a target="_blank" href="' .$i["adress"]. '" title="' .$i["adress"]. '" >' .shortUrl($i["adress"]). '</a>
                    </td>
                </tr>
            ';
        }
        
        $r .= "\n<!-- -----------------------------------------------------------------!>";
        return $r;
    }

?>

