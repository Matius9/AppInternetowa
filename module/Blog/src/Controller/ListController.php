<?php

namespace Blog\Controller;

use Blog\Model\PostRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ListController extends AbstractActionController
{
    private $postRepository;
    private $authService;
    
    public function __construct(PostRepositoryInterface $postRepository, $authService)
    {
        $this->postRepository = $postRepository;
        $this->authService = $authService;
    }
    
    public function indexAction()
    {
        if ($this->authService->hasIdentity()){
            $lo = true;
        } else {
            $lo = false;
        }
        
        $paginator = $this->postRepository->findAllPosts(true);
        
        $page = (int) $this->params()->fromQuery('page', 1);
        $page = ($page < 1) ? 1 : $page;
        $paginator->setCurrentPageNumber($page);

        $paginator->setItemCountPerPage(10);
        
        return new ViewModel([
            'paginator' => $paginator,
            'lo' => $lo,
        ]);
    }
    public function detailAction()
    {
        $id = $this->params()->fromRoute('id');
        
        try {
            $post = $this->postRepository->findPost($id);
        } catch(\InvalidArgumentException $e) {
            return $this->redirect()->toRoute('blog');
        }
        
        return new ViewModel([
            'post' => $post,
        ]);
        
        
    }
}