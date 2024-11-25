<?php

namespace App\Models;

class Photo
{
    private string $url;

    public function __construct(string $url)
    {
        $this->setUrl($url);
    }

    /**
     * Get the value of url
     */ 
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of url
     *
     * @return  self
     */ 
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}