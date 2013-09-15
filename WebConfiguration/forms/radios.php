<div class="page-header">
    <h1>Paramètres<small> - webradios</small></h1>
    <p>
        Personnalisez la liste de vos webradios et vous pourrez les écouter depuis votre réveil ou dès votre lever
    </p>
</div>
<p>
    <div class="col-md-offset-1 col-md-10" >
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
                                            <button type="button" class="btn btn-info btn-sm"><i class="icon-pencil"></i> Modifier</button>
                                            <button type="button" class="btn btn-danger btn-sm"><i class="icon-remove"></i> Supprimer</button>
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
            
            
            <ul class="nav nav-tabs">
                <li class="active" ><a href="#radio-search" data-toggle="tab"><i class="icon-search"></i> Rechercher</a></li>
                <li><a href="#radio-man" data-toggle="tab"><ic class="icon-pencil"></i> Manuel</a></li>
            </ul>

            <div class="tab-content">
            
                <!-- ---------- Mode recherche ---------- -->
                <div class="tab-pane container active" id="radio-search">
                    <h3>Liste des webradios ...</h3>
                    <p>
                        Il y aura un tableau avec un champ de recherche de radio
                    </p>
                </div>
                
                <!-- ---------- Mode manuel ---------- -->
                <div class="tab-pane container" id="radio-man">
                    <p>
                        <form>
                            <fieldset>
                                <div class="form-group">
                                    <label for="RadioName" >Nom de la webradio</label>
                                    <div class="input-group" >
                                        <span class="input-group-addon"><i class="icon-font"></i></span>
                                        <input type="text" id="RadioName" class="form-control first_focus form-element" placeholder="Nom affiché" >
                                    </div>
                                    <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
                                </div>
                                <div class="form-group">
                                    <label for="RadioUrl" >Adresse de la webradio</label>
                                    <div class="input-group" >
                                        <span class="input-group-addon"><i class="icon-code"></i></span>
                                        <input type="text" id="RadioUrl" class="form-control form-element" placeholder="Url du flux de la radio" >
                                    </div>
                                    <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
                                </div>
                                <div class="form-group">
                                    <label for="RadioIcon" >Icone de la webradio</label>
                                    <div class="input-group" >
                                        <span class="input-group-addon"><i class="icon-picture"></i></span>
                                        <input type="text" id="RadioIcone" class="form-control form-element" placeholder="Url de l'icone de la webradio" >
                                    </div>
                                    <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
                                </div>
                            </fieldset>
        
                            <div class="input-prepend input-append" style="padding-left:75px"><br>
                                <button class="btn btn-danger" type="button" id="btn_annuler"> <i class="icon-remove"></i> Annuler</button>
                                <button class="btn btn-success" type="button" id="btn_envoyer"> <i class="icon-ok"></i> Valider</button> 
                            </div>
                        </form>
                    </p>
                </div>
                
                <div class="alert hide col-sm-11 col-md-11 alert-warning" id="generalErreur">
                    Ici, les erreurs
                </div>
                
            </div>
    </div>
        
    <div class="alert span11 hide" id="generalErreur">
        Ici, les erreurs
    </div>
</p>