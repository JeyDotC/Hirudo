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