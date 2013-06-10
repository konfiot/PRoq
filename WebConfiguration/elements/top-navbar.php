<?php $page = basename($_SERVER['PHP_SELF']); //On récupère le nom de la page ouverte ?>

    <!-- ----------------------------------------------------------------------------------------------- -->
    <!--                                       Barre de navigation                                       -->
    <!-- ----------------------------------------------------------------------------------------------- -->

    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="brand" href="index.html">Smart wake</a>
                <div class="nav-collapse collapse">
                    <p class="navbar-text pull-right">
                        Petit message sympatique de bienvenue
                    </p>
                    <ul class="nav">
                        <li <?php if($page=="index.php")      echo 'class="active"'; ?> ><a href="index.php">Accueil</a></li>
                        <li <?php if($page=="status.php")     echo 'class="active"'; ?> ><a href="status.php">Status</a></li>
                        <li <?php if($page=="parametres.php") echo 'class="active"'; ?> ><a href="parametres.php">Paramètres</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ----------------------------------------------------------------------------------------------- -->
    <!-- ----------------------------------------------------------------------------------------------- -->
    