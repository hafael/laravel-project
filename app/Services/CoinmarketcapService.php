<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CoinmarketcapService
{

    protected $apiKey = '8af0951e-78a0-4187-b9ed-b7ee6ad5cc9b';
    protected $url = 'https://pro-api.coinmarketcap.com';
    protected $sandboxApiKey = 'b54bcf4d-1bca-4e8e-9a24-22ff2c3d462c';
    protected $sandboxUrl = 'https://sandbox-api.coinmarketcap.com';
    protected $sandbox = false;

    /**
     * Toggle sandbox.
     *
     * @return $this
     */
    public function sandbox($sandbox = true)
    {
        $this->sandbox = $sandbox;

        return $this;
    }

    /**
     * Is sandbox request.
     *
     * @return bool
     */
    protected function isSandbox()
    {
        return $this->sandbox;
    }

    /**
     * Is sandbox request.
     *
     * @return bool
     */
    public function baseURL()
    {
        return $this->isSandbox() ? $this->sandboxUrl : $this->url;
    }

    /**
     * Is sandbox request.
     *
     * @return bool
     */
    public function apiKey()
    {
        return $this->isSandbox() ? $this->sandboxApiKey : $this->apiKey;
    }

    /**
     * Resource Path.
     *
     * @return string
     */
    protected function resourcePath($path)
    {
        return $this->baseURL() . '/' . $path;
    }

    public function sendRequest($method, $url, $options)
    {
        return Http::baseUrl($this->baseURL())
                    ->withHeaders([
                        'X-CMC_PRO_API_KEY' => $this->apiKey()
                    ])
                    ->send($method, $url, $options);
    }

    public function latestMarketQuote($params = [])
    {

        $response = $this->sendRequest('GET', 'v1/cryptocurrency/quotes/latest', [
            'query' => $params
        ]);

        if($response->successful())
        {
            return $response->json();
        }

        if($response->serverError()) {
            return [
                'error' => 500,
                'message' => 'Server Error'
            ];
        }

        if($response->clientError()) {
            return $response->throw();
        }

        return $response;
    }

    public function priceConversion($params = [])
    {

        $response = $this->sendRequest('GET', 'v1/tools/price-conversion', [
            'query' => $params
        ]);

        if($response->successful())
        {
            return $response->json();
        }

        if($response->serverError()) {
            return [
                'error' => 500,
                'message' => 'Server Error'
            ];
        }

        if($response->clientError()) {
            return $response->throw();
        }

        return $response;
    }


}
