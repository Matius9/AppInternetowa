<?php
namespace User\Validator;

use Zend\Validator\AbstractValidator;
use User\Entity\User;

class UserExistsValidator extends AbstractValidator 
{
    protected $options = array(
        'entityManager' => null,
        'user' => null
    );
    
    const NOT_SCALAR  = 'notScalar';
    const USER_EXISTS = 'userExists';
     
    protected $messageTemplates = array(
        self::NOT_SCALAR  => "Email musi być poprawny.",
        self::USER_EXISTS  => "Inny użytkownik z takim emailem już istnieje."        
    );
    
    public function __construct($options = null) 
    {
        if(is_array($options)) {            
            if(isset($options['entityManager']))
                $this->options['entityManager'] = $options['entityManager'];
            if(isset($options['user']))
                $this->options['user'] = $options['user'];
        }
        
        parent::__construct($options);
    }
        
    public function isValid($value) 
    {
        if(!is_scalar($value)) {
            $this->error(self::NOT_SCALAR);
            return false; 
        }
        
        $entityManager = $this->options['entityManager'];
        
        $user = $entityManager->getRepository(User::class)
                ->findOneByEmail($value);
        
        if($this->options['user']==null) {
            $isValid = ($user==null);
        } else {
            if($this->options['user']->getEmail()!=$value && $user!=null) 
                $isValid = false;
            else 
                $isValid = true;
        }
        
        if(!$isValid) {            
            $this->error(self::USER_EXISTS);            
        }
        
        return $isValid;
    }
}

