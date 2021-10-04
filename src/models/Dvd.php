<?php

namespace App\Models;

/**
 * Dvd - extends the Product class to provide a custom field
 *
 * @author      David Márquez <ibisdavi012@gmail.com>
 * @license     MIT
 *
 */
class Dvd extends Product
{
    protected $size = 0;

    public function __construct()
    {
        $this->parseable_attributes = array('id', 'sku', 'name', 'price', 'type');
        $this->custom_attributes = array('size');
        parent::__construct();
    }

    /**
     * Validates and sets Dvd's Size
     *
     * @param  mixed $size
     * @return bool
     */
    public function setSize($size)
    {
        return $this->setAttribute('size', $size);
    }

    /**
     * Returns the Dvd's size
     *
     * @return float
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Returns an array with the Dvd's attributes
     *
     * @return void
     */
    public function toArray()
    {

        $attributes = parent::toArray();
        $attributes['size'] = $this->getSize();
        return $attributes;
    }

    /**
     * Saves the Dvd to the Database
     *
     * @return void
     */
    public function save()
    {
        $lastInsertedId = $this->executeQuery("INSERT INTO eav_products 
        (sku,name, price, type, custom_attributes) 
    VALUES 
        (?,?,?,?,?)", array(
            $this->getSku(),
            $this->getName(),
            $this->getPrice(),
            $this->getType(),
            "{\"size\":{$this->getSize()}}"
        ));

        if ($lastInsertedId > 0) {
            $this->setId($lastInsertedId);
            return $lastInsertedId;
        }
        return null;
    }

    /**
     * TODO: Implements a new delete functionality if the databse model is changed into an EAV model.
     *
     * @return void
     */
    public function delete()
    {
    }

    /**
     * TODO: Implements a new update functionality if the databse model is changed into an EAV model.
     *
     * @return void
     */
    public function update()
    {
    }
}
