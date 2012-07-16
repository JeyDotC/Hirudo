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

namespace Hirudo\Impl\Drupal;

use Hirudo\Core\Context\Principal as Principal;
use Hirudo\Core\Annotations\Export;

/**
 *
 * @Export(id="principal", factory="instance")
 */
class DrupalPrincipal extends Principal {

    /**
     *
     * @var JPrincipal
     */
    private static $instance;

    /**
     *
     * @return JPrincipal
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new DrupalPrincipal();
        }

        return self::$instance;
    }

    /**
     * @var JUser
     */
    private $user;

    function __construct() {
        parent::__construct();
        global $user;
        $this->user = $user;
        $this->setName($this->user->name);
        $this->setCredential($this->user->pass);

        if (!$this->isAnonimous()) {
            $this->setPermissions($this->user->roles);
        }
    }

    public function isAnonimous() {
        return $this->user->uid == 0;
    }

}

?>
