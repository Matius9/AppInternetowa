<?php
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User 
{
    const STATUS_ACTIVE       = 1;
    const STATUS_RETIRED      = 2;
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** 
     * @ORM\Column(name="email")  
     */
    protected $email;
    
    /** 
     * @ORM\Column(name="full_name")  
     */
    protected $fullName;

    /** 
     * @ORM\Column(name="password")  
     */
    protected $password;

    /** 
     * @ORM\Column(name="status")  
     */
    protected $status;
    
    /**
     * @ORM\Column(name="date_created")  
     */
    protected $dateCreated;
        
    /**
     * @ORM\Column(name="pwd_reset_token")  
     */
    protected $passwordResetToken;
    
    /**
     * @ORM\Column(name="pwd_reset_token_creation_date")  
     */
    protected $passwordResetTokenCreationDate;
    
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getEmail() 
    {
        return $this->email;
    }

    public function setEmail($email) 
    {
        $this->email = $email;
    }
    
    public function getFullName() 
    {
        return $this->fullName;
    }       

    public function setFullName($fullName) 
    {
        $this->fullName = $fullName;
    }
    
    public function getStatus() 
    {
        return $this->status;
    }

    public static function getStatusList() 
    {
        return [
            self::STATUS_ACTIVE => 'Aktywny',
            self::STATUS_RETIRED => 'Nieaktywny'
        ];
    }    
    
    public function getStatusAsString()
    {
        $list = self::getStatusList();
        if (isset($list[$this->status]))
            return $list[$this->status];
        
        return 'Nieznany';
    }    
    
    public function setStatus($status) 
    {
        $this->status = $status;
    }   
    
    public function getPassword() 
    {
       return $this->password; 
    }
    public function setPassword($password) 
    {
        $this->password = $password;
    }
    
    public function getDateCreated() 
    {
        return $this->dateCreated;
    }
    
    public function setDateCreated($dateCreated) 
    {
        $this->dateCreated = $dateCreated;
    }    
    
    public function getResetPasswordToken()
    {
        return $this->passwordResetToken;
    }
    
    public function setPasswordResetToken($token) 
    {
        $this->passwordResetToken = $token;
    }
    
    public function getPasswordResetTokenCreationDate()
    {
        return $this->passwordResetTokenCreationDate;
    }
    
    public function setPasswordResetTokenCreationDate($date) 
    {
        $this->passwordResetTokenCreationDate = $date;
    }
}



