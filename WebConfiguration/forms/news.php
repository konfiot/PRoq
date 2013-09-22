<div class="page-header">
    <h1>Paramètres<small> - news</small></h1>
    <p>
        Connectez vous à votre gestionnaire de news et soyez le premier informé de l'actualité
    </p>
</div>
<p>
    <form class="col-md-offset-1 col-md-10" >
        <fieldset>
            <legend>Connection à votre gestionnaire de news</legend>
            
            <div class="form-group">
                <label for="NewsProvider">Gestionnaire</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-rss"></i></span>
                    <select class="selectpicker form-element form-control" id="NewsProvider">
                        <option>newsblur</option>
                        <option>theoldreader</option>
                    </select>
                    <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
                </div>
            </div>
                  
            <div class="form-group">
                <label for="NewsUser">Nom d'utillisateur</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-user"></i></span>
                    <input type="text" id="NewsUser" class="form-element form-control" placeholder="Votre identifiant" >
                </div>
                <span class="help-block"></span> <!-- Message d'erreur -->
            </div>
            
            <div class="form-group">
                <label for="NewsPassword">Mot de passe</label>
                <div class="input-group">
                        <span class="input-group-addon"><i class="icon-key"></i></span>
                        <input type="password" id="NewsPassword" class="form-element form-control" placeholder="Votre mot de passe">
                </div>
                <span class="help-block"></span> <!-- Message d'erreur -->
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