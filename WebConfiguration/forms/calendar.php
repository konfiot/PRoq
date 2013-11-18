<div class="page-header">
    <h1>Paramètres<small> - calendrier</small></h1>
    <p>
        Enregistrez votre agenda au format ICS et soyez avertis de tous vos évenements iminants
    </p>
</div>
<p>
    <form class="col-md-offset-1 col-md-10" >
        <fieldset>
            <legend>Paramètrage de l'adresse du calendrier</legend>
        
            <div class="form-group">
                <label for="CalendarUrl" >Url du calendrier</label>
                <div class="input-group" >
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="CalendarUrl" class="form-control first_focus form-element" placeholder="L'adresse de votre calendrier" >
                </div>
                <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
            </div>
        </fieldset>
        
        <div class="input-prepend input-append" style="padding-left:75px"><br>
            <button class="btn btn-danger"  type="button" id="btn_annuler"> <i class="fa fa-times"></i> Annuler</button>
            <button class="btn btn-success" type="button" id="btn_envoyer" data-loading-text=" <i class='fa fa-spinner fa-spin'></i> Valider"> <i class="fa fa-check"></i> Valider</button> 
        </div>
    </form>
        
    <div class="alert hide col-sm-11 col-md-11 alert-warning" id="generalErreur">
        Ici, les erreurs
    </div>
    
</p>