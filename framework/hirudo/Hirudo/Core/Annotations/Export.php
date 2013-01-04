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

namespace Hirudo\Core\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Signals a class, method or property as a service exporter.
 *
 * @author JeyDotC
 * 
 * @Annotation
 * @Target({"CLASS", "METHOD", "PROPERTY"})
 */
final class Export {

    /**
     * The id of the service to be exported.
     * 
     * @var string 
     */
    public $id = "";

    /**
     * An optional factory method which is in charge of returning
     * an instance of the service.
     * 
     * @var string 
     */
    public $factory = "";
    
    /**
     * Optional tags.
     * 
     * @var array
     */
    public $tags = array();

}

?>
