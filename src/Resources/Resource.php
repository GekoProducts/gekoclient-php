<?php

namespace GekoProducts\HttpClient\Resources;

abstract class Resource
{
    protected $attributes;

    /**
     * Order constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getAttribute(string $key, $default = null)
    {
        if (!array_key_exists($key, $this->attributes)) {
            return $default;
        }

        return $this->attributes[$key];
    }

    public function __get($name)
    {
        return $this->getAttribute($name, null);
    }
}
