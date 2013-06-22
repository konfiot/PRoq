smart-wake
==========

Le projet SmartWake de SI 2013

#Prérequis
* Linux
* Python 2.7 avec l'extension icalendar
* Apache  PHP
* SVOX Pico
* PIL avec les bindings tkinter

#Installation
Cloner le dépot ou le télécharger en Zip

Créer un vhost ou un lien symbolique qui pointe vers le dossier WebConfiguration

#Tester
Pour tester la synthèse vocale, il suffit d'appeler le script tts.py (En l'ayant au préalable rendu executable)

Pour tester le script total de réveil, il faut configurer le path de la musique à lire dans le fichier de configuration dans conf/wake.json, puis lancer le script wakeup.py

#Crédits

Toutes les informations météoroligiques sonte fournies par openweathermap.org
