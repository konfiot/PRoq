var requeteSearch;

var radios = {
    add : function() {
        $("#btn_envoyer_radio").button("loading");
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
                $("#btn_envoyer_radio").button("reset");
            },
            error: function(){
                config.generalErreur("danger", "Un problème est arrivé pendant l'ajout d'une webradio");
                $("#btn_envoyer_radio").button("reset");
            }
        });   
    },
    
    change : function() {
        $("#btn_envoyer_C-radio").button("loading");
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
                $("#btn_envoyer_C-radio").button("reset");
                $("#tab-forms>li:first-child>a").tab("show");
            },
            error: function(){
                config.generalErreur("danger", "Un problème est arrivé pendant la modification d'une webradio");
                $("#btn_envoyer_C-radio").button("reset");
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
        $("[title]").tooltip({"container": "body"});
        
        $("#radio-search [title].radio-desc").off("click").click(function(e){
            if( e.target.localName != "a")
                alert("dan");
        });
        
        $("#RadioSearch").keydown(function(){
            $("#radio-search .input-group i").removeClass("icon-search").addClass("icon-spinner icon-spin");
            
            if(requeteSearch !== undefined)
                requeteSearch.abort();
                
            requeteSearch = $.ajax({
                type: "GET",
                url : "functions/searchRadio.php?format=html&q=" + $("#RadioSearch").val(),
                dataType: "html",
                success : function(data) {
                    $("#radio-search tbody").html(data);
                    $("#radio-search [title]").tooltip({"container": "#radio-search tbody"});
                    
                    $("#radio-search .input-group i").removeClass("icon-spinner icon-spin").addClass("icon-search");
                    $("#radio-search [title].radio-desc").tooltip("destroy").tooltip({"container": "#radio-search tbody", placement: "right"});
                }
            });
        });
        
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
            $(e.delegateTarget).find("i").addClass("icon-spin");                // Effet de rotation le temps de la supresssion
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
            
            element.addClass("success");                                        // Met la ligne éditée en surbrillance
            config.checkForm("#radio-change");                                  // Juste pour la couleur
        });
        
        //Pour supprimer l'effet de surbrillance
        $("a[data-toggle='tab']:not([href='#radio-change'])").on("shown.bs.tab", function(e) {
            $(".radio-search").removeClass("success");
        })
    }
};