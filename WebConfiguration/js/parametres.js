$(function() {  //Executé après le chargement
/*******************************************************************************************************************************
**                                                  Gestion du menu                                                           **        
*******************************************************************************************************************************/

$(".leftnav").mousedown(function(e){//Quand on clic sur un élément du menu
    $(".leftnav").removeClass("active");                                //On desactive tout
    $(e.delegateTarget).addClass("active");                             //On active le bon
    
    //---------------------
    
    var onglet = $(e.delegateTarget).children("a").attr("href");        //On choppe l'id ciblé par le lien
    onglet = onglet.substring(1, onglet.length);                        //On vire le '#'

    $(".hero-unit").load("forms/" + onglet + ".html", function(){       //On envoit la requette
        config.erreur("AdresseMail", "success", "Salut, ca va  ?");
        connectInputs();                                                //On connecte les inputs
    });
    
});

/****/
});             //Executé après le chargement {fin}


/*******************************************************************************************************************************
**                                                Gestion des formulaires                                                    **        
*******************************************************************************************************************************/


var config = {
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
    }
}

//Connecte tous les inputs
function connectInputs(){
    //Check le champ lors de la perte du focus
    $("input").focusout(function(){
        if(this.value == "" && inputP[this.id]["obligatoire"])
            config.erreur("#"+this.id, "error", "Champ obligatoire");
        else if(inputP[this.id]["format"].test(this.value))
            config.erreur("#"+this.id, "success", "");
        else
            config.erreur("#"+this.id, "error", inputP[this.id]["error"]);
    });
}

//Configuraton de la validation du formulaire
var inputP = {"AdresseMail" : {
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
                "obligatoire" : false } };
