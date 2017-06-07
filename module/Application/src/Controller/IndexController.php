<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Entity\User;

class IndexController extends AbstractActionController 
{
    
    private $entityManager;
    
    
    public function __construct($entityManager) 
    {
       $this->entityManager = $entityManager;
    }
    
    public function indexAction() 
    {
        return new ViewModel();
    }

    public function aboutAction() 
    {              
        $appName = 'Artykuły';
        $appDescription = 'Opis aplikacji';
        
        return new ViewModel([
            'appName' => $appName,
            'appDescription' => $appDescription
        ]);
    }  
    
    public function settingsAction()
    {
        $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($this->identity());
        
        if ($user==null) {
            throw new \Exception('Nie znaleziono użytkownika o takim emailu.');
        }
        
        return new ViewModel([
            'user' => $user
        ]);
    }
}

