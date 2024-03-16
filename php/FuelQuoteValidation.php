<?php
    class FuelQuoteValidation
    {
        private $FuelQuote;
        private $errors = array();
        private $fields = ['gallons','address','date'];

        public function __construct(FuelQuoteModule $FuelQuote)
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
                if(!array_key_exists($field, $this->FuelQuote->getdata()))
                {
                    trigger_error("$field is not present in data");
                    return;
                }
            }
            $this->validateGallons();
            $this->validateAddress();
            return $this->errors();

        }
        private function validateGallons()
        {

        }
        private function validateAddress()
        {

        }
        private function validateDate()
        {

        }
    }
?>