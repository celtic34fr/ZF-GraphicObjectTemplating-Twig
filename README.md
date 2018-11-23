# GraphicObjectTemplating

## Introduction

This module help you for building UI object oriented and interacting with it, using TWIG Templating Engine. This version work only on Zend Framework 2.5+ and 3.0+

## Installation using Composer

First during creating your Zend Framework 3 project, you need to install :
* the developer toolbar,
* caching support,
* JSON de/serialization support,
* i18n support (if you need),
* the official MVC plugins, including PRG support, identity, and flash messages (if you use Authentication),
* sessions support

Then, you must declare the developer toolbar in config/development.config.php.dist, and all the other module in  config/modules.config.php

For installing **GraphicObjectTemplating** use the following command :

    composer.phar require celtic34fr/zf-graphic-object-templating-twig dev-master

In order to use the installed module, you need to configure your application as follows:

First, in **config/modules.config.php** file, add the following lines :

    ..., 
    'ZfcTwig',
    'GraphicObjectTemplating',
    ...,

In public folder of your application, create a linked directory with the **vendor/celtic34fr/zf-graphic-object-templating-twig/public** directory named **graphicobjecttemplating** with the following command executed :

    ln -s ../vendor/celtic34fr/zf-graphic-object-templating-twig/public graphicobjecttemplating

Copy the files **zfGraphicObjectTemplting.local.php.dist** and **zfGrpahicObjectTemplating.development.local.php.dist** found in the config folder of **GraphicObjectTemplating** config folder without **dist** extension in *config/autoload* folder of your project.
They will activate all the needed parameters by **GraphicObjectTemplating**.

By using *Twig Templating Engine*, you have to replace somes templates and paramters. You can found some templates in view/twigtemplates for your project :
* in *application/index* folder you have the template *index.twig* the same as index.phtml in a standard project,
* in *error* folder you have *index.twig* and *404.twig* to replace in *error* folder of your project *index.phtml* and *404.phtml*,
* in *layout* folder is a translation of the original *layout.phtml* in *layout.twig*.

With these models, you will have the same behavior as with an original Zend Framework 3 project. Some extensions to Twig have been programmed to reproduce the same mechanisms implemented in a Zend Framework 3 project that does not use Twig for rendering pages.

This is only a base for your development that you can modify and adapt at your convenience. the current layout.twig template works with the Twig block mode. in this it is defined several blocks to insert different data:
* the variable * local * allows to define the language of the page, example 'fr' or 'en',
* the * Hmeta * block defines the basic metas, which you can record or complete,
* the * Hstyle * block descriptes the style sheets to apply to the page,
* the * Hscript * block describes the JavaScript sources to load so that the base events are managed,
* the * Bcontent * block contains or will contain if you changed the page by itself, and contains the * content * block which is set up for this to see the central part of page,
* the * Bscript * block is there to allow ajour, JavaScript code or source loading while changing the central part of the page

## Development mode


## Running Unit Tests

