#ODButton – objet bouton

##objet bouton pour déclenchement de processus, renvoi de lien

L’objet **ODButton** hérite de l’objet **ODContained** pour la base de ses attributs et méthodes.

##Notes sur le fonctionnement

On peut affecter à un bouton un type de fonctionnement : (pouvant être réaffecté suivant d’autre attribut)

    * CUSTOM    = bouton divers permettant de déclencher une action,
    * SUBMIT    = bouton de déclenchement du pseudo-formulaire auquel il est lié,
    * RESET	    = bouton de réinitialisation du pseudo-formulaire auquel il est lié,
    * LINK	    = lien pour accès à une ressource interne ou externe au site à l’application (type HTML).

Ce paramétrage est affecté à la présence d’un identifiant de regroupement en formulaire et à l’existence d’un événement (de type clic).

Les règles sont les suivantes :

    * Type LINK : l’attribut form est initialisé à vide, et l’événement clic est retravaillé afin que l’attribut class contienne la route et l’attribut method le tableau des paramètres (comme controller, action …),
    * Type RESET : si l’attribut form est vide, on bascule le type à CUSTOM,
    * Type SUBMIT : si l’attribut form est vide, on bascule le type à CUSTOM,
    * Type CUSTOM : si l’attribut form est non vide, on bascule le type à SUBMIT ou RESET suivant le contexte,
    
    * À l’affectation de l’attribut form, si il n’y a pas d’événement clic, le type est basculé à RESET, dans le cas contraire, à SUBMIT,
    * Dans la méthode evtClick si l’attribut form est non vide le type est basculé à SUBMIT,
    * Dans la méthode evtClick si l’attribut form est vide et le type différent de LINK, le type est basculé à CUSTOM.

L'affectation de la nature à un bouton en détermine son aspect (couleur de fond) :

    * DEFAULT 	= nature par défaut (valeur par défaut)
    * PRIMARY	= nature primaire (bleu roi)
    * SUCCESS 	= nature succès (vert)
    * INFO    	= nature information (gris bleu)
    * WARNING 	= nature avertissement alerte (orange)
    * DANGER  	= nature danger, erreur (rouge)
    * LINK    	= nature lien (lien HTML, plus bouton alors)

Cette nature peut de fait devenir signifiante suivant le contexte de l’emploi du bouton.

Le seul événement géré sur le bouton est le clic. À ce moment, le programme fournit la référence de la méthode (callback) à exécuter.

Le contenu du bouton peut être texte (affectation d’un label) et/ou icône (affectation d’une icône font awesome / glyphicon par classe suivant disponibilité, voir une image).

Le seul évènement géré sur le bouton est le click. À ce moment, le programme fourni la référence de la méthode (callback) à exécuter

On peut, comme sur tout objet, avoir une bulle d'aide information grâce aux fonctions liées à l'attribut infoBulle.
Cette information pourra prendre 2 aspects : information sur une ligne (**tooltip**), panneau explicatif (**popover**).

##Les attributs de base

###Les attributs généraux

| Attribut | Explications |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **type**              | Type du bouton |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **label**             | Texte écrit dans le bouton |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **icon**              | Icône (classe) ou Image (chemin d’accès) ajoutée au label du bouton |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **pathFile** | Chemin d’accès à l’image paramétrée comme icône du bouton (pris en compte si l'attribut *icon* est non renseigné) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **event**             | Tableau de paramétrage des événements possibles sur un bouton : clic seulement  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **nature**            | Présentation graphique du bouton  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

###Le bloc de paramétrage d'événement - bloc 'event'

| Attribut | Explications |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **class**              | Suivant le type de bouton : |
| | • type lien (**LINK**) = la route **Zend Framework** du lien, |
| | • autre type = le nom de la classe pour instancier l’objet dans lequel on exécutera une méthode. (avec son namespace **Php**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **method**              | Suivant le type de lien : |
| | • type lien (**LINK**) = le tableau des paramètres permettant le calcul et génération de l’URL en fonction de la route **Zend Framework**, |
| | • autre type : nom de la méthode à exécuter dans l’objet instancié à partir du nom ce classe stocké dans class. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **stopEvt**              | Booléen indiquant la propagation (**true**) ou la non propagation (**false**) de l’événement codé dans la page. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

Le bloc ‘event’  sera intégré dans l’attribut tableau event en ayant pour clé ‘clic’.

##Les constantes de base

Les constantes de typologie de bouton :

	- BUTTONTYPE_CUSTOM = bouton divers permettant de déclencher une action
	- BUTTONTYPE_SUBMIT = bouton de déclenchement du pseudo-formulaire auquel il est lié
	- BUTTONTYPE_RESET  = bouton de réinitialisation du pseudo-formulaire auquel il est lié
	- BUTTONTYPE_LINK   = lien pour accès à une resource interne ou externe au site à l'application (type HTML)

Les constantes de présentation (couleur) de bouton :

    - BUTTONNATURE_DEFAULT = bouton fond blanc écriture gris foncé [#333] (valeur par défaut)
    - BUTTONNATURE_PRIMARY = bouton fond bleu roi [#428bca] écriture blanche
    - BUTTONNATURE_SUCCESS = bouton fond vert [#5cb85c] écriture blanche
    - BUTTONNATURE_INFO    = bouton fond gris bleu [#5bc0de] écriture blanche
    - BUTTONNATURE_WARNING = bouton fond orange [#f0ad4e] écriture blanche
    - BUTTONNATURE_DANGER  = bouton fond rouge [#d9534f] écriture blanche
    - BUTTONNATURE_LINK    = lien HTML sans forme de bouton

Les constantes de cible d’ouverture de lien (non mise en œuvre pour l’heure) :

    - BUTTONLINK_TARGET_BLANK  = ouverture dans une nouvelle page, un nouvel onglet
    - BUTTONLINK_TARGET_SELF   = ouverture dans la page actuelle (remplacement de contenu)
    - BUTTONLINK_TARGET_PARENT = ouverture dans la fenêtre parent de l’actuelle
    - BUTTONLINK_TARGET_TOP    = ouverture dans la fenêtre racine de la session en cours
 
##Méthodes de base

###Les méthodes publiques

####Le constructeur - __construct(string $id)

Méthode de génération de l’objet.

	$id             : identifiant de l’objet,
	$pathObjArray	: tableau de noms et chemins du fichier de paramétrage de l’objet (spécifique).

Le tableau $pathObjArray enrichi du fichier de configuration spécifique à la classe ODButton avant appel à la méthode parente dans ODContained.

####Les méthodes générales

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setLabel(string $label)**    | Méthode affectant à l’attribut *label* avec **$label**, avant de retourner l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getLabel()**          | Méthode restituant la valeur contenue dans l’attribut **label**. |
|                     | Si aucune valeur n’est trouvée, la méthode retourne la valeur faux (**false**)  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setIcon(string $icon)**      | Affecte la ou les classes à appliquer à l’objet courant pour lui adjoindre une icône choisie parmi les icônes Bootstrap Twitter ou autres. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setImage($pathFile)** | Affectation d’une image comme icône du bouton à gauche du label (*.ico-custom*). |
| | Après vérification de l’existence du fichier de chemin relatif **$pathFile**, affectation de ce dernier à l’attribut *pathFile*. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getIcon()**           | récupère suivant le cas la classe associée (**setIcon()**) ou le chemin de l’image (**setImage**()). Si aucunes valeurs n’existent, la méthode retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setForm($form)**      | Surcharge de la méthode **setForm()** dans **ODContained**. Permet de valider le contenu de l’attribut *type* suivant le paramétrage ou non d’un événement *clic*. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setType(string $type = self::BUTTONTYPE_CUSTOM)** | Permet d’affecter l’un des différents types de bouton à l’objet courant.
| | Si le type de bouton fourni par **$type**, n’existe pas, il l’initialise à **CUSTOM**. En même temps qu’il affecte un type de bouton, il valide par le contexte que le type paramétré est le bon avant de retourner l’objet courant. |
| | • **CUSTOM** : type divers, |
| | • **SUBMIT** : type soumission (de formulaire), |
| | • **RESET** : type remise à zéro des champs (de formulaire), |
| | • **LINK**   : type lien **HTML**. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getType()**         | Méthode restituant la valeur contenue dans l’attribut *type*. Si aucune valeur n’existe, la méthode retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **evtClick(string $class, string $method, bool $stopEvent = false)**  | Méthode d’affectation de l’événement *clic* avec les règles précisées dans la description du bloc d’attributs *event*. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getClick()**        | Récupération des paramètres de l’évènement ‘*onclick*’ sur le bouton. Fait appel à la méthode **getEvent()** pour l’événement *click* dans la classe mère **OObject**. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **disClick()**        | Méthode déactivant tout paramétrage d’événement *click* sur l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setNature(string $nature = self::BUTTONNATURE_DEFAULT)** | Méthode affectant à l’attribut *nature* l’une des natures possibles. Si elle n’existe pas dans les natures possibles, on paramètre le bouton aspect **DEFAULT** |
| | • **DEFAULT** : nature par défaut (valeur par défaut), |
| | • **PRIMARY** : nature primaire (bleu roi), |
| | • **SUCCESS** : nature succès (vert), |
| | • **INFO** : nature information (gris bleu), |
| | • **WARNING** : nature avertissement alerte (orange), |
| | • **DANGER** : nature danger, erreur (rouge), |
| | • **LINK** : nature lien (lien **HTML**, plus bouton alors) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getNature()**       | Méthode restituant la valeur contenue dans l’attribut *nature*. Si aucune valeur n’existe, la méthode retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **enaDefault()**      | Affecte la valeur vraie (**true**) à l’attribut *default* |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **disDefault()**      | Affecte la valeur faux (**false**) à l’attribut *default* |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **createSimpleControl(Container &$sessionObj, $ord)** | Méthode facilitant la construction de boutons répétés dont seul l’indice ou numéro d’ordre varie (**$ord**). Retourne l’occurrence du nouveau bouton. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setNatureCustom(string $customBGround, string $customColor)** | Permet d’affecter à un bouton une couleur de fond, **$customBGround**, et une couleur d’écriture, **$customColor**, directement en chaîne hexadécimales les valeurs des couleurs à appliquer. Affecte via calcul, la couleur de bordure du bouton. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getNatureCustom()** | Restitue, si les 3 attributs, *custom*, *customColor* et *customBorder*, existent, un tableau formé par ces dits 3 attributs. |
| | Si aucune valeur n’existe, la méthode retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getNatureCustomBackground()** | Restitue, s’il existe, la valeur de l’attribut *custom*. |
|                             | Si aucune valeur n’existe, la méthode retourne la valeur faux (**false**) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getNatureCustomColor()** | Restitue, s’il existe, la valeur de l’attribut *customColor*. |
| | Si aucune valeur n’existe, la méthode retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getNatureCustomBorder()** | Restitue, s’il existe, la valeur de l’attribut *customBorder*. |
| | Si aucune valeur n’existe, la méthode retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setWidth(string $width)** | Surcharge de l’affectation de la largeur du bouton et de l’image servant d’icône en directives **CSS** situé dans la classe mère **OObject**. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setLeft(string $left)** | affectation du déport à gauche de l’image servant d’icône. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getLeft()** | Récupération du déport à gauche de l’image servant d’icône. |
| | Si aucune valeur n’existe, la méthode retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setTop(string $top)** | Affectation du déport en haut de l’image servant d’icône |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getTop()** | Récupération du déport en haut de l’image servant d’icône |
| | Si aucune valeur n’existe, la méthode retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

####Les méthodes privées

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getBtnTypesConstatnts()** | Méthode de filtrage des constantes récupérées pour une garder que celle contenant **BTNTYPE**, avec constitué un tableau qui sera ensuite retourné par la méthode. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getNatureConst()** | Méthode de filtrage des constantes récupérées pour une garder que celle contenant **NATURE**, avec constitué un tableau qui sera ensuite retourné par la méthode. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getLinkTargetConstants()** | Méthode de filtrage des constantes récupérées pour une garder que celle contenant **BUTTONLINK_TARGET**, avec constitué un tableau qui sera ensuite retourné par la méthode. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
