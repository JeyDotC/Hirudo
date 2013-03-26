<?php

namespace Hirudo\Core\Extensions\WebApi;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Extensions\TaskRequirements\RequirementResolverInterface;
use Hirudo\Core\Annotations\Export;
use ReflectionParameter;

/**
 * Resolves the parameter directly from the request payload.
 *
 * @author JeyDotC
 * @Export(id="web_api_parameters_resolver", tags={"requirements_resolver"})
 */
class WebApiRequirementResolver implements RequirementResolverInterface {

    private $request;

    function __construct() {
        $this->request = ModulesContext::instance()->getRequest();
    }

    /**
     * Atempts to resolve the parameter from the request payload.
     * 
     * If the parameter is type hinted with a class, the request payload
     * is decoded based on the mime/type given by the Content-Type header value.
     * Otherwise the value is assumed to come from the GET.
     * 
     * @param ReflectionParameter $param
     * @param mixed $source
     * @return mixed
     */
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

    /**
     * This resolver recognizes the sources that are strings and have this 
     * value: "web_api" case-sensitive.
     * 
     * @param mixed $source
     * @return boolean
     */
    public function suports($source) {
        return $source == "web_api";
    }
}

?>
