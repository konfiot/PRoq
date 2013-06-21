var dialogs = {
    confirm : function(sel, onOk, onNo){
        var btnOui = $(sel + " > .modal-footer > .btn-oui"),
            btnNon = $(sel + "> .modal-footer > .btn-non");
            
        $(sel).modal("show");
        
        var valide = function(){
            onOk();
            
            $("#confirmModal").modal("hide");
            btnOui.unbind("click", valide);                  //On supprime les évenements
            btnNon.unbind("click", refuse);
        };
        var refuse = function(){
            onNo();
            
            $("#confirmModal").modal("hide");
            btnOui.unbind("click", valide);                  //On supprime les évenements
            btnNon.unbind("click", refuse);
        };
        
        btnOui.bind("click", valide);
        btnNon.bind("click", refuse);
    }
};