<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <title>Smart Wake - configuration</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrapSwitch.css" rel="stylesheet">
    
    <link href="css/main.css" rel="stylesheet">
  </head>
  <body>

    <?php include("elements/top-navbar.php"); ?>
  
    <div class="container-fluid">
        <div class="row-fluid">
  
            <!-- ----------------------------------------------------------------------------------------------- -->
            <!--                                              Menu                                               -->
            <!-- ----------------------------------------------------------------------------------------------- -->
            
            <div class="span3">
                <div class="well sidebar-nav">
                    <ul class="nav nav-list">
                        <li class="nav-header">Paramètres de reveil</li>
                        <li class="leftnav"><a href="#horaires">
                            <i class="icon-fixed-width icon-time"></i> Regler les horaires de sonerie</a></li>
                        <li class="leftnav"><a href="#sonneries">
                            <i class="icon-fixed-width icon-bell"></i> Choisir la sonnerie</a></li>
                        <li class="leftnav"><a href="#radios">
                            <i class="icon-fixed-width icon-music"></i> Webradios</a></li>
                        <li class="leftnav"><a href="#snooze">
                            <i class="icon-fixed-width icon-pause"></i> Règlage de la touche "snooze"</a></li>
                        <li class="nav-header">Paramètres des informations</li>
                        <li class="leftnav"><a href="#informations">
                            <i class="icon-fixed-width icon-info-sign"></i> Informations à dicter</a></li>
                        <li class="leftnav"><a href="#mail">
                            <i class="icon-fixed-width icon-envelope-alt"></i> Mails</a></li>
                        <li class="leftnav"><a href="#calendrier">
                            <i class="icon-fixed-width icon-calendar"></i> Calendrier</a></li>
                    </ul>
                </div>
            </div>
    
            <!-- ----------------------------------------------------------------------------------------------- -->
            <!-- ----------------------------------------------------------------------------------------------- -->
            
            <!-- ----------------------------------------------------------------------------------------------- -->
            <!--                                              Corps                                              -->
            <!-- ----------------------------------------------------------------------------------------------- -->
    
            <div class="span9 hero-unit">
                <h1>Paramètres</h1>
                <p>
                    Chaipas quoi mettre ici, à la limite autant afficher direct la premiere page de paramètres ^^ <br />
                    Au moins j'ai rentabilisé la navbar xD <br />
                    La navigation entre les pages de configuration se fera en javascript je pense
                </p>
            </div>
    
            <!-- ----------------------------------------------------------------------------------------------- -->
            <!-- ----------------------------------------------------------------------------------------------- -->
        </div>
    </div>
    
    <?php include("elements/fenConfirm.php"); ?>
    
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrapSwitch.js"></script>
    
    <script type="text/javascript" src="js/config/elements.js"></script>
    <script type="text/javascript" src="js/config/autoconfig.js"></script>
    <script type="text/javascript" src="js/config/parametres.js"></script>
    
    <script type="text/javascript" src="js/dialogs.js"></script>
  </body>
</html>