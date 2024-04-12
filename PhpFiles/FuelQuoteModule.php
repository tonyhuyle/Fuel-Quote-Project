<?php
    namespace PhpFiles;
    class FuelQuoteModule
    {
        private $data;
        private $gallons = 0;
        private $address = "123HillLane";
        private $date = "03/28/2024";
        private $suggestPrice = 3.02;
        private $totalPrice = 0;
        private $errors = array();
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
            $this->setSuggestPrice(3.02);
            $this->setTotalPrice($this->getGallons() * $this->getSuggestedPrice());
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
        public function InsertFuelQuote($CurrentUser)
        {
            $this->setUp();
            $pdo = $this->pdo;
            try{
            $pdo->beginTransaction();
            $psCompliantDate = (new \DateTime($this->getDate()))->format('Y-m-d');
            $stmt = $pdo->prepare('INSERT INTO fuelquotehistory (userid, gallonsrequested, deliveryaddress, requestdate, deliverydate, suggestedprice, totalamountdue) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $params = array($CurrentUser, $this->getGallons(), $this->getAddress(), date('Y/m/d'), $psCompliantDate, $this->getSuggestedPrice(), $this->getTotalPrice());
            $stmt->execute($params);
            $pdo->commit();
            }
            catch(\PDOException $e)
            {
                $pdo->rollBack();
                throw $e;
            }
            /*
            $params = array($this->getDate(), $this->getAddress(), $this->getGallons(), $this->getSuggestedPrice(), $this->getTotalPrice(), $CurrentUser);
            $db_connection = pg_connect("host=localhost dbname=myDB user=postgres password=root"); //change myDB to postgres
            if(!$db_connection) // If connection failed
            {
                $this->errors["Connection Exectution Error:"] = "Failed to Connect to DB: ";
            }
            else 
            {
                $result = pg_query_params($db_connection, 'INSERT INTO public."History" ("DeliveryDate", "StreetAddress", "Gallons_Request", "Price_Per_Gallon", "Total_Price", "Username") 
                VALUES ($1, $2, $3, $4, $5, $6)', $params); //change to postgres.
                if(!$result) // If Insert query failed
                {
                    $this->errors["Query Exectution Error:"] = "Failed to Execute Query: ";
                }
            }
            /*
            $test = 'SELECT COUNT(*) FROM public."History"';
            $testResult = pg_query($db_connection, $test);
            if(!$testResult)
            {
                echo "Failed to count Rows";
                return;
            }
            
            $row = pg_fetch_row($testResult);
            $row_count = $row[0];
            pg_close($db_connection);
            */
        }
        public function getErrors()
        {
            return $this->errors;
        }

    }
    class pricingModule
    {

    }
?>