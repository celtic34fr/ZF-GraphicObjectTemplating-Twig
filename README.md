# GraphicObjectTemplating

## Introduction

This module help you for building UI object oriented and interacting with it, using TWIG Templating Engine. This version work only on Zend Framework 2.5+ and 3.0+

## Installation using Composer

Fisrt during creating your Zend Framework 3 project, you need to install :
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

In public folder of your application, create a linked directory with the **vendor/celtic34fr/zf-graphic-object-templating-twig/public** directory named **graphicobjecttemplating** with the following command executed at the root of the project :

    ln -s ../vendor/celtic34fr/zf-graphic-object-templating-twig/public graphicobjecttemplating

Copy the files **zfGraphicObjectTemplting.local.php.dist** and **zfGrpahicObjectTemplating.development.local.php.dist** in the config folder of GraphicObjectTemplating config folder witout **dist** extension in config/autoload folder of your project.
They will activate all the needed parameters by **GraphicObjectTemplating**.


## Development mode


## Running Unit Tests

