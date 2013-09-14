<?php $page = basename($_SERVER['PHP_SELF']); //On récupère le nom de la page ouverte ?>

    <!-- ----------------------------------------------------------------------------------------------- -->
    <!--                                       Barre de navigation                                       -->
    <!-- ----------------------------------------------------------------------------------------------- -->

    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Smart wake</a>
            </div>
            <div class="navbar-collapse collapse">
                <p class="navbar-text pull-right">
                    Petit message sympatique de bienvenue
                </p>
                <ul class="nav navbar-nav">
                <li <?php if($page=="index.php")      echo 'class="active"'; ?> ><a href="index.php"><i class="icon-white icon-home"></i> Accueil</a></li>
                    <li <?php if($page=="status.php")     echo 'class="active"'; ?> ><a href="status.php"><i class="icon-white icon-signal"></i> Status</a></li>
                    <li <?php if($page=="parametres.php") echo 'class="active"'; ?> ><a href="parametres.php"><i class="icon-white icon-wrench"></i> Paramètres</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- ----------------------------------------------------------------------------------------------- -->
    <!-- ----------------------------------------------------------------------------------------------- -->
    