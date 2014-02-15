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
                    <span class="input-group-addon"><i class="fa fa-rss"></i></span>
                    <select class="selectpicker form-element form-control" id="NewsProvider">
                        <option _disable="" >newsblur</option>
                        <option _disable="#NewsRoot" >theoldreader</option>
                        <option _disable="" >commafeed</option>
                        <option _disable="#NewsRoot" >bazqux</option>
                        <option _disable="#NewsRoot" >inoreader</option>
                        <option _disable="#NewsRoot" >feedhq</option>
                        <option _disable="#NewsRoot" >subreader</option>
                        <option _disable="#NewsRoot" >reedah</option>
                        <option _disable="" >selfoss</option>
                        <option _disable="" >ttrss</option>
                        <option _disable="#NewsPassword,#NewsRoot" >kouio</option>
                        <option _disable="" >birdreader</option>
                        <option _disable="" >feedbin</option>
                        <option _disable="" >miniflux</option>
                    </select>
                    <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
                </div>
            </div>
                  
            <div class="form-group">
                <label for="NewsUser">Nom d'utillisateur</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" id="NewsUser" class="form-element form-control" placeholder="Votre identifiant" >
                </div>
                <span class="help-block"></span> <!-- Message d'erreur -->
            </div>
            
            <div class="form-group">
                <label for="NewsPassword">Mot de passe</label>
                <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" id="NewsPassword" class="form-element form-control" placeholder="Votre mot de passe">
                </div>
                <span class="help-block"></span> <!-- Message d'erreur -->
            </div>
            
            <div class="form-group">
                <label for="NewsRoot">Adresse</label>
                <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        <input type="text" id="NewsRoot" class="form-element form-control" placeholder="L'adresse de votre serveur de news (facultatif)">
                </div>
                <span class="help-block"></span> <!-- Message d'erreur -->
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