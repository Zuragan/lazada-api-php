<?php

use Zuragan\Lazada\LazadaAPI;
use Zuragan\Lazada\Actions\ActionFactory;

class GetTest extends PHPUnit\Framework\TestCase
{
    private $url;
    private $apiKey;
    private $email;

    protected function setup()
    {
        $this->url = getenv('LAZADA_API_URL');
        $this->apiKey = getenv('LAZADA_API_KEY');
        $this->email = getenv('LAZADA_USER_EMAIL');
    }

    /** @test */
    public function shouldGetProducts()
    {
        $api = new LazadaAPI($this->url);
        $factory = new ActionFactory($this->email, $this->apiKey);

        $action = $factory->getAction('GetProducts', ['Limit' => 10]);
        $decodedResponse = $api->get($action);

        $this->assertTrue(property_exists($decodedResponse, 'SuccessResponse'));
    }
}
