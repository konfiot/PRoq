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
            success: function(data){
                $("#radios-list tbody").replaceWith("<tbody>" + data + "</tbody>");
                radios.connectAll();
                config.generalErreur("success", "Liste des radios modifiée");
            },
            error: function(){
                config.generalErreur("danger", "Un problème est arrivé pendant l'ajout d'une webradio");
            }
        });   
    },
    
    rm : function(name) {
        $.ajax({
            type: "GET",
            url: "functions/webradios.php?remove="  + name,
            dataType: "html",
            success: function(data){
                $("#radios-list tbody").replaceWith("<tbody>" + data + "</tbody>");
                radios.connectAll();
                config.generalErreur("success", "Liste des radios modifiée");
            },
            error: function(){
                config.generalErreur("danger", "Un problème est arrivé pendant la suppression d'une webradio");
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