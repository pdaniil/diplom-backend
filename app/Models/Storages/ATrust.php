<?php

namespace App\Models\Storages;
use Illuminate\Support\Facades\Http;
use App\Models\Search\Storage;
class ATrust extends Storage
{
    public function authenticate() {
        //$login = $this->connection_options->login;
        //$password = $this->connection_options->password;

        $login = 'svetalyaskov@yandex.ru';
        $password = 'svetalyaskov@yandex.ru';
        $response = Http::post('https://ws.a-trast.ru/v1/auth/login', ['username' => $login, 'password' => $password]);
        $this->auth_params = json_decode($response)->token;
    }

    function getProducts( $article, $brand = null ) {
        $url = 'https://ws.a-trast.ru/v1/search/products?query_search_mode=1&expand=analogs,partner_stocks&article='.$article.'&sort=title&page_limit=500';
        $response = Http::withToken( $this->auth_params )->get( $url );
        $result = json_decode($response);
        foreach ($result->products as $product)
        {
            $productArr = [
                "price" => $product->price,
                "brand" => $product->brand,
                "article" => $product->article,
                "title" => $product->title,
                "exist" => $product->count,
                "delivery_time" => $product->warehouse_delivery_time / 24,
                'storage' => 'ATrust'
            ];

            $this->appendProduct( $productArr );
        }
    }
}
