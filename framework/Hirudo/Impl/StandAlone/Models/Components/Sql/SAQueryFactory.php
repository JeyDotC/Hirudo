<?php

namespace Hirudo\Impl\StandAlone\Models\Components\Sql;

use Hirudo\Models\Components\Sql\QueryFactory;
use Hirudo\Core\Annotations\Export;

/**
 * Description of JAWQueryFactory
 *
 * @author JeyDotC
 * 
 * @Export(id="query_factory")
 */
class SAQueryFactory extends QueryFactory {

    protected function createQuery() {
        $config = \Hirudo\Core\Context\ModulesContext::instance()->getConfig();
        $settings = $config->get("sa-db-connection");
        $connectionString = $settings["dsn"];
        $user = isset($settings["user"]) ? $settings["user"] : "";
        $pass = isset($settings["password"]) ? $settings["password"] : "";
        $options = isset($settings["options"]) ? (array)$settings["options"] : array();
        
        return new SAQuery($connectionString, $user, $pass, $options);
    }
}

?>
