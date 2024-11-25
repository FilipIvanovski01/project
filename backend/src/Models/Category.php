<?php

namespace App\Models;

class Category
{
    private string $name;

    public function __construct(string $name)
    {
        $this->setName($name);
    }


    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}