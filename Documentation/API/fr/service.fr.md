Service *'graphic-object-templating-services'*
==============================================

Le service *'graphic-object-templating-services'* donne une interface pour générer les différentes données **HTML** pour construire les pages.

méthodes :

* ***render*** : à partir d'un objet, quequ'en soit le type, restitue le code HTML pour afficher l'objet dans la page,
* ***header*** : génération des références des fichiers CSS / JS à charger dans la page pour l'affichage, la gestion de cette dernières dans la balise \<head> ... \</head>,
* ***bootstrap*** : génération de la chaîne de caractères des classes Bootstrap Twitter à affecter à un objet pour sa présentation.
* ***rscs*** : méthode de récupération filtrage des ressources
* ***loadMainMenu*** : méthode de chargement du menu principal de vosd pages (***à valider utilité***)
* ***getTheme*** : récupère dans la configuration de ***G.O.T.*** le thème graphique ***G.O.T.*** (extension G.O.T.) à utiliser pour vos pages