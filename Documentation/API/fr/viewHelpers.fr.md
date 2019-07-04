Les ViewHelpers
===============

Les ViewHelper proposés par **G.O.T.** ne sont que la traduction des méthodes accessibles au travers du [service](service.fr.md) 'graphic-object-templating-services' en premier lieu.

Y ont été ajouté quelques  aides de vue (viewHelper) pour facilité l'accès à certaines informations.

liste des ViewHelper :
----------------------

* gotRender : (méthode render) rendu HTML d'objet
* gotHeader : (méthode header) génération des référence de fichier CSS / JS à intégrer dans la balise \<head> ... \</head>
* gotBootstrap : (méthode bootstrap) classe Bootstrap Twiter à applique à lm'objet pour sa présention.
* gotversion : pour avoir accès au numéro actuel de version de **G.O.T.**
* gotHttpHost : restitue le HostName de votre site, application internet