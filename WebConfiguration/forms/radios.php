<div class="page-header">
    <h1>Paramètres<small> - webradios</small></h1>
    <p>
        Personnalisez la liste de vos webradios et vous pourrez les écouter depuis votre réveil ou dès votre lever
    </p>
</div>
<p>
    <div class="col-md-offset-1 col-md-10" id="radios-list" >
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
                <tbody class=".radio-search" >

                    <?php
                        $_GET["format"] = "html";
                        include("../functions/webradios.php");
                    ?>

                </tbody>
            </table>
        </fieldset>
        
        <fieldset>
            <legend>Ajout d'une nouvelle radio</legend>
            
            
            <ul class="nav nav-tabs" id="tab-forms" >
                <li class="active" >
                    <a href="#radio-search" data-toggle="tab">
                        <i class="icon-search"></i> Rechercher
                    </a>
                </li>
                <li>
                    <a href="#radio-man" data-toggle="tab">
                        <ic class="icon-pencil"></i> Manuel
                    </a>
                </li>
                <li class="vanish" id="radio-change-tab" >
                    <a href="#radio-change" data-toggle="tab">
                        <i class="icon-edit"></i> Modifier
                    </a>
                </li>
            </ul>


            <div class="tab-content">
            
                <!-- ---------- Mode recherche ---------- -->
                <div class="tab-pane container active" id="radio-search">
                    <p>
                        <div class="input-group" >
                            <span class="input-group-addon"><i class="icon-search"></i></span>
                            <input type="text" id="RadioSearch" class="form-control first_focus form-element" placeholder="Rechercher une radio" >
                        </div>
                    </p>
                    <div id="table-frame">
                        <!-- Résultat de la recherche -->
                    </div>
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
                                    <label for="RadioIcone" >Icone de la webradio</label>
                                    <div class="input-group" >
                                        <span class="input-group-addon"><i class="icon-picture"></i></span>
                                        <input type="text" id="RadioIcone" class="form-control form-element" placeholder="Url de l'icone de la webradio" >
                                    </div>
                                    <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
                                </div>
                            </fieldset>
        
                            <div class="input-prepend input-append" style="padding-left:75px"><br>
                                <button class="btn btn-success" type="button" id="btn_envoyer_radio" data-loading-text=" <i class='icon-spinner icon-spin'></i> Valider"> <i class="icon-ok"></i> Valider</button> 
                            </div>
                        </form>
                    </p>
                </div>
            
                <!-- ---------- Mode modification ---------- -->
                <div class="tab-pane container" id="radio-change">
                    <h3>Modification : <em id="C-previous-name">[ancien nom]</em></h3>
                    <p>
                        <form>
                            <fieldset>
                                <div class="form-group">
                                    <label for="C-RadioName" >Nom de la webradio</label>
                                    <div class="input-group" >
                                        <span class="input-group-addon"><i class="icon-font"></i></span>
                                        <input type="text" id="C-RadioName" class="form-control first_focus form-element" placeholder="Nom affiché" >
                                    </div>
                                    <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
                                </div>
                                <div class="form-group">
                                    <label for="C-RadioUrl" >Adresse de la webradio</label>
                                    <div class="input-group" >
                                        <span class="input-group-addon"><i class="icon-code"></i></span>
                                        <input type="text" id="C-RadioUrl" class="form-control form-element" placeholder="Url du flux de la radio" >
                                    </div>
                                    <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
                                </div>
                                <div class="form-group">
                                    <label for="C-RadioIcone" >Icone de la webradio</label>
                                    <div class="input-group" >
                                        <span class="input-group-addon"><i class="icon-picture"></i></span>
                                        <input type="text" id="C-RadioIcone" class="form-control form-element" placeholder="Url de l'icone de la webradio" >
                                    </div>
                                    <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
                                </div>
                            </fieldset>
        
                            <div class="input-prepend input-append" style="padding-left:75px"><br>
                                <button class="btn btn-success" type="button" id="btn_envoyer_C-radio" data-loading-text=" <i class='icon-spinner icon-spin'></i> Modifier"> <i class="icon-ok"></i> Modifier</button> 
                            </div>
                        </form>
                    </p>
                </div>
                
            </div>
                
            <div class="alert hide col-sm-11 col-md-11 alert-warning" id="generalErreur">
                Ici, les erreurs
            </div>
    </div>
        
    <div class="alert span11 hide" id="generalErreur">
        Ici, les erreurs
    </div>
</p>