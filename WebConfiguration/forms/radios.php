<h1>Paramètrage des webradios</h1>
<p>
    <form class="form-horizontal">
    
        <fieldset>         
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td></td>
                        <th>Nom</th>
                        <th>Adresse</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Lecture du Json
                        
                        $fichier = fopen("../../conf/webradios.json", 'r+');
                        $json = fread($fichier, filesize("../../conf/webradios.json"));
                        $json = json_decode($json, true);
                        
                        
                        foreach( $json["list"] as $i ) {
                            
                            // Pour réduire l'adresse
                            $radio_short = $i["adress"];
                            if( strpos($radio_short, "//") != 0 )
                                $radio_short = substr($radio_short, strpos($radio_short, "//")+2);
                            if( strpos($radio_short, "/", 1) != 0 )
                                $radio_short = substr($radio_short, 0 , strpos($radio_short, "/", 1));
                            
                            echo '
                                <tr class="radio-desc" >
                                    <td><img src="' .$i["icon"]. '" class="icon" /></td>
                                    <td class="name" >' .$i["name"]. '</td>
                                    <td class="adresse">
                                        <a target="_blank" href="' .$i["adress"]. '" >' .$radio_short. '</a>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info"><i class="icon-pencil"></i> Modifier</button>
                                            <button type="button" class="btn btn-danger"><i class="icon-remove"></i> Supprimer</button>
                                        </div>
                                    </td>
                                </tr>
                            ';
                        }
                        
                    ?>
                </tbody>
            </table>
        </fieldset>
        
        <fieldset>
        <legend>Ajout d'une nouvelle radio</legend>
            <div class="control-group">
                <label class="control-label" for="RadioName">Nom de la radio</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-font"></i></span>
                        <input type="text" id="RadioName" placeholder="Nom affiché" class="form-element">
                    </div>
                    <span class="help-inline"></span> <!-- Message d'erreur -->
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="RadioUrl">Url de la radio</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-code"></i></span>
                        <input type="text" id="RadioUrl" placeholder="Adresse de la radio" class="form-element">
                    </div>
                    <span class="help-inline"></span> <!-- Message d'erreur -->
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="RadioPic">Icone de la radio</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-picture"></i></span>
                        <input type="text" id="RadioPic" placeholder="Adresse d'une image" class="form-element">
                    </div>
                    <span class="help-inline"></span> <!-- Message d'erreur -->
                </div>
            </div>
        </fieldset>
        
        <div class="input-prepend input-append" style="padding-left:75px" >
            <button class="btn btn-info" type="button btn-info" id="btn_annuler"> <i class="icon-search"></i> Chercher une radio</button>
            <button class="btn btn-success" type="button btn-success" id="btn_envoyer"> <i class="icon-plus"></i> Ajouter</button> 
        </div>
    </form>
        
    <div class="alert span11 hide" id="generalErreur">
        Ici, les erreurs
    </div>
</p>