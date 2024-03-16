<?php
    class FuelQuoteModule
    {
        private $data;
        private $gallons = 0;
        private $address = "123HillLane";
        private $date = "03/28/2024";
        private $suggestPrice = -1;
        private $totalPrice =-1;

        public function __construct($post_data)
        {
            $this->data = $post_data;
            
        }
        public function getData()
        {
            return $this->data;
        }
        public function setGallons($gal){
            $this->gallons = $gal;
        }
        public function setAddress($addressParam){
            $this->address = $addressParam;
        }
        public function setDate($dateParam){
            $this->address = $dateParam;
        }
        public function setSuggestPrice($price){
            $this->suggestPrice = $price;
        }
        public function setTotalPrice($price){
            $this->totalPrice = $price;
        }
        public function getGallons()
        {
            return $this->gallons;
        }
        public function getAddress()
        {
            return $this->address;
        }
        public function getDate()
        {
            return $this->date;
        }
        public function getSuggestedPrice()
        {
            return $this->suggestPrice;
        }
        public function getTotalPrice()
        {
            return $this->totalPrice;
        }

    }
    class pricingModule
    {

    }
?>