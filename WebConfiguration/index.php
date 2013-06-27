<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <title>Smart Wake</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    
    <link href="css/font-awesome.min.css" rel="stylesheet">
    
    <link href="css/main.css" rel="stylesheet">
    <link href="css/presentation.css" rel="stylesheet">
 
  </head>
  <body>

    <?php include("elements/top-navbar.php"); ?>
  
    <!-- ----------------------------------------------------------------------------------------------- -->
    <!--                                              Corps                                              -->
    <!-- ----------------------------------------------------------------------------------------------- -->
    
    
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="offset1 span10 hero-unit">
                <p>
                    Bienvenue sur l'interface web qui vous permettra de configurer votre Smart Wake de qualité
                </p>
                
                <h2>Qu'est-ce que Smart wake ?</h2>
                <p>
                    On peut mettre ici une petite description du projet, toutca toutca ...
                    <ul>
                        <li>On dit que c'est de qualité</li>
                        <li>Que ca a été très dur à réaliser</li>
                        <li>Et surtout ... que Dan est un Kouby</li>
                    </ul>
                </p>
                <p>
                    <a class="btn btn-primary btn-large pull-right" href="https://github.com/konfiot/smart-wake"><i class="icon-github icon"></i> Projet github</a>
                </p>
            </div>
            
            
            <div class="span8 offset2">
                <div class="carousel slide" id="presentation">
                    <div class="carousel-inner">
                        <a class="item active" href="http://twitter.github.io/bootstrap/"> <img alt="" src="img/presentation/bootstrap.jpg"/>
                            <div class="carousel-caption">
                                <p>Bootstrap</p>
                                Pour un design élégant
                            </div>
                        </a>
                        <a class="item" href="http://jquery.com"> <img alt="" src="img/presentation/jquery.png"/>
                            <div class="carousel-caption">
                                <p>JQuery</p>
                                Pour une gestion du javascript permetant une prise en main meilleure de l'interface
                            </div>
                        </a>
                        <a class="item" href="http://www.raspberrypi.org/"> <img alt="" src="img/presentation/pi.jpg"/>
                            <div class="carousel-caption">
                                <p>Hébergé par un raspberry pi</p>
                                Parce-que c'est pas cher
                            </div>
                        </a>
                        <a class="item" href="http://github.com/"> <img alt="" src="img/presentation/github.jpg"/>
                            <div class="carousel-caption">
                                <p>Github</p>
                                Nous a permis un travail de groupe organisé et efficace
                            </div>
                        </a>
                    </div>
                    <a class="carousel-control left" data-slide="prev" href="#presentation">‹</a> 
                    <a class="carousel-control right" data-slide="next" href="#presentation">›</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ----------------------------------------------------------------------------------------------- -->
    <!-- ----------------------------------------------------------------------------------------------- -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(function (){
            $('.carousel').carousel();
        });
    </script>
  </body>
</html>