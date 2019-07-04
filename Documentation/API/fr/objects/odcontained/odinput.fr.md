L'objet ODInput
===============

Méthode de l'objet ODInput
--------------------------

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
