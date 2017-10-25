<?php

use Zuragan\Lazada\LazadaAPI;
use Zuragan\Lazada\Actions\ActionFactory;

class PostTest extends PHPUnit\Framework\TestCase
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
    public function shouldUpdateProduct()
    {
        $api = new LazadaAPI($this->url);
		$factory = new ActionFactory($this->email, $this->apiKey);

		$updatePayload = [
			'Product' => [
				'Skus' => [
					'Sku' => [
						'SellerSku' => '01',
						'quantity' => '12',
					],
				],
			]
		];

        $action = $factory->postAction('UpdateProduct', [], $updatePayload);
        $decodedResponse = $api->post($action);

        $this->assertTrue(property_exists($decodedResponse, 'SuccessResponse'));
    }
}

