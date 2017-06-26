<?php

namespace App;

class Card extends Model
{
    private $category;
    private $value;

    public function __construct($category, $value){
        $this->category = $category;
        $this->value = $value;
    }

    public function getCategory(){
        return $this->category;
    }

    public function getValue(){
        return $this->value;
    }

    public function setCategory($category){
        $this->category = $category;
    }

    public function setValue($value){
        $this->value = $value;
    }
    
}
