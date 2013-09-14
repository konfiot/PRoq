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
                <label for="MeteoPos" class="col-md-12" >Votre position</label>
                <div class="input-group col-md-10">
                    <span class="input-group-addon"><i class="icon-map-marker"></i></span>
                    <input type="text" id="MeteoPos" class="form-element form-control" placeholder="La ville où vous habitez">
                </div>
                <button class="btn btn-info col-md-2" type="button" id="btn-find-pos"> <i class="icon-search"></i> Me localiser</button>
                <span class="help-block col-md-12" style="display: none;" ></span> <!-- Message d'erreur -->
            </div>
        </fieldset>
        
        <div class="input-prepend input-append" style="padding-left:75px"><br>
            <button class="btn btn-danger" type="button" id="btn_annuler"> <i class="icon-remove"></i> Annuler</button>
            <button class="btn btn-success" type="button" id="btn_envoyer"> <i class="icon-ok"></i> Valider</button> 
        </div>
    </form>
        
    <div class="alert hide col-sm-11 col-md-11 alert-warning" id="generalErreur">
        Ici, les erreurs
    </div>
    
</p>