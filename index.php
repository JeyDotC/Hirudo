<?php

require_once 'init.php';

use Hirudo\Core\ModulesManager;

$manager = new ModulesManager(array(
            //The request data.
            'Hirudo\Impl\StandAlone\SARequest',
            //The URL builder.
            'Hirudo\Impl\StandAlone\SARouting',
            //The session Manager.
            'Hirudo\Impl\StandAlone\SASession',
            //The current user.
            'Hirudo\Impl\StandAlone\SAPrincipal',
            //The configuration manager.
            'Hirudo\Impl\StandAlone\SAppConfig',
            //The templating system.
            'Hirudo\Impl\Common\Templating\SmartyTemplating',
            //The Sql Model
            'Hirudo\Impl\Common\Models\Components\Sql\SAQueryFactory',
        ));

echo $manager->run();
?>
