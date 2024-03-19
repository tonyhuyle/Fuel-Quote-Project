<?php
    namespace PhpFiles;
    #require __DIR__ . "/FuelQuoteModule.php";
    use PhpFiles\FuelQuoteModule as Module;

    class FuelQuoteValidation
    {
        private $FuelQuote;
        private $errors = array();
        private $fields = ['gallons','address','date'];

        public function __construct($FuelQuote)
        {
            $this->FuelQuote = $FuelQuote;
            
        }
        public function errors()
        {
            return $this->errors;
        }
        public function is_valid()
        {
            foreach(self::$fields as $field)
            {
                if(!array_key_exists($field, $this->FuelQuote))
                {
                    trigger_error("$field is not present in data");
                    return;
                }
            }
            $this->validateGallons();
            $this->validateAddress();
            $this->validateDate();
            return $this->errors();

        }
        public function validateGallons()
        {
            $regex = "/^[0-9]+$/";
            $regex2 = "/^[0-9]+\.[0-9]$/";
            $value = trim($this->FuelQuote['gallons'] ?? "");
            if(empty($value))
            {
                $this->appendErrors('gallons', "There needs to be a positive amount of gallons submitted");
            }
            else if((!(preg_match($regex, $value) or preg_match($regex2, $value))))
            {
                $this->appendErrors('gallons', "There needs to be a positive amount of gallons submitted in the form of either an positive integer or a decimal with one decimal place");
            }
        }
        public function validateAddress()
        {

        }
        public function validateDate()
        {
            $regex = "/^[0-9]{2,4}+\-[0-9]{2}+\-[0-9]{2}+$/";
            $potentialDate = htmlspecialchars($this->FuelQuote['date'] ?? "");
            $potentialDate = trim($potentialDate);
            if(empty($potentialDate))
            {
                $this->appendErrors('date', "There is no date input given!");
            }
            if(preg_match($regex, $potentialDate))
            {
                list($Year, $month, $day) = explode('-', $potentialDate);
                if(checkdate($Year, $month, $day))
                {
                    $currentDate = date("Y-M-D");
                    $date1YearFuture = date('Y-M-D', strtotime('+1 year'));
                    if($potentialDate < $currentDate) //Date is already passed! Append an Error!
                    {
                        $this->appendErrors('date', "This date has already passed! Please enter a valid date!");
                    }
                    else if($potentialDate > $date1YearFuture) //Date can't be more than 1 year in future! Append an Error. 
                    {
                        $this->appendErrors('date', "This date is too far into the future! Please enter a valid date that is less than 1 year into the future!");
                    }
                }
            }
            else
            {
                $this->appendErrors('date', "This input is not a valid date! Please input a valid date from our date picker!");
            }
        }
        public function appendErrors($key, $value)
        {
            $this->errors[$key] = $value;
        }
        
    }
?>