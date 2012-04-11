<?php

namespace Hirudo\Impl\Joomla;

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
