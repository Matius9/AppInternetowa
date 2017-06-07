<?php

namespace Application;

use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $serviceManager = $application->getServiceManager();    
        $sessionManager = $serviceManager->get(SessionManager::class);
    }
}

