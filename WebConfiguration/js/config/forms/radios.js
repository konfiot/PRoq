var radios = {
    add : function() {
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
            dataType: "html",
            success: function(){
                config.generalErreur("success", "Le formulaire à été envoyé avec succès");
                $("#radios-list tbody").load("functions/webradios.php?format=html", function(){
                    radios.connectAll();
                }); // A optimiser à l'occasion
            },
            error: function(){
                config.generalErreur("danger", "Un problème est arrivé pendant l'envoit du formulaire");
            }
        });   
    },
    
    rm : function(name) {
        $.ajax({
            type: "GET",
            url: "functions/webradios.php?remove="  + name,
            dataType: "html",
            success: function(data){
                //alert(data);
                config.generalErreur("success", "Le formulaire à été envoyé avec succès");
                $("#radios-list tbody").load("functions/webradios.php?format=html", function(){
                    radios.connectAll();
                }); // A optimiser à l'occasion
            },
            error: function(){
                config.generalErreur("danger", "Un problème est arrivé pendant l'envoit du formulaire");
            }
        });
    },
    
    connectAll : function(){
        $("#btn_envoyer_radio").off("click").click(function(){
            radios.add();
        });
        
        $(".radio-rm").off("click").click(function(e){
            var name = $(e.delegateTarget).parent().parent().parent().find(".name").html();
            radios.rm(name);
        });
    }
};