/*******************************************************************************************************************************
**                                               Gestion de l'autoconfig                                                      **        
*******************************************************************************************************************************/
var autoConfig = {
    mail : function(){
        //Quand on enleve le focus de l'adresse mail ca change l'adresse du serveur par defaut
        $("#AdresseMail").on("changed", function(){        
            var c = $("#AdresseMail");
            var serv = c.val();
            var e = inputs.ServMail;
            config.config.mail.username = serv.substring(0, serv.indexOf("@")); //On enregistre le nom d'utillisateur mail dans le json
            
            serv = serv.substring(serv.indexOf("@")+1, serv.length);            //On isole le sufixe de l'adresse mail
    
            if( (serv !== "") )                                                 //Si quelque chose est entré dans le champ mail et rien dans le serveur, on cherche le serveur mail
                $.ajax({
                    type: "GET",
                    url: "functions/servmail.php?adresse=" + serv,
                    dataType: "text",
                    success: function(serveur){
                        if( (serveur === "") && ($("#ServMail").val() === "") ){
                            e.manset("Ex : imap.googlemail.com");
                        }
                        else{
                            e.autoset(serveur);
                        }
                    }
                });
            else if( $("#ServMail").val() === "" ){
                e.autoset("Facultatif");                      //Si rien n'est inscrit, on reset le champ mail
                e.erreur("", "");
            }
        });
    },
    port : function(){
        //Quand on enleve le focus de l'adresse mail ca change l'adresse du serveur par defaut
        $("#AdresseMail").on("changed", function(){        
            var c = $("#AdresseMail");
            var serv = c.val();
            var e = inputs.PortMail;
            
            serv = serv.substring(serv.indexOf("@")+1, serv.length);            //On isole le sufixe de l'adresse mail
    
            if( (serv !== "") )                                                 //Si quelque chose est entré dans le champ mail
                $.ajax({
                    type: "GET",
                    url: "functions/servmail.php?champ=port&adresse=" + serv,
                    dataType: "text",
                    success: function(serveur){
                        if( (serveur === "") && ($("#PortMail").val() === "") ){
                            e.manset("Ex : 993");
                        }
                        else{
                            e.autoset(serveur);
                        }
                    }
                });
            else if( $("#PortMail").val() === "" ){
                e.autoset("Facultatif");                      //Si rien n'est inscrit, on reset le champ mail
                e.erreur("", "");
            }
        });
    },
    ssl : function(){
        $("#AdresseMail").on("changed", function(){        
            var c = $("#AdresseMail");
            var serv = c.val();
            var e = inputs.MailSsl;
            
            serv = serv.substring(serv.indexOf("@")+1, serv.length);            //On isole le sufixe de l'adresse mail
    
            if( serv !== "")                                                    //Si quelque chose est entré dans le champ mail
                $.ajax({
                    type: "GET",
                    url: "functions/servmail.php?champ=socketType&adresse=" + serv,
                    dataType: "text",
                    success: function(serveur){
                        if( serveur !== "" ){
                            e.valeur( serveur == "SSL" );
                        }
                    }
                });
        });
    },
    ville : function(){
        $("#btn-find-pos").click(function(){
            inputs.MeteoPos.valeur(geoplugin_city());
        });
    }
};