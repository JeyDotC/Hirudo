Models
======

This is the models folder, here shall be contained your data model and the persistence
mechanisms that store it.

In Hirudo, the models are divided into two aspects: 

* The Entities, which are plain old PHP objects which sole purpose is to hold data 
and represent the current state of the system.

* The Components, those are in charge of storing the entities in wherever they are suposed
to be stored.

A component is just another class with a set of methods that save your entities in
storage, this way, a Component may save entities into the session, or a relational 
database or send it to a WebService. 

The components must acomplish only three conditions: 
* Their name must end with Component.
* They must have a default constructor which receives no parameters.
* They must be into the MyApp\Models\Components folder.

The component can be accessed from Modules via the component() method, you can see
a sample usage [here](https://github.com/JeyDotC/Hirudo/blob/master/src/KitchenSink/Modules/CrudModule/CrudModule.php).

###A Hirudo ninja hint

The currently running application's namespace is always registered for autoloading.
That means that, if your classes respect the namespacing [conventions](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md), 
they can be instanced without the need of including their source code.

###Where to go now

To see the entities and the considerations that must be taken about them, go to
the [Entities/](https://github.com/JeyDotC/Hirudo/tree/master/src/KitchenSink/Models/Entities)
folder.

To see a sample implementation of a component, go to [Components/](https://github.com/JeyDotC/Hirudo/tree/master/src/KitchenSink/Models/Components)
folder.

###The end of readmes: rise of the source files.

For the next folders you won't find any README.md file as the source code is overly documented
and it looks like the comment documentation is just enough to help you understand what's going on in code.

Happy code exploring! :)