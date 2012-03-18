<?php

namespace Hirudo\Impl\Joomla;

/**
 * Description of _JoomlaHelper
 *
 * @author JeyDotC
 */
class JoomlaHelper {

    /**
     *
     * @return JApplication
     */
    public static function getMainframe() {
        return JFactory::getApplication();
    }

}

?>
