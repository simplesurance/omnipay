<?php

namespace simplesurance\Tests\Omnipay\Sofort;

use Omnipay\Tests\GatewayTestCase;
use simplesurance\Omnipay\Sofort\Gateway;
use simplesurance\Omnipay\Sofort\Message\AuthorizeResponse;
use simplesurance\Omnipay\Sofort\Message\CompleteAuthorizeResponse;

class GatewayTest extends GatewayTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testAuthorizeSuccess(): void
    {
        $options = [
            'amount' => '10.00',
            'returnUrl' => 'https://www.example.com/return',
            'cancelUrl' => 'https://www.example.com/cancel',
        ];

        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        /** @var AuthorizeResponse $response */
        $response = $this->gateway->authorize($options)->send();

        $this->assertInstanceOf(AuthorizeResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('https://www.sofort.com/payment/go/dd853fc10480b7b6b1ae47252a973166e96aab5b', $response->getRedirectUrl());
    }

    public function testAuthorizeFailure(): void
    {
        $options = [
            'amount' => '10.00',
            'returnUrl' => 'https://www.example.com/return',
            'cancelUrl' => 'https://www.example.com/cancel',
        ];

        $this->setMockHttpResponse('AuthorizeFailure.txt');

        $response = $this->gateway->authorize($options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEmpty($response->getTransactionReference());
        $this->assertSame('8015: Amount is out of range. ', $response->getMessage());
    }

    public function testCompleteAuthorizeSuccess(): void
    {
        $this->setMockHttpResponse('CompleteAuthorizeSuccess.txt');

        $options = ['transactionId' => '55742-165747-52441DAF-3596'];

        $response = $this->gateway->completeAuthorize($options)->send();

        $this->assertInstanceOf(CompleteAuthorizeResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('55742-165747-52441DAF-3596', $response->getTransactionReference());
    }

    public function testCompleteAuthorizeFailure()
    {
        $this->setMockHttpResponse('CompleteAuthorizeFailure.txt');

        $options = [];

        $response = $this->gateway->completeAuthorize($options)->send();

        $this->assertInstanceOf(CompleteAuthorizeResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }
}
