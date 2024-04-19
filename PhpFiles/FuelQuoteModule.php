<?php
    namespace PhpFiles;
    require(__DIR__ .'/FuelPricingModule.php');
    use PhpFiles\FuelPricingModule as PricingModule;
    class FuelQuoteModule
    {
        private $data;
        private $gallons = 0;
        private $address = "123HillLane";
        private $address2 = "";
        private $date = "03/28/2024";
        private $suggestPricePerGallon = 1.50;
        private $totalPrice;
        private $state;
        private $city;
        private $zipcode;
        private $errors = array();
        private $pricingMod;
        protected $pdo;
        protected function setUp(): void
        {
            require __DIR__ . '/../dist/connection.php';
            $this->pdo = $pdo;
        }

        public function __construct($post_data)
        {
            $this->data = $post_data;
            $this->setGallons($this->data["gallons"]);
            $this->setAddress($this->data["address"]);
            $this->setDate($this->data["date"]);
            $this->setState($this->data["state"]);
            $this->setAddress2($this->data["address2"]);
            $this->setZipcode($this->data["zip"]);
            $this->setCity($this->data["city"]);
            $this->setTotalPrice($this->suggestPricePerGallon * $this->gallons);
            #$this->pricingMod = new PricingModule($post_data);
            #$this->suggestPricePerGallon = $this->pricingMod->getSuggestedPricePerGallon();
           #$this->totalPrice = $this->pricingMod->getTotalPrice();
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
            $this->date = $dateParam;
        }
        public function setSuggestPrice($price){
            $this->suggestPricePerGallon = $price;
        }
        public function setTotalPrice($price){
            $this->totalPrice = $price;
        }
        public function setState($_state)
        {
            $this->state = $_state;
        }
        public function setZipcode($_zip)
        {
            $this->zipcode= $_zip;
        }
        public function setCity($_city)
        {
            $this->city= $_city;
        }
        public function setAddress2($_address2)
        {
            $this->address2= $_address2;
        }
        public function getGallons()
        {
            return $this->gallons;
        }
        public function getAddress()
        {
            return $this->address;
        }
        public function getAddress2()
        {
            return $this->address2;
        }
        public function getCity()
        {
            return $this->city;
        }
        public function getState()
        {
            return $this->state;
        }
        public function getZipcode()
        {
            return $this->zipcode;
        }
        public function getDate()
        {
            return $this->date;
        }
        public function getSuggestedPrice()
        {
            return $this->suggestPricePerGallon;
        }
        public function getTotalPrice()
        {
            return $this->totalPrice;
        }
        public function InsertFuelQuote($CurrentUser)
        {
            $this->setUp();
            $pdo = $this->pdo;
            try{
            $pdo->beginTransaction();
            $psCompliantDate = (new \DateTime($this->getDate()))->format('Y-m-d');
            $stmt = $pdo->prepare('INSERT INTO fuelquotehistory (userid, gallonsrequested, deliveryaddress, requestdate, deliverydate, suggestedprice, totalamountdue) VALUES (?, ?, ?, ?, ?, ?, ?) RETURNING quoteid');
            $params = array($CurrentUser, $this->getGallons(), $this->getAddress(), date('Y/m/d'), $psCompliantDate, $this->getSuggestedPrice(), $this->getTotalPrice());
            $stmt->execute($params);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $quoteId = $result["quoteid"];
            $pdo->commit();
            }
            catch(\PDOException $e)
            {
                $pdo->rollBack();
                throw $e;
            }
        }
        public function getErrors()
        {
            return $this->errors;
        }

    }
?>