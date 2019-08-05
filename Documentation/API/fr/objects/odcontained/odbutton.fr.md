l'objet ODButton
================

On peut affecter à un bouton un type de fonctionnement : (pouvant être réaffecté suivant d'autre attribut)

	- CUSTOM	= bouton divers permettant de déclencher un action
	- SUBMIT	= bouton de déclenchement du pseudo formulaire auquel il est lié
	- RESET		= bouton de réinitialisation du pseudo formulaire auquel il est lié
	- LINK		= lien pour accès à une resource interne ou externe au site à l'application (type HTML)

Ce paramétrage est affecté par la présence d’un identifiant de regroupement en formulaire et à l’existence d’un événement (de type clic).

Les règles sont les suivantes :

    - type LINK : l’attribut form est initialisé à vide, et l’événement clic est retravaillé afin que l’attribut class contienne la route et l’attribut method le tableau des paramètres (comme controller, action …),
    - type RESET : si l’attribut form est vide, on bascule le type à CUSTOM,
    - type SUBMIT : si l’attribut form est vide, on bascule le type à CUSTOM,
    - à l’affectation de l’attribut form, si il n’y a pas d’événement clic, le type est basculé à RESET, dans le cas contraire, à SUBMIT, 
    
    - dans la méthode evtClick si l’attribut form est non vide le type est basculé à SUBMIT,
    - dans la méthode evtClick si l’attribut form est vide et le type différent de LINK, le type est basculé à CUSTOM.

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
Cette information pourra prendre 2 aspects : information sur une ligne (**tooltip**), panneau explicatif (**popover**).

le contenu du bouton peut être texte (affectation d'un label) et/ou icône (affectation d'une font awesome / glyphicon par classe suivbant disponibilité)

Les attributs de base
---------------------

###Les attributs généraux

| Attribut | Explications |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| type              | Type du bouton  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| label             | Texte écrit dans le bouton  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| icon              | Icône ajoutée au label du bouton  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| event             | Tableau de paramétrage des événements possibles sur un bouton : clic seulement  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| nature            | Présentation graphique du bouton  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

###Le bloc de paramétrage d'événement - bloc 'event'

Le bloc ‘event’  sera intégré dans l’attribut tableau event en ayant pour clé ‘clic’.

Méthodes de base
----------------

###Les méthodes publiques

####Le constructeur - __construct(string $id)

Méthode de génération de l’objet.

	$id			: identifiant de l’objet,
	
Cette méthode demande l’exécution de la méthode publique de l’objet parent (ODContained) parent::__construct($id, $arrayData). $arrayData prend pour valeur le chemin et le nom du fichier de paramétrage de l’objet ODButton.

####Les méthodes générales

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setLabel($label)    | Méthode affectant à l’attribut label avec $label, avant de retourner l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getLabel()          | Méthode restituant la valeur contenue dans l’attribut label. |
|                     | Si aucune valeur n’existe, la méthode retourne false  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setIcon($icon)      | Affecte la ou les classes à appliquer à l’objet courant pour lui adjoindre une icône choisie parmi les icônes Bootstrap Twitter. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setImage($pathFile) | affectation d’une image comme icône du bouton à gauche du label (.ico-custom). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIcon()           | récupère suivant le cas la classe associée (setIcon()) ou le chemin de l’image (setImage()). Si aucune valeur n’existe, la méthode retourne false |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setForm($form)      | Surcharge de la méthode setForm() dans ODContained. Permet de valider le contenu de l’attribut type suivant le paramétrage ou non d’un événement clic. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setType($type)    | Permet d’affecter l’un des différents type de bouton à l’objet courant.
|                   | Si le type de bouton fourni $type, n’existe pas, il l’initialise à CUSTOM. En même temps qu’il affecte un type de bouton, il valide par le contexte que le type paramétré est le bon avant de retourner l’objet courant. |
|                   | - CUSTOM : type divers                                                                                  |
|                   | - SUBMIT : type soumission (de formuulaire)                                                             |
|                   | - RESET  : type remise à zéro des champs (de formulaire)                                                |
|                   | - LINK   : type lien HTML                                                                               |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getType()         | Méthode restituant la valeur contenue dans l’attribut type. Si aucune valeur n’existe, la méthode retourne false |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| evtClick($class,  | Méthode d’affectation de l’événement clic avec les règles précisées dans la description du bloc d’attributs ‘event’. |
| $method, $stopEvt)|                                                                                                         |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getClick()        | Récupération des paramètres de l’évènement ‘onclick’ sur le bouton. Fait appel à la méthode getEvent() pour l’événement ‘click’ dans la classe mère OObject. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disClick()        | Méthode déactivant tout paramétrage d’événement clic sur l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setNature($nature)| affectation de la nature du bouton                                                                      |
|                   |                                                                                                         |
|                   | - DEFAULT : nature par défaut (valeur par défaut)                                                       |
|                   | - PRIMARY : nature primaire (bleu roi)                                                                  |
|                   | - SUCCESS : nature succès (vert)                                                                        |
|                   | - INFO : nature information (gris bleu)                                                                 |
|                   | - WARNING : nature avertissement alerte (orange)                                                        |
|                   | - DANGER : nature danger, erreur (rouge)                                                                |
|                   | - LINK : nature lien (lien HTML, plus bouton alors)                                                     |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getNature()       | Méthode restituant la valeur contenue dans l’attribut nature. |
|                   | Si aucune valeur n’existe, la méthode retourne false |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| enaDefault()      | Affecte la valeur vraie (true) à l’attribut ‘default’ |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disDefault()      | Affecte la valeur faux (false) à l’attribut ‘default’ |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| createSimpleControl(Container &$sessionObj, $ord) | Méthode facilitant la construction de boutons répétés dont seul l’indice ou numéro d’ordre varie ($ord). Retourne l’occurrence du nouveau bouton. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setNatureCustom(string $customBGround, string $customColor) | Permet d’affecter à un bouton une couleur de fond, $customBGround, et une couleur d’écriture, $customColor, directement en chaîne hexadécimales les valeurs des couleurs à appliquer. Affecte via calcul, la couleur de bordure du bouton. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getNatureCustom() | Restitue, si les 3 attributs, custom, customColor et customBorder, existent, un tableau formé par ces dits 3 attributs. |
|                   | Si aucune valeur n’existe, la méthode retourne false |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getNatureCustomBackground() | Restitue, s’il existe, la valeur de l’attribut custom. |
|                             | Si aucune valeur n’existe, la méthode retourne false |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getNatureCustomColor() | Restitue, s’il existe, la valeur de l’attribut customColor. |
|                        | Si aucune valeur n’existe, la méthode retourne false |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getNatureCustomBorder() | Restitue, s’il existe, la valeur de l’attribut customBorder. |
|                         | Si aucune valeur n’existe, la méthode retourne false |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setWidth(string $width) | surcharge de l’affectation de la largeur du bouton et de l’image servant d’icône en directives CSS situé dans la classe mère OObject. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setLeft(string $left) | affectation du déport à gauche de l’image servant d’icône. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getLeft() | récupération du déport à gauche de l’image servant d’icône. |
|           | Si aucune valeur n’existe, la méthode retourne false |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setTop(string $top) | affectation du déport en haut de l’image servant d’icône |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getTop() | récupération du déport en haut de l’image servant d’icône |
|          | Si aucune valeur n’existe, la méthode retourne false |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

####Les méthodes privées

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getBtnTypesConstatnts() | Méthode de filtrage des constantes récupérées pour une garder que celle contenant ‘BTNTYPE_’, avec constitué un tableau qui sera ensuite retourné par la méthode. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getNatureConst() | Méthode de filtrage des constantes récupérées pour une garder que celle contenant ‘NATURE_’, avec constitué un tableau qui sera ensuite retourné par la méthode. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getEvent() | Méthode restituant un tableau contenant sous forme de chaînes de caractères, les paramétrages de l’événement clic. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
