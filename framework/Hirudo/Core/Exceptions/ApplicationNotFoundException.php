<?php

namespace Hirudo\Core\Exceptions;

/**
 * Description of ApplicationNotFoundException
 *
 * @author JeyDotC
 */
class ApplicationNotFoundException extends HirudoException {

    function __construct($app, $path) {
        parent::__construct(new ModuleCall($app, ""), "Application '$app' not found at '$path'");
    }

}

?>