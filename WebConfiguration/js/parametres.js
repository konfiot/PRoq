$(function() {
/*******************************************************************************************************************************
**                                                  Gestion du menu                                                           **        
*******************************************************************************************************************************/

$(".leftnav").mousedown(function(e){//Quand on clic sur un élément du menu
    $(".leftnav").removeClass("active");                                //On desactive tout
    $(e.delegateTarget).addClass("active");                             //On active le bon
    
    //---------------------
    
    var onglet = $(e.delegateTarget).children("a").attr("href");        //On choppe l'id ciblé par le lien
    onglet = onglet.substring(1, onglet.length);                        //On vire le '#'

    $(".hero-unit").load("forms/" + onglet + ".html", function(){ });   //On envoit la requette
});

/****/
});