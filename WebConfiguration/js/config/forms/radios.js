var requeteSearch;

var radios = {
    
    radioList : function(args) {
    /*  Argument de la classe d'édition de la liste des webradios :
        {
            action : [
                {
                    type : "remove",
                    arg : "[name]"
                },
                {
                    type : "add",
                    arg : "[name]"
                }
            ],
            error : {
                type : "danger",
                message : "[message]"
            },
            at_end : function() {}
        } */
        
        this.json = args;
        
        // Valeurs par défaut
        this.json.error.type = this.json.error.type || "danger";
        this.json.error.message = this.json.error.type || "La modification a échoué";
        
        this.sendReq = function() {
            var req = "functions/webradios.php?";
            for( var i=0 ; i < this.json.action.length ; i++) {
                if(i) req += "&";
                req += this.json.action[i].type + "=" + this.json.action[i].arg;
            }
            
            var json = this.json;
            
            $.ajax({
                type: "GET",
                url: req,
                dataType: "html",
                success: function(data){
                    $("#radios-list tbody").html(data);
                    radios.connectAll();
                    
                    config.generalErreur("success", "Liste des radios modifiée");
                    json.at_end();
                },
                error: function(){
                    json.showError();
                    json.at_end();
                }
            });
        };
        
        this.showError = function() {
            config.generalErreur(this.json.error.type, this.json.error.message);
        };
    },
    
    add : function() {
        $("#btn_envoyer_radio").button("loading");
        var json = {
            "name" : inputs.RadioName.valeur(),
            "icon" : inputs.RadioIcone.valeur(),
            "adress"  : inputs.RadioUrl.valeur()
        };
            
        if( json.icon === "" )
            json.icon = "img/missing-img.png";
        
        
        var req = new radios.radioList({
            action : [{
                type : "add",
                arg : JSON.stringify(json)
            }],
            error : {
                message : "L'ajout d'une webradio a échoué"
            },
            at_end : function() {
                $("#btn_envoyer_radio").button("reset");
            }
        });
        
        req.sendReq();
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
        
        var req = new radios.radioList({
            action : [
                {
                    type : "remove",
                    arg : ans
                }, {
                    type : "add",
                    arg : JSON.stringify(json)
                }
            ],
            error : {
                message : "La modification d'une webradio a échouée"
            },
            at_end : function() {
                $("#btn_envoyer_C-radio").button("reset");
            }
        });
        
        req.sendReq();
    },
    
    rm : function(name) {
        var req = new radios.radioList({
            action : [{
                type : "remove",
                arg : name
            }],
            error : {
                message : "La suppression d'une webradio a échouée"
            },
            at_end : function() {}
        });
        
        req.sendReq();
    },
    
    /* ********************************************************************** */
    
    connectAll : function(){
        $("[title]").tooltip({"container": "body"});
        
        $("#radio-search .input-group i").removeClass("icon-spinner icon-spin").addClass("icon-search");
        $("#radio-search [title].radio-desc").tooltip("destroy").tooltip({"container": "#radio-search tbody", placement: "right"});
        
        $("#radio-search [title].radio-desc").off("click").click(function(e){
            if( e.target.localName != "a") {
                var element = $(e.delegateTarget);
                var name = element.find(".name").html();
                var url = element.find(".adresse>a").attr("href");
                var icon = element.find("td img").attr("src");
                
                $("#RadioName").val(name);
                $("#RadioUrl").val(url);
                $("#RadioIcone").val(icon);
                
                $('#tab-forms a[href="#radio-man"]').tab('show');
            }
        });
        
        $("#RadioSearch").off("keyup").keyup(function(){
            $("#radio-search .input-group i").removeClass("icon-search").addClass("icon-spinner icon-spin");
            
            if(requeteSearch !== undefined)
                requeteSearch.abort();
                
            requeteSearch = $.ajax({
                type: "GET",
                url : "functions/searchRadio.php?format=html&q=" + $("#RadioSearch").val().replace(/\s+/g, ''), //On vire les espaces
                dataType: "html",
                success : function(data) {
                    $("#table-frame").html(data);
                    $("#radio-search [title]").tooltip({"container": "#radio-search tbody"});
                    
                    radios.connectAll();
                }
            });
        });
        
        $("#table-frame .pagination a").off("click").click(function(e){
            $("#radio-search .input-group i").removeClass("icon-search").addClass("icon-spinner icon-spin");
            
            if(requeteSearch !== undefined)
                requeteSearch.abort();
            requeteSearch = $.ajax({
                type: "GET",
                url : "functions/searchRadio.php?format=html&q=" + $("#RadioSearch").val().replace(/\s+/g, '') + "&page=" + $(e.delegateTarget).attr("page"),
                dataType: "html",
                success : function(data) {
                    $("#table-frame").html(data);
                    $("#radio-search [title]").tooltip({"container": "#radio-search tbody"});
                    
                    radios.connectAll();
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
            
            $("#radios-list .radio-desc.success").removeClass("success");
            element.addClass("success");                                        // Met la ligne éditée en surbrillance
            config.checkForm("#radio-change");                                  // Juste pour la couleur
        });
        
        //Pour supprimer l'effet de surbrillance
        $("a[data-toggle='tab']:not([href='#radio-change'])").on("shown.bs.tab", function(e) {
            $(".radio-search").removeClass("success");
        })
    }
};