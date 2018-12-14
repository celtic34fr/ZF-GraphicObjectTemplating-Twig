# GraphicObjectTemplating

## Introduction

This module will help you to build interactive object oriented UI elements using the TWIG Templating Engine. This version only works with Zend Framework versions 2.5+ and 3.0+, however it has only been tested with Zend version 3.0+.

## Before Installation ##

* You must have a Zend Framework 3 project,
* with the following dependencies:
    * developer toolbar (in order to debug your project),
    * support for caching (useful in productions using TWIG),
    * support for JSON de/serialization,
    * support for sessions.

optionally, you can also install:
* i18n support (if needed),
* the official MVC plugins, including PRG support, identity, and flash messages (if you use Authentication),

## Installation using Composer

For to install **GraphicObjectTemplating** use the following command:

    composer.phar require celtic34fr/zf-graphic-object-templating-twig dev-master

In order to use the installed module, you need to configure your application as follows:

First, in **config/modules.config.php** file, add the following lines:

    ...,
    'ZfcTwig',
    'GraphicObjectTemplating',
    ...,

In your project's public folder, create a linked directory with the **vendor/celtic34fr/zf-graphic-object-templating-twig/public** directory named **graphicobjecttemplating** with the following commands:
If you're on Linux, run the following command:

    ln -s ../vendor/celtic34fr/zf-graphic-object-templating-twig/public graphicobjecttemplating

If you're on Windows, run the following command as an administrator using cmd.exe in the public folder:

    mklink /D graphicobjecttemplating ..\vendor\celtic34fr\zf-graphic-object-templating\public

Copy the files **zfGraphicObjectTemplting.local.php.dist** and **zfGrpahicObjectTemplating.development.local.php.dist** found in the config folder of **GraphicObjectTemplating** without **.dist** extension in *config/autoload* folder of your project.
They will activate all the basics needed parameters by **GraphicObjectTemplating**. 

By using the *Twig Templating Engine*, you have to replace some templates and parameters. You can find templates in view/twigtemplates for your project:
* in the *application/index* folder, you have the *index.twig* template, which is the same as index.phtml in a standard project,
* in the *error* folder, you'll find the *index.twig* and *404.twig* files. Use them to replace the *index.phtml* and *404.phtml* files in your project's *error* folder,
* in the *layout* folder you'll find the *layout.twig* file, which is an adaptation of the original *layout.phtml* file, to be used with the Twig templating engine.

One this is done, you will experience the same behavior as an original Zend Framework 3 project. Some extensions to Twig have been made to copy the same mechanics as a Zend Framework 3 project that do not originally use Twig for rendering pages.

This is only a foundation for your development, you can modify/adapt it to fit your needs. The current *layout.twig* template works with the Twig block mode. In this, there are several variables and blocks that are defined, so you can input your own data:
* the variable *local* allows you to define the language of the page, for instance; 'fr' or 'en',
* the *Hmeta* block defines the basic metas, which you can either change or complete,
* the *Hstyle* block defines the stylesheets needed to run **GraphicObjectTemplating** in any page,
* the *Hscript* block defines the JavaScript files needed to run **GraphicObjectTemplating** in any page,
* the *Bcontent* block contains or will contain, the structure of your page, the *content* blocks contain the main part of the page (excluding the navigation bar and footer),
* the *Bscript* block is there to allow you to add JavaScript code or files, loaded in the body of the page.

Finally, before developing your application, you must make some changes in the module/Application/config/module.config.php file. In the *template_map* block you must change all the file name extension from *.phtml* to *.twig*. Don't forget to dump autoload before controlling if all is in order to work.

## Development mode

First, install all the needed packages for your dev environment:

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
