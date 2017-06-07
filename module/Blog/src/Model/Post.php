<?php

namespace Blog\Model;

class Post
{
    private $id;
    private $title;
    private $text;
    private $aDate;
    private $author;
    private $inputFilter;
    
    public function __construct($title, $text, $aDate, $author, $id = null)
    {
        $this->title = $title;
        $this->text = $text;
        $this->aDate = $aDate;
        $this->author = $author;
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function getText()
    {
        return $this->text;
    }
    
    public function getADate()
    {
        return $this->aDate;
    }
    
    public function getAuthor()
    {
        return $this->author;
    }
    
    
}