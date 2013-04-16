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
 * Hirudo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Impl\StandAlone;

use Hirudo\Core\Context\Principal as Principal;
use Hirudo\Core\Context\Session as Session;

/**
 *
 * @Hirudo\Core\Annotations\Export(id="principal", factory="instance")
 * 
 */
class SAPrincipal extends Principal {

    private $isAnonimous = true;

    /**
     *
     * @var Session
     */
    private $session;

    /**
     *
     * @var SAPrincipal
     */
    private static $instance;

    /**
     *
     * @return SAPrincipal
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new SAPrincipal();
        }

        return self::$instance;
    }

    function __construct() {
        parent::__construct();
    }

    public function isAnonimous() {
        return $this->isAnonimous;
    }

    /**
     *
     * @param Session $session 
     * 
     * @Hirudo\Core\Annotations\Import(id="session")
     */
    public function setSession(Session $session) {
        $this->session = $session;
        if ($this->session->has("__Principal")) {
            $principalData = $this->session->get("__Principal");
            $this->setName($principalData["name"]);
            $this->setCredential($principalData["credential"]);
            $this->setPermissions($principalData["permissions"]);
            $this->isAnonimous = false;
        }
    }

}

?>
