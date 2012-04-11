<?php

namespace Hirudo\Impl\Joomla;

use Hirudo\Core\Context\AppConfig as AppConfig;
use Hirudo\Core\Annotations\Export;

require_once "JoomlaHelper.php";

/**
 * Description of JAppConfig
 *
 * @author JeyDotC
 * 
 * @Export (id="config", factory="instance")
 * 
 */
class JoomlaAppConfig extends AppConfig {

    /**
     *
     * @var JAppConfig
     */
    private static $instance;

    /**
     *
     * @return JAppConfig
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new JAppConfig();
        }

        return self::$instance;
    }

    /**
     *
     * @var JParameter 
     */
    private $configObject;

    public function get($key, $default = null) {
        return $this->configObject->get($key, $default);
    }

    protected function load() {
        $mainframe = JoomlaHelper::getMainframe();
        $this->configObject = $mainframe->getPageParameters($mainframe->scope);
    }

}

?>
