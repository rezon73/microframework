<?php

abstract class Model
{
    protected $data = [];

    public function __get($field)
    {
        if (!isset($this->data[$field])) {
            return null;
        }

        return $this->data[$field];
    }

    public function __set($field, $value)
    {
        $this->data[$field] = $value;

        return $this;
    }

    public function import(array $data)
    {
        $this->data = $data;

        return $this;
    }
}