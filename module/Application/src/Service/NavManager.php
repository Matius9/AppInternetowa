<?php
namespace Application\Service;

class NavManager
{
    private $authService;    
    private $urlHelper;
    
    public function __construct($authService, $urlHelper) 
    {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
    }
    
    public function getMenuItems() 
    {
        $url = $this->urlHelper;
        $items = [];
        
        $items[] = [
            'id' => 'home',
            'label' => 'Strona główna',
            'link'  => $url('home')
        ];
        
        $items[] = [
            'id' => 'blog',
            'label' => 'Artykuły',
            'link'  => $url('blog')
        ];
        
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Zaloguj',
                'link'  => $url('login'),
                'float' => 'right'
            ];
        } else {
            
            $items[] = [
                'id' => 'admin',
                'label' => 'Admin',
                'dropdown' => [
                    [
                        'id' => 'users',
                        'label' => 'Użytkownicy',
                        'link' => $url('users')
                    ]
                ]
            ];
            
            $items[] = [
                'id' => 'logout',
                'label' => $this->authService->getIdentity(),
                'float' => 'right',
                'dropdown' => [
                    [
                        'id' => 'settings',
                        'label' => 'Ustawienia',
                        'link' => $url('application', ['action'=>'settings'])
                    ],
                    [
                        'id' => 'logout',
                        'label' => 'Wyloguj',
                        'link' => $url('logout')
                    ],
                ]
            ];
        }
        
        return $items;
    }
}


