<?php

namespace simplesurance\Tests\Omnipay\SaferpayBusiness;

use Omnipay\Tests\GatewayTestCase;
use simplesurance\Omnipay\SaferpayBusiness\Gateway;
use simplesurance\Omnipay\SaferpayBusiness\Message\CompleteAuthorizeResponse;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->initialize([
            'accountId' => '99867-94913159',
            'spPassword' => 'XAjc3Kna',
        ]);
    }

    public function testCompleteAuthorizeSuccess(): void
    {
        $this->setMockHttpResponse('CompleteAuthorizeSuccess.txt');

        $response = $this->gateway->completeAuthorize([
            'amount' => 20.50,
            'IBAN' => 'DE17970000011234567890',
        ])->send();

        $this->assertInstanceOf(CompleteAuthorizeResponse::class, $response);
        $this->assertTrue($response->isSuccessful());

        $this->assertEquals('Y29lE1bjxztCSAAfW85UA96I6Utb', $response->getTransactionReference());
    }
}
