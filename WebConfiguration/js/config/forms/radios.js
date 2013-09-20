var radios = {
    add : function() {
        var json = {
            "name" : inputs.RadioName.valeur(),
            "icon" : inputs.RadioIcone.valeur(),
            "adress"  : inputs.RadioUrl.valeur()
        };
            
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
    
    change : function() {
        var json = {
            "name" : $("#C-RadioName").val(),
            "icon" : $("#C-RadioIcone").val(),
            "adress"  : $("#C-RadioUrl").val()
        };
        
        var ans = $("#C-previous-name").html();
        
        if( json.icon === "" )
            json.icon = "img/missing-img.png";
        
        $.ajax({
            type: "GET",
            url: "functions/webradios.php?remove=" + ans + "&add=" + JSON.stringify(json),
            dataType: "html",
            success: function(data){
                $("#radios-list tbody").replaceWith("<tbody>" + data + "</tbody>");
                radios.connectAll();
                config.generalErreur("success", "Liste des radios modifiée");
                $("#tab-forms>li:first-child>a").tab("show");
            },
            error: function(){
                config.generalErreur("danger", "Un problème est arrivé pendant la modification d'une webradio");
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
            if( config.checkForm("#radio-man") )
                radios.add();
            else
                config.generalErreur("danger", "La webradio n'a pas pu être ajoutée, le formulaire est invalide");
        });
        
        $("#btn_envoyer_C-radio").off("click").click(function(){
            if( config.checkForm("#radio-change") )
                radios.change();
            else
                config.generalErreur("danger", "La webradio n'a pas pu être modifiée, le formulaire est invalide");
        });
        
        $(".radio-rm").off("click").click(function(e){
            var name = $(e.delegateTarget).parent().parent().parent().find(".name").html();
            radios.rm(name);
        });
        
        $(".radio-change").off("click").click(function(e){
            var element = $(e.delegateTarget).parent().parent().parent();
            var name = element.find(".name").html();
            var url = element.find(".adresse>a").attr("href");
            var icon = element.find("td img").attr("src");
            
            $('#tab-forms a[href="#radio-change"]').tab('show');
            $("#C-previous-name").html(name);
            $(document).scrollTop( $("#tab-forms").offset().top );
            
            $("#C-RadioName").val(name);
            $("#C-RadioUrl").val(url);
            $("#C-RadioIcone").val(icon);
            
            config.checkForm("#radio-change");                                  // Juste pour la couleur
        });
    }
};