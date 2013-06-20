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
            if(onglet == "mail")
                mail.connectInputs();
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
    
    checkInput : function(sel){
        var e = $("#" + sel);
        
        if( e.val() === "" && config.inputP[sel]["obligatoire"] )
            config.erreur("#"+sel, "error", "Champ obligatoire");
        else if( config.inputP[sel]["format"].test( e.val() ) ){
            config.erreur("#"+sel, "success", "");
            return true
        }
        else
            config.erreur("#"+sel, "error", config.inputP[sel]["error"]);
            
        return false;
    },

    //Connecte tous les inputs
    connectInputs : function(){
        //Enregistre la valeure du champ avant l'édition
        $("input").focusin(function(){
            config.initialValue = this.value;
        });
        
        //Check le champ lors de la perte du focus
        $("input").focusout(function(){
            if( config.initialValue != this.value )                             //Quelque-chose a changé
                config.checkInput(this.id);
        });
        
    },
    
    //Configuraton de la validation du formulaire
    inputP : {  "AdresseMail" : {
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
                    "obligatoire" : false }
             }                    
}