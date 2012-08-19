src/
====

What Goes Here
--------------

Welcome to the *src* folder, here go your applications.

In Hirudo, an *application* is just a folder with three folders inside:

* An *assets* folder to place your assets, such as javascripts, css and Master templates. 

* A *Models* folder where the entities, data access, components and all the things 
expected to be in the model layer of an MVC architecture are stored. 

* A *Modules* folder. This one contains a series of directories, each one represents
a Module. A *Module* is the implamentation of a use case and is equivalent to
controllers in an MVC architecture.

So, to create an application you just need to create a directory with this structure:

    YourApp/
        assets/ <-- Your js, css, etc.
        Models/ <-- Your Models layer.
        Modules/ <-- Your controllers
            AModule/
            AnotherModule/
            ...
            LotsOfModules/

You can have various applications, each one with their own *assets*, *Models* layer and with their
own *Modules*.

    YourApp/
        assets/
        Models/
        Modules/
    AnotherApp/
        assets/
        Models/
        Modules/
        ...
    LotsOfApps/
        assets/
        Models/
        Modules/

Once you have created an application you need to make it do something, here is
where modules come in play. 

As I said before, a *Module* is the representation of a use case, to create a Module
is necesary to do these things:

1. Create a Folder in the *Modules/* directory of the App with the name of the module.
2. Create a class with exactly the same name of the Module's folder. Such class must:
    * Be in the `AppName\Modules\ModuleName` namespace, where 'AppName' is the name of your App.
      and ModuleName is the name of the module. 
    * Extend the `Hirudo\Core\Module` class.
3. Create a *views/* folder in which to put the views associated to the module. This
step is optional if the module renders it's results without recurring to
the templating system or uses views located in another modules.

The resulting directory listing looks like this:

    YourApp/
        Models/ <-- Did I mention that this is optional?
        Modules/
            SomeModule/
                views/
                    index.tpl <-- This is a view file.
                SomeModule.php <-- Our module

And here is the source code for your Module Class:

File *SomeModule.php*:

```php
<?php
namespace YourApp\Modules\SomeModule;
use Hirudo\Core\Module;

class SomeModule extends Module {
    public function index() {
        echo "<h1>Hello world!</h1>";
    }
}
?>
```

With this basic code you can now type in your browser a url like this: 
*http://Path/To/Hirudo/index.php?h=YourApp/SomeModule* where 'Path/To/Hirudo/'
gereally is localhost/HirudoFolder/ and a big "Hello world" message should appear.

**Note:** The look of the URL my vary from one implementation to another, but usually you'll
find the 'h' parameter which represents a Hirudo call, where the first part is the Application,
the second is the module and the third(optional) is the method to be executed.

### An importatnt note about Models in Hirudo

Hirudo by itself doesn't provide a persistence layer, instead, there will be some
extensions that addresses data persistence which will be quite easy to install and
use.

This is due to the need of allowing various persistence mechanisms, like Restful
clients, ORM based persistence, etc.

There will be an extensions repository for Hirudo very soon, in which you will find various
persistence mechanisms.

Anyway, Hirudo uses a Components based model, where a component is just a class
that deals with persistence, this way, an extension mechanism may provide a base
class for components.

### Where to go now

To have a more complete view of the modules creation, you can visit the sample application
(The [KitchenSink/](http://github.com/JeyDotC/Hirudo/tree/master/src/KitchenSink) folder) 
and look at the *README.md* file or just look at the files in it if you find them self explanatory 
enough.