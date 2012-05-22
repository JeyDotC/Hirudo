<?php

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 *  Hirudo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Core\Exceptions;

/**
 * Thrown when there is an attempt to call a non existent application
 *
 * @author JeyDotC
 */
class ApplicationNotFoundException extends HirudoException {

    /**
     * Creates an ApplicationNotFoundException.
     * 
     * @param string $app The application name.
     * @param string $path The directory in which the application should be.
     */
    function __construct($app, $path) {
        parent::__construct(new ModuleCall($app, ""), "Application '$app' not found at '$path'");
    }

}

?>