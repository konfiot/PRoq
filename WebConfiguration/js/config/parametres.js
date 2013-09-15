$.ajaxSetup ({
    cache: false                                                                //Pour ne pas utiliser le cache en dev
});

$(function() {  //Executé après le chargement
/*******************************************************************************************************************************
**                                                  Gestion du menu                                                           **        
*******************************************************************************************************************************/

    $(".leftnav").mousedown(function(e){    //Quand on clic sur un élément du menu
        $(".leftnav").removeClass("active");                                    //On desactive tout
        $(e.delegateTarget).addClass("active");                                 //On active le bon
        
        //----------------------------
        
        config.loadForm(window.location.hash.slice(1));

    });
    
    /**************************************************************************/
    
    $.getJSON("functions/config.php", function(donnees){                        //On recupère la configuration sur le serveur
        config.config = donnees;
        
    
        /**********************************************************************/
        //Pour afficher le bon formulaire si il y a une ancre
        config.loadForm(window.location.hash.slice(1));
    });
    
/****/
});             //Executé après le chargement {fin}

//Quand l'ancre change
$(window).bind('hashchange', function(){
   config.loadForm(window.location.hash.slice(1));
});

/*******************************************************************************************************************************
**                                                 Gestion des formulaires                                                    **        
*******************************************************************************************************************************/


var config = {
    initialValue : "",                                                          //Une variable qui contient la valeur initiale du champ édité
    onglet : "defaut",                                                          //Contient l'onglet actuel
    config : {},                                                                //Et celle - ci la configuration json
    
    //Pour changer le formulaire affiché
    loadForm : function(formulaire){
        if(formulaire === "")
            formulaire = "defaut";
            
        $("#main").load("forms/" + formulaire + ".php", function(){    //On envoit la requette
            config.connectAll();                                                //On connecte les inputs
        
            config.resetForm();                                                 //On met les valeurs existantes
            config.checkForm();                                                 //On colore les champs
            
            $('.switch')['bootstrapSwitch']();
        });
        
        $(".leftnav>a").each(function(e) {
            $(".leftnav>a")[e].parentNode.className = "leftnav";
            if("#" + $(".leftnav>a")[e].href.split('#')[1] == window.location.hash){
                $(".leftnav>a")[e].parentNode.className = "leftnav active";
            }
        });
    },

    //Une fonction qui sert à éditer l'erreur ; sel est l'id du champ
    erreur: function(sel, type, message) {
        var el = $(sel);
        el.parent().parent().removeClass("has-success has-error has-warning").addClass("has-" + type);
        el.show();
        
        if( message !== "" )
            el.parent().parent().children(".help-block").show().html(message);
        else
            el.parent().parent().children(".help-block").hide();
    },
    
    //Pour afficher une erreur en bas de la page
    generalErreur: function(type, message) {
        var date = new Date();                                                  //On récupère l'heure actuelle
        var prefixe = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
        prefixe = "<strong>" + prefixe + "</strong> - ";
        
        if(message === "")
            $("#generalErreur").addClass("hide");
        else{
            $("#generalErreur").removeClass("hide alert-success alert-danger alert-info");
            $("#generalErreur").addClass("alert-" + type).html(prefixe + message);
        }
    },
    
    //Réinscrit les valeurs du json dans les champs
    resetForm : function(){
        $(".form-element").each(function(e){
            var champ = inputs[this.id].champ,
                categorie = inputs[this.id].categorie;
                
            inputs[this.id].valeur( config.config[categorie][champ] );
        });
    },
    
    //Verifie tous les champs et remet en forme
    checkForm : function(){
        var test = true;
        $(".form-element").each(function(e){
            test = inputs[this.id].isValid() ? test : false;
        });
        return test;
    },
    
    sendForm : function(){
        if( !config.checkForm() ){
            config.generalErreur("danger", "Echec de l'envoit : formulaire invalide");
            return;
        }

        $(".form-element").each(function(e){
            var champ = inputs[this.id].champ,
                categorie = inputs[this.id].categorie;
            config.config[categorie][champ] = inputs[this.id].valeur();
        });
        
        categorie = window.location.hash.slice(1);
        $.ajax({
            type: "GET",
            url: "functions/config.php?categorie=" + categorie + "&value=" + JSON.stringify(config.config[categorie]),
            dataType: "text",
            success: function(){
                config.generalErreur("success", "Le formulaire à été envoyé avec succès");
            },
            error: function(){
                config.generalErreur("danger", "Un problème est arrivé pendant l'envoit du formulaire");
            }
        });
    },

    //Connecte tous les inputs
    connectAll : function(){
        for (var i in inputs) {
            inputs[i].reconnect();
        }
        
        //Pour reset le formulaire
        $("#btn_annuler").click(function(){
            dialogs.confirm("#confirmModal",
                function(){     //onOk
                    config.resetForm();
                    config.checkForm();
                },
                function(){     //onNo
                    
                });
        });
        
        $("#btn_envoyer").click(config.sendForm);        
    }
};

/*******************************************************************************************************************************
**                                              Configuration des éléments                                                    **        
*******************************************************************************************************************************/

var inputs = {
    //Paramètres des mails    --------------------------------------------------
    "AdresseMail": new elementInput("#AdresseMail",
        "mail",
        "full_adress",
        [
            {
                "format": /\S+/,
                "msg": {
                    "type": "error",
                    "text": "Champ obligatoire"
                }
            },
            {
                "format": /^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/,
                "msg": {
                "type": "error",
                "text": "Adresse mail invalide"
                }
            }
        ],
        function(){}
    ),
    "MailPassword": new elementInput("#MailPassword",
        "mail",
        "passwd",
        [
            {
                "format": /\S+/,
                "msg": {
                    "type": "error",
                    "text": "Champ obligatoire"
                }
            }
        ],
        function(){}
    ),
    "ServMail": new elementInputAuto("#ServMail",
        "mail",
        "server",
        [
            {
                "format": /\S+/,
                "msg": {
                    "type": "warning",
                    "text": "A remplir manuellement"
                }
            }
        ],
        autoConfig.mail
    ),
    "PortMail": new elementInputAuto("#PortMail",
        "mail",
        "port",
        [
            {
                "format": /\S+/,
                "msg": {
                    "type": "warning",
                    "text": "A remplir manuellement"
                }
            },
            {
                "format": /^[0-9]{1,5}$/,
                "msg": {
                    "type": "error",
                    "text": "Le port doit etre un nombre compris entre 1 et 65535"
                }
            }
        
        ],
        autoConfig.port
    ),
    "MailSsl": new elementSwitch("#MailSsl",
        "mail",
        "ssl",
        [ ],
        autoConfig.ssl
    ),
    //Paramètresdu calendrier    -----------------------------------------------
    "CalendarUrl": new elementInput("#CalendarUrl",
        "calendar",
        "url",
        [
            {
                "format": /\S+/,
                "msg": {
                    "type": "error",
                    "text": "Champ obligatoire"
                }
            }
        ],
        function(){}
    ),
    //Paramètres de la météo    ------------------------------------------------
    "MeteoPos": new elementInput("#MeteoPos",
        "weather",
        "location",
        [
            {
                "format": /\S+/,
                "msg": {
                    "type": "error",
                    "text": "Champ obligatoire"
                }
            },
            {
                "format": autoConfig.checkCity,
                "msg": {
                    "type": "warning",
                    "text": "Cette ville n'est pas référencé"
                }
            }
        ],
        autoConfig.ville
    ),
    //Paramètres des news    ---------------------------------------------------
    "NewsProvider": new elementList("#NewsProvider",
        "news",
        "provider",
        [
            {
                "format": /\S+/,
                "msg": {
                    "type": "error",
                    "text": "Champ obligatoire"
                }
            }
        ],
        function(){}
    ),
    "NewsUser": new elementInput("#NewsUser",
        "news",
        "user",
        [
            {
                "format": /\S+/,
                "msg": {
                    "type": "error",
                    "text": "Champ obligatoire"
                }
            }
        ],
        function(){}
    ),
    "NewsPassword": new elementInput("#NewsPassword",
        "news",
        "passwd",
        [
            {
                "format": /\S+/,
                "msg": {
                    "type": "error",
                    "text": "Champ obligatoire"
                }
            }
        ],
        function(){}
    )
};