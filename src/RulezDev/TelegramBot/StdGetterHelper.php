<?php

namespace RulezDev\TelegramBot;


class StdGetterHelper
{
    /**
     * @var array
     */
    protected $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function getAttribute($key, $default = null)
    {
        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }

    public function getAttributes()
    {
        return $this->data;
    }
}