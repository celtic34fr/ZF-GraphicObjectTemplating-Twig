# GraphicObjectTemplating

## Introduction

This module help you for building UI object oriented and interacting with it, using TWIG Templating Engine. This version work only on Zend Framework 2.5+ and 3.0+ (tested only with 3.0+ project)

## Before any Installation ##

* You must have a Zend Framework 3 project,
* during its installation, you will need to have installed :
    * the developer toolbar (in order to debug your project),
    * caching support (useful in production by the use of Twig),
    * JSON de/serialization support,
    * sessions support.

optionally, you can also install
* i18n support (if you need),
* the official MVC plugins, including PRG support, identity, and flash messages (if you use Authentication),

## Installation using Composer

For installing **GraphicObjectTemplating** use the following command :

    composer.phar require celtic34fr/zf-graphic-object-templating-twig dev-master

In order to use the installed module, you need to configure your application as follows:

First, in **config/modules.config.php** file, add the following lines :

    ..., 
    'ZfcTwig',
    'GraphicObjectTemplating',
    ...,

In public folder of your project, create a linked directory with the **vendor/celtic34fr/zf-graphic-object-templating-twig/public** directory named **graphicobjecttemplating** with the following command executed :

    ln -s ../vendor/celtic34fr/zf-graphic-object-templating-twig/public graphicobjecttemplating

Copy the files **zfGraphicObjectTemplting.local.php.dist** and **zfGrpahicObjectTemplating.development.local.php.dist** found in the config folder of **GraphicObjectTemplating** without **.dist** extension in *config/autoload* folder of your project.
They will activate all the basics needed parameters by **GraphicObjectTemplating**.

By using *Twig Templating Engine*, you have to replace somes templates and parameters. You can found some templates in view/twigtemplates for your project :
* in *application/index* folder you have the template *index.twig* the same as index.phtml in a standard project,
* in *error* folder you have *index.twig* and *404.twig* to replace in *error* folder of your project *index.phtml* and *404.phtml*,
* in *layout* folder is an adaptation of the original *layout.phtml* in *layout.twig* using Twig facilities.

With these models, you will have the same behavior as with an original Zend Framework 3 project. Some extensions to Twig have been programmed to reproduce the same mechanisms implemented in a Zend Framework 3 project that does not use Twig for rendering pages.

This is only a base for your development that you can modify and adapt at your convenience. The current *layout.twig* template works with the Twig block mode. In this, it is defined severals variables and blocks to insert different datas :
* the variable *local* allows to define the language of the page, as 'fr' or 'en',
* the *Hmeta* block defines the basic metas, which you can change or complete,
* the *Hstyle* block sets the stylesheets files needed to run **GraphicObjectTemplating** in any page,
* the *Hscript* block sets the necessaries JavaScript files  to run **GraphicObjectTemplating** in any page,
* the *Bcontent* block contains or will contain if you changed it, the structure of your page, the *content* blocks contains the main part of the page (excluding navigation bar and footer),
* the *Bscript* block is there to allow you to add JavaScript code or files, loaded in the body of the page.

Finaly, before developping you application, you must make some changes in module/Application/config/module.config.php file. In the bloc *template_map* you must change all the file name extension from *.phtml* to *.twig*. Don't forget to dump autoload before controlling if all is in order to work.

## Development mode

First, install all the needed package just for dev environment :

    composer.phar require --dev zendframework/zend-developer-tools ^1.1.0
    composer.phar require --dev san/san-session-toolbar ^2.0.2

As **GraphicObjectTemplating** uses Php sessions, we need to be able to review and delete their content as needed. For this, and only in development mode, the *san/san-session-toolbar* extension has been installed with **GraphicObjectTemplating**.
To use this extension, add the following lines to the config/development.config.php file of your project:

    ...
    'modules' => [
        ...
        'ZendDeveloperTools',
        'SanSessionToolBar',
        ...
    ],
    ...

## Running Unit Tests

