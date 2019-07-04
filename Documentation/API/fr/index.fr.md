Graphic Object Templating
=========================

!!!! ATTENTION !!!
==================

Cette version est en cours de réoganisation - refonte, la documentation n'est peut être pas tout à fait à jour.

Si vous rencontrez quelques problèmes n'hésitez pas à me contacter :
**Gilbert ARMENGAUD** *<gilbert.armengaud@gmail.com>*

Comment utilisation G.O.T.
--------------------------
Pour utiliser ***G.O.T.***, il faut en premier lieu, utiliser ces objets pour créer page ou section, article de page.
Puis, il s'offre à vous 2 manières de générer les pages HTML5 de vos sites, applications :

* avec le [service](service.fr.md) *'graphic-object-templating'services'*
* avec les [*viewHelpers*](viewHelpers.fr.md) dans vos modèles de pages

Les objets mis à disposition
----------------------------

Les objets mis à disposition pour construire vos page sont de 2 types:
* les objets contenant une valeur, une information : **ODContained (Object Data Contained)**
* les objets servant de contenant pour d'autres objets : **OSContainer (Object Structure Container)**

Toutefois, une structure commune, [**OObject**](objects/oobject.fr.md), assure la cohésion des déclaration des objet en intégrant l'ensemble des mécanismes communs de base.