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

namespace Hirudo\Impl\Joomla\V15;

use Hirudo\Core\Context\Principal as Principal;
use Hirudo\Core\Annotations\Export;

/**
 *
 * @Export(id="principal", factory="instance")
 */
class JoomlaPrincipal extends Principal {

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
            self::$instance = new JoomlaPrincipal();
        }

        return self::$instance;
    }

    /**
     * @var JUser
     */
    private $jUser;

    function __construct() {
        parent::__construct();
        $this->jUser = \JFactory::getUser();
        $this->setName($this->jUser->username);
        $this->setCredential($this->jUser->password);

        if (!$this->isAnonimous()) {
            $session = \JFactory::getSession();
            $extraData = $session->get("__ExtraData", array());
            foreach ($extraData as $key => $value) {
                $this->getData()->add($key, $value);
            }
            $this->setPermissions($session->get("roles"));
        }
    }

    public function isAnonimous() {
        return $this->jUser->guest;
    }

}

?>
