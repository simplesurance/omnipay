<?php

namespace simplesurance\Tests\Omnipay\Ideal\Tests;

use Omnipay\Tests\GatewayTestCase;
use simplesurance\Omnipay\Ideal\Gateway;
use simplesurance\Omnipay\Ideal\Message\FetchIssuersResponse;

class GatewayTest extends GatewayTestCase
{
    /** @var Gateway */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->initialize([
            'userId'          => '12345',
            'projectId'       => '54321',
            'projectPassword' => 'Kilimanjaro',
            'senderCountryId' => 'NL',
            'apiKey'          => 'f21f57dpm88700d916ce1c2399',
            'testMode'        => false,
        ]);
    }

    public function testFetchIssuersSuccess(): void
    {
        $this->setMockHttpResponse('FetchIssuersSuccess.txt');

        /** @var FetchIssuersResponse $response */
        $response = $this->gateway->fetchIssuers()->send();

        $this->assertInstanceOf(FetchIssuersResponse::class, $response);
        $this->assertTrue($response->isSuccessful());

        $expectedIssuers = [
            'ABNANL2A' => 'ABN Amro',
            'INGBNL2A' => 'ING',
        ];
        $this->assertEquals($expectedIssuers, $response->getIssuers());
    }
}
