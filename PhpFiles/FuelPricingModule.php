<?php
namespace PhpFiles;
class FuelPricingModule
{
    private int $gallons;
    private float $basePricePerGallon = 1.50;
    private float $totalPrice;
    private float $locationFactor;
    private float $rateHistoryFactor;
    private float $companyProfitFactor = 0.1;
    private float $gallonsRequestedFactor;
    private float $suggestedPricePerGallon;

    public function __construct($_data)
    {
        $this->gallons = $_data["gallons"];
        if($_data["state"] != "TX")
            $this->locationFactor = 0.04;
        else
            $this->locationFactor = 0.02;
        if($_data["hasHistory"] == true)
            $this->rateHistoryFactor = 0.01;
        else
            $this->rateHistoryFactor = 0.0;
        if($this->gallons > 1000)
            $this->gallonsRequestedFactor = 0.02;
        else
            $this->gallonsRequestedFactor = 0.03;
        $this->calculatePricing();
    }
    public function update($_data)
    {
        $this->gallons = $_data["gallons"];
        if($_data["state"] != "TX")
            $this->locationFactor = 0.04;
        else
            $this->locationFactor = 0.02;
        if($_data["hasHistory"] == true)
            $this->rateHistoryFactor = 0.0;
        else
            $this->rateHistoryFactor = 0.01;
        if($this->gallons > 1000)
            $this->gallonsRequestedFactor = 0.02;
        else
            $this->gallonsRequestedFactor = 0.03;
        $this->calculatePricing();
        
    }
    public function calculatePricing()
    {
        $this->suggestedPricePerGallon = $this->basePricePerGallon + ($this->basePricePerGallon * ($this->locationFactor - $this->rateHistoryFactor + $this->gallonsRequestedFactor + $this->companyProfitFactor));
        $this->totalPrice = $this->suggestedPricePerGallon * $this->gallons;
    }
    public function getSuggestedPricePerGallon()
    {
        return $this->suggestedPricePerGallon;
    }
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    

}