<div class="page-header">
    <h1>Paramètres<small> - proxy</small></h1>
    <p>
        Paramètrez un éventuel proxy
    </p>
</div>
<p>
    <form class="col-md-offset-1 col-md-10" >
        <fieldset>
            <div class="form-group">
                <label class="control-label" for="ProxyOn">Utiliser un proxy</label>
                <span><div class="switch form-element col-md-offset-1" data-on-label="Oui" data-off-label="Non" id="ProxyOn">
                    <input type="checkbox" checked="checked" class="col-md-offset-1" >
                </div></span> <!-- Pour avoir le bon nombre de parents -->
                <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
            </div>
        </fieldset>
        
        <fieldset>
            <legend>Connection à un proxy</legend>
        
            <div class="form-group">
                <label for="ProxyIp">Adresse du serveur</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-terminal"></i></span>
                    <input id="ProxyIp" class="first_focus form-control form-element" placeholder="Adresse ip du proxy">
                </div>
                <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
            </div>
        </fieldset>
        
        <div class="input-prepend input-append" style="padding-left:75px"><br>
            <button class="btn btn-danger"  type="button" id="btn_annuler"> <i class="fa fa-times"></i> Annuler</button>
            <button class="btn btn-success" type="button" id="btn_envoyer" data-loading-text=" <i class='fa fa-spinner fa-spin'></i> Valider"> <i class="fa fa-check"></i> Valider</button> 
        </div>
    </form>
</p>