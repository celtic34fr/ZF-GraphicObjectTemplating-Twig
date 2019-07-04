l'objet ODButton
================

On peut affecter à un bouton un type de fonctionnement : (pouvant être réaffecté suivant d'autre attribut)

	- CUSTOM	= bouton divers permettant de déclencher un action
	- SUBMIT	= bouton de déclenchement du pseudo formulaire auquel il est lié
	- RESET		= bouton de réinitialisation du pseudo formulaire auquel il est lié
	- LINK		= lien pour accès à une resource interne ou externe au site à l'application (type HTML)

L'affectation de la nature à un bouton en détermine son aspect (couleur de fond) :

    - DEFAULT = nature par défaut (valeur par défaut)
    - PRIMARY = nature primaire (bleu roi)
    - SUCCESS = nature succès (vert)
    - INFO    = nature information (gris bleu)
    - WARNING = nature avertissement alerte (orange)
    - DANGER  = nature danger, erreur (rouge)
    - LINK    = nature lien (lien HTML, plus bouton alors)

Cette nature peut de fait devenir signifiante suivant le contexte de l'emploi du bouton.

Le seul évènement géré sur le bouton est le click. À ce moment, le programme fourni la référence de la mérthode (callback) à exécuter

On peut, comme sur tout objet, avoir une bulle d'aide information grâce aux fonctions liées à l'attribut infoBulle.
Cette information pourra prendre 2 aspects : information sur une ligne (tooltip), panneau explicatif (popover).

le contenu du bouton peut être texte (affectation d'un label) et/ou icône (affectation d'une font awesome / glyphicon par classe suivbant disponibilité)

Méthode de l'objet ODButton
---------------------------

Il contient les méthodes communes aux objets OObject_  et ODContained_ avant d'avoir des méthodes spéfifiques :

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setLabel          | affectation du texte présenté dans le bouton   |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getLabel          | récupération du texte présenté dans le bouton  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setIcon           | affecte une icône au bouton (font awesome / glyphicon) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIcon           | récupère le nom de l'icône affecté au bouton                                                            |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setForm           | surchange de la méthode d'affectation de l'identifiant de regroupement (simulation de formulaire), peut induire une modification du type du bouton                                                         |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setType           | affectation du type de bouton                                                                           |
|                   | - CUSTOM : type divers                                                                                  |
|                   | - SUBMIT : type soumission (de formuulaire)                                                             |
|                   | - RESET  : type remise à zéro des champs (de formulaire)                                                |
|                   | - LINK   : type lien HTML                                                                               |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getType           | récupération du type du bouton                                                                          |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| evtClick          | activation et paramètrage de l'évènement 'click' sur le bouton                                          |
|                   |                                                                                                         |
|                   | callback     : "nomModule/nomObjet/nomMéthode"                                                          |
|                   |                                                                                                         |
|                   |  - si type == LINK -> "nomRoute[/nomControlleur[/nomAction[/id]]]"                                      |
|                   |  - si nomObjet contient 'Controller' -> "nomModule/Controller/nomObjet/nomMéthode"                      |
|                   |  - si nomModule == 'Object' :                                                                           |
|                   |                                                                                                         |
|                   |    - si nomObjet commence par 'OD' -> "GraphicObjectTemplating/Objects/ODContained/nomObjet/nomMéthode" |
|                   |    - si nomObjet commence par 'OS' -> "GraphicObjectTemplating/Objects/OCContainer/nomObjet/nomMéthode" |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disClick          | désactivation de lm'évènement 'click' sur le bouton                                                     |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setNature         | affectation de la nature du bouton                                                                      |
|                   |                                                                                                         |
|                   | - DEFAULT : nature par défaut (valeur par défaut)                                                       |
|                   | - PRIMARY : nature primaire (bleu roi)                                                                  |
|                   | - SUCCESS : nature succès (vert)                                                                        |
|                   | - INFO : nature information (gris bleu)                                                                 |
|                   | - WARNING : nature avertissement alerte (orange)                                                        |
|                   | - DANGER : nature danger, erreur (rouge)                                                                |
|                   | - LINK : nature lien (lien HTML, plus bouton alors)                                                     |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getNature         | restitue la nature actuelle du bouton                                                                   |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| enaAutoCenter(w,h)| active l'auto centrage pour l'affichage de l'objet                                                      |
|                   | remarque : w et h en string, ex : "500px" "40%" "1.5em"                                                 |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disAutoCenter     | desactive l'auto centrage pour l'affichage de l'objet                                                   |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
