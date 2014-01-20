var horaires = {
    
    connectAll : function() {       // S'il existe on charge les données
        if( $("#wake-list").length !== 0 ) {
            horaires.readAll();
        }
        
        $("#btn_envoyer_horaires").click(function(){
            horaires.add();
        });
    },
    
    addLine : function(carac) {
        var ligne = $("#wake-list #schema-horaire").clone();
        ligne.removeAttr("id").addClass("horaire");
        
        
        ligne.find(".titre").html(carac.name);
        ligne.find(".heure").html(carac.h + "h" + carac.m);
        
        for(i in carac.dow) {
            $(ligne.find(".day")[ (carac.dow[i]-1)%7 ]).addClass("active");
        }
        
        if( carac.enable )
            ligne.addClass("enable");
        
        
        ligne.appendTo($("#wake-list tbody"));

        
        ligne.find(".radio-rm").click(function(e){
            var ligne = $(e.delegateTarget).parent().parent().parent();
            if( ligne.hasClass("enable") ){
                horaires.rm(ligne)
            }
        });
    },
    
    readAll : function() {
        $.getJSON("functions/cron.php", function(caracs){                        //On recupère la configuration sur le serveur
            $("#wake-list .horaire").remove();
        
            for( horaire in caracs ) {
                horaires.addLine( caracs[horaire] );
            }
        });
    
    },
    
    rm : function(ligne) {
        ligne.find(".radio-rm").addClass("fa-spin");
        
        $.ajax({
            type: "GET",
            url: "functions/cron.php?rm=" + ligne.find(".titre").text(),
            dataType: "text",
            success: function(){
                config.generalErreur("success", "Le formulaire à été envoyé avec succès");
                ligne.remove();
            },
            error: function(){
                config.generalErreur("danger", "Un problème est arrivé pendant l'envoit du formulaire");
                ligne.find(".radio-rm").removeClass("fa-spin");
            }
        });
    },
    
    //{"m":"00","h":"7","day":"*","month":"*","dow":["1","2","3","4","5"],"command":"\/root\/proq\/scripts\/wakeup.py adresse_sonnerie_1 ","enable":true,"name":"Cours"}
    add : function() {
        $("#btn_envoyer_horaires").find("i").addClass("fa-spin");
        
        var dow_list = [ ];
        for(var i in $("#HoraireDOW input")) {
            if(!isNaN(parseInt(i))) {
                if( $($("#HoraireDOW input")[i]).is(':checked') ) {
                    dow_list.push(parseInt(i)+1);
                }
            }
        }
        
        var json = {
            nom : $("#HoraireName").val(),
            horaire : {
                h : $("#HoraireTime").val(),
                m : $("#HoraireMin").val()
            },
            actif : $("#HoraireEnable").is(':checked'),
            jours : dow_list,
            sonnerie : "adresse_sonnerie"
        };
        
        console.log(JSON.stringify(json));
        
        $.ajax({
            type: "GET",
            url: "functions/cron.php?add=" + JSON.stringify(json),
            dataType: "text",
            success: function(){
                config.generalErreur("success", "Le formulaire à été envoyé avec succès");
                $("#btn_envoyer_horaires").button("reset");
                horaires.addLine({
                    name : json.nom,
                    h : json.horaire.h,
                    m : json.horaire.m,
                    enable : json.actif,
                    dow : json.jours
                });
                
                $("#btn_envoyer_horaires").find("i").removeClass("fa-spin");
            },
            error: function(){
                config.generalErreur("danger", "Un problème est arrivé pendant l'envoit du formulaire");
                $("#btn_envoyer_horaires").button("reset");
                
                $("#btn_envoyer_horaires").find("i").removeClass("fa-spin");
            }
        });
    }
};