var mail = {
    
    connectInputs : function(){
        //Quand on enleve le focus de l'adresse mail ca change l'adresse du serveur par defaut
        $("#AdresseMail").focusout(function(){        
            var c = $("#AdresseMail");
            var serv = c.val();
            config.config.mail.username = serv.substring(0, serv.indexOf("@")); //On enregistre le nom d'utillisateur mail dans le json
            
            serv = serv.substring(serv.indexOf("@")+1, serv.length);            //On isole le sufixe de l'adresse mail
    
            if( (serv !== "") )                                                 //Si quelque chose est entré dans le champ mail et rien dans le serveur, on cherche le serveur mail
                $.ajax({
                    type: "GET",
                    url: "functions/servmail.php?adresse=" + serv,
                    dataType: "text",
                    success: function(serveur){
                        if( (serveur === "") && ($("#ServMail").val() === "") ){
                            config.erreur("#ServMail", "error", "Impossible de trouver le serveur");
                            $("#ServMail").attr("placeholder", "A indiquer manuellement");
                        }
                        else{
                            $("#ServMail").attr("placeholder", serveur);
                            config.erreur("#ServMail", "success", "");
                        }
                    }
                });
            else if( $("#ServMail").val() === "" ){
                $("#ServMail").attr("placeholder", "Facultatif");               //Si rien n'est inscrit, on reset le champ mail
                config.erreur("#ServMail", "", "");
            }
        });
        
    }
    
};