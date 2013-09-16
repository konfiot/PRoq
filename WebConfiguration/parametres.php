<!doctype html>
<html><head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <title>Smart Wake - configuration</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrapSwitch.min.css" rel="stylesheet">
    
    <link href="css/main.css" rel="stylesheet">
    <link href="css/parametres.css" rel="stylesheet">
  </head>
  <body>

    <?php include("elements/top-navbar.php"); ?>
  
    <div class="container">
        <div class="row">
  
            <!-- ----------------------------------------------------------------------------------------------- -->
            <!--                                              Menu                                               -->
            <!-- ----------------------------------------------------------------------------------------------- -->
            
            <div class="col-md-3"> 
                <div class="bs-sidebar hidden-print affix">
                    <ul class="nav bs-sidenav">
                    
                        <li class="leftnav"><h5>
                            Paramètre du réveil</h5></li>
                        <li class="leftnav"><a href="#horaires">
                            <i class="icon-fixed-width icon-time"></i> Horaires de sonerie</a></li>
                        <li class="leftnav"><a href="#sonneries">
                            <i class="icon-fixed-width icon-bell"></i> Choisir la sonnerie</a></li>
                        <li class="leftnav"><a href="#radios">
                            <i class="icon-fixed-width icon-music"></i> Webradios</a></li>
                        <li class="leftnav"><a href="#snooze">
                            <i class="icon-fixed-width icon-pause"></i> Touche "snooze"</a></li>
                        <li class="leftnav"><a href="#informations">
                            <i class="icon-fixed-width icon-comment-alt"></i> Informations à dicter</a></li>
                            
                        <li class="leftnav"><h5>
                            Informations</h5></li>
                        <li class="leftnav"><a href="#calendar">
                            <i class="icon-fixed-width icon-calendar"></i> Calendrier</a></li>
                        <li class="leftnav"><a href="#weather">
                            <i class="icon-fixed-width icon-cloud"></i> Météo</a></li>
                            
                        <li class="leftnav"><h5>
                            Comptes</h5></li>
                        <li class="leftnav"><a href="#mail">
                            <i class="icon-fixed-width icon-envelope-alt"></i> Mails</a></li>
                        <li class="leftnav"><a href="#news">
                            <i class="icon-fixed-width icon-rss"></i> News</a></li>
                    </ul>
                </div>
            </div>
    
            <!-- ----------------------------------------------------------------------------------------------- -->
            <!-- ----------------------------------------------------------------------------------------------- -->
            
            <!-- ----------------------------------------------------------------------------------------------- -->
            <!--                                              Corps                                              -->
            <!-- ----------------------------------------------------------------------------------------------- -->
    
            <div class="col-md-9" id="main" >
                <div class="container">
                    <div class="page-header">
                        <h1>Paramètres 
                            <img src="img/loader/horizontal.gif">                     <!-- Image générée avec http://ajaxload.info/ -->
                        </h1>
                    </div>
                    <p>
                        Le contenu est en train de charger, veuillez patienter ...
                    </p>
                </div>
            </div>
    
            <!-- ----------------------------------------------------------------------------------------------- -->
            <!-- ----------------------------------------------------------------------------------------------- -->
        </div>
    </div>
    
    <?php include("elements/fenConfirm.php"); ?>
    
    <script type="text/javascript" src="//code.jquery.com/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.geoplugin.net/javascript.gp"></script>
    
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrapSwitch.min.js"></script>
    
    <script type="text/javascript" src="js/config/elements.js"></script>
    <script type="text/javascript" src="js/config/autoconfig.js"></script>
    <script type="text/javascript" src="js/config/parametres.js"></script>
    
    <script type="text/javascript" src="js/dialogs.js"></script>
  
</body></html>