<?php
class Product extends Model {
    public $id;
    public $name;
    public $price;
    
    public function validate(): array {
        $errors = [];
        if (empty($this->name)) {
            $errors[] = "Name is required";
        }
        if (!is_numeric($this->price) || $this->price <= 0) {
            $errors[] = "Price must be a positive number";
        }
        return $errors;
    }
}