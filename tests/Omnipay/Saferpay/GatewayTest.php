<?php

namespace simplesurance\Tests\Omnipay\Saferpay;

use Omnipay\Tests\GatewayTestCase;
use simplesurance\Omnipay\Saferpay\Gateway;
use simplesurance\Omnipay\Saferpay\Message\AuthorizeResponse;
use simplesurance\Omnipay\Saferpay\Message\CompleteAuthorizeResponse;

class GatewayTest extends GatewayTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testAuthorizeSuccessJPY(): void
    {
        $options = [
            'amount' => '10000',
            'currency' => 'JPY',
            'returnUrl' => 'https://www.example.com/return',
            'cancelUrl' => 'https://www.example.com/cancel',
        ];

        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        $this->gateway->authorize($options)->send();

        foreach ($this->getMockedRequests() as $mockedRequest) {
            $this->assertContains('AMOUNT=10000&', $mockedRequest->getUri()->getQuery());
        }
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

        foreach ($this->getMockedRequests() as $mockedRequest) {
            $this->assertContains('AMOUNT=1000&', $mockedRequest->getUri()->getQuery());
        }

        $this->assertInstanceOf(AuthorizeResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals(
            'https://www.saferpay.com/vt2/Pay.aspx?DATA=%3cIDP+MSGTYPE%3d%22PayInit%22+MSG_GUID%3d%22a34ffb2f67bd49b5952592b0e2396d43%22+CLIENTVERSION%3d%222.2%22+KEYID%3d%220-99867-7d5a273c0f5043e28811e764d6433086%22+TOKEN%3d%2299fc151aa5c44e55b204c9bafd78fc63%22+ALLOWCOLLECT%3d%22no%22+DELIVERY%3d%22yes%22+EXPIRATION%3d%2220131210+23%3a47%3a44%22+ACCOUNTID%3d%2299867-94913159%22+AMOUNT%3d%223495%22+CURRENCY%3d%22EUR%22+DESCRIPTION%3d%22Ger%c3%a4te-Schutzbrief+Smartphone+250%22+SUCCESSLINK%3d%22https%3a%2f%2flocal.schutzklick.de%2fpayment%2fcomplete%2fsaferpay%22+BACKLINK%3d%22https%3a%2f%2flocal.schutzklick.de%2fpayment%2fcomplete%2fsaferpay%3fcancel%3d1%22+FAILLINK%3d%22https%3a%2f%2flocal.schutzklick.de%2fpayment%2fcomplete%2fsaferpay%3fcancel%3d1%22+CCNAME%3d%22yes%22+APPEARANCE%3d%22auto%22+%2f%3e&SIGNATURE=01723ba2c0604617c79ad138908504b5ab65404a98cdfc3a4d3d016c9c6bea8e7f3030267b9c88a37eaf24ee171d09238d77387725427b0bc43ecc0aeaf0a80b',
            $response->getRedirectUrl()
        );
    }

    public function testAuthorizeDescriptionIsHtmlEncoded(): void
    {
        $options = [
            'description' => 'Zażółć gęślą jaźń',
        ];

        $requestData = $this->gateway->authorize($options)->getData();

        $this->assertEquals($requestData['DESCRIPTION'], 'Za&#380;&oacute;&#322;&#263; g&#281;&#347;l&#261; ja&#378;&#324;');
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
        $this->assertSame('ERROR: Missing AMOUNT attribute', $response->getMessage());
    }

    public function testCompleteAuthorizeSuccess(): void
    {
        $this->setMockHttpResponse('CompleteAuthorizeSuccess.txt');

        /** @var CompleteAuthorizeResponse $response */
        $response = $this->gateway->completeAuthorize()->send();

        $this->assertInstanceOf(CompleteAuthorizeResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('56a77rg243asfhmkq3r', $response->getTransactionReference());
        $this->assertSame('3e235462FA23C4FE4AF65', $response->getToken());
    }

    public function testCompleteAuthorizeFailure(): void
    {
        $this->setMockHttpResponse('CompleteAuthorizeFailure.txt');

        $response = $this->gateway->completeAuthorize()->send();

        $this->assertInstanceOf(CompleteAuthorizeResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('ERROR: Possible manipulation', $response->getMessage());
    }

    public function testCaptureSuccess(): void
    {
        $options = [
            'accountId' => 'spaccount',
            'spPassword' => 'supersecret',
            'amount' => '9.99',
        ];

        $this->setMockHttpResponse('CaptureSuccess.txt');

        $response = $this->gateway->capture($options)->send();

        $this->assertTrue($response->isSuccessful());
    }

    public function testCaptureSuccessLong(): void
    {
        $options = [
            'accountId' => 'spaccount',
            'spPassword' => 'supersecret',
            'amount' => '9.99',
        ];

        $this->setMockHttpResponse('CaptureSuccessLong.txt');

        $response = $this->gateway->capture($options)->send();

        $this->assertTrue($response->isSuccessful());
    }

    public function testCaptureFailure(): void
    {
        $options = [
            'accountId' => 'spaccount',
            'spPassword' => 'supersecret',
            'amount' => '9.99',
        ];

        $this->setMockHttpResponse('CaptureFailure.txt');

        $response = $this->gateway->capture($options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('ERROR: Error description', $response->getMessage());
    }
}
