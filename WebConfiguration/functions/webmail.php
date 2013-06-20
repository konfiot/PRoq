<?php
    /***********************************************************************
    *   Recherche du serveur mail à l'aide de l'autoconfig mozilla 
    *       - Argument "adresse" = deuxième partie de l'adresse mail
    *       - Argument "protocole" = imap (defaut) ou pop3
    ***********************************************************************/

    if($_GET["protocole"] == "")
        $_GET["protocole"] = "imap";
    

    $dom = new DomDocument;
    $xml = file_get_contents("http://autoconfig.thunderbird.net/v1.1/" . $_GET["adresse"]);
    $dom->loadXML($xml);
    
    $e = $dom->getElementsByTagName("emailProvider")->item(0);
    $e = $e->getElementsByTagName("incomingServer");
    foreach($e as $i)
        if( $i->hasAttribute("type") )
        if( $i->getAttribute("type") == $_GET["protocole"] )
            echo $i->getElementsByTagName("hostname")->item(0)->nodeValue;
?>