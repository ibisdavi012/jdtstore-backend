<?php

namespace App\Models;

/**
 * Product - Basic Product Model without custom attributes
 *
 * @author      David Márquez <ibisdavi012@gmail.com>
 * @license     MIT
 *
 */
class Product extends ProductModel
{
    protected $id = null;
    protected $sku = '';
    protected $name = '';
    protected $price = 0;
    protected $type = 'dvd';

    public function __construct()
    {
        parent::__construct('eav_products');
    }


    /**
     * Set ID
     *
     * @param  mixed $id
     * @return bool
     */
    public function setId($id)
    {
        if (!is_numeric($id)) {
            $this->errors[] = 'Id is invalid';
            return false;
        }
        $this->id = intval($id);
        return true;
    }

    /**
     * Returns the product ID
     *
     * @return void
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Validate the input and sets the SKU field
     *
     * @param  string $sku
     * @return bool
     */
    public function setSku($sku)
    {
        $validSku = preg_match('/^[a-z0-9]{10,20}$/i', $sku);
        if (!$validSku) {
            $this->errors['sku'] = 'SKU is not valid. It must be an alphanumeric value between 10 and 20 characters.';
            return false;
        }
        $this->sku = $sku;
        return true;
    }

    /**
     * Returns the SKU value of the product
     *
     * @return string
     */
    public function getSku()
    {

        return $this->sku;
    }

    /**
     * Validate and sets the Name field
     *
     * @param  mixed $name
     * @return bool
     */
    public function setName($name)
    {

        $isValid = true;
        $alphanumeric = preg_match('/^[a-zA-Z0-9\s]{5,15}$/i', $name);
        if (!$alphanumeric) {
            $this->errors['name'] = 'Invalid value. It must be an alphanumeric string between 5 and 15 characters.';
            return false;
        }

        $consecutiveSpacing = preg_match('/(\s+){2}/', $name);
        if ($consecutiveSpacing) {
            $this->errors['name'] = 'It contains to many blank spaces in a row.';
            return false;
        }

        $this->name = $name;
        return true;
    }

    /**
     * Returns the name of the product
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Validates and set the product's price
     *
     * @param  mixed $price
     * @return bool
     */
    public function setPrice($price)
    {

        if (!is_numeric($price)) {
            $this->errors['price'] = 'Invalid format. It must be a valid number in the Standard American format. Ex. 1,000.00 / 34.75';
            return false;
        }

        $this->price = (float)$price;
        return true;
    }

    /**
     * Returns the product's price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * Validate and sets the product's type
     *
     * @param  string $type
     * @return bool
     */
    public function setType($type)
    {
        if (!in_array($type, array('dvd', 'book', 'furniture'))) {
            $this->errors['type'] = 'Type does not exist';
            return false;
        }
        $this->type = $type;
        return true;
    }

    /**
     * Returns the product's type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Returns an array with a key/value pairs corresponding to
     * the product's fields and their values.
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'type' => $this->getType()
        );
    }

    /**
     * Vsalidate and sets an attribute
     *
     * @param  string $attribute
     * @param  float $value
     * @param  string $unit
     * @return void
     */
    protected function setAttribute($attribute, $value, $unit)
    {

        $validValue = preg_match("/^(\d+|\d+\.[\d]{1,2})\s{0,1}($unit){0,1}$/i", $value);
        if (!$validValue) {
            $this->errors[$attribute] = "It must be express in $unit. Follow the format: 12$unit / 15 $unit / 25.10$unit / 17.23 $unit";
            return false;
        }

        if (is_string($value)) {
            $this->{$attribute} = (float)trim(preg_replace('/[a-zA-Z]/', '', $value));
        } else {
            $this->{$attribute} = (float)$value;
        }

        return true;
    }

    /**
     * SAves the product into the database
     *
     * @return void
     */
    public function save()
    {
        $saveResult = $this->executeQuery("INSERT INTO products 
        (sku,name, price, type, custom_attributes) 
    VALUES 
        (?,?,?,?)", array(
            $this->getSku(),
            $this->getName(),
            $this->getPrice(),
            $this->getType()
        ));

        return $saveResult;
    }

    /**
     * Deletes the current product from the database
     *
     * @return void
     */
    public function delete()
    {
        if ($this->id === null) {
            $this->errors['id'] = 'You must specify a valid ID.';
            return false;
        }

        return  $this->deleteById($this->getId());
    }

    /**
     * TODO: Update Product Information
     *
     * @return void
     */
    public function update()
    {
    }
}
