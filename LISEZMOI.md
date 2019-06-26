# GraphicObjectTemplating

## Introduction

Ce module vous aidera à construire des interfaces utilisateurs (UI) à partir d’objets, en utilisant le moteur de rendu de page TWIG. Cette version ne fonctionne qu’avec les versions 2.5+ et 3.0+ de Zend Framework (testé pour un projet 3.0+).

## Avant toute installation ##

* Vous devez avoir créé un projet **Zend Framework 3.0+**
* durant son installation, vous devez avoir également installé :
    * la barre de mise au point (*ZendDeveloperToolbar*),
    * le support du cache (utile en production par l’utilisation *Twig*),
    * le support de la dé/sérialisation *JSON*,
    * le support des sessions *PHP*.
    
faculitatif, vous pouvez également installer :
* l’internationalisation (*i18n*, si vous en avez besoin),
* les plugins officiels MVC, incluant le support de PRG, de *identity* (si vous utilisez le module Authentication), et des messages flash,

## Installation avec Composer

Pour installer **GraphicObjectTemplating** utilisez la commande suivante :

    composer.phar require celtic34fr/zf-graphic-object-templating-twig dev-master

Afin de pouvoir utiliser le module installé, vous devez configurer votre application comme suit :

En premier, dans le fichier **config/modules.config.php**, ajoutez les lignes suivantes :

    ..., 
    'ZfcTwig',
    'GraphicObjectTemplating',
    ...,

Dans le dossier *public* de votre projet, créez un répertoire lié au répertoire **vendor/celtic34fr/zf-graphic-object-templating-twig/public** que vous nommerez **graphicobjecttemplating** avec la commande suivante sous Linux :

    cd public
    ln -s ../vendor/celtic34fr/zf-graphic-object-templating-twig/public graphicobjecttemplating

Dans un environnement **Windows** utiliser seulement **cmd.exe** pour lancer la commande à exécuter en tant qu'administrateur, dans le répertoire *public* du projet :

    cd public
    mklink /D graphicobjecttemplating ..\vendor\celtic34fr\zf-graphic-object-templating\public

Copier le fichier **zfGraphicObjectTemplting.local.php.dist** que vous trouverez dans le répertoire *config* de **GraphicObjectTemplating** sans l'extension **.dist** dans le répertoire *config/autoload* de votre projet.
Ceci activera tous les paramètres de bases nécessaires au bon fonctionnement de **GraphicObjectTemplating**.

Afin de pouvoir utiliser l'objet ODDragNDrop, téléchargement de fichier par glisser - déposer, il vous faudra réaliser 2 opérationss.

Dans le répertoire config/autoload de votre projet, php le ligne suivante : 

    return [
        ...
        'publicFolder' => __DIR__.'/../../public',
        ...
    ];
    
Dans le répertoire public de votre projet, il faut créer le répertoire uploadFiles en affectant les droit sur les répertoires public et uploadedFiles à tous les utlisateurs (sous Linux 'chmod 777 ...').

Avec l'utilisation du *moteur de rendu de page TWIG*, vous devrez remplacer quelques modèles et paramètres. Vous pouvez trouver des modèles de remplacement dans le répertoire *view/twigtemplates* du module **GraphicObjectTemplating** utilisables pour votre projet :

* dans le répertoire *application/index*, vous avez le modèle *index.twig* à l'identique à celui d'un projet de base *index.phtml*,
* dans le répertoire *error*, vous avez les modèles *index.twig* and *404.twig* pour remplacer ceux du répertoire *error* de votre projet, *index.phtml* et *404.phtml*,
* dans le répertoire *layout*, vous trouverez une adaptation du modèle original *layout.phtml*, *layout.twig* utilisant les facilités fournies par le moteur *Twig*.

Avec ces modèles, vous obtiendrez le même comportement qu’avec un projet standard **Zend Framework 3.0**. Quelques extensions au moteur *TWIG* ont été développées afin de reproduire et implémenter les mêmes mécanismes que ceux d’un projet **Zend Framework 3** n’utilisant pas le moteur *TWIG*.

Ceci n'est qu'une base pour vos développements que vous pouvez modifier et adapter à votre convenance. Le modèle *layout.twig* fourni, fonctionne avec la mise en place de bloc *TWIG*. Dans ce dernier, différentes variables et blocs sont définis pour insérer vos données :
* la variable *local* permet de définir la langue supportée par la page, comme 'fr' ou 'en',
* le bloc *Hmeta* fourni  la définition de base des metas de la page, que vous pouvez modifier ou compléter,
* le bloc *Hstyle* formalise l'insertion des fichiers de feuilles de styles nécessaires au bon fonctionnement de **GraphicObjectTemplating**,
* le bloc *Hscript* formalise l'insertion des fichiers JavaScript nécessaires au bon fonctionnement de **GraphicObjectTemplating**,
* le bloc *Bcontent* contient ou contiendra si vous le modifiez, la structure de votre page, le bloc *content* contiendra la partie principale de votre page (exclus la barre de navigation et le pied de page),
* le bloc *Bscript* est là afin de vous permettre d'ajouter du code et/ou des fichiers JavaScript, changés dans le corps de la page.

En dernier, avant de débuter le développement de votre application, vous devrez faire quelques changement dans le fichier *module/Application/config/module.config.php*. Dans le bloc *template_map* vous devez changer toutes les extensions des noms de fichiers de *.phtml* en *.twig*. Après cela, n'oubliez par de refaire un dump des autoload **Zend Framework** (*composer.phar dump-autoload*) avant de contrôler quer tout fonctionne correctement.

## Paramètrage d'Objet - besoin technique ##

Pour que le moteur **GraphicObjectTemplating** fonctionne, il faut faire quelques action supplémenrtaires au regard des objets que vous serez amménés à utiliser.

### L'objet ODDragNDrop ###

Cet objet va occasionner plusieurs modifications.

Dans le cadre d'un projet Zend Framework, il vous faut en premier lieu créer le répertoier '*uploadedFiles*' dans le répertoire '*data*' de votre application, projet. Lui affecter les droits d'écriture par n'impote quel utilisateur (chmod 777). Dans le cas ou vous ne pouver donner le droit d'écriture qu'au propriétaire du répertoire et aux utilisateurs de son groupe, ajouter au dit groupe l'utilisateur '*www-data*' utiliser par le serveur HTTP.

On doit également modifier la définition de votre hôte virtuel définissant l'accès à votre site, votre application. Ceci va passer par la déclaration, sous *nginx*, d'un alias pointant sur le répertoire que vous venez de créer:

    ...
	location ^~ /odnd_files/ {
		alias /path_to_your_project/data/uploadedFiles/;
		internal;
	}
    ...

Cette déclaration sera positionnée en fin de définition de votre hôte virtuel.

## Mode Développement

En premier, installez, seulement en mode développement, les extensions nécessaires :

    composer.phar require --dev zendframework/zend-developer-tools ^1.1.0
    composer.phar require --dev san/san-session-toolbar ^2.0.2

Comme **GraphicObjectTemplating** utilise les sessions *PHP*, nous devons avoir un moyen pour les consulter, voire supprimer leur contenu au besion. Pour cela, et seulement en mode de développement, il a été installé en plus de la barre de développement, l'extension *san/san-session-toolbar*, en même temps que **GraphicObjectTemplating**.
Pour pouvoir utiliser ces extensions, ajoutez les lignes suivantes dans le fichier *config/developement.config.php* de votre projet :

    ...
    'modules' => [
        ...
        'ZendDeveloperTools',
        'SanSessionToolBar',
        ...
    ],
    ...

## Running Unit Tests

