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
                <span><span>
                    <input class="switch form-element" type="checkbox" data-on-label="Oui" data-off-label="Non" id="ProxyOn">
                </div></span> <!-- Pour avoir le bon nombre de parents -->
                <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
            </div>
        </fieldset>
        
        <fieldset>
            <legend>Connection à un proxy</legend>
        
            <div class="form-group">
                <label for="ProxyHttp">Proxy HTTP</label>
                <div class="input-group">
                    <span class="input-group-addon"><strong>http://</strong></span>
                    <input id="ProxyHttp" class="first_focus form-control form-element" placeholder="Adresse ip du proxy http">
                </div>
                <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
            </div>
        
            <div class="form-group">
                <label for="ProxyHttps">Proxy HTTPS</label>
                <div class="input-group">
                    <span class="input-group-addon"><strong>https://<strong/></span>
                    <input id="ProxyHttps" class="first_focus form-control form-element" placeholder="Adresse ip du proxy https">
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