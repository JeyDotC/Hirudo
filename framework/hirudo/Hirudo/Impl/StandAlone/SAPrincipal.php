<?php

namespace Hirudo\Impl\StandAlone;

use Hirudo\Core\Context\Principal as Principal;
use Hirudo\Core\Context\Session as Session;

/**
 *
 * @Hirudo\Core\Annotations\Export(id="principal", factory="instance")
 * 
 */
class SAPrincipal extends Principal {

    /**
     *
     * @var Session
     */
    private $session;

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
            self::$instance = new SAPrincipal();
        }

        return self::$instance;
    }

    function __construct() {
        parent::__construct();
    }

    public function isAnonimous() {
        throw new Exception("Not implemented yet");
    }

    /**
     *
     * @param Session $session 
     * 
     * @Hirudo\Core\Annotations\Import(id="session")
     */
    public function setSession(Session $session) {
        $this->session = $session;
//        if ($this->session->has("__Principal")) {
//            $principalData = $this->session->get("__Principal");
//            $this->setName($principalData["name"]);
//            $this->setCredential($principalData["credential"]);
//            $this->setPermissions($principalData["permissions"]);
//        }
    }

}

?>
