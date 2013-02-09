<?php

namespace Hirudo\Core\Extensions\WebApi;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Extensions\TaskRequirements\RequirementResolverInterface;
use Hirudo\Core\Annotations\Export;
use ReflectionParameter;

/**
 * Description of ParametersResolver
 *
 * @author JeyDotC
 * @Export(id="web_api_parameters_resolver", tags={"requirements_resolver"})
 */
class WebApiRequirementResolver implements RequirementResolverInterface {

    private $request;

    function __construct() {
        $this->request = ModulesContext::instance()->getRequest();
    }

    public function resolve(ReflectionParameter $param, $source) {
        $defaultValue = $param->isOptional() ? $param->getDefaultValue() : null;
        $result = null;

        if ($param->getClass() != null) {
            $resolver = new ApiRequest();
            $result = $resolver->loadEntityFromPayload($param->getClass()->name);
        } else {
            $result = $this->request->get($param->name, $defaultValue);
        }

        return $result;
    }

    public function suports($source) {
        return $source == "web_api";
    }
}

?>
