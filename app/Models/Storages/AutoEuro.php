<?php

namespace App\Models\Storages;
use Illuminate\Support\Facades\Http;
use App\Models\Search\Storage;
class AutoEuro extends Storage
{
    public function authenticate() {
        $this->auth_params =
        [
            'api_key' => 'VNoMNZ98BupT0aBRieIJ5xc1MdX0OSHpVdIPklBrNlDRmJ9Cq5jqkietAre1',
            'with_crosses' => '1',
            'with_offers' => '1',
            'delivery_key' => 'QS59xUr7fbkuHwkhoYZm5lyhkGf8oPlNyxCbgkkDgHbY9hrszkUNTsEuZYBmJUwOEPb2iIb01uSVTJYQWkRv05qrVm4c',
            'payer_key' => 'pdblb93eDZqVAs9duXsB5LoW6x1sbxW0Bt9mQklg1wakK5Ow21hA'
        ];
    }

    function getBrands( $article ) {
        $url = 'https://api2.autoeuro.ru/api/v2/json/search_brands/';
        $response = Http::withHeaders([
            "key" => $this->auth_params["api_key"]
        ])->post($url, ["code" => $article]);

        $manufacturers = json_decode($response);
        foreach ($manufacturers->DATA as $manufacturer)
            $this->brands[] = $manufacturer->brand;
    }

    function getProducts( $article, $brand = null) {
        $this->getBrands( $article );

        $url = 'https://api2.autoeuro.ru/api/v2/json/search_items/';
        $params =
            [
                'code' => $article,
                'with_crosses' => $this->auth_params["with_crosses"],
                'with_offers' => $this->auth_params["with_offers"],
                'delivery_key' => $this->auth_params["delivery_key"],
                'payer_key' => $this->auth_params["payer_key"],
                'brand' => ''
            ];
        foreach ($this->brands as $brand)
        {
            $params['brand'] = $brand;
            $response = HTTP::withHeaders([
                "key" => $this->auth_params['api_key']
            ])->post($url, $params);

            $result = json_decode($response);
            $products = $result->DATA;

            foreach ($products as $product)
            {
                $productArr = [
                    "price" => (int)$product->price,
                    "brand" => $product->brand,
                    "article" => (string)$product->code,
                    "title" => (string)$product->name,
                    "exist" => (int)$product->amount,
                    "delivery_time" => (strtotime($product->delivery_time) - time()) / 60 / 60 / 24,
                    'storage' => 'AutoEuro'
                ];

                $this->appendProduct( $productArr );
            }
        }
    }
}
