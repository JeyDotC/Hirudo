*\- To my lord Jesus Christ, who didn't scatimate himself for all of us so we could call him brother and friend.*

HIRUDO FRAMEWORK
================

Overview
--------

Hirudo is a small, general purpose framework for PHP 5.3+ which goal is to abstract 
developers from challenges of creating extensions for CMSs.

It's components mainly consist in abstract classes and interfaces so the different
implelemtations shall deal with the containing CMS details, generally using the
corresponding classes of the CMS and delegating the responsibility to them.

There are three implementations up to now:

* The Joomla! version that works as a component [Supported versions: 1.5, 1.6(not tested), 1.7, 2.5].
* The Drupal version that works as a module and creates a block [Supported versions: 6.x, 7.x, 8.x].
* The Stand alone version that can live by itself.

### About the name

*Hirudo* comes from latin and means *leech*, that's because the framework ideally
delegates the implementation of it's functionalities to the containing CMS.

Documentation
-------------

The Hirudo's documentation is, for now, a work in progress, currently you can see our
Tutorial documentation (starting below) or the [API documentation](https://github.com/JeyDotC/Hirudo-docs).
Both are made to be read directly in the repository they are in.

If you've been using Hirudo for a while, you can contribute to the [Wiki](https://github.com/JeyDotC/Hirudo/wiki)

Tutorial
--------

As soon as there is an stable version and classes get fully documented there will be a 
tutorial to get you started with Hirudo, but, for now, I'll try to teach the 
framework with this approach: On each folder you will find a *README.md* file wihch will have
a section named "What Goes Here" explaining what is inside the directory, what
can you put in there, where to and where not to go from this place.

So, lets get started with this one, the root folder:

What Goes Here
--------------

In this folder you can find the root directory of the framework, some important
files and the folder where you are going to work. 

Let explain each one:

* [ext/](http://github.com/JeyDotC/Hirudo/tree/master/ext): Here goes the global extensions to the framework: plugins, smarty plugins, configuration, etc, those can be used by all applications.

* [framework/](http://github.com/JeyDotC/Hirudo/tree/master/framework): Obviously here goes the framework classes; normally you should not
look into this folder, unless you are very curious or even have an idea to improve
the framework itself ;)

* [src/](http://github.com/JeyDotC/Hirudo/tree/master/src): Here goes your applications. In this place you will put your fantastic 
application code.

* [index.php](http://github.com/JeyDotC/Hirudo/blob/master/index.php): This is the main entry point for the stand alone version, it just instantiates
the ModulesManager class and makes it execute.

* [hirudo.php](http://github.com/JeyDotC/Hirudo/blob/master/hirudo.php): This is the main entry point for the Joomla! version, it just instantiates the ModulesManager class and makes it execute wraped into a Joomla! controller.
* [hirudo.xml](http://github.com/JeyDotC/Hirudo/blob/master/hirudo.xml): This this file installs hirudo on Joomla!.

* [hirudo6.info](http://github.com/JeyDotC/Hirudo/blob/master/hirudo6.info),
[hirudo7.info](http://github.com/JeyDotC/Hirudo/blob/master/hirudo7.info),
[hirudo8.info](http://github.com/JeyDotC/Hirudo/blob/master/hirudo8.info): These files provide information to dupal so it can interact with the framework as a Drupal Module.

* [hirudo6.install](http://github.com/JeyDotC/Hirudo/blob/master/hirudo6.install),
[hirudo7.install](http://github.com/JeyDotC/Hirudo/blob/master/hirudo7.install),
[hirudo8.install](http://github.com/JeyDotC/Hirudo/blob/master/hirudo8.install): These files are called by Drupal to install and uninstall hirudo. 
**NOTE:** When hirudo gets installed on Drupal, it creates a block, in order to make it visible you must place it somewhere in your site's structure.

* [hirudo6.module](http://github.com/JeyDotC/Hirudo/blob/master/hirudo6.module),
[hirudo7.module](http://github.com/JeyDotC/Hirudo/blob/master/hirudo7.module),
[hirudo8.module](http://github.com/JeyDotC/Hirudo/blob/master/hirudo8.module): These files are the entry point for the Drupal implementation of Hirudo.

* [init.php](http://github.com/JeyDotC/Hirudo/blob/master/init.php): This file just initializes some stuff and creates a couple of constants, it's presence
is due to the need to know the absolute path to the root folder.

* [.htaccess](http://github.com/JeyDotC/Hirudo/blob/master/.htaccess): All .htaccess files are configuration files that keep bad guys from lurking on your application files.

### Where to go now

If you are willing to know how to **make an application in Hirudo**, the [src/](http://github.com/JeyDotC/Hirudo/tree/master/src) folder
is your place, there you will find a sample application that tests some of the
Hirudo framework features and a neat *README.md* file with some explanations.