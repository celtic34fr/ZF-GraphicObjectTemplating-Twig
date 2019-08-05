Les objets de type contenu - ODContained
========================================

###Le bloc de paramétrage d'événement - bloc 'event'

| Attribut | Explications |
| :---  | --- |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| class             | Suivant le type de bouton  |
|                   |  - type lien (LINK) = la route Zend Framework du lien,                                      |
|                   |  - autre type = le nom de la classe pour instancier l’objet dans lequel on exécutera une méthode. (avec son namespace Php). |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| method            | Suivant le type de bouton  |
|                   |  - type lien (LINK) = le tableau des paramètres permettant le calcul et génération de l’URL en fonction de la route Zend Framework, |
|                   |  - autre type : nom de la méthode à exécuter dans l’objet instancié à partir du nom ce classe stocké dans class. |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| stopEvent         | Booléen indiquant la propagation (true) ou la non propagation (false) de l’événement codé.  |
| --------------------------- | ------------------------------------------------------------------------------------------------ |

Les objets de type contenu permettent le manipuler l'information tant en acquisition, qu'en restitution.

Ils donnent aussi des éléments de contrôle, de dérivation, d'acccès à d'autres informations, d'autres pages.

* [ODButton](odcontained/odbutton.fr.md) :
    permet de mettre des boutons dans les pages afin de donner accès à de l'information ou déclencher des traitement.
    
* [ODContent](odcontained/odcontent.fr.md) :
    cet objet contenu est pour mettre des information textuelles, graphique pour lecture, présentation. C'est une version non typé des balises HTML5 Article, Aside.
    
* [ODInput](odcontained/odinput.fr.md) :
    zone de saisie de base utilisable dans toute page, formulaire.

