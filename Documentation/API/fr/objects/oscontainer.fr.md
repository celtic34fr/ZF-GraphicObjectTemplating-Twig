#OSContainer – Objet Structure Container

##Objet contenant d’autres objets par encapsulation

La classe **OSContainer** est une extension de la classe **OObject**. Elle enrichit celle-ci de l’ensemble des méthodes et mécanismes de gestion de conteneur d’objets.

##Les attributs de base

| Attribut | Explications |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **children**             | Tableau contenant les identifiants / valeurs, des objets inclus dans l’objet contenant.  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **form**             | Identifiant de la structure de formulaire à laquelle l’objet peut appartenir (attribut *form* non vide) |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **codeCss**             | Tableau de Couple sélecteur **CSS** – code **CSS** associé au conteneur ou à son contenu. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

L’attribut *children* est un tableau qui contiendra en valeur l’ensemble des identifiants des objets le formant quel qu’en soit le type. C’est la méthode magique **__get($idObjet)** qui assurera l’accès aux objets enfants tout en exécutant la reconstruction de ce dernier par la méthode statique **OObject::buildObject($id)**.

##Les constantes de base

La gestion des insertions d’enfant dans un objet de type contenant implique de savoir comment et ou faire l’insertion. Cet en cela que les constantes de définition de mode d’insertion fonctionnent :

* **MODE_LAST     = 'last';**		→ ajout en fin de liste des enfants,
* **MODE_FIRST    = 'first';**		→ ajout en début de liste des enfants,
* **MODE_BEFORE   = 'before';**	→ avant l’objet précisé par son identifiant en paramètre,
* **MODE_AFTER    = 'after';**		→ après l’objet précisé par son identifiant en paramètre,
* **MODE_NTH      = 'nth';**		→ à la position précisée par le paramètre numérique ‘nth’.

##Les méthodes de base

###Les méthodes publiques

####Le constructeur – __construct(string $id, array $pathObjArray = [])

Méthode de génération de l’objet.

*	**$id**			: identifiant de l’objet,
*	**$pathObjArray**		: tableau de noms et chemins du fichier de paramétrage de l’objet (spécifique).

Le tableau **$pathObjArray** obtenu de l’appel de la classe enfant est enrichi du fichier de configuration spécifique à la classe OSContainer avant appel à la méthode parente dans OObject.

####Les méthodes magiques

#####Accès aux objets enfants – __get($nameChild)

*	**$nameChild**		: nom de l’objet contenu auquel on veut accéder,

Cette méthode permet d’accéder à un enfant dans l’ensemble de ceux paramétré. Après validation de l’existence du nom de l’enfant (attribut *name*, et/ou attribut *id* si vide), l’objet est directement instancié par la méthode statique **OObject::buildObject($idChild, $sessionObj)**.

S’il n’existe pas, la méthode retournera false.

#####Existence d’objets enfants – __isset(string $nameChild)

* **$nameChild**		: nom de l’objet contenu auquel on veut accéder,

Cette méthode vise à valider l’existence d’un objet enfant ayant pour nom (attribut *name*) ou identifiant (attribut *id*) **$nameChild**, et retour alors la valeur vrai (**true**).

S’il n’existe pas, la méthode retournera faux (**false**).

####Les méthodes générales

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getValue()** | Dans le contexte spécifique d’objet de type contenant (**OSContainer**), retourne le contenu de l’attribut *children* (tableau des objets enfants de premier niveau). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getForm()** | Retourne la valeur de l’attribut *form* s’il existe, sinon faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setForm(string $form)** | Méthode affectant à l’attribut **form** la valeur $form si cette dernière est non vide.|
| | Sinon, la méthode retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **addChild(OObject $child, string $mode =self::MODE_LAST, $params=null)** | Ajout d’un autre objet à l’objet de type contenant. **$child** est obligatoirement un objet (au minimum instance de **OObject**), mais seulement son identifiant et sa valeur sera stocké dans le tableau *children*. L’ordre de déclaration sera celui d’affichage des objets contenus dans l’objet contenant. |
| | **$mode** précise le mode d’insertion, en fin de liste par défaut. Dans le cas de l’utilisation des modes before ou after, **$params** contiendra l’identifiant de l’objet avant ou après lequel on devra insérer l’objet **$child**. Dans le cas de l’utilisation du mode *nth*, **$params** contiendra le rang d’insertion de l’objet **$child**. Dans le cas où l’identifiant fourni ou le rang indiqué dans **$params** est incorrect, rien n’est fait sur l’objet courant, ce dernier est retourné en l’état.|
| | Si l’objet **$child** est vide, la valeur faux (**false**) est alors retournée. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setChild(OObject $child, $value = null)** | Dans le cas où l’identifiant de l’objet **$child** existe dans l’attribut *children*, tableau des enfants de l’objet, affecte **$value** à cet identifiant dans le tableau *children*. |
| | Cette méthode n’impacte pas la valeur directement associée à l’objet **$child**. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **removeChild(OObject $child)** | Supprime un objet de la liste des objets enfants. |
| | **$child** est obligatoirement un objet (au minimum instance de **OObject**), dont on vérifie l’existence dans la liste des objets enfants avant de le supprimer. |
| | La méthode retourne l’objet lui-même sauf si **$child** n’existe pas, alors la méthode retourne la valeur faux (**false**), |
| | Cette méthode de détruit pas l’objet **$child**. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **isChild(string $child)** | Méthode validant si l’identifiant **$child** fait bien parti de la liste des objets enfants de l’objet. Si oui, la valeur vrai (**true**) et retournée, sinon la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **hasChild()** | Méthode de contrôle d’existence d’objet enfant (avoir au moins un objet dans la liste des objets enfants, attribut *children*). |
| | Retourne la valeur vrai (**true**) si on a au moins un objet enfant, sinon la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **countChildren()** | Méthode retournant le nombre d’objets enfants présent dans la liste des objets enfants de l’objet. Retourne une valeur à partir de 0 si l’attribut *children* existe, sinon la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getChildren()** | Retourne un tableau d’objets instanciés à partir de la liste des objets enfants de l’objet. S’il n’y a pas d’enfant, un tableau vide est retournée. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **removeChildren()** | Méthode réinitialisant l’attribut *children* à un tableau vide. |
| | Cette méthode ne détruit pas les objets précédemment présents dans le tableau *children*. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **addCodeCss(string $selector, string $code)** | Insère dans l’attribut *codeCss* (tableau) le couple sélecteur **CSS** **$selector** – code **CSS** **$code** sous la forme clé – valeur à la seule condition que le sélecteur **$selector** ne soit pas déjà présent et que **$code** ne soit pas vide. |
| | Cette méthode retourne l’objet courant, sauf si erreur : retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setCodeCss(string $selector, string $code)** | Surcharge l’attribut *codeCss* (tableau) pour la clé d’accès **$selector** par le code **CSS** **$code** à la seule condition que le sélecteur **$selector** soit déjà présent et que **$code** ne soit pas vide. |
| | Cette méthode retourne l’objet courant, sauf si erreur : retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **rmCodeCss(string $selector)** | Supprime dans l’attribut *codeCss* (tableau), la clé d’accès **$selector** et sa valeur associée à la seule condition que le sélecteur **$selector** soit déjà présent.|
| | Cette méthode retourne l’objet courant, sauf si erreur : retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getCodeCss(string $selector)** | Retourne la valeur associée à la clé d’accès **$selector** dans l’attribut *codeCss* (tableau), à la seule condition que le sélecteur **$selector** soit déjà présent. |
| | En cas d’erreur, la méthode retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setAllCss(array $allCss)** | Affecte à l’attribut *codeCss* le contenu du tableau **$allCss**. Aucune vérification du contenu du tableau **$allCss** n’est faite. |
| | Cette méthode retourne l’objet courant, sauf si **$allCss** est vide : retourne alors faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getAllCss()** | Retourne le contenu de l’attribut *codeCss*. |
| | S’il n’existe pas, la méthode retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
