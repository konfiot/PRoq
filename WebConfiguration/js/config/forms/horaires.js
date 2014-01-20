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
    },
    
    readAll : function() {
        $.getJSON("functions/cron.php", function(caracs){                        //On recupère la configuration sur le serveur
            $("#wake-list .horaire").remove();
        
            for( horaire in caracs ) {
                horaires.addLine( caracs[horaire] );
            }
        });
    
    },
    //{"m":"00","h":"7","day":"*","month":"*","dow":["1","2","3","4","5"],"command":"\/root\/proq\/scripts\/wakeup.py adresse_sonnerie_1 ","enable":true,"name":"Cours"}
    add : function() {
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
                m : $("#HoraireTime").val(),
                h : $("#HoraireMin").val()
            },
            actif : $("#HoraireEnable").is(':checked'),
            jours : dow_list,
            sonnerie : "adresse_sonnerie"
        };
        
        $.ajax({
            type: "GET",
            url: "functions/cron.php?add=" + JSON.stringify(json),
            dataType: "text",
            success: function(){
                config.generalErreur("success", "Le formulaire à été envoyé avec succès");
                $("#btn_envoyer_horaires").button("reset");
            },
            error: function(){
                config.generalErreur("danger", "Un problème est arrivé pendant l'envoit du formulaire");
                $("#btn_envoyer_horaires").button("reset");
            }
        });
    }
};