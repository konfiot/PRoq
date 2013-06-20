$(function() {  //Executé après le chargement
/*******************************************************************************************************************************
**                                                  Gestion du menu                                                           **        
*******************************************************************************************************************************/

    $(".leftnav").mousedown(function(e){//Quand on clic sur un élément du menu
        $(".leftnav").removeClass("active");                                    //On desactive tout
        $(e.delegateTarget).addClass("active");                                 //On active le bon
        
        //---------------------
        
        var onglet = $(e.delegateTarget).children("a").attr("href");            //On choppe l'id ciblé par le lien
        onglet = onglet.substring(1, onglet.length);                            //On vire le '#'
    
        $(".hero-unit").load("forms/" + onglet + ".html", function(){           //On envoit la requette
            config.connectInputs();                                             //On connecte les inputs
        });
    });      
    
/****/
});             //Executé après le chargement {fin}


/*******************************************************************************************************************************
**                                                 Gestion des formulaires                                                    **        
*******************************************************************************************************************************/


var config = {
    initialValue : "",                                                          //Une variable qui contient la valeure initiale du champ édité
    
    //Une fonction qui sert à éditer l'erreur ; sel est l'id du champ
    erreur: function(sel, type, message) {
        var el = $(sel);
        el.parent().parent().removeClass("success error").addClass(type);
        el.parent().children(".help-inline").html(message);
    },
    
    //Pour afficher une erreur en bas de la page
    generalErreur: function(type, message) {
        if(message == "")
            $("#generalErreur").addClass("hide");
        else{
            $("#generalErreur").removeClass("hide alert-success alert-danger");
            $("#generalErreur").addClass(type).html(message);
        }
    },

    //Connecte tous les inputs
    connectInputs : function(){
        //Enregistre la valeure du champ avant l'édition
        $("input").focusin(function(){
            config.initialValue = this.value;
        });
        
        //Check le champ lors de la perte du focus
        $("input").focusout(function(){
            if( config.initialValue == this.value ) return;                     //Rien n'a changé
            
            if(this.value === "" && config.inputP[this.id]["obligatoire"])
                config.erreur("#"+this.id, "error", "Champ obligatoire");
            else if(config.inputP[this.id]["format"].test(this.value))
                config.erreur("#"+this.id, "success", "");
            else
                config.erreur("#"+this.id, "error", config.inputP[this.id]["error"]);
        });
        
        //Quand on enleve le focus de l'adresse mail ca change l'adresse du serveur par defaut
        $("#AdresseMail").focusout(function(){        
            var c = $("#AdresseMail");
            var serv = c.val()
            serv = serv.substring(serv.indexOf("@")+1, serv.length);            //On isole le sufixe de l'adresse mail

            if( serv !== "")                                                    //Si quelque chose est entré dans le champ serveur, on cherche le serveur mail
                $.ajax({
                    type: "GET",
                    url: "functions/webmail.php?adresse=" + serv,
                    dataType: "text",
                    success: function(serveur){
                        $("#ServMail").attr("placeholder", serveur);
                        config.erreur("#ServMail", "succes", "");
                        
                        if(serveur === ""){
                            config.erreur("#ServMail", "error", "Impossible de trouver le serveur");
                            $("#ServMail").attr("placeholder", "A indiquer manuellement");
                        }                        
                    }
                });
            else{
                $("#ServMail").attr("placeholder", "Facultatif");               //Si rien n'est inscrit, on reset le champ mail
                config.erreur("#ServMail", "", "");
            }
        });
        
    },
    
    //Configuraton de la validation du formulaire
    inputP : {"AdresseMail" : {
                    "error" : "Adresse mail invalide",
                    "format" : /^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/,
                    "obligatoire" : true },
                  "MailPassword" : {
                    "error" : "Mot de passe non valide",
                    "format" : /()/,
                    "obligatoire" : true },
                  "ServMail" : {
                    "error" : "Serveur mail incorrect",
                    "format" : /()/ ,
                    "obligatoire" : false } }                    
}