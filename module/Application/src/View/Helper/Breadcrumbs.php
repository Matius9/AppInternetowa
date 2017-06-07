<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This view helper class displays breadcrumbs.
 */
class Breadcrumbs extends AbstractHelper 
{
    private $items = [];
    
    public function __construct($items=[]) 
    {                
        $this->items = $items;
    }
    
    public function setItems($items) 
    {
        $this->items = $items;
    }
    
    public function render() 
    {
        if (count($this->items)==0)
            return '';
        
        $result = '<ol class="breadcrumb">';
        $itemCount = count($this->items); 
        $itemNum = 1;
        
        foreach ($this->items as $label=>$link) {
            
            $isActive = ($itemNum==$itemCount?true:false);
            $result .= $this->renderItem($label, $link, $isActive);
            $itemNum++;
        }
        
        $result .= '</ol>';
        
        return $result;
        
    }
    
    protected function renderItem($label, $link, $isActive) 
    {
        $escapeHtml = $this->getView()->plugin('escapeHtml');
        
        $result = $isActive?'<li class="active">':'<li>';
        
        if (!$isActive)
            $result .= '<a href="'.$escapeHtml($link).'">'.$escapeHtml($label).'</a>';
        else
            $result .= $escapeHtml($label);
                    
        $result .= '</li>';
    
        return $result;
    }
}
