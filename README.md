HIRUDO FRAMEWORK
================

Hirudo is a small, general purpose framework for PHP 5.3+ which goal is to abstract 
developers from challenges of creating extensions for CMS.

It's components maily consist in abstract classes and interfaces so the different
implelemtations shall deal with the containing CMS details, generally using the
corresponding classes of the CMS and delegating the responsibility to them.

There will be two implementations at first:

* A Joomla! version that will work as a Joomla! component.
* A Stand alone version that can live by itself.

### About the name

*Hirudo* comes from latin and means *leech*, that's because the framework ideally
delegates the implementation of it's functionalities to the containing CMS.

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
files and the folder where you are going to work. Lets explain each one:

* [assets/](http://github.com/JeyDotC/Hirudo/tree/master/assets): In this folder you will put your web stuff, like *css, js and image* files. 
Also you can put your special templates like, the *Master.tpl* or *Base.twig* templates 
for example, but the latter is just a convension.

* [ext/](http://github.com/JeyDotC/Hirudo/tree/master/ext): Here goes the extensions to the framework: plugins, smarty plugins, configuration, etc.

* [framework/](http://github.com/JeyDotC/Hirudo/tree/master/framework): Obviously here goes the framework classes; normally you should not
look into this folder, unless you are very curious or even have an idea to inprove
the framework itself ;)

* [src/](http://github.com/JeyDotC/Hirudo/tree/master/src): Here goes your applications. In this place you will put your fantastic 
application code; for more information please look at the *README.md* file inside.

* [index.php](http://github.com/JeyDotC/Hirudo/blob/master/index.php): This is the main entry point for the stand alone version, it just instantiates
the modulemanager and makes it execute.

* [hirudo.php](http://github.com/JeyDotC/Hirudo/blob/master/hirudo.php): This is the main entry point for the Joomla! version, it just instantiates the modulemanager and makes it execute wraped into a Joomla! controller. 
To make it work as a component just rename this file with the name of your component.

* [init.php](http://github.com/JeyDotC/Hirudo/blob/master/init.php): This file just initializes some stuff and creates a couple of constants, it's presence
is due to the need to know the absolute path to the root folder.

* [.htaccess](http://github.com/JeyDotC/Hirudo/blob/master/.htaccess): All .htaccess files are configuration files that keep bad guys from lurking on your application files.

### Where to go now

If you are willing to know how to **make an application in Hirudo**, the [src/](http://github.com/JeyDotC/Hirudo/tree/master/src) folder
is your place, there you will find a sample application that tests some of the
Hirudo framework features and a neat *README.md* file with some explanations.