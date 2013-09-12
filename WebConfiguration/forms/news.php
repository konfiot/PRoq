<h1>Paramètres - news</h1>
<p>
    <form class="form-horizontal">
    
        <fieldset>
        <legend>Paramètres du gestionnaire de news</legend>            
            <div class="control-group">
                <label class="control-label" for="NewsProvider">Gestionnaire</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-rss"></i></span>
                        <select class="selectpicker form-element" id="NewsProvider">
                            <option>newsblur</option>
                            <option>theoldreader</option>
                        </select>
                    </div>
                    <span class="help-inline"></span> <!-- Message d'erreur -->
                </div>
            </div>
        </fieldset>
        
        <fieldset>
        <legend>Connection à votre compte</legend>            
            <div class="control-group">
                <label class="control-label" for="NewsUser">Nom d'utillisateur</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" id="NewsUser" placeholder="Votre identifiant" class="form-element">
                    </div>
                    <span class="help-inline"></span> <!-- Message d'erreur -->
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="NewsPassword">Mot de passe</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-key"></i></span>
                        <input type="password" id="NewsPassword" placeholder="Votre mot de passe" class="form-element">
                    </div>
                    <span class="help-inline"></span> <!-- Message d'erreur -->
                </div>
            </div>
        </fieldset>
        
        <div class="input-prepend input-append" style="padding-left:75px" ><br />
            <button class="btn" type="button" id="btn_annuler"> <i class="icon-remove"></i> Annuler</button>
            <button class="btn" type="button" id="btn_envoyer"> <i class="icon-ok"></i> Valider</button> 
        </div>
    </form>
        
    <div class="alert span11 hide" id="generalErreur">
        Ici, les erreurs
    </div>
</p>