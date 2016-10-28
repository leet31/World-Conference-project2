<?php
class Field{
    private $name;
    private $msg = '';
    private $isError = false;
            
    function __construct($name, $message='') {
        $this->name = $name;
        $this->msg = $message;
    }
    public function getName() { 
        return $this->name;
    }
    public function getMsg() { 
        return $this->msg;
    }
    public function getIsError() {
        return $this->isError;
    }
    public function setName($name) {
        $this->name = $name;
        $this->isError = false;
    }
    public function setErrorMsg($msg) {
        $this->msg = $msg;
        $this->isError = true;
    }
    public function clrErrorMsg($error) {
        $this->msg = '';
        $this->isError=false;
    }
}
class Fields {
    private $fields = array();
    function __construct() {
    }
    public function addField ($name, $msg = '') {
        $field = new Field($name, $msg);
        $this->fields[$name] = $field;
    }
    public function getField ($name) {
        return $this->fields[$name];
    }
    public function hasErrors() {
        foreach ($this->$fields as $field) {
            if ($field->getIsError()) {
                return true;
            }
        }
        return false;
    }
}

