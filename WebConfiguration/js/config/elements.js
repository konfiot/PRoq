/*******************************************************************************************************************************
**                                                Classe élément mère                                                         **        
*******************************************************************************************************************************/

function element(_sel, _categorie, _champ){
    this.element = _sel;                                                        //Selecteur JQuery
    this.categorie = _categorie;                                                //Categorie pour l'enregistrement
    this.champ = _champ;                                                        //Champ pour l'enregistrement
    
    this.initialValue = "";                                                     //Sert à retenir la valeur à la prise de focus
    
    this.valeure = function(v){
        if( (typeof v) !== "undefined" ){
            $(this.element).val(v);
            $(this.element).trigger("changed");
        }
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
        if( (typeof v) !== "undefined" ){
            $(this.element).val(v);
            this.isValid();
            
            $(this.element).trigger("changed");
        }
        else{
            if( $(this.element).val() !== "" )
                return $(this.element).val();
            else
                return "";
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
        var temp = new element();
        temp.reconnect.call(this);
        
        $(this.element).on("changed", function(){
            inputs[this.id].isValid();
        });
    };
}

/*******************************************************************************************************************************
**                                            Classe élément auto-définis                                                     **        
*******************************************************************************************************************************/

function elementInputAuto(_element, _categorie, _champ, _validation, _proccess){
    elementInput.call(this, _element, _categorie, _champ, _validation);
    this.proccess = _proccess;
    this.auto = false;
    
    this.valeure = function(v){
        var temp = new elementInput();
        temp.valeure.call(this, v);
        
        if( $(this.element).val() == $(this.element).attr("placeholder") ){
            this.valeure("");
            this.auto = true;
        }
        else this.auto = false;
            
        if( typeof v === "undefined" && $(this.element).val() === "" && this.auto)
            return $(this.element).attr("placeholder");
    };
    
    this.manset = function(v){
        this.auto = false;
        $(this.element).attr("placeholder", v);
    };
    
    this.autoset = function(v){
        this.auto = true;
        $(this.element).attr("placeholder", v);
        
        if( $(this.element).val() == $(this.element).attr("placeholder") ){
            this.valeure("");
            this.auto = true;
        }
        else this.auto = false;
    };
    
    this.isValid = function(){
        if( this.auto )                                                         //Si c'est auto ... On s'en tappe !!!
            return true;
            
        var temp = new elementInput();
        return temp.isValid.call(this);
    };
    
    this.reconnect = function(){
        var temp = new elementInput();
        temp.reconnect.call(this);
        
        this.proccess();
    };
};