<?php

// not used in our codebase, our team was not able to find the time and knowledge to implement this class

class Model
{

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * Fill model properties from an associative array
     * @param array $data Associative array of properties to fill
     * @return Model Returns $this for method chaining
     */
    public function fill(array $data): Model
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    public function validate(): array
    {
        return [];
    }

    public function isValid(): bool
    {
        return empty($this->validate());
    }

    public function __toString(): string
    {
        return get_class($this) . ': ' . json_encode($this->toArray());
    }
}