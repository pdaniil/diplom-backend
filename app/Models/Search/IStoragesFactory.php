<?php
namespace App\Models\Search;
use App\Models\Search\IStorage;
interface IStoragesFactory
{
    public function make(IStorage $storage, $params = null);
}