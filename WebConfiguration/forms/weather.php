<div class="page-header">
    <h1>Paramètres<small> - Météo</small></h1>
    <p>
        Donnez votre localisation de manière à ce que votre smart-wake puisse vous indiquer la météo de la journée
    </p>
</div>
<p>
    <form class="horizontal-form col-md-offset-1 col-md-10" >
        <fieldset>
            <legend>Paramètrage de votre position</legend>    
            
            <div class="form-group">
                <label for="MeteoPos" >Votre position</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-map-marker"></i></span>
                    <input type="text" id="MeteoPos" class="form-element form-control" placeholder="La ville où vous habitez">
                    <span class="input-group-btn">
                        <button class="btn btn-info" type="button" id="btn-find-pos" > <i class="icon-search"></i> Me localiser</button>
                    </span>
                </div>
                <span class="help-block" style="display: none; z-index: -1;" ></span> <!-- Message d'erreur -->
            </div>
        </fieldset>
        
        <div class="input-prepend input-append" style="padding-left:75px"><br>
            <button class="btn btn-danger"  type="button" id="btn_annuler"> <i class="icon-remove"></i> Annuler</button>
            <button class="btn btn-success" type="button" id="btn_envoyer" data-loading-text=" <i class='icon-spinner icon-spin'></i> Valider"> <i class="icon-ok"></i> Valider</button> 
        </div>
    </form>
        
    <div class="alert hide col-sm-11 col-md-11 alert-warning" id="generalErreur">
        Ici, les erreurs
    </div>
    
</p>