<?php

namespace KitchenSink\Modules\CrudModule\ViewModels;

use Hirudo\Core\Context\ModulesContext;
use KitchenSink\Models\Entities\Foo;
use UIExtensions\Html\Grid\GridModel;

/**
 * Description of FooGridModel
 *
 * @author JeyDotC
 */
class FooGridModel extends GridModel {

    protected function init() {
        $this->column()->createFor(function (Foo $foo) {
                    return $foo->getId();
                })->named("Id");

        $this->column()->createFor(function (Foo $foo) {
                    return $foo->getDescription();
                })->named("Description");

        return $this;
    }

    public function withActions() {
        $this->column()->createFor(function (Foo $foo) {
                    $routing = ModulesContext::instance()->getRouting();
                    $params = array("id" => $foo->getId(),);
                    return "<a href='{$routing->appAction("KitchenSink", "CrudModule", "view", $params)}'>View</a> | 
                            <a href='{$routing->appAction("KitchenSink", "CrudModule", "edit", $params)}'>Edit</a> | 
                            <a href='{$routing->appAction("KitchenSink", "CrudModule", "remove", $params)}'>Remove</a>";
                })->named("Actions");
        return $this;
    }

}

?>
