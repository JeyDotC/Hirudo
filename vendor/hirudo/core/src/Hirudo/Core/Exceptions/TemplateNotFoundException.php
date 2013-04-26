<?php

namespace Hirudo\Core\Exceptions;

use Exception;

/**
 * Description of TemplateNotFoundException
 *
 * @author JeyDotC
 */
class TemplateNotFoundException extends Exception {

    public function __construct($viewFile) {
        parent::__construct("The template file $viewFile was not found.");
    }

}

?>
