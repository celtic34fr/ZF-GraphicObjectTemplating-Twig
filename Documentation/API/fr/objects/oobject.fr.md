Les Objets - OObject, base de tous les objets
=============================================

C'est à partir de cet objet que tous les autres sont construits. Il fournit l'ensemble des méthodes et attributs commun à tous objet, quelqu'en soit le type.

Les autres objets de type contenus ([ODContained](odcontained.fr.md)) ou de type contenant ([OSContainer](oscontainer.fr.md)) prennet donc appuis sur cet objet pour y ajouter attributs, constantes et méthodes spécifiques.

Les attributs de bases
----------------------

    id            => l'identifiant (ID de balise HTML) de l'objet
    name          => nom de l'objet qui peut être différent de son ID
    className     => namespace complét de la classe Php d'instanciation de l'objet
    display       => visibilité de l'objet (directive CSS display, par défaut 'block')
    object        => nom de l'objet dans G.O.T.
    typeObj       => type de l'objet (actuellement odcontained ou oscontainer)
    template      => nom du fichier modèle à utiliser pour la génération HTML
    widthBT       => largeur de l'objet dans une grille Bootstrap Twitter (par défaut 12)
    lastAccess    => datetime du dernier accès à l'objet par G.O.T.
    state         => état de l'objet : accessible (true) ou inaccessible (false)
    classes       => classes CSS à appliquer à l'objet
    width         => largeur en directive CSS de l'objet
    height        => hauteur de l'objet en directive CSS de l'objet

    autoCenter    => drapeu d'activation (true) ou désactivation (false) de l'auto-centrage de l'objet à l'écran
    acPx          => largeur de l'objet auto-centré en directive CSS
    acPy          => hauteur de l'objet auto-centré en directive CSS

    infoBulle     => paramétrage d'info-bulle sur l'objet
        setIB         => drapeau indiquant si l'info-bulle n'est qu'un titre (false) ou un titre -contenu (true)
        type          => par défaut 'tooltip', mais possible en 'popover'
        animation     => active (true) oiu désactive (false) l'animation de l'info-bulle
        delay         => défionition des temps d'affichage / disparution
            show          => temps d'affichage fixé par défaut à 500 millisecondes
            hide          => temps de disparution de l'objet fixé par défaut à 100 millisecondes
        html          => drapeau pour affichage HTML (true) ou non (false) de l'info-bulle
        placement     => placement de l'info-bulle par rapport à l'objet, par défaut fixé au dessus
        title         => titre de l'info-bulle
        content       => texte ou contenu de l'info-bulle
        trigger       => mode d'affichage de l'info-bulle, fixé par défaut au surval
    ],

Les constantes de base
----------------------

    Les constantes de visibilité de l'objet
    ---------------------------------------
    const DISPLAY_NONE    = 'none';
    const DISPLAY_BLOCK   = 'block';
    const DISPLAY_INLINE  = 'inline';
    const DISPLAY_INBLOCK = 'inline-block';
    const NO_DISPLAY      = 'noDisplay';

    Les constantes d'état de l'objet
    --------------------------------
    const STATE_ENABLE    = true;
    const STATE_DISABLE   = false;

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

    Les constantes booléennes (pour restitution en chaîne de caractère)
    -------------------------------------------------------------------
    const BOOLEAN_TRUE    = 'true';
    const BOOLEAN_FALSE   = 'false';

    Les constantes pour affectation de couleur pour écriture ou fond
    ----------------------------------------------------------------
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

Les méthodes statiques

    * static function validateSession()
    * static function existObject($id, $sessionObj)
    * static function buildObject($id, $valeur = null)
    * static function destroyObject($id)
    * static function clearObjects()
    * static function cloneObject($object)
    * static function formatBootstrap($widthBT)
    * static function formatRetour($idSource, $idCible, $mode, $code = null)
    * static function getPersistantObjs()

les méthodes publiques

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

Les méthodes de gestion des infobulles mis sur les objets

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
 
 Les méthodes privées
 
    * getConstants()
    * getDisplayConstants()
    * getStateConstants()
