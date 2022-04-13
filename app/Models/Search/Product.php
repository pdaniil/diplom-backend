<?php

namespace App\Models\Search;

class Product
{
    public $price;
    public $brand;
    public $article;
    public $title;
    public $exist;
    public $delivery_time;
    public $storage;

    function __construct( $product )
    {
        $this->article = $product["article"];
        $this->brand = $product["brand"];
        $this->price = $product["price"];
        $this->exist = $product["exist"];
        $this->delivery_time = $product["delivery_time"];
        $this->title = $product["title"];
        $this->storage = $product["storage"];
    }

    function valid()
    {
        if ($this->article != '')
            return true;
    }
}