#ODInput – Object zone de saisie
##objet zone de saisie multiple

La classe ODInput est une extension de la classe ODContained. Elle en hérite donc de l’ensemble des attributs et les enrichit pour la mise en œuvre d’une zone de saisie.

##Les attributs de l'objet

| Attribut | Explications |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| type              | Type de la zone de saisie, par défaut : type texte (TEXT). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| size              | Taille de la saisie affichée. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| minlength         | Taille minimale de la zone de saisie (en caractères). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| maxlength         | Taille minimale de la zone de saisie (en caractères). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| label             | Texte placé à côté de la zone de saisie |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| placeholder       | Texte de l’invite de saisie |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| labelWidthBT      | Taille en grille Bootstrap Twitter d’affichage du label associé à la zone de saisie |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| inputWidthBT      | Taille en grille Bootstrap Twitter d’affichage de la zone de saisie proprement dite |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| errorMessage      | Message d’erreur émis pour donner la cause de l’anomalie (sur validation le plus souvent) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| autoFocus         | Permet de positionner le focus, le curseur de saisie dans la zone de saisie si à vrai (true), par défaut à faux (false) |
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

##Méthode de base

###Les méthodes publiques

###Le constructeur - __construct($id)

Méthode de génération de l’objet.
* $id		: identifiant de l’objet.
* $pathObjArray	: tableau de noms et chemins du fichier de paramétrage de l’objet (spécifique).

Le tableau $pathObjArray enrichi du fichier de configuration spécifique à la classe ODInput avant appel à la méthode parente dans ODContained.

###Les méthodes générales

| Méthode        | Fonctionnalité                                                                                         |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setType(string  $type) | Affecte le type de saisie par le paramétre $type qui peut avoir l’une des valeurs suivantes : |
| | → TEXT : mode texte,  |
| | → PASSWORD : saisie de mot de passe (caché, présence d’étoile à la place),  |
| | → HIDDEN   : variable cachée |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getType() | Restitue la valeur contenue dans l’attribut type de l’objet ODInput. |
| | Retourne la valeur faux (false) si l’attribut n’est pas trouvé. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setSize(int $size) | Fixe le nombre de caractères (maximum) à afficher, c’est-à-dire, la taille de la zone de saisie affichée à l’écran s’il est supérieur à 0. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getSize() | Restitue la taille en affichage de la zone de saisie en nombre de caractères. |
| |              Retourne la valeur faux (false) si l’attribut n’est pas trouvé. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setMinlength(int $minlength) | Fixe le nombre de caractères (minimum) à saisir dans la zone de saisie ainsi définie, attribut minlength. |
| |                                 La méthode retourne finalement l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getMinLength() | Retourne en nombre de caractères, la taille minimale de la zone de saisie, attribut minlength. |
| | Retourne la valeur faux (false) si l’attribut n’est pas trouvé. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setMaxlength(int $maxlength) | Fixe le nombre de caractères (maximum) à saisir dans la zone de saisie ainsi définie, attribut maxlength. |
| | La méthode retourne finalement l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getMaxlength() | Retourne en nombre de caractères, la taille maximale de la zone de saisie, attribut maxlength. |
| | Retourne la valeur faux (false) si l’attribut n’est pas trouvé. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setLabel(string $label) | Affecte la valeur du label devant être affiché à côté de la zone de saisie (balise HTML input) |
| | La méthode retourne finalement l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getLabel() | Restitue le label devant être affiché à côté de la zone de saisie. |
| | Retourne la valeur faux (false) si l’attribut n’est pas trouvé. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setPlaceholder(string $placeholder) | Affecte la valeur du texte de l’invite de saisie. Retourne l’objet courant au final. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getPlaceholder() | Retourne la chaîne de caractères qu’est l’invite de saisie. |
| | Retourne la valeur faux (false) si l’attribut n’est pas trouvé. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setLabelWidthBT(string $labelWidthBT) | Attribut une largeur (Bootstrap Twitter) au texte du label (tableau de valeur en rapport des 4 médias gérés) affiché à côté de la zone de saisie (à gauche) s’il est exprimé. Le complément à 12 est fait pour attribuer à la zone de saisie sa taille à l’écran. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getLabelWidthBT() | Restitue la taille d’affichage en grille Bootstrap Twitter du label placé à gauche de la zone de saisie. |
| | Retourne la valeur faux (false) si l’attribut n’est pas trouvé. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getInputWidthBT() | Restitue la taille d’affichage en grille Bootstrap Twitter de la zone de saisie proprement dite.
| | Retourne la valeur faux (false) si l’attribut n’est pas trouvé.|
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| enaDispBySide() | Active l’affichage du label à côté de la zone de saisie.
| | La méthode retourne l’objet lui-même.|
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| enaDispUnder() | Active l’affichage du label au-dessus de la zone de saisie.
| | La méthode retourne l’objet lui-même.|
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setErrMessage(string $errMessage) | Affecte à l’attribut errMessage la chaîne de caractères $errMessagee pour affichage à l’écran. |
| | La méthode retourne l’objet lui-même. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getErrMessage() | Méthode restituant la valeur contenue dans l’attribut errMessage. |
| | Retourne la valeur faux (false) si l’attribut n’est pas trouvé. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| evtChange(string $class, string $method, bool $stopEvent = false) | Méthode d’affectation de l’événement change, changement de valeur avec les règles précisées dans la description du bloc d’attributs event. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getChange() | Récupération des paramètres de l’évènement ‘onchange’ sur la zone de saisie. Fait appel à la méthode getEvent() pour l’événement change dans la classe mère OObject. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disChange() | Méthode déactivant tout paramétrage d’événement change sur l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| evtKeyup(string $class, string $method, bool $stopEvent = false) | Méthode d’affectation de l’événement keyup, touche du clavier relâchée avec les règles précisées dans la description du bloc d’attributs event. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getKeyup() | Récupération des paramètres de l’évènement ‘onkeyup’ sur la zone de saisie. Fait appel à la méthode getEvent() pour l’événement keyup dans la classe mère OObject. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disKeyup() | Méthode déactivant tout paramétrage d’événement keyup sur l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| enaAutoFocus() | Active l’auto-focus sur le champ pour débuter la saisie (dernier paramétré qui prend le pas sur les autres). |
| | La méthode retourne l’objet lui-même. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disAutoFocus() | Désactive l’auto-focus sur le champ pour débuter la saisie. |
| | La méthode retourne l’objet lui-même. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getAutoFocus() | Méthode restituant la valeur contenue dans l’attribut autoFocus. |
| | Retourne la valeur faux (false) si l’attribut n’est pas trouvé.
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| enaMask($mask) | Active l’utilisation du masque de saisie $mask sauvegardé dans l’attribut mask. l’attribut type est forcé au type texte en cas d’utilisation de masque. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disMask() | Méthode déactivant l’utilisation de masque de saisie sur l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getMask() | Méthode restituant la valeur contenue dans l’attribut mask. |
| | Retourne la valeur faux (false) si l’attribut n’est pas trouvé. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setValMax(int $valMax = 0) | Dans le cas de valeurs bordées, fixe la valeur maximale acceptée, $valMax, par défaut initialisée à 0, à l’attribut valMax. |
| | La valeur $valMax doit être obligatoirement supérieure ou égale à la valeur de l’attribut valMin si ce dernier est renseigné, et que le type de saisie est numérique. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getValMax() | Méthode restituant la valeur contenue dans l’attribut valMax. |
| | Retourne la valeur faux (false) si l’attribut n’est pas trouvé. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setValMin(int $valMin = 0) | Dans le cas de valeurs bordées, fixe la valeur minimale acceptée, $valMin, par défaut initialisée à 0, à l’attribut valMin. |
| | La valeur $valMin doit être obligatoirement inférieure ou égale à la valeur de l’attribut valMax si ce dernier est renseigné, et que le type de saisie est numérique. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getValMin() | Méthode restituant la valeur contenue dans l’attribut valMin. |
| | Retourne la valeur faux (false) si l’attribut n’est pas trouvé. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| validateContent() | Méthode de validation / invalidation du champ ODInput |
| | • si retour un champ vide  = champ valide |
| | • sinon retourne le message d'erreur |
| | |    
| | cette méthode reproduit les mêmes traitements que ceux codés dans le fichier JavaScript ./public/oobject/odcontained/odinput/js/odinput.js dans la méthode invalidate |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

####Méthodes de gestion de retour de callback

| Méthode        | Fonctionnalité                                                                                         |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| returnSetData() | Méthode formatant le retour d’appel de callback demandant à mettre à jour le champ dans la page. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

###Les méthodes protégées ou privées
| Méthode        | Fonctionnalité                                                                                         |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getInpTypesConstants() | Méthode de filtrage des constantes récupérées pour une garder que celle contenant ‘INPUTTYPE’, avec constitué un tableau qui sera ensuite retourné par la méthode. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
