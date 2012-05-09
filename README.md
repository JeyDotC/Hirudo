HIRUDO FRAMEWORK
================

For now this framework is under construction, I'm just begining.

Overview
--------

This is a small, general purpose framework for PHP 5.x which goal is to abstract 
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

* *assets/*: In this folder you will put your web stuff, like *css, js and image* files. 
Also you can put your special templates like, the *Master.tpl* or *Base.twig* templates 
for example, but the later is just a convension.

* *ext/*: Here goes the extensions to the framework: plugins, smarty plugins, configuration, etc.

* *framework/*: Obviously here goes the framework classes; normally you should not
look into this folder, unless you are very curious or even have an idea to inprove
the framework itself ;)

* *src/*: Here goes your applications. In this place you will put your fantastic 
application code; for more information please look at the *README.md* file inside.

* *index.php*: This is the main entry point for the stand alone version, it just instantiates
the modulemanager and makes it execute.

* *hirudo.php*: This is the main entry point for the Joomla! version, it just instantiates the modulemanager and makes it execute wraped into a Joomla! controller. 
To make it work as a component just rename this file with the name of your component.

* *init.php*: This file just initializes some stuff and creates a couple of constants, it's presence
is due to the need to know the absolute path to the root folder.

### Where to go now

If you are willing to know how to make an application in Hirudo, the [src/](/JeyDotC/Hirudo/tree/master/src) folder
is your place, there you will find a sample application that tests some of the
Hirudo framework features and a neat *README.md* file with some explanations.


<!--
* This is the most basic configuration object and has the next propeties:
        * "businessRoot": the root to your applications.
        * "debug": Tells if the application is in debug or produccion mode.
        * "onModuleNotFound": This is an action to be called in case that a 
          requested module is not found. The given string has this format *ApplicationName::ModuleName::methodName*
        * "onError": This is called in case of any exception, this string has the same format that the one above.

    * For this file you will have to be careful as it is parsed via the *json_decode* function
    and it is very stricted with the JSON syntax (I accept sugestions on this field).
-->
