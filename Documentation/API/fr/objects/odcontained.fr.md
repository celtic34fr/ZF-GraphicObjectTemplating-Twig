Les objets de type contenu - ODContained
========================================

##Les attributs de base

La classe **ODContained** est une extension de la classe **OObject**. Elle enrichit cette dernière de la gestion de valeur associée à l’objet.

Ce sont les attributs communs à l’ensemble des objets : ils sont divisés en 2 parties, une partie déclaration administrative et une partie déclaration plus fonctionnelle.

| Attribut | Explications |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **value**             | Valeur associée à l’objet  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **form**             | Identifiant de regroupement en formulaire  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **default**             | Valeur par défaut attribuée à l’objet, servant lors de sa réinitialisation sans valeur. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **event**             | Tableau d’attributs contenant les définitions des événements programmés sur l’objet  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

On doit revenir sur la notion de formulaire dans ***G.O.T.***

On doit partir du postulat que tout objet de type contenant (**OSContainer**) a capacité à être un formulaire. Pour des raisons purement pratiques, l’objet **OSForm** a été créé pour regrouper tous les mécanismes de création, contrôles et gestions de structure de formulaire.

Ce dernier gère tous les champs non visibles (attribut *display* à ‘*none*’) comme ne devant pas être transmis dans le code généré **HTML** du formulaire pour en alléger la taille. Ceci est fait au travers de l’attribut *hidden*, stockant sous la forme clé (identifiant de l’objet) – valeur, les champs non visibles. Cela induit de fait, que si l’on passe de l’état caché à visible un objet, il faut en impacter le contenu de l’attribut *hidden*. c’est pour cela que la méthode **setDisplay()** est surchargée ici pour assurer de la gestion de l’attribut *hidden* en cas d’appartenance de l’objet à une structure de formulaire.

De cette remarque découle également la nécessité par le programmeur de générer les mises à jour nécessaires d’objets suite au chargement de visibilité d’objets ainsi opéré.

Cet objet n’aura pas de constantes.

###Le bloc de paramétrage d'événement - bloc 'event'

| Attribut | Explications |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **class**             | Suivant le type de bouton  |
|                   |  - type lien (*LINK*) = la route **Zend Framework** du lien,                                      |
|                   |  - autre type = le nom de la classe pour instancier l’objet dans lequel on exécutera une méthode. (avec son namespace **Php**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **method**            | Suivant le type de bouton  |
|                   |  - type lien (*LINK*) = le tableau des paramètres permettant le calcul et génération de l’URL en fonction de la route **Zend Framework**, |
|                   |  - autre type : nom de la méthode à exécuter dans l’objet instancié à partir du nom ce classe stocké dans *class*. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **stopEvent**         | Booléen indiquant la propagation (**true**) ou la non propagation (**false**) de l’événement codé aux parents.  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

##Les méthodes de base

###Les méthodes publiques

Ces méthodes servent au paramétrage bas niveau de l’objet, au regard ds attributs de base. Généralement ces méthodes ne seront pas surchargées, sauf cas contraire suivant le contexte.

####Le constructeur - __construct(string $id, array $pathObjArray)

Méthode de génération de l’objet.
*	**$id**		: identifiant de l’objet,
*	**$pathObjArray**	: tableau de noms et chemins du fichier de paramétrage de l’objet (spécifique).

Le tableau **$pathObjArray** obtenu de l’appel de la classe enfant est enrichi du fichier de configuration spécifique à la classe **ODContained** avant appel à la méthode parente dans **OObject**.

####Les méthodes générales

| Méthode | Fonctionnalité |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getValue()** | Méthode restituant la valeur de l’attribut *value*. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setValue($value = null)** | Initialisation de la valeur associé à l’objet courant, attribut *value*, au travers du paramètre **$value**.|
| | Dans le cas ou l’objet traité est un des champs d’un formulaire (attribut *form* précisé) qui ne doit pas être visible, on met directement à jour la valeur associé au dit objet dans le tableau des champs du formulaire dans les variables de sessions.|
| | Retourne l’objet courant au final.|
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getForm()** | Méthode restituant la valeur de l’attribut *form*, qui associé l’objet courant à une structure de formulaire. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setForm(string $form = null)** | Association de l’objet courant à une structure de formulaire nommée **$form**, par affectation de la valeur de l’attribut *form* seulement si **$form** est non vide. |
| | La méthode retourne l’objet lui-même si tout est vérifié, sinon retourne la valeur faux (**false**). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **getDefault()** | Méthode restituant, si elle est paramétrée, la valeur par défaut associée à l’objet courant |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setDefault($default = null)** | Paramétrage de la valeur par défaut, **$default**, associée à l’objet courant. |
| | Retourne l’objet courant au final. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **setDisplay(string $display = self::DISPLAY_BLOCK)** | Surcharge de la méthode présente dans la classe mère **OObject** pour inclure la gestion de la visibilité des objets appartenant à une structure de formulaire. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| **resetValue()** | Méthode de réinitialisation de la valeur associée à l’objet courant. |
| | Cette méthode récupère la valeur affectée à l’attribut *default* de l’objet courant. Si l’attribut n’existe pas, un chaîne vide sera affectée à la valeur de l’objet courant. |
| | Retourne l’objet courant au final. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

##Description des objets issus de la classe ODContained

Les objets de type contenu permettent le manipuler l'information tant en acquisition, qu'en restitution.

Ils donnent aussi des éléments de contrôle, de dérivation, d’accès à d'autres informations, d'autres pages.

* [ODButton](odcontained/odbutton.fr.md) :
    permet de mettre des boutons dans les pages afin de donner accès à de l'information ou déclencher des traitement.
    
* [ODInput](odcontained/odinput.fr.md) :
    zone de saisie de base utilisable dans toute page, formulaire.

