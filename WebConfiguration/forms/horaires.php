<!-- ---------------------------------------------- Contenu ---------------------------------------------- -->
<div class="page-header">
    <h1>Paramètres<small> - horaires de sonnerie</small></h1>
    <p>
        On pourra plus tard interragir avec cron et modifier les horraires de sonnerie
    </p>
</div>

<table class="table table-condensed" id="wake-list" >
    <thead>
        <tr>
            <th>Titre</th>
            <th>Horaire</th>
            <th colspan="7" >Jours</th>
        </tr>
    </thead>
    <tbody>
        <tr id="schema-horaire">
            <td class="titre" > titre </td>
            <td class="heure" > heure </td>
            
            <td class="day" > <i class="fa fa-ban"></i><span>L</span> </td>
            <td class="day" > <i class="fa fa-ban"></i><span>M</span> </td>
            <td class="day" > <i class="fa fa-ban"></i><span>M</span> </td>
            <td class="day" > <i class="fa fa-ban"></i><span>J</span> </td>
            <td class="day" > <i class="fa fa-ban"></i><span>V</span> </td>
            <td class="day" > <i class="fa fa-ban"></i><span>S</span> </td>
            <td class="day" > <i class="fa fa-ban"></i><span>D</span> </td>
            
            <td class="btn-col" >
                <div class="btn-group small-button-group">
                    <a class="btn radio-change" title="Editer" >
                        <i class="fa fa-pencil fa-large fa-lg"></i>
                    </a>
                    <a class="btn radio-rm" title="Supprimer" >
                        <i class="fa fa-times fa-lg"></i>
                    </a>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<!-- ------------------------------------------------------------------------------------------------------ -->
<form class="col-md-offset-1 col-md-10" >
    <fieldset>
        <legend>Ajouter/Modifier une radio</legend>
        
            <div class="form-group">
                <label for="HoraireName" >Nom de l'horaire</label>
                <div class="input-group" >
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    <input type="text" id="HoraireName" class="form-control first_focus" placeholder="Nom identifiant l'horaire" >
                </div>
                <span class="help-block" style="display: none;" ></span> <!-- Message d'erreur -->
            </div>
    </fieldset>
</form>

       
<form class="form-inline col-md-offset-1 col-md-10">
    <fieldset>
        <label>Heure de sonnerie</label>
        
        <div class="form-group">
            <input type="number" id="HoraireTime" class="form-control" style="width : 60px" min="0" max="23" value="7" placeholder="Heure" >
        </div>
        heures
        <div class="form-group">
            <input type="number" id="HoraireMin" class="form-control" style="width : 60px" min="0" max="59" value="0" placeholder="Heure" >
        </div>
        minutes
    </fieldset>
</form>

<form class="form-inline col-md-offset-1 col-md-10" >
    <fieldset>
        <label>Choisir les jours</label>
        
        <div class="form-group" id="HoraireDOW">
            <div class="checkbox">
                <label>
                    <input type="checkbox"> L
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> M
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> M
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> J
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> V
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> S
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> D
                </label>
            </div>
        </div>
    </fieldset>
</form>

<form class="col-md-offset-1 col-md-10" >
    <fieldset>
        <div class="checkbox">
                <label>
                    <input type="checkbox" id="HoraireEnable"> Activer
                </label>
            </div>
    </fieldset>
</form>

<div class="input-prepend input-append" style="padding-left:75px"><br>
    <button class="btn btn-success" type="button" id="btn_envoyer_horaires" data-loading-text=" <i class='fa fa-spinner fa-spin'></i> Valider"> <i class="fa fa-check"></i> Valider</button> 
</div>