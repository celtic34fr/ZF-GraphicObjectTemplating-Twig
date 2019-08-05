Les Objets - OObject, base de tous les objets
=============================================

C'est à partir de cet objet que tous les autres sont construits. Il fournit l'ensemble des méthodes et attributs commun à tous objet, quelqu'en soit le type.

Les autres objets de type contenus ([ODContained](odcontained.fr.md)) ou de type contenant ([OSContainer](oscontainer.fr.md)) prennet donc appuis sur cet objet pour y ajouter attributs, constantes et méthodes spécifiques.

Les attributs de bases
----------------------

    id            => l'identifiant (ID de balise HTML) de l'objet
    name          => nom de l'objet (utilisé pour principalement pour l’ODInput) qui peut être différent de son ID
    className     => nNamespace PHP et nom de la classe d’instanciation de l’objet
    display       => visibilité de l’objet (directive CSS display, par défaut 'block')
    object        => nom de l'objet dans G.O.T.
    typeObj       => Type d’objet (ODContainer : contenant, ODContained : contenu)
    template      => Nom du modèle (template) et chemin relatif d’accès pour le rendu HTML
    widthBT       => Largeur de l’objet dans une grille Bootstrap Twitter (par défaut 12)
    lastAccess    => Date et heure (datetime) du dernier accès à l’objet par G.O.T.
    state         => état de l'objet : accessible (true) ou inaccessible (false)
    classes       => classes CSS à appliquer à l'objet
    width         => largeur en directive CSS de l'objet
    height        => hauteur de l'objet en directive CSS de l'objet

    autoCenter    => drapeau d’activation (true) ou désactivation (false) de l’auto-centrage du conteneur courant
    acPx          => largeur de l'objet auto-centré en directive CSS
    acPy          => hauteur de l'objet auto-centré en directive CSS

Les attributs object et typeObj seront redéfinis dans le fichier de configuration de chaque objet. L’attribut template ne contiendra au départ, relativement à chaque objet, que le nom du modèle sans le chemin relatif d’accès. C’est lors de la construction de l’objet que cet attribut sera dûment complété.

###Attributs de base – cas particulier des info-bulles

Dans le cadre des info-bulles, un tableau d’attributs est mis en place dans l’objet OOjbect pour permettre de définir et caractériser l’info-bulle à afficher pour l’objet en question. Le tableau d’attributs aura pour clé d’accès ‘infoBulle’. Voici les attributs contenus dans le dit tableau :

    infoBulle     => paramétrage d'info-bulle sur l'objet
        setIB         => drapeau indiquant si l'info-bulle n'est qu'un titre (false) ou un titre + contenu (true)
        type          => par défaut 'tooltip', mais possible en 'popover'
        animation     => active (true) ou désactive (false) l'animation de l'affichage de l'info-bulle
        delay         => tableau d'attributs permettant la définition des temps d'affichage et disparition de l'info-bulle
            show          => temps d'affichage fixé par défaut à 500 millisecondes
            hide          => temps de disparition de l'objet fixé par défaut à 100 millisecondes
        html          => drapeau pour définir l’affichage en mode HTML (true) ou non (false) de l'info-bulle
        placement     => placement de l'info-bulle par rapport à l'objet, par défaut fixé au dessus
        title         => titre de l'info-bulle
        content       => texte ou contenu de l'info-bulle
        trigger       => mode d'affichage de l'info-bulle, fixé par défaut au survol
    ],

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
| validateSession() | Valide la session actuelle. Si la durée de vie de la session est dépassée, cette dernière est totalement réinitialisée. |
|  | Dans tous les cas, cette méthode retourne le container de session 'gotObjList', contenant objets ('objects'), ressources ('resources'), objets permanents ('persistObjs') et date/heure du dernier accès ('lastAccess'). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| existObject($id, $sessionObj) | Après avoir validé la session (::validateSession()), recherche l'existance de la clé $id dans le tableau des objets ('objects'). |
|  | Si la clé existe, la méthode retourne la valeur vrai (true), sinon la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| buildObject($id, $valeur = null) | Après avoir validé l'existance de la clé $id (::existObject($id)), instancie l'objet d'identitifiant $i et le retourne, s'il existe bien. |
|  | Dans le cas d'instanciation tecnique (identifiant 'dummy' avec tableau des propriétés vide), retourn la velru null, sinon retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| cloneObject(OObject $object, Container $sessionObj) | Permet de cloner l'objet $object si ce dernier existe en lui affectant un identifiant temporaire 'tmpObj'. |
|  | Le programme peut alors le changer directement via la méthode setId(). |
|  | Si l'objet $object n'existe pas dans les objets en session, la méthode retourne la valeur faux (false). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| destroyObject($id, $session = false) | Méthode permettant de détruire un ou tous les objets non persistés. |
|  | Par défaut $session est à faux (false), impliquant la destruction d'un seul objet ayant $id pour identifiant |
|  | Si $session est à vrai (true), la destruction concerne tous les objets sauf ceux présent dans le tableau 'persistObjs' |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| clearObjects() | Vide totalement le container de session 'gotObjList', en initialisant les tableaux 'objects', 'resources' et 'persistObjs' par une tableau vide. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| formatBootstrap(string $widthBT) | méthode visant à formaté la directive de taille de colonne Bootstrap Twitter, en incluant les offset de colonne. |
|  | La chaîne finale renvoyée est de la forme 'WL99:WM99:WS99:WX99' au minimum ou 99 correspondant à la largeur Bootstrap suivant le device. |
|  | Les directives d'offset seront sous la forme 'OL99:OM99:OS99:OX99', et pourront être mixée avec les directives de largeur. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| formatLabelBT($labelWidthBT) | Méthode complémentaure à formatBootstrap() visant à retourner un tableau de 2 chaînes de caractères pour fiormater l'affichage de label et valeur (zone de saisie ODInput par exemple) plus rapidement. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| formatRetour($idSource, $idCible, $mode, $code = null) | Métyhode générique visant à formater les informations de retours d'appel de callback sous forme d'un tableau. |
| | ['idSource'=>$idSource, 'idCible'=>$idCible, 'mode'=>$mode, 'code'=>$code]; |
| | 'idSource' : identifaint de l'objet ayant déclenché l'appel de callback
| | 'idCible' : identifaint de l'objet sur lequel on pourra affecter le retour d'aoppel de callback
| | 'mode' : type ou méthode à déclencher en retour d'appel de callback
| | 'code' : code paramètre du retour de callback
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getPersistantObjs() | Méthode retournant le contenu du tableau 'persistObjs', objet persistés de la session |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

###Les méthodes publiques

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

    * getProperty(string $name)
    * getProperties()
    * setProperties(array $properties)
    * getId()
    * setId(string $id)
    * getName()
    * setName(string $name)
    * setDisplay($display = OObject::DISPLAY_BLOCK)
    * getDisplay()
    * setWidthBT(string $widthBT)
    * getWidthBT()
    * setClassName(string $className = null)
    * getClassName()
    * setTemplate(string $template = null)
    * getTemplate()
    * setObject(string $object = null)
    * getObject()
    * setTypeObj(string $typeObj = null)
    * getTypeObj()
    * getLastAccess()
    * setClasses($classes = null)
    * addClass($class = null)
    * removeClass($class = null)
    * getClasses()
    * addCssFile($nameFile, $pathFile)
    * removeCssFile($nameFile)
    * getPathCssFile($nameFile)
    * enaCssFile($nameFile)
    * disCssFile($nameFile)
    * getCssFileStatus($nameFile)
    * addJsFile($nameFile, $pathFile)
    * removeJsFile($nameFile)
    * getPathJsFile($nameFile)
    * enaJsFile($nameFile)
    * disJsFile($nameFile)
    * getJsFileStatus($nameFile)
    * enable()
    * disable()
    * getState()
    * enaAutoCenter()
    * disAutoCenter()
    * getStateAC()
    * setACWidth($width)
    * getACWidth()
    * setACHeight($height)
    * getACHeight()
    * setACWidthHeight($width, $height)
    * getACWidthHeight()
    * setEvent($event, $class, $method, $stopEvent = false)
    * getEvent($event)
    * getEvents()
    * disEvent($event)
    * saveProperties()
    * setWidth($width)
    * getWidth()
    * setHeight($height)
    * getHeight()
    * isPersistantObjs()
    * addPersistantObjs()

####Les méthodes de gestion des infobulles mis sur les objets

    * setIBType($IBtype = self::IBTYPE_TOOLTIP)
    * getIBType()
    * enaIBAnimation()
    * disIBAnimation()
    * getIBAnimation()
    * setIBDelay(array $delay = null)
    * getIBDelay()
    * enaIBHtml()
    * disIBHtml()
    * getIBHtml()
    * setIBPlacement($IBplacement = self::IBPLACEMENT_TOP)
    * getIBPlacement()
    * setIBTitle($title = null)
    * getIBTitle()
    * setIBContent($IBContent = null)
    * getIBContent()
    * setIBTrigger($IBtrigger = self::IBTRIGGER_HOVER)
    * getIBTrigger()
 
###Les méthodes privées

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getConstants() | Méthode générale de récupération des constantes de la classes au travers de la classe ReflectionClass() |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| getDisplayConstants() | Méthode de récupération des constantes d'affichage de l'objet (prefix 'DISPLAY'). | 
|  | Retourne les constante sous forme d'un tableau et sauvegarde ce résultat dans un attribut de la classe. | 
|  | Cette sauvegarde vise à ne pas refaire l'extraction des constantes si la méthode est appellée au moins une seconde fois. | 
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
|  | De fait si une clé de valeur est présente dans tableau array1 et array2, c'est la valeur de tableau array2 qui est gardée au fianl. | 
| --------------------------- | ------------------------------------------------------------------------------------------------ |
