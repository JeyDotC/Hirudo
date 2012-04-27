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
 * This annotation marks a method as a dependency requester, a point in which
 * to inject a dependency.
 * 
 * Note that this annotation only applies to methods, that is because it might be
 * cheaper than looking at an attribute and determinig it's type by looking at
 * the PhpDoc. This is most likely to change in the near future, may be by adding
 * a direct class attribute to the annotation.
 *
 * @author JeyDotC
 * 
 * @Annotation
 * @Target({"METHOD", "PROPERTY"})
 */
final class Import {

    /**
     * The id of the dependency to be injected. If null, the dependency should be
     * resolved by looking at the method's type hinting.
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
