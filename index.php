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
            'Hirudo\Impl\StandAlone\Models\Components\Sql\SAQueryFactory',
            //The Asset system
            'Hirudo\Impl\StandAlone\SAssets',
        ));

echo $manager->run();
?>
