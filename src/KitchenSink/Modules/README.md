Modules/
========

Hello again, in this folder you will find several modules that makes use of some
Hirudo features. 

Each module represents a use case, remember that when designing
your application, or deciding what module to do next.

What Goes Here
--------------

The list of implemented use cases for this KitchenSink application.

* [Welcome/](http://github.com/JeyDotC/Hirudo/tree/master/src/KitchenSink/Welcome) A kind of "Hello world module". 
It just renders a page, shows some notifications and intentionally throws an exception to test error handling in
Hirudo.

* [Errors/](http://github.com/JeyDotC/Hirudo/tree/master/src/KitchenSink/Errors) This module is called each time
there is an unhandled exception. Also is called when a requested module doesn't exist. The module in charge of
handling errors can be configured at the [ext/config/Config.yml](https://github.com/JeyDotC/Hirudo/blob/master/ext/config/Config.yml) file.

* [CrudModule/](http://github.com/JeyDotC/Hirudo/tree/master/src/KitchenSink/CrudModule) This is a module that represents a
typical Create, Read, Update, Delete use case.

### Where to go now

To know the very basics of Hirudo, go to [Welcome/](https://github.com/JeyDotC/Hirudo/tree/master/src/KitchenSink/Modules/Welcome),
as it uses the most simple characteristics of the framework.

To see a way of error handling, look at the [Errors/](https://github.com/JeyDotC/Hirudo/tree/master/src/KitchenSink/Modules/Errors)
module, it represents just a way of managing exceptions.

And finally, to know the basics of **doing** things, look at the [CrudModule/](https://github.com/JeyDotC/Hirudo/tree/master/src/KitchenSink/Modules/CrudModule).

###The end of readmes: rise of the source files.

For the next folders you won't find any README.md file as the source code is overly documented
and it looks like the comment documentation is just enough to help you understand what's going on in code.

Happy code exploring! :)