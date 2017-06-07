<?php
namespace Blog\Form;

use Zend\Form\Fieldset;

use Blog\Model\Post;
use Zend\Hydrator\Reflection as ReflectionHydrator;

class PostFieldset extends Fieldset
{
    public function init()
    {
        $this->setHydrator(new ReflectionHydrator());
        $this->setObject(new Post('', '', '', ''));
        
        $this->add([
            'name' => 'id',
            'type' => 'hidden',
            
        ]);
        
        $this->add([
            'name' => 'title',
            'type' => 'text',
            'option' => [
                'label' => 'Tytuł',
            ],
        ]);
        
        $this->add([
            'name' => 'text',
            'type' => 'textarea',
            'option' => [
                'label' => 'Treść artykułu',
            ],
        ]);
        
        $this->add([
            'name' => 'aDate',
            'type' => 'date',
            'attributes' => [
                'value' => date("y-m-d"),
                //'value' => date("Y-m-d H:i:s"),
            ],            
        ]);
        
        $this->add([
            'name' => 'author',
            'type' => 'text',
            'attributes' => [
                'value' => 'Admin'
            ],
        ]);
    }
}