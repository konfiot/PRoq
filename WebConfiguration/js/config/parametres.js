$(function() {  //Executé après le chargement
/*******************************************************************************************************************************
**                                                  Gestion du menu                                                           **        
*******************************************************************************************************************************/

    $(".leftnav").mousedown(function(e){//Quand on clic sur un élément du menu
        $(".leftnav").removeClass("active");                                    //On desactive tout
        $(e.delegateTarget).addClass("active");                                 //On active le bon
        
        //----------------------------
        
        config.onglet = $(e.delegateTarget).children("a").attr("href");         //On choppe l'id ciblé par le lien
        config.onglet = config.onglet.substring(1, config.onglet.length);       //On vire le '#'
    
        $(".hero-unit").load("forms/" + config.onglet + ".html", function(){    //On envoit la requette
            config.connectAll();                                                //On connecte les inputs
        
            config.resetForm();                                                 //On met les valeurs existantes
            config.checkForm();                                                 //On colore les champs
            
            $('.switch')['bootstrapSwitch']();
        });
    });      
        
    /**************************************************************************/
    
    $.getJSON("functions/config.php", function(donnees){                        //On recupère la configuration sur le serveur
        config.config = donnees;
    });
    
/****/
});             //Executé après le chargement {fin}


/*******************************************************************************************************************************
**                                                 Gestion des formulaires                                                    **        
*******************************************************************************************************************************/


var config = {
    initialValue : "",                                                          //Une variable qui contient la valeur initiale du champ édité
    onglet : "defaut",                                                          //Contient l'onglet actuel
    config : {},                                                                //Et celle - ci la configuration json
    
    //Une fonction qui sert à éditer l'erreur ; sel est l'id du champ
    erreur: function(sel, type, message) {
        var el = $(sel);
        el.parent().parent().removeClass("success error").addClass(type);
        el.parent().children(".help-inline").html(message);
    },
    
    //Pour afficher une erreur en bas de la page
    generalErreur: function(type, message) {
        if(message === "")
            $("#generalErreur").addClass("hide");
        else{
            $("#generalErreur").removeClass("hide alert-success alert-danger alert-info");
            $("#generalErreur").addClass("alert-" + type).html(message);
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
            config.generalErreur("danger", "Formulaire invalide");
            return;
        }

        $(".form-element").each(function(e){
            var champ = inputs[this.id].champ,
                categorie = inputs[this.id].categorie;
            config.config[categorie][champ] = inputs[this.id].valeur();
        });
        
        $.ajax({
            type: "GET",
            url: "functions/config.php?categorie=" + config.onglet + "&value=" + JSON.stringify(config.config[config.onglet]),
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
    //Paramètres des mails
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
                    "type": "info",
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
                    "type": "info",
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
    //Paramètresdu calendrier
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
    //Paramètres de la météo
    "MeteoPos": new elementInput("#MeteoPos",
        "weather",
        "location",
        [
            {
                "format": autoConfig.checkCity,
                "msg": {
                    "type": "warning",
                    "text": "Cette ville n'est pas référencé"
                }
            }
        ],
        autoConfig.ville
    )
};