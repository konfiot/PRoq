var radios = {
    sendForm : function() {
        var json = {
            "name" : inputs.RadioName.valeur(),
            "icon" : inputs.RadioIcone.valeur(),
            "adress"  : inputs.RadioUrl.valeur()
        }
        
        if( json.icon === "" )
            json.icon = "img/missing-img.png";
        
        $.ajax({
            type: "GET",
            url: "functions/webradios.php?add="  + JSON.stringify(json),
            dataType: "text",
            success: function(){
                config.generalErreur("success", "Le formulaire à été envoyé avec succès");
                $("#radios-list tbody").load("functions/webradios.php?format=html"); // A optimiser à l'occasion
            },
            error: function(){
                config.generalErreur("danger", "Un problème est arrivé pendant l'envoit du formulaire");
            }
        });   
    },
    
    connectAll : function(){
        $("#btn_envoyer_radio").click(function(){
            radios.sendForm();
        });
    }
};