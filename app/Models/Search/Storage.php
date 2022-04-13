<?php

namespace App\Models\Search;
use App\Models\Search\IStorage;

class Storage implements IStorage
{
    protected $connection_options;
    protected $request_url;
    protected $auth_params;

    public $products;
    public $brands;
    public $error_log;

    public function __construct( $connection_options = null )
    {
        if (!is_null($connection_options))
        {
            $this->connection_options = $connection_options;
            $this->authenticate();
        }
    }

    public function appendBrand( $brandArr ) {

        $brand = new Brand( $brandArr );

        if ($brand->valid())
            $this->brands[] = $brand;
    }

    public function appendProduct( $productArr ) {

        $product = new Product( $productArr );

        if ($product->valid())
            $this->products[] = $product;
    }

    public function authenticate() {

    }

    function getBrands( $article ) {

    }

    function getProducts( $article, $brand=null ) {

    }
}
