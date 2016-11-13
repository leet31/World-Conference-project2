<?php

/**
 * This class is referred from textbook
 */
class Validate {

    private $fields;

    function __construct() {
        $this->fields = new Fields();
    }

    public function getFields() {
        return $this->fields;
    }

// general text match
    public function text($name, $value, $required = true, $min = 1, $max = 255) {
        $field = $this->fields->getField($name);
        //if the textbox isn't required to fill and nothing is filled by a user
        if (!$required && empty($value)) {
            $field->clrErrorMsg();
            return;
        }
        //if the textbox is required to fill and nothing is filled by a user
        if ($required && empty($value)) {
            $field->setErrorMsg('Required');
        } else if ($required && strlen($value) < $min) {
            //if the textbox is required to fill and the length is shorter than min
            $field->setErrorMsg('Too short');
        } else if ($required && strlen($value) > $max) {
            //if the textbox is required to fill and the length is longer than max
            $fiel->setErrorMsg('Too long');
        } else {
            $field->clrErrorMsg();
        }
    }

//general pattern match
    public function pattern($name, $value, $pattern, $msg, $required = true) {
        $field = $this->fields->getField($name);
        if (!$required && empty($value)) {
            $field->clrErrorMsg();
            return;
        }
        //if required
        // need match pattern once
        if ($required) {
            $match = preg_match($pattern, $value);
            if ($match == false) {
                $field->setErrorMsg('Has an error here.');
            } else if ($match != 1) {
                $field->setErrorMsg($message);
            } else {
                $field->clrErrorMsg();
            }
        }
    }

    public function phone($name, $value, $required = true) {
        $field = $this->fields->getField($name);
        $this->text($name, $value, $required);
        if ($field->hasError()) {
            return;
        }
        //pattern for a phone number
        //$pattern = '/^[[:digit:]]{3}-[[:digit:]]{3}-[[:digit:]]{4}$/';
        $pattern='/^[0-9]{10}$/';
        $msg = 'Invalide phone number.';
        $this->pattern($name, $value, $pattern, $msg, $required);
    }

    public function email($name, $value, $required = true) {
        $field = $this->fields->getField($name);
        $this->text($name, $value, $required);
        if ($field->hasError()) {
            return;
        }
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $field = $this->setErrorMsg('The email address in not valid');
        } else {
            $field->clrErrorMsg();
        }
    }

    // only check if the password is at least length of 6
    public function password($name, $value, $required = true) {
        $field = $this->fields->getField($name);
        $this->text($name, $required, 6);
    }

    //verify if the second password is same as first one
    public function verify($name, $password, $verify, $required = true) {
        $field = $this->fields->getField($name);
        $this->text($name, $verify, $required, 6);
        if ($field->hasError()) {
            return;
        }
        if (strcmp($password, $verify) != 0) {
            $field->setErrorMsg("Password do not match");
            return;
        }
    }

    public function state($name, $value, $required = true) {
        $field = $this->fields->getField($name);
        $this->text($name, $value, $required);
        if ($field->hasError()) {
            return;
        }
        $states = array(
            'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC',
            'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY',
            'LA', 'ME', 'MA', 'MD', 'MI', 'MN', 'MS', 'MO', 'MT',
            'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH',
            'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT',
            'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
        
        $states = implode('|', $states);
        $pattern = '/^(' . $states . ')$/';
        $this->pattern($name, $value, $pattern, 'Invalid state name', $required);
    }

    public function zip($name, $value, $required = true) {
        $field = $this->fields->getField($name);
        $this->text($name, $value, $required);
        if ($field->hasError()) {
            return;
        }
        $pattern = '/^[[:digit:]]{5}(-[[:digit:]]{4})?$/';
        $msg = 'Invalid zip colde.';
        $this->pattern($name, $value, $pattern, $msg, $required);
    }

    public function cardType($name, $value, $required = true) {
        $field = $this->fields->getField($name);
        if (empty($value)) {
            $field->setErrorMsg('Please select a card type.');
            return;
        }
        $types = array('m', 'v', 'a', 'd');
        $types = implode('|', $types);
        $pattern = '/^(' . $types . ')$/';
        $this->pattern($name, $value, $pattern, 'Invalide card type');
    }

    public function cardNumber($name, $value, $type, $required = true) {
        $field = $this->fields->getField($name);
        switch ($type) {
            case 'm'://MasterCard
                $prefixes = '51-55';
                $lengths = '16';
                break;
            case 'v'://visa
                $prefixes = '4';
                $lengths = '13, 16';
                break;
            case 'a'://american express
                $prefixes = '6011,622126-622925,644-649,65';
                $lengths = '16';
                break;
            case '': //No card type selected.
                $field->clrErrorMsg();
                return;
            default:
                $field->setErrorMsg('Invalid card type.');
                return;
        }
        //check lengths
        $lengths = explode(',', $length);
        foreach ($lengths as $length) {
            $pattern = '/^[[:digit:]]{' . $length . '}$/';
            $msg = 'Invalide card number length';
            $this->pattern($name, $length, $pattern, $msg);
            if ($field->hasError()) {
                return;
            }
        }
        // check card prefix
        $prefixes = explode(',', $prefixes);
        $rangePattern = '/^[[:digit:]]+-[[:digit:]]+$/';
        foreach ($prefixes as $prefix) {
            $this->pattern($name, $prefix, $rangePattern, $msg);
            if (!$field->hasError()) {//prefix is a range pattern
                $range = explode('-', $prefix);
                $start = intval($range[0]);
                $end = intval($range[1]);
                $msg = 'Card number prefix is not valid.';
                for ($prefix = $start; $prefix <= $end; $prefix++) {
                    $pattern = '/^' . $prefix . '/';
                    $this->pattern($name, $value, $pattern, $msg, $required);
                    if ($field->hasError()) {
                        return;
                    }
                }
            }else {// prefix is not a range pattern
                $pattern='/^'.$prefix.'/';
                $msg = 'Card number prfix is not avalid.';
                $this->pattern($name, $value, $pattern, $msg, $required);
            }
        }
        
        //validate checksum
        $sum=0;
        $length=strlen($value);
        for ($i = 0; $i <$length;$i++) {
            $digit = intval($value[$length - $i - 1]);
            $digit=$i%2 == 1 ? $digit*2:$digit;
            $digit=($digit>9)?$digit-9:$digit;
            $sum+= $digit;
        }
        if ($sum%10 !=0) {
            $field->setErrorMsg('Invalid card number checksum.');
            return;
        }
        $field->clrErrorMsg();
    }
    public function expDate($name, $value) {
        $field= $this->fields->getField($name);
        $dataPattern ='/^(0[1-9]|1[012])\/[1-9][[:digit:]]{3}?$/';
        $msg = 'Invalid data format';
        $this->pattern($name, $value, $dataPattern, $msg);
        if($field->hasError()){
            return;
        }
        //date matches
        $dataParts = explode('/', $value);
        $month = $dataParts[0];
        $year = $dateParts[1];
        $dateString = $month.'/01/'.$year.' last day of 23:59:59';
        $exp = new \DateTime($dataString);
        $now = new \DateTime();
        if ($exp < $now) {
            $field->setErrorMsg('Card is expired.');
            return;
        }
        $field->clrErrorMsg();           
    }
    //attendee is an array
    public function attendee($name, $value, $required = true){
        $field = $this->fields->getField($name);
        if (isset($value)) {
            $field->clrErrorMsg();
        } else {
            $field->setErrorMsg('Please pick at least one.');
        }
    }

}
