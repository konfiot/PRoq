<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <title>Smart Wake - configuration</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
 
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="index.html">Smart wake</a>
				<div class="nav-collapse collapse">
					<p class="navbar-text pull-right">
						Petit message sympatique de bienvenue
					</p>
					<ul class="nav">
						<li><a href="index.html">Accueil</a></li>
						<li><a href="status.html">Status</a></li>
						<li class="active"><a href="parametres.html">Paramètres</a></li>
					</ul>
				</div> <!--/.nav-collapse -->
			</div>
		</div>
    </div>
    
    <div class="container-fluid">
		<div class="row-fluid">
			<div class="span3">
				<div class="well sidebar-nav">
					<ul class="nav nav-list">
						<li class="nav-header">Paramètres de reveil</li>
						<li class="leftnav"><a href="#horaires">Regler les horaires de sonerie</a></li>
						<li class="leftnav"><a href="#sonneries">Choisir la sonnerie</a></li>
						<li class="leftnav"><a href="#radios">Webradios</a></li>
						<li class="leftnav"><a href="#snooze">Règlage de la touche "snooze"</a></li>
						<li class="nav-header">Paramètres des informations</li>
						<li class="leftnav"><a href="#informations">Informations à dicter</a></li>
						<li class="leftnav"><a href="#mails">Mails</a></li>
						<li class="leftnav"><a href="#calendrier">Calendrier</a></li>
					</ul>
				</div>
			</div>
			<div class="span9 hero-unit">
				<h1>Paramètres</h1>
				<p>
					Chaipas quoi mettre ici, à la limite autant afficher direct la premiere page de paramètres ^^ <br />
					Au moins j'ai rentabilisé la navbar xD <br />
					La navigation entre les pages de configuration se fera en javascript je pense
				</p>
			</div>
		</div>
	</div>
    
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
	
	<script>	
		$(function() {
			$(".leftnav").mousedown(function(e){
				$(".leftnav").removeClass("active");								//On desactive tout
				$(e.delegateTarget).addClass("active");								//On active le bon
				
				var onglet = $(e.delegateTarget).children("a").attr("href");		//On choppe l'id ciblé par le lien
				onglet = onglet.substring(1, onglet.lenght);						//On vire le '#'

				$(".hero-unit").load("forms/" + onglet + ".html", function(){ });	//On envoit la requette
			});
		});
	</script>
  </body>
</html>