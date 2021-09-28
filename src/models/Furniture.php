<?php

namespace App\Models;

/**
 * Furniture - extends the Product class to provide customs field
 *
 * @author      David Márquez <ibisdavi012@gmail.com>
 * @license     MIT
 *
 */
class Furniture extends Product
{
    protected $height = 0;
    protected $width = 0;
    protected $length = 0;

    public function __construct()
    {

        $this->parseable_attributes = array('id', 'sku', 'name', 'price', 'type');
        $this->custom_attributes = array('height', 'width', 'length');
        parent::__construct();
    }

    /**
     * Validates and sets Height
     *
     * @param  mixed $height
     * @return bool
     */
    public function setHeight($height)
    {
        return $this->setAttribute('height', $height, 'cm');
    }

    /**
     * Returns furniture's height
     *
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Validates and sets furniture's width
     *
     * @param  mixed $width
     * @return bool
     */
    public function setWidth($width)
    {
        return $this->setAttribute('width', $width, 'cm');
    }

    /**
     * Returns Furniture's width
     *
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }


    /**
     * Validates and sets furniture's Length
     *
     * @param  mixed $length
     * @return bool
     */
    public function setLength($length)
    {
        return $this->setAttribute('length', $length, 'cm');
    }

    /**
     * Returns furnitures's length
     *
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }

    public function toArray()
    {

        $attributes = parent::toArray();
        $attributes['height'] = $this->getHeight();
        $attributes['width'] = $this->getWidth();
        $attributes['length'] = $this->getLength();
        return $attributes;
    }

    public function save()
    {

        $save = $this->executeQuery("INSERT INTO eav_products 
                                (sku,name, price, type, custom_attributes) 
                            VALUES 
                                (?,?,?,?,?)", array(
            $this->getSku(),
            $this->getName(),
            $this->getPrice(),
            $this->getType(),
            "{\"height\":{$this->getHeight()},
                                        \"width\":{$this->getWidth()},
                                        \"length\":{$this->getLength()}}",
        ));
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
