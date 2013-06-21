/*******************************************************************************************************************************
**                                                Classe élément mère                                                         **        
*******************************************************************************************************************************/

function element(_sel, _categorie, _champ){
    this.element = _sel;                                                        //Selecteur JQuery
    this.categorie = _categorie                                                 //Categorie pour l'enregistrement
    this.champ = _champ;                                                        //Champ pour l'enregistrement
    
    this.initialValue = "";                                                     //Sert à retenir la valeur à la prise de focus
    
    this.valeure = function(v){
        if( (typeof v) !== "undefined" )
            $(this.element).val(v);
        else
            return $(this.element).val();
    };
    
    //Une fonction qui sert à éditer l'erreur
    this.erreur = function(type, message) {
        $(this.element).parent().parent().removeClass("success error").addClass(type);
        $(this.element).parent().children(".help-inline").html(message);
    },
    
    this.isValid = function(){
        this.erreur("success", "");
        return true;
    };
    
    this.reconnect = function(){
        $(this.element).focusin(function(){
            $.data( $("#"+this.id), "initialValue", this.value );
        });
        
        $(this.element).focusout(function(){
            if( $.data( $("#"+this.id), "initialValue" ) != this.value ){
                $("#"+this.id).trigger("changed");
            }
        });
    };
}

/*******************************************************************************************************************************
**                                                Classe élément input                                                        **        
*******************************************************************************************************************************/

function elementInput(_element, _categorie, _champ, _validation){
    element.call(this, _element, _categorie, _champ);                           //Hérite de la classe élément
    this.validation = _validation;                                              //Liste des validateurs
    
    this.valeure = function(v){
        if( (typeof v) !== "undefined" )
            $(this.element).val(v);
        else{
            if( $(this.element).val() !== "" )
                return $(this.element).val();
            else
                return $(this.element).attr("placeholder");
        }
    };
    
    this.isValid = function(){
        for (var i = 0 ; i < this.validation.length ; i++) {
            if( !this.validation[i].format.test( $(this.element).val() ) ){
                this.erreur(this.validation[i].msg.type, this.validation[i].msg.text);
                return false;
            }
        }
        this.erreur("success", "");
        return true;
    };
    
    this.reconnect = function(){
        var temp = new element("a", "z", "e");
        temp.reconnect.call(this);
        
        $(this.element).on("changed", function(){
            inputs[this.id].isValid();
        });
    }
}