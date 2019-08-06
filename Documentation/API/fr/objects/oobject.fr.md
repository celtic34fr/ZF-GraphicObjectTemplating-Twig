OObject – Original Object
=========================
##objet de base pour les autres objets

L’objet OObject est l’objet de base à partir duquel tous les autres seront créés. Il en assume les attributs, constantes et méthodes communes à tout objet.

Toutefois, le programmeur aura quelques règles à suivre dans le cadre général de l’utilisation de GOT [Graphic Object Templating] :
* Veiller à l’unicité de l’identifiant attribué à l’objet,
* Les objets étant sauvegardés en session PHP, pour être facilement récupérable, ces derniers ne sont pas systématiquement réinitialisés ou supprimés. Cette tâche incombe au programmeur qui devra la prévoir dans ses traitements.
    
Les autres objets de type contenus ([ODContained](odcontained.fr.md)) ou de type contenant ([OSContainer](oscontainer.fr.md)) prennent donc appuis sur cet objet pour y ajouter attributs, constantes et méthodes spécifiques.

Les attributs de bases
----------------------

Ce sont les attributs communs à l’ensemble des objets : ils sont divisés en 2 parties, une partie déclaration administrative et une partie déclaration plus fonctionnelle.

### Attributs de base -- attributs généraux

    id            => Identifiant unique  donnée à l’objet (ID de balise HTML)
    name          => Nom de l'objet (utilisé pour principalement pour l’ODInput) qui peut être différent de son ID
    className     => Namespace PHP et nom de la classe d’instanciation de l’objet
    display       => Visibilité de l’objet (directive CSS display, par défaut 'block')
    object        => Nom de l’objet  G.O.T. instancié
    typeObj       => Type d’objet (odcontainer : contenant, odcontained : contenu)
    template      => Nom du modèle (template) et chemin relatif d’accès pour le rendu HTML
    widthBT       => Largeur de l’objet dans une grille Bootstrap Twitter (par défaut 12)
    lastAccess    => Date et heure (datetime) du dernier accès à l’objet par G.O.T.
    state         => État de l'objet : accessible (true) ou inaccessible (false)
    classes       => Classes CSS à appliquer à l'objet
    width         => Largeur en directive CSS de l'objet
    height        => Hauteur de l'objet en directive CSS de l'objet

    autoCenter    => Drapeau d’activation (true) ou désactivation (false) de l’auto-centrage de l’objet
    acPx          => Largeur de l'objet auto-centré en directive CSS
    acPy          => Hauteur de l'objet auto-centré en directive CSS

Les attributs object et typeObj seront redéfinis dans le fichier de configuration de chaque objet. L’attribut template ne contiendra au départ, relativement à chaque objet, que le nom du modèle sans le chemin relatif d’accès. C’est lors de la construction de l’objet que cet attribut sera dûment complété.

###Attributs de base – cas particulier des info-bulles

Dans le cadre des info-bulles, un tableau d’attributs est mis en place dans l’objet OOjbect pour permettre de définir et caractériser l’info-bulle à afficher pour l’objet en question. Le tableau d’attributs aura pour clé d’accès ‘infoBulle’. Voici les attributs contenus dans le dit tableau :

    infoBulle     => Paramétrage d'info-bulle sur l'objet
        setIB         => Drapeau indiquant si l'info-bulle n'est qu'un titre (false) ou un titre + contenu (true)
        type          => Type d'infoBulle, par défaut 'tooltip', mais possible en 'popover'
        animation     => Active (true) ou désactive (false) l'animation de l'affichage de l'info-bulle
        delay         => Tableau d'attributs permettant la définition des temps d'affichage et disparition de l'info-bulle
            show          => Temps d'affichage fixé par défaut à 500 millisecondes
            hide          => Temps de disparition de l'objet fixé par défaut à 100 millisecondes
        html          => Drapeau pour définir l’affichage en mode HTML (true) ou non (false) de l'info-bulle
        placement     => Placement de l'info-bulle par rapport à l'objet, par défaut fixé au dessus
        title         => Titre de l'info-bulle
        content       => Texte ou contenu de l'info-bulle
        trigger       => Mode d'affichage de l'info-bulle, fixé par défaut au survol

Les constantes de base
----------------------

La notion d’affichage est mise systématiquement, afin de permettre plus facilement d’afficher ou cacher certain objet rapidement. Les notions utilisées sont :

    Les constantes de visibilité de l'objet
    ---------------------------------------
    const DISPLAY_NONE    = 'none';
    const DISPLAY_BLOCK   = 'block';
    const DISPLAY_INLINE  = 'inline';
    const DISPLAY_INBLOCK = 'inline-block';
    const NO_DISPLAY      = 'noDisplay';

Les constantes de gestion de l’état de l’objet seront également initialisées :

    Les constantes d'état de l'objet
    --------------------------------
    const STATE_ENABLE    = true;
    const STATE_DISABLE   = false;

Pour permettre un paramétrage plus facile de l’info-bulle d’un conteneur, on déploie 3 groupes de constantes :
* La typologie de l’info-bulle (IBTYPE_*),
* Le positionnement de l’info-bulle par rapport au conteneur (IBPLACEMENT_*),
* Les modes de déclenchement de l’affichage / disparition de l’info-bulle (IBTRIGGER_*).


    Les types d'info-bulle
    ----------------------
    const IBTYPE_TOOLTIP    = 'tooltip';
    const IBTYPE_POPOVER    = 'popover';

    Les placement d'info-bulle
    --------------------------
    const IBPLACEMENT_TOP       = 'top';
    const IBPLACEMENT_BOTTOM    = 'bottom';
    const IBPLACEMENT_LEFT      = 'left';
    const IBPLACEMENT_RIGHT     = 'right';
    const IBPLACEMENT_AUTO      = 'auto';

    les modes de déclenchement d'affichage de l'info-bulle
    ------------------------------------------------------
    const IBTRIGGER_CLICK       = 'click';
    const IBTRIGGER_HOVER       = 'hover';
    const IBTRIGGER_FOCUS       = 'focus';
    const IBTRIGGER_MANUEL      = 'manuel';

2 autres groupes de constantes sont présents.

    Les constantes booléennes (pour restitution en chaîne de caractère)
    -------------------------------------------------------------------
    const BOOLEAN_TRUE    = 'true';
    const BOOLEAN_FALSE   = 'false';

    Les constantes pour affectation de couleur pour écriture ou fond (CSS)
    ----------------------------------------------------------------------
    const COLOR_BLACK         = 'black';
    const COLOR_WHITE         = 'white';
    const COLOR_LIME          = 'lime';
    const COLOR_GREEN         = 'green';
    const COLOR_EMERALD       = 'emerald';
    const COLOR_TEAL          = 'teal';
    const COLOR_BLUE          = 'blue';
    const COLOR_CYAN          = 'cyan';
    const COLOR_COBALT        = 'cobalt';
    const COLOR_INDIGO        = 'indigo';
    const COLOR_VIOLET        = 'violet';
    const COLOR_PINK          = 'pink';
    const COLOR_MAGENTA       = 'magenta';
    const COLOR_CRIMSON       = 'crimson';
    const COLOR_RED           = 'red';
    const COLOR_ORANGE        = 'orange';
    const COLOR_AMBER         = 'amber';
    const COLOR_YELLOW        = 'yellow';
    const COLOR_BROWN         = 'brown';
    const COLOR_OLIVE         = 'olive';
    const COLOR_STEEL         = 'steel';
    const COLOR_MAUVE         = 'mauve';
    const COLOR_TAUPE         = 'taupe';
    const COLOR_GRAY          = 'gray';
    const COLOR_DARK          = 'dark';
    const COLOR_DARKER        = 'darker';
    const COLOR_DARKBROWN     = 'darkBrown';
    const COLOR_DARKCRIMSON   = 'darkCrimson';
    const COLOR_DARKMAGENTA   = 'darkMagenta';
    const COLOR_DARKINDIGO    = 'darkIndigo';
    const COLOR_DARKCYAN      = 'darkCyan';
    const COLOR_DARKCOBALT    = 'darkCobalt';
    const COLOR_DARKTEAL      = 'darkTeal';
    const COLOR_DARKEMERALD   = 'darkEmerald';
    const COLOR_DARKGREEN     = 'darkGreen';
    const COLOR_DARKORANGE    = 'darkOrange';
    const COLOR_DARKRED       = 'darkRed';
    const COLOR_DARKPINK      = 'darkPink';
    const COLOR_DARKVIOLET    = 'darkViolet';
    const COLOR_DARKBLUE      = 'darkBlue';
    const COLOR_LIGHTBLUE     = 'lightBlue';
    const COLOR_LIGHTRED      = 'lightRed';
    const COLOR_LIGHTGREEN    = 'lightGreen';
    const COLOR_LIGHTERBLUE   = 'lighterBlue';
    const COLOR_LIGHTTEAL     = 'lightTeal';
    const COLOR_LIGHTOLIVE    = 'lightOlive';
    const COLOR_LIGHTORANGE   = 'lightOrange';
    const COLOR_LIGHTPINK     = 'lightPink';
    const COLOR_GRAYDARK      = 'grayDark';
    const COLOR_GRAYDARKER    = 'grayDarker';
    const COLOR_GRAYLIGHT     = 'grayLight';
    const COLOR_GRAYLIGHTER   = 'grayLighter';


Les méthode de base
-------------------

Par le codage en PHP des méthodes de l’objet OObject, on divisera en 3 types principaux :
* Les méthodes statiques, appelables directement à partir de la classe. Leur utilité réside dans l’exécution de tâche globale, comme la recréation d’objet, la suppression d’objet des sessions PHP …,
* Les méthodes publiques accessibles pour tout objet,
* Les méthodes privées qui ne sont là que pour assurer un traitement secondaire pour l’objet limité à la classe.

###Les méthodes statiques

Ce sont des méthodes décorrélées de tout contexte d’objet. Elles sont là pour réaliser quelques opérations visant à faciliter la gestion des objets sauvegardés en session PHP.

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| validateSession() | Méthode visant à valider l’existence de l’objet de session 'gotObjList' qui stockera l’ensemble des définitions des objets GOT. S’il n’existe pas, il le crée. |
| | Si elle existe, valide la session actuelle. Si la durée de vie de la session est dépassée, cette dernière est totalement réinitialisée. |
| | Dans tous les cas, cette méthode retourne le container de session 'gotObjList', contenant objets ('objects'), ressources ('resources'), objets permanents ('persistObjs') et date/heure du dernier accès ('lastAccess'). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| existObject($id, Container $sessionObj) | Après avoir validé la session (::validateSession()), recherche l'existence de la clé $id (identifiant) dans le tableau des objets ('objects'). |
| | Si la clé existe, la méthode retourne la valeur vrai (true), sinon la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| buildObject($id, Container $sessionObj, $value) | Après avoir validé l'existence de la clé $id (::existObject($id)), instancie l'objet d'identifiant $id et le retourne, s'il existe bien. |
| | Dans le cas d'instanciation technique (identifiant 'dummy' avec tableau des propriétés vide), retourne la valeur null, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| cloneObject(OObject $object, Container $sessionObj) | Permet de cloner l'objet $object si ce dernier existe en lui affectant un identifiant temporaire 'tmpObj'. |
| | Le programme peut alors le changer directement via la méthode setId(). |
| | Si l'objet $object n'existe pas dans les objets en session ('objects'), la méthode retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| destroyObject($id, $session = false) | Méthode permettant de détruire un ou tous les objets non persistés. |
| | Par défaut $session est à faux (false), impliquant la destruction d'un seul objet ayant $id pour identifiant |
| | Si $session est à vrai (true), la destruction concerne tous les objets non persistés, c'est-à-dire, sauf ceux présents dans le tableau 'persistObjs' |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| clearObjects() | Vide totalement le container de session 'gotObjList', en initialisant les tableaux 'objects', 'resources' et 'persistObjs' par un tableau vide. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| formatBootstrap(string $widthBT) | Méthode visant à formater la directive de taille de colonne Bootstrap Twitter, en incluant les offset de colonne. |
|  | La chaîne finale renvoyée est de la forme 'WL99:WM99:WS99:WX99' au minimum ou 99 correspondant à la largeur Bootstrap suivant le device. |
|  | Les directives d'offset seront sous la forme 'OL99:OM99:OS99:OX99', et pourront être mixée avec les directives de largeur. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| formatLabelBT($labelWidthBT) | Méthode complémentaire à formatBootstrap() visant à retourner un tableau de 2 chaînes de caractères pour formater l'affichage de label et valeur (zone de saisie ODInput par exemple) plus rapidement. |
| | La méthode reçoit le paramètre $labelWidthBT, et restitue un tableau de 2 valeurs de clés respectives  labelWidthBT et inputWidthBT. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| formatRetour($idSource, $idCible, $mode, $code = null) | Méthode générique visant à formater les informations de retours d'appel de callback sous forme d'un tableau. |
| | ['idSource'=>$idSource, 'idCible'=>$idCible, 'mode'=>$mode, 'code'=>$code]; |
| | 'idSource' : identifiant de l'objet ayant déclenché l'appel de callback
| | 'idCible' : identifiant de l'objet sur lequel on pourra affecter le retour d'appel de callback
| | 'mode' : type ou méthode à déclencher en retour d'appel de callback
| | 'code' : code paramètre à utiliser dans le retour d’appel de callback
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getPersistantObjs() | Méthode retournant le contenu du tableau 'persistObjs', objet persistés de la session |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

###Les méthodes publiques

Ces méthodes servent au paramétrage bas niveau de l’objet, au regard ds attributs de base. Généralement ces méthodes ne seront pas surchargées, sauf cas contraire suivant le contexte.

####Le constructeur - __construct(string $id, array $adrProperties)

Méthode de génération de l’objet.
* $id		: identifiant de l’objet,
* $adrProperties	: tableau des noms et chemins d’accès du fichier de paramétrage de l’objet (spécifique).

le tableau $adrProperties conteint l'ensemble des références de fichiers de configurations à intéghrer comme attributs de l'objet courant.

####Les méthodes générales

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getProperty(string $name) | Méthode qui retourne la valeur associée à l'attribut $name de l'objet s'il existe. |
| | Si l'attribut $name n'existe pas, la méthode retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getProperties() | Méthode retournant le tableau associatif des attributs de l'objet si l'attribut direct 'id' existe non vide, sinon retourne la valeur faux (false) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setProperties(array $properties) | Méthode permettant d'affecter le contenu de tableau associatif $properties comme attribut de l'objet |
| | Cette affectation ne se fera que si : |
| | -> l'attribut id de l'objet existe et est non vide |
| | -> le tableau associatif $properties est non vide et contient l'attribut id |
| | La méthode retourne l'objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getId() | Méthode restituant si elle existe la valeur de l'attribut 'id'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setId(string $id) | Méthode d'affectation de la valeur de l'attribut 'id' de l'objet courant. |
| | ATTENTION cette méthode est présente pour faciliter les opérations de post clonage ou toute autre nécessité de changement d'attribut id de l'objet. |
| | L'affectation se fait à 2 niveaux, en premier l'attribut direct de l'objet 'id', en suite l'attribut sauvegardé dans le tableau associatif 'properties', 'id'. |
| | Elle affecte directement le contenu des objets sauvegardés en session. Dans le cas de changement d'identifiant d'objet, l'ancien objet est détruit et le nouveau sauvegardé. |
| | La méthode retourne l'objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getName() | Méthode restituant si elle existe la valeur de l'attribut 'name'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setName(string $name) | Méthode d'affectation de la valeur de l'attribut 'name' de l'objet courant. |
| | L'affectation de l'attribut 'name' se fait si et seulement si l'attribut direct de l'objet 'id' n'est pas vide. |
| | Alors est affecté l'attribut direct 'name' de l'objet et celui sauvegardé dans le tableau associatif 'properties', 'name'.
| | La méthode retourne l'objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getDisplay() | Méthode restituant si elle existe la valeur de l'attribut 'display'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setDisplay(string $display = OObject::DISPLAY_BLOCK) | Méthode d'affectation de la valeur de l'attribut 'display', visibilité de l'objet. |
| | Les valeurs admises sont : [
| | • ‘none’		pas d’affichage de l’objet |
| | • ‘block’		affichage de type bloc (Cf. CSS display), |
| | • ‘inline’		affiche dans la ligne (Cf. CSS display), |
| | • ‘inline-block’	affichage composé bloc et dans la ligne. |
| | Si la valeur $display fournie n’est pas l’une des valeurs possibles, elle est initialisée à la valeur par défaut, ‘block’. |
| | Retourne l’objet courant au final.La méthode retourne l'objet lui-même. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getWidthBT() | Méthode restituant si elle existe la valeur de l'attribut 'widthBT'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setWidthBT(string $widthBT) | Méthode d'affectation de la valeur de l'attribut 'widthBT'. |
| | La valeur du paramètre $widthBT n'est pas prise telle que, mais passe au travers de la méthode statique formatBootstrap() pour être formatée correctement avant affectation réelle .|
| | La méthode retourne l'objet lui-même si $widthBT n'est pas vide, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getClassName() | Méthode restituant si elle existe la valeur de l'attribut 'className'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setClassName(string $className = null) | Méthode d'affectation de la valeur de l'attribut 'className'. |
| | ATTENTION cette méthode est présente pour faciliter les opérations de post clonage ou toute autre nécessité de changement d'attribut className de l'objet. |
| | Si le paramètre $className n'est pas vide, la méthode valide l'existence de la classe dans l'environnement. |
| | Si la classe existe bien, l'affecte à l'attribut 'className' du tableau associatif 'properties'. |
| | La méthode retourne l'objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getTemplate() | Méthode restituant si elle existe la valeur de l'attribut 'template'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setTemplate(string $template = null) | Méthode visant à paramétrer le nom et le chemin relatif d’accès au fichier modèle (template) de l’objet. |
| | Le chemin relatif calculé en base à partir du répertoire ‘view/graphic-object-templating’, est constitué de champs séparés par des barres de fraction : |
| | • l’attribut ‘typeObj’, |
| | • l’attribut ‘objet’, |
| | • l’attribut d’origine ‘template’. |
| | Ici $template doit être déjà formé comme décrit ci-dessus. Si le fichier visé par $template n’existe pas, la méthode retourne le booléen false. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false).|
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getObject() | Méthode restituant si elle existe la valeur de l'attribut 'object'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setObject(string $object = null) | Méthode qui affecte à l’objet son nom G.O.T., $object (le nom de sa classe d’instanciation en minuscules). Cette information est codée dans le fichier de configuration de l’objet, cette méthode ne doit pas être normalement utilisée. |
| | ATTENTION cette méthode est présente pour faciliter les opérations de post clonage ou toute autre nécessité de changement d’attribut object de l’objet. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getTypeObj() | Méthode restituant si elle existe la valeur de l'attribut 'typeObj'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setTypeObj(string $typeObj = null) | Méthode qui affecte son type à l’objet courant, $typeObj. Cette information est codée dans le fichier de configuration de l’objet, cette méthode ne doit pas être normalement utilisée. |
| | ATTENTION cette méthode est présente pour faciliter les opérations de post clonage ou toute autre nécessité de changement d’attribut typeObj de l’objet. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getLastAccess() | Méthode restituant si elle existe la valeur de l'attribut direct 'lastAccess'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getClasses() | Méthode restituant si elle existe la valeur de l'attribut 'classes'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setClasses($classes = null) | Méthode d’affectation des classes CSS spécifiques à associer à l’objet courant. Ces classes sont issues de fichier(s) externe(s) de présentation CSS ou directement dans les modèle de rendu de vue, et elles peuvent être associées à l’objet courant grâce à la gestion de ressources (addCssFile(), setCssFile()) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| addClass(string $class = null) | Méthode permettant l’ajout de classe(s) (par une chaîne de caractères), $class, à la valeur de l’attribut 'classes' déjà codées sur l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| removeClass(string $class = null) | Méthode visant à supprimer $class de la liste des classes dans la valeur de l’attribut 'classes' appliquées à l’instance d’objet. Retourne l’objet lui-même alors. |
| | Si $class n’existe pas, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| addCssFile(string $nameFile, string $pathFile) | Ajout d’une référence de fichier CSS, à l’instance d’objet. |
| | Par référence il faut voir : chemin relatif d’accès au fichier à partir du répertoire public de l’application Zend Framework. |
| | La valeur $nameFile correspond au nom du fichier CSS ajouté et à la clé d’accès dans le tableau des resources CSS. |
| | La valeur $pathFile correspond au chemin complet et nom du fichier CSS ajouté. C’est à valeur associée à la clé d’accès $nameFile dans le tableau des resources CSS. |
| | Après validation de l’existence physique de $pathFile, que le fichier $nameFile n’est pas déjà référencé, le couple $nameFile/$pathFile est alors ajouté aux resources CSS de l’objet courant. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| removeCssFile(string $nameFile) | Méthode visant à supprimer une référence de fichier CSS dans le tableau des resources CSS de l’instance d’objet. Le resource CSS à supprimer est donnée par la clé d’accès $nameFile. Si la resource $nameFile est trouvée, elle est  supprimée du tableau des resources CSS de l’instance d’objet, comme du tableau des resources actives/inactives, si présente. |
| | Si $nameFile n’existe pas, la méthode retourne le booléen false. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getPathCssFile(string $nameFile) | Méthode restituant le chemin complet d’accès à la resource CSS ayant pour clé d’accès $nameFile, relativement au répertoire public de l’application Zend Framework. |
| | Si $nameFile existe, la méthode retourne la valeur qui lui est associé dans le tableau des resources CSS de l’objet courant. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| enaCssFile(string $nameFile) | Active la resource CSS ayant pour clé d’accès $nameFile, c’est-à-dire, permet l’utilisation de la resource dans les pages générées par G.O.T. |
| | Si $nameFile n’existe pas, la méthode retourne le booléen false. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disCssFile(string $nameFile) | Désactive la resource CSS ayant pour clé d’accès $nameFile, c’est-à-dire, interdit l’utilisation de la resource dans les pages générées par G.O.T. |
| | Si $nameFile n’existe pas, la méthode retourne le booléen false. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getCssFileStatus(string $nameFile) | Restitue l’état de la resource CSS dans le système, activé (enable) ou désactivé (disable), pour la clé d’accès $nameFile. |
| | Si $nameFile existe, la méthode retourne la valeur vrai (true), sinon la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| addJsFile(string $nameFile, string $pathFile) | Ajout d’une référence de fichier JS, à l’instance d’objet. |
| | Par référence il faut voir : chemin relatif d’accès au fichier à partir du répertoire public de l’application Zend Framework. |
| | La valeur $nameFile correspond au nom du fichier JS ajouté et à la clé d’accès dans le tableau des resources JS. |
| | La valeur $pathFile correspond au chemin complet et nom du fichier JS ajouté. C’est à valeur associée à la clé d’accès $nameFile dans le tableau des resources JS. |
| | Après validation de l’existence physique de $pathFile, que le fichier $nameFile n’est pas déjà référencé, le couple $nameFile/$pathFile est alors ajouté aux resources JS de l’objet courant. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| removeJsFile(string $nameFile) | Méthode visant à supprimer une référence de fichier JS dans le tableau des resources JS de l’instance d’objet. Le resource JS à supprimer est donnée par la clé d’accès $nameFile. Si la resource $nameFile est trouvée, elle est  supprimée du tableau des resources JS de l’instance d’objet, comme du tableau des resources actives/inactives, si présente. |
| | Si $nameFile n’existe pas, la méthode retourne le booléen false. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getPathJsFile(string $nameFile) | Méthode restituant le chemin complet d’accès à la resource JS ayant pour clé d’accès $nameFile relativement au répertoire public de l’application Zend Framework. |
| | Si $nameFile existe, la méthode retourne la valeur qui lui est associé dans le tableau des resources JS de l’objet courant. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| enaJsFile(string $nameFile) | Active la resource JS ayant pour clé d’accès $nameFile, c’est-à-dire, permet l’utilisation de la resource dans les pages générées par G.O.T. |
| | Si $nameFile n’existe pas, la méthode retourne le booléen false. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disJsFile(string $nameFile) | Désactive la resource JS ayant pour clé d’accès $nameFile, c’est-à-dire, interdit l’utilisation de la resource dans les pages générées par G.O.T. |
| | Si $nameFile n’existe pas, la méthode retourne le booléen false. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getJsFileStatus(string $nameFile) | Restitue l’état de la resource JS dans le système, activé (enable) ou désactivé (disable), pour la clé d’accès $nameFile. |
| | Si $nameFile existe, la méthode retourne la valeur vrai (true), sinon la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| enable() | Méthode d’activation de l’objet courant. Ceci a pour effet de rendre fonctionnel l’objet courant, de réactiver les événements par exemple. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disable() | Méthode de désactivation de l’objet courant. Désactive toutes les interactions et événements sur l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getState() | Méthode restituant si elle existe la valeur de l'attribut 'state'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| enaAutoCenter() | Active l’auto-centrage de l’affichage de l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disAutoCenter() | Désactive l’auto-centrage de l’objet courant. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getStateAC() | Méthode restituant si elle existe la valeur de l'attribut 'autoCenter'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getACWidth() | Méthode restituant si elle existe la valeur de l'attribut 'acPx'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setACWidth(string $width) | Méthode fixant la largeur de l’instance d’objet à auto-centrer en directive CSS (‘px’, ‘em’, voir ‘rem’, attribut acPx). Aucun contrôle n’est fait sur la valeur $width. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getACHeight() | Méthode restituant si elle existe la valeur de l'attribut 'acPy'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setACHeight(string $height) | Méthode fixant la hauteur de l’instance d’objet à auto-centrer en directive CSS (‘px’, ‘em’, voir ‘rem’, attribut acPy). Aucun contrôle n’est fait sur la valeur $height . |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getACWidthHeight() | Méthode restituant la largeur et la hauteur définie de l’instance d’objet pour être auto-centré. (sous forme d’un tableau d’attributs acPx, acPy) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setACWidthHeight(string $width, string $height) | Méthode fixant la largeur et la hauteur de l’instance d’objet à auto-centrer en directive CSS (‘px’, ‘em’, voir ‘rem’, attributs acPx, acPy). Aucuns contrôles ne sont faits sur les valeurs $width et $height . |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getEvent(string $event = null) | Méthode restituant le tableau de paramètres pour un événement de l’objet courant. L’événement est précisé par le paramètre $evt, son nom. |
| | S’il n’existe pas, la méthode retourne le booléen false. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getEvents() | Méthode restituant si elle existe la valeur de l'attribut 'event'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setEvent(string $event, string $class, string $method, bool $stopEvent = false) | Méthode de paramétrage d’un événement sur l’objet courant. $event est le nom de l’événement, $class est le Namespace PHP complet de la classe à instancier (qui doit exister dans l’environement) pour pouvoir exécuter la méthode $method (présente dans cette dernière), le drapeau $stopEvent permet de décider si l’on doit ou non propager l’événement aux autres événements paramétrés sur l’instance d’objet ou sur ses parents. Ce drapeau est à false par défaut (non propagation) |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disEvent(string $event) | Méthode permettant de désactiver l’événement $event sur l’objet, s’il existe, la méthode retourne l’instance d’objet. |
| | La désactivation se fait par la suppression de l’entrée de clé $event dans le tableau de définition des événements de l’instance d’objet. Pour réactiver le dit événement, il faut le reparamétrer par la méthode setEvent(). |
| | S’il n’existe pas, la méthode retourne le booléen false. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| saveProperties() | Méthode sauvegardant le tableau du tableau d’attributs properties de l’instance d’objet en session gotObjList, variable objects, pour persistance des attributs de l’instance d’objet durant la session. |
| | La méthode retourne l’objet lui-même. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getWidth() | Méthode restituant si elle existe la valeur de l'attribut 'width'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setWidth(string $width) | Méthode fixant la largeur en directive CSS de l’instance d’objet. |
| | Aucun contrôle n’est fait sur la valeur $width. |
| | La méthode retourne l’objet lui-même. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getHeight() | Méthode restituant si elle existe la valeur de l'attribut 'height'. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setHeight(string $height) | Méthode fixant la hauteur en directive CSS de l’instance d’objet. |
| | Aucun contrôle n’est fait sur la valeur $height . |
| | La méthode retourne l’objet lui-même. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| isPersistantObjs() | Méthode déterminant si l’instance d’objet courante est une instance d’objet persisté ou non.  |
| | Ceci se fait par la recherche de la présence dans l’objet session sauvegardé du tableau persistObjs. Si ce dernier est présent, recherche le l’identifiant de l’instance courant dans le dit tableau. Si l’identifiant est trouvé, la méthode retourne la valeur true. Dans les cas ou le tableau persistObjs n’existe pas ou l’identifiant de l’instance n’est pas trouvé, la méthode retourne la valeur false. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| addPersistantObjs() | Ajoute l’instance d’objet courante à la liste des instances persistées : tableau persistObjs dans l’objet session sauvegardé. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

####Les méthodes de gestion des infobulles mis sur les objets

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIBType() | Méthode restituant le type d’info-bulle paramétrée sur l’instance d’objet. Il ne peut être que ‘tooltip’ ou ‘popover’. |
| | S’il n’existe pas, la méthode retourne le booléen false. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setIBType(string $IBtype = self::IBTYPE_TOOLTIP) | Méthode paramétrant le type d’info-bulle à mettre en place pour l’instance d’objet. |
                                                     | | Si $IBtype fourni n’est pas l’un des 2 types possibles, la valeur est alors initialisée à ‘tooltip’, valeur par défaut. |
                                                     | | Retourne l’objet courant au final. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| enaIBAnimation() | Méthode d’activation de l’animation (attribut animation) pour l’apparition et disparition de l’info-bulle. |
| | Retourne l’objet courant au final. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disIBAnimation() | Méthode de désactivation de l’animation (attribut animation) pour l’apparition et disparition de l’info-bulle. |
| | Retourne l’objet courant au final. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIBAnimation() | Méthode restituant si elle existe la valeur de l’attribut 'animation' dans le tableau d’attribut ‘infoBulle’. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIBDelay() | Méthode restituant si elle existe la valeur du tableau d’attribut 'delay' dans le tableau d’attribut ‘infoBulle’. Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setIBDelay(array $delay = null) | Méthode de paramétrage des temps d’attente (tableau d’attributs delay) pour l’apparition et la disparition de l’info-bulle. |
| | Si le tableau $delay n’est pas formé avec les entrées ‘show’ et ‘hide’, la méthode retourne le booléen false. Si le dit tableau est vide, les valeurs par défaut sont appliquées : 500 millisecondes pour l’affichage et 100 millisecondes pour la disparition. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| enaIBHtml() | Méthode d’activation de l’affichage (attribut html) de l’info-bulle en code HTML. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| disIBHtml() | Méthode de désactivation de l’affichage (attribut html) de l’info-bulle en code HTML. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIBHtml() | Méthode retournant l’état de l’attribut html de l’info-bulle. La valeur retournée est true (affichage HTML activée) ou false (affichage HTML  désactivée) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIBPlacement() | Méthode restituant le placement (attribut placement) paramétré pour l’affichage de l’info-bulle par rapport à l’instance de l’objet, s’il est présent. |
| | Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setIBPlacement(string $IBplacement = self::IBPLACEMENT_TOP) | Méthode de paramétrage du placement (attribut placement) de l’info-bulle par rapport à l’instance d’objet. |
| | Si la valeur fournie $IBplacement n’est l’une des valeurs possible, cette dernière est initialisée à ‘top’, valeur par défaut. |
| | Retourne l’objet courant au final. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIBTitle() | Méthode restituant la chaîne de caractères paramétrée en tant que titre (attribut title) de l’info-bulle, s’il est présent. |
| | Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setIBTitle(string $IBtitle = null) | Méthode de paramétrage de la chaîne de caractères servant de titre (attribut title) à l’info-bulle. |
| | Prends en compte de contexte, présence de l’attribut setIB pour paramétrer titre ou titre + contenu. |
| | Retourne l’objet courant au final. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIBContent() | Méthode restituant la chaîne de caractères formant le contenu (attribut contenu), le corps de l’info-bulle s’il est présent. |
| | Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setIBContent(string $IBContent = null) | Méthode de paramétrage de la chaîne de caractères servant de contenu (attribut contenu), de corps à l’info-bulle. Cette méthode impacte l’attribut ‘setIB’ qui détermine si l’info-bulle n’est qu’un titre ou un titre et un corps, comme setIBTitle(). |
| | Retourne l’objet courant au final. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIBTrigger() | Méthode restituant la chaîne de caractères déterminant le mode d’affichage (attribut trigger) de l’info-bulle, s’il est présent. |
| | Dans le cas contraire, retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| setIBTrigger(string $IBtrigger = self::IBTRIGGER_HOVER) | Méthode de paramétrage du mode d’affichage (attribut trigger) de l’info-bulle. |
| | Si la valeur fournie $IBtrigger n’est l’une des valeurs possible, cette dernière est initialisée à ‘hover’, valeur par défaut avant d’être affectée à l’attribut trigger. |
| | Retourne l’objet courant au final. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
 
###Les méthodes privées

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getConstants() | Méthode générale de récupération des constantes de la classes au travers de la classe ReflectionClass() |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getDisplayConstants() | Méthode de récupération des constantes d'affichage de l'objet (prefix 'DISPLAY'). | 
|  | Retourne les constantes sous forme d'un tableau et sauvegarde ce résultat dans un attribut de la classe. | 
|  | Cette sauvegarde vise à ne pas refaire l'extraction des constantes si la méthode est appelée au moins une seconde fois. | 
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getStateConstants() | Méthode de récupération des constantes d'état de l'objet (prefix 'STATE'). | 
|  | Retourne les constante sous forme d'un tableau et sauvegarde ce résultat dans un attribut de la classe. | 
|  | Cette sauvegarde vise à ne pas refaire l'extraction des constantes si la méthode est appellée au moins une seconde fois. | 
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIBTypesConstants() | Méthode de récupération des constantes de types d'info-bulle de l'objet (prefix 'IBTYPE_'). | 
|  | Retourne les constante sous forme d'un tableau et sauvegarde ce résultat dans un attribut de la classe. | 
|  | Cette sauvegarde vise à ne pas refaire l'extraction des constantes si la méthode est appellée au moins une seconde fois. | 
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIBPlacementConstants() | Méthode de récupération des constantes de placement d'info-bulle de l'objet (prefix 'IBPLACEMENT_'). | 
|  | Retourne les constante sous forme d'un tableau et sauvegarde ce résultat dans un attribut de la classe. | 
|  | Cette sauvegarde vise à ne pas refaire l'extraction des constantes si la méthode est appellée au moins une seconde fois. | 
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getIBTriggersContants() | Méthode de récupération des constantes de déclenchement d'affichage d'info-bulle de l'objet (prefix 'IBTRIGGER_'). | 
|  | Retourne les constante sous forme d'un tableau et sauvegarde ce résultat dans un attribut de la classe. | 
|  | Cette sauvegarde vise à ne pas refaire l'extraction des constantes si la méthode est appellée au moins une seconde fois. | 
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getColorConstants() | Méthode de récupération des constantes de couleurs (fond, écriture) applicable à l'objet (prefix 'COLOR_'). | 
|  | Retourne les constante sous forme d'un tableau et sauvegarde ce résultat dans un attribut de la classe. | 
|  | Cette sauvegarde vise à ne pas refaire l'extraction des constantes si la méthode est appellée au moins une seconde fois. | 
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| arrayMerge(array $array1, array $array2) | Méthode de fusion de tableaux, le tableau array2 en premier. | 
|  | De fait si une clé de valeur est présente dans tableau array1 et array2, c'est la valeur de tableau array2 qui est gardée au final. | 
| | Retourne le tableau ainsi construit. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
