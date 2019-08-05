L'objet ODInput
===============

##Les attributs de l'objet

La classe ODInput est une extension de la classe ODContained. Elle en hérite donc de l’ensemble des attributs et les enrichit pour la mise en œuvre d’une zone de saisie.

| Attribut | Explications |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| type              | Type de la zone de saisie, par défaut : type texte (TEXT) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| size              | Taille affiché de la zone de saisie |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| minlength         | Taille minimale de la zone de saisie |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| maxlength         | Taille maximale de la zone de saisie |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| label             | Texte placé à coté de la zone de saisie |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| placeholder       | Texte de l’invite de saisie |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| labelWidthBT      | Taille en grille Bootstrap Twitter d’affichage du label associé à la zone de saisie |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| inputWidthBT      | Taille en grille Bootstrap Twitter d’affichage de la zone de saisie proprement dite |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| errorMessage      | Message d’erreur émis pour donner la cause de l’anomalie (sur validation le plus souvent) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| icon              | Icône placée à côté de la zone de saisie avec le label (généralement à sa gauche) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| autofocus         | Permet de positionner le focus, le curseur de saisie dans la zone de saisie si à vrai (true), par défaut à faux (false) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| mask              | Permet de préciser un masque de saisie |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| valMin            | Dans le cas de valeurs bordées, fixe la valeur minimale acceptée, par défaut initialisée à vide. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| valMax            | Dans le cas de valeurs bordées, fixe la valeur maximale acceptée, par défaut initialisée à vide. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

###Le bloc de paramétrage d'événement - bloc 'event'

Ce dernier est hérité de l'objet ODContained.
Le bloc ‘event’  sera intégré dans l’attribut tableau event en ayant pour clé ‘change’ et ‘keyup’.
L’événement ‘change’ sera déclenché sur tout changement de valeur de l’objet ODInput. Pour ce qui est de l’événement ‘keyup’, il sera déclenché à chaque relâchement d’une touche du clavier.

Méthode de base
---------------

###Les méthodes publiques

###Le constructeur - __construct($id)

Il contient les méthodes communes aux objets OObject_  et ODContained_ avant d'avoir des méthodes spéfifiques :

| Méthode        | Fonctionnalité                                                                                         |
| -------------- | ---|
|setType         | affecte le type de saisie                                                                              |
|                |   - TEXT     : mode texte                                                                              |
|                |   - PASSWORD : saisie de mot de passe (caché, présence d'étoile à la place)                            |
|                |   - HIDDEN   : variable cachée                                                                         |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getType        | restitue le type de saisie                                                                             |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setSize        | fixe le nombre de caractères (maximum) à afficher                                                      |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getSize        | restitue le nombre maximal de caractères à afficher                                                    |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setMaxlength   | fixe le nombre de caractères (maximum) à saisir                                                        |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getMaxlength   | restitue le nombre maximal de caractères à saisir                                                      |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setLabel       | attribut un label, une étiquette à la zone de saisie                                                   |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getLabel       | restitue le label, l'étiquette affectée à la zone de saisie                                            |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setPlaceholder | affecte le texte à montyer quand la zone de saisie est vide (linvite de saisie)                        |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getPlaceholder |restitue le texte affiché quand la zone de saisie est vide                                              |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setLabelWidthBT| attribut une largeur (Bootstrap Twitter) au label (tableau de valeur en rapport des 4 médias gérés)    |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getLabelWidthBT| restitue la largeur (Bootstrap Twitter) du label (tableau de valeur en rapport des 4 médias gérés)     |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| evtChange      | évènement changement de valeur, paramètre callback                                                     |
|                | callback  "nomModule/nomObjet/nomMéthode"                                                              |
|                |                                                                                                        |
|                |  - si nomObjet contient 'Controller' -> "nomModule/Controller/nomObjet/nomMéthode"                     |
|                |  - si nomModule == 'Object' :                                                                          |
|                |                                                                                                        |
|                |    - si nomObjet commence par 'OC' -> "GraphicObjectTemplating/Objects/ODContent/nomObjet/nomMéthode"  |
|                |    - si nomObjet commence par 'OS' -> "GraphicObjectTemplating/Objects/OCContainer/nomObjet/nomMéthode"|
| --------------------------- | ------------------------------------------------------------------------------------------------ |
|disChange       | désactivation de l'évènement changement de valeur                                                      |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
|evtKeyup        | évènement touche frappée (à chaque saisie de caractère), paramètre callback                            |
|                | callback : "nomModule/nomObjet/nomMéthode"                                                             |
|                |                                                                                                        |
|                |  - si nomObjet contient 'Controller' -> "nomModule/Controller/nomObjet/nomMéthode"                     |
|                |  - si nomModule == 'Object' :                                                                          |
|                |                                                                                                        |
|                |    - si nomObjet commence par 'OC' -> "GraphicObjectTemplating/Objects/ODContent/nomObjet/nomMéthode"  |
|                |    - si nomObjet commence par 'OS' -> "GraphicObjectTemplating/Objects/OCContainer/nomObjet/nomMéthode"|
| --------------------------- | ------------------------------------------------------------------------------------------------ |
|disKeyup        | désactivation de l'évènement touche frappée                                                            |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
|setIcon         | affecte une icône après le label (font awesome / glyphicon)                                            |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
|getIcon         | récupère le nom de l'icône affecté après le label                                                      |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
