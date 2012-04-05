<?php

namespace Hirudo\Core\Exceptions;

use Hirudo\Core\Context\ModuleCall;

class ModuleNotFoundException extends HirudoException {

    public function __construct($module, $app) {
        parent::__construct(new ModuleCall($app, $module), "The module '$module' from application '$app' Doesn't exist and there is no default module.");
    }

}

?>
