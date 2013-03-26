<?php

namespace Hirudo\Core\Extensions\TaskRequirements;

use Hirudo\Core\Context\ModulesContext;
use ReflectionParameter;

/**
 * The default parameter resolver, resolves values from request variables.
 *
 * @author JeyDotC
 */
class RequestRequirementResolver implements RequirementResolverInterface {

    private $request;

    function __construct() {
        $this->request = ModulesContext::instance()->getRequest();
    }

    /**
     * Resolves the parameter value fron the given request variable.
     * 
     * If the parameter is type hinted with a class, this resolver will 
     * instantiate the object and use the Hirudo\Core\Context\Request::bind()
     * method to setup its values.
     * 
     * @param ReflectionParameter $param Information about the parameter.
     * @param string $source The request variable name ("get", "post"...)
     * @return mixed The value of the parameter.
     * 
     * @see RequestRequirementResolver::supports() To know which request variables
     * are supported.
     * 
     * @see \Hirudo\Core\Context\Request::bind()
     */
    public function resolve(ReflectionParameter $param, $source) {
        $defaultValue = $param->isOptional() ? $param->getDefaultValue() : null;
        $from = strtolower($source);
        $result = null;

        if ($param->getClass() != null) {
            $result = $param->getClass()->newInstance();
            $this->request->bind($result, $this->request->$from($param->name));
        } else {
            $result = $this->request->$from($param->name, $defaultValue);
        }
        
        return $result;
    }

    /**
     * {@inheritdoc}
     * 
     * This resolver recognizes the sources that are strings and have any of these
     * velues: "get", "post", "cookie", "env" or "server" case-insensitive.
     * 
     * @param mixed $source
     * @return boolean
     */
    public function suports($source) {
        return is_string($source) && in_array(strtolower($source), array(
                    "get",
                    "post",
                    "cookie",
                    "env",
                    "server"));
    }

}

?>
