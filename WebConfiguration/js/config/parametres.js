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
            config.connectInputs();                                             //On connecte les inputs
            if(config.onglet == "mail")
                mail.connectInputs();
        
            config.resetForm();                                                 //On met les valeures existantes
            config.checkForm();                                                 //On colore les champs
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
    initialValue : "",                                                          //Une variable qui contient la valeure initiale du champ édité
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
        if(message == "")
            $("#generalErreur").addClass("hide");
        else{
            $("#generalErreur").removeClass("hide alert-success alert-danger");
            $("#generalErreur").addClass(type).html(message);
        }
    },
    
    resetForm : function(){
        $("input").each(function(e){
            var champ = config.inputP[this.id]["nomChamp"];
            this.value = config.config[config.onglet][champ];
        });
    },
    
    //Verifie si un champ est valide et le met en forme
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
    
    //Verifie tous les champs et remet en forme
    checkForm : function(){
        var test = true;
        $("input").each(function(e){
            test = config.checkInput(this.id) ? test :false;
        });
        return test;
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
        
        //Pour reset le formulaire
        $("#btn_annuler").click(function(){
            $("#confirmModal").modal("show");
            
            $("#confirmModalOui").click(function(){
                config.resetForm();
                $("#confirmModal").modal("hide");
                config.checkForm();
            });
            $("#confirmModalNon").click(function(){
                $("#confirmModal").modal("hide");
            });
        });
        
    },
    
    //Configuraton de la validation du formulaire
    inputP : {  "AdresseMail" : {
                    "nomChamp" : "full_adress",
                    "error" : "Adresse mail invalide",
                    "format" : /^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/,
                    "obligatoire" : true },
                "MailPassword" : {
                    "nomChamp" : "passwd",
                    "error" : "Mot de passe non valide",
                    "format" : /()/,
                    "obligatoire" : true },
                "ServMail" : {
                    "nomChamp" : "server",
                    "error" : "Serveur mail incorrect",
                    "format" : /()/ ,
                    "obligatoire" : false }
             }                    
}