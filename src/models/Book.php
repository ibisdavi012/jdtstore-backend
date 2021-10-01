<?php

namespace App\Models;

/**
 * Book - extends the Product class to provide a custom field
 *
 * @author      David Márquez <ibisdavi012@gmail.com>
 * @license     MIT
 *
 */
class Book extends Product
{
    protected $weight = 0;

    public function __construct()
    {
        $this->parseable_attributes = array('id', 'sku', 'name', 'price', 'type');
        $this->custom_attributes = array('weight');
        parent::__construct();
    }

    /**
     * Validates and sets the Weight
     *
     * @param  float $weight
     * @return bool
     */
    public function setWeight($weight)
    {
        return $this->setAttribute('weight', $weight);
    }

    /**
     * Returns Book's weight
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Generates and returns an array with the attributes of the book
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = parent::toArray();
        $attributes['weight'] = $this->getWeight();
        return $attributes;
    }

    /**
     * Saves the book to the database and returns the new ID
     *
     * @return int
     */
    public function save()
    {
        $insert_id = $this->executeQuery("INSERT INTO eav_products 
        (sku,name, price, type, custom_attributes) 
    VALUES 
        (?,?,?,?,?)", array(
            $this->getSku(),
            $this->getName(),
            $this->getPrice(),
            $this->getType(),
            "{\"weight\":{$this->getWeight()}}"
        ));
        if ($insert_id > 0) {
            $this->setId($insert_id);
            return $insert_id;
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
