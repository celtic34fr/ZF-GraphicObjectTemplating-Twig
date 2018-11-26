# GraphicObjectTemplating

## Introduction

Ce module vous aidra à contruire des interface utilisateur (UI) à parti d'objets, en utilisant le moteur de rendu de page TWIG. Cette version ne fonctionne qu'avec les version 2.5+ et 3.0+ de Zend Framework (testé pour un projet 3.0+).

## Avant toute installation ##

* Vous devez avoir créé un projet Zend Framework 3.0+
* durant son installation, vous devez avoir également installé :
    * la barre de mise au point (ZendDeveloperToolbar),
    * le support du cache (utile en production par l'utilisatetion Twig),
    * le support de la dé/sérailisation JSON,
    * le support des sessions PHP.
    
faculitatif, vous pouvez également installer :
* l'internationnalisation (i18n, si vous en avez besoin),
* les plugins officiels MVC, incluant le support de PRG, de *identity* (si vous utilisé le module Authentication), et des messages flash,

## Installation avec Composer

Pour installer **GraphicObjectTemplating** utilisez la commande suivante :

    composer.phar require celtic34fr/zf-graphic-object-templating-twig dev-master

Afin de pouvoir utiliser le module installé, vous devez configurer votre application comme suit :

En premier, dans le fichier **config/modules.config.php**, ajoutez les lignes suivantes :

    ..., 
    'ZfcTwig',
    'GraphicObjectTemplating',
    ...,

Dans le dossier *public* de votre projet, créez un répertoire lié au répertoire **vendor/celtic34fr/zf-graphic-object-templating-twig/public** que vous nommerez **graphicobjecttemplating** avec la commande suivante :

    ln -s ../vendor/celtic34fr/zf-graphic-object-templating-twig/public graphicobjecttemplating

Copier les fichiers  **zfGraphicObjectTemplting.local.php.dist** and **zfGrpahicObjectTemplating.development.local.php.dist** que vous trouverez dans le répertoire *config* de **GraphicObjectTemplating** sans l'extension **.dist** dans le répertoire *config/autoload* de votre projet.
Ceci activera tous les paramètres de bases nécessaires au bon fonctionnement de **GraphicObjectTemplating**.

Avec l'utilisation du *moteur de rendu de page TWIG*, vous devrez remplacer quelques modèles et paramètres. Vous pouvez trouver des modèles de remplacement dans le répertoier *view/twigtemplates* du module **GraphicObjectTemplating** utilisabole pour votre projet :

* dans le répertoire *application/index*, vous avez le modèle *index.twig* à l'identique à celui d'un projet de base *index.phtml*,
* dans le répertoire *error*, vous avez les modèles *index.twig* and *404.twig* pour remplacer ceux du répertoire *error* de votre projet, *index.phtml* et *404.phtml*,
* dans le répertoire *layout*, vous trouverez une adaptation du modèle original *layout.phtml*, *layout.twig* utilisant le facilités fournier par le moteur Twig.

Avec ces modèles, vous optiendrez le même comportement qu'avec un projet standarty Zend Framework 3.0. Quelques extensions au moteur TWIG ont été développées afin de reproduire et implémenter les mêmes mécanismes que ceux d'un projet Zend Framework 3 n'utilisant pas le moteur TWIG.

Ceci n'est qu'une base pour vo développement que vous pouvez modifier et adapter à votre convenance. Le modèle *layout.twig* fourni, fonctionne avec la mise en plaxce de bloc TWIG. Dans ce dernier, différentes variables et blocs sont définis pour insérer vos données :
* la variable *local* permet de définir la langue supporté par la page, comme 'fr' ou 'en',
* le bloc *Hmeta* fourni  la définition de base des metas de la page, que vous pouvez modifier ou compléter,
* le bloc *Hstyle* formalise les fichiers de feuilles de styles nécessaires au bon fonctionnement de **GraphicObjectTemplating**,
* le bloc *Hscript* formalmise les fichiers JavaScript nécessaires au bon fonctionnement de **GraphicObjectTemplating**,
* le bloc *Bcontent* contient ou contiendra si vous le modifié, la structure de votre page, le bloc *content* contiendra la partie princiaple de votre page (exclus la barre de navigation et le pied de page),
* le bloc *Bscript* est là afin de vous permettre d'ajouter du code ou des fichiers JavaScript, changé dans le corps de la page.

En dernier, avant de débuter le développement de votre application, vous devrez faire quelques changement dans le fichier *module/Application/config/module.config.php*. Dans le bloc *template_map*n vous devez changer toutes les extension des noms de fichiers de *.phtml* en *.twig*. Après cela, n'oubliez par de refaire un dump des autoload Zend Framework (composer.phar dump-autoload) avant de contrôler quer tout fonctionne correctement.

## Mode Dévelopment

En premier, installez, seulement en mode développement, les extasions nécessaires :

    composer.phar require --dev zendframework/zend-developer-tools ^1.1.0
    composer.phar require --dev san/san-session-toolbar ^2.0.2

Comme **GraphicObjectTemplating** utilise les sessions Php, nous devons avoir un moyen pour les consulter, voire supprimer leur contenu au besion. Pour cela, et seulement en mode de développement, il a été installé l'extension *san/san-session-toolbazr*, en même temps que **GraphicObjectTemplating**.
Pour pouvoir utiliser cette extension, ajoutez les lignes suivantes dans le fichier *config/developement.config.php* de votre projet :

    ...
    'modules' => [
        ...
        'ZendDeveloperTools',
        'SanSessionToolBar',
        ...
    ],
    ...

## Running Unit Tests

