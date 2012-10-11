<?php

namespace Thelia\Routing\Matcher;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Thelia\Controller\NullController;

/**
 * Default matcher when no action is needed and there is no result for urlmatcher
 */
class DefaultMatcher implements RequestMatcherInterface{
    
    protected $controller;
    
    public function __construct(NullController $controller) {
        $this->controller = $controller;
    }
    
    public function matchRequest(Request $request) {
        
        
        $objectInformation = new \ReflectionObject($this->controller);
        
        $parameter = array(
          '_controller' => $objectInformation->getName().'::noAction'  
        );
        
        return $parameter;
    }
}


?>