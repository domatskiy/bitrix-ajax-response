<?php

namespace Domatskiy\AjaxResponse;

class Result implements \Serializable
{
    protected $errors = array();
    protected $data;
    protected $code = 422;

    function __construct()
    {

    }

    public function serialize() {

        return '';
    }

    public function unserialize($data) {


    }

    public function __toString()
    {
        return ''.print_r($this->data, true);
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getResponseCode()
    {
        return $this->code;
    }

    public function setResponseCode($code)
    {
        $this->code = $code;
    }

    public function setError($message, $key = '')
    {
        if(is_string($key) && $key)
            $this->errors[$key] = $message;
        else
            $this->errors[] = $message;

    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isSuccess()
    {
        return empty($this->errors);
    }

}