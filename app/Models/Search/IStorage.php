<?php

namespace App\Models\Search;

interface IStorage
{
    public function authenticate();
    public function appendBrand( $brandArr );
    public function appendProduct( $productArr );
    public function getBrands( $article );
    public function getProducts( $article, $brands = null);
}
