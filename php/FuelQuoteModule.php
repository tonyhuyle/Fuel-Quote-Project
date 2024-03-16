<?php
    class FuelQuote
    {
        private $gallons = 0;
        private $address = "123HillLane";
        private $date = "03/28/2024";
        private $suggestPrice;
        private $totalPrice;

        public function setGallons($gal){
            $gallons = $gal;
        }
        public function setAddress($addressParam){
            $address = $addressParam;
        }
        public function setDate($dateParam){
            $address = $dateParam;
        }
        public function setSuggestPrice($price){
            $suggestPrice = $price;
        }
        public function setTotalPrice($price){
            $totalprice = $price;
        }
        public function getGallons()
        {
            return $gallons;
        }
        public function getAddress()
        {
            return $address;
        }
        public function getDate()
        {
            return $date;
        }
        public function getSuggestedPrice()
        {
            return $suggestPrice;
        }
        public function getTotalPrice()
        {
            return $totalPrice;
        }

    }
?>