<?php

namespace App\Models;

/**
 * ProductModel - All product models extends this Model.
 *
 * @author      David Márquez <ibisdavi012@gmail.com>
 * @license     MIT
 *
 */
abstract class ProductModel extends BaseModel
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct('eav_products');
    }

    /**
     * __destruct
     *
     * @return void
     */
    public function __destruct()
    {
        $this->db_connection_handle = null;
    }

    /**
     * Find All Products
     *
     * @return void
     */
    public function findAll()
    {
        $products = array();
        $productList = parent::findAll();

        if ($productList != null) {
            for ($index = 0; $index < count($productList); $index++) {
                $productType = "App\\Models\\" . ucfirst($productList[$index]['type']);
                $product = !class_exists($productType, true) ? new Product() : new $productType();
                $product->parse($productList[$index]);
                $products[] = $product;
            }

            return $products;
        }
    }


    abstract public function toArray();
}
