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
 * This annotation marks a method or property as a dependency requester, a point in which
 * to inject a dependency.
 *
 * @author JeyDotC
 * 
 * @Annotation
 * @Target({"METHOD", "PROPERTY"})
 */
final class Import {

    /**
     * The id of the dependency to be injected.
     * 
     * If this attribute is null, the dependency injector shall determine the class
     * of the requested object and create a new instance to inject it. The way the class is
     * determined is like below:
     * 
     * If this annotation is applied to a method, the method's type hinting will be used
     * to determine the class of the dependency.
     * 
     * If this nanotation is applied to a property, the className property of this annotation
     * must be set to the fully qualified class name, this is a way to avoid the efford
     * of determining the class name based on the doc blocks.
     * 
     * @var string 
     */
    public $id = null;

    /**
     * A dependency class name. This is useful if the dependency class is instantiable
     * and direct instantiation is acceptable. To import interfaces, abstract
     * classes or classes with some kind of special instatiation issue 
     * (like factory methods), use Import::$id instead and export the dependency
     * class with the @Export annotation.
     * 
     * @var string  The fully qualified name of the class to be imported. 
     */
    public $className = null;
}

?>
