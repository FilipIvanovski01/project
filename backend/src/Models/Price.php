<?php

namespace App\Models;

class Price 
{
    private float $amount;
    private string $currencyLabel;
    private string $currencySymbol;

    public function __construct(float $amount, string $currencyLabel, string $currencySymbol)
    {
        $this->setAmount($amount);
        $this->setCurrencyLabel($currencyLabel);
        $this->setCurrencySymbol($currencySymbol);
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */ 
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of currencyLabel
     */ 
    public function getCurrencyLabel()
    {
        return $this->currencyLabel;
    }

    /**
     * Set the value of currencyLabel
     *
     * @return  self
     */ 
    public function setCurrencyLabel($currencyLabel)
    {
        $this->currencyLabel = $currencyLabel;

        return $this;
    }

    /**
     * Get the value of currencySymbol
     */ 
    public function getCurrencySymbol()
    {
        return $this->currencySymbol;
    }

    /**
     * Set the value of currencySymbol
     *
     * @return  self
     */ 
    public function setCurrencySymbol($currencySymbol)
    {
        $this->currencySymbol = $currencySymbol;

        return $this;
    }
}