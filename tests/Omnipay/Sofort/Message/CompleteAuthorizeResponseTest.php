<?php

declare(strict_types=1);

namespace simplesurance\Tests\Omnipay\Sofort\Message;

use Omnipay\Tests\TestCase;
use simplesurance\Omnipay\Sofort\Message\CompleteAuthorizeResponse;

class CompleteAuthorizeResponseTest extends TestCase
{
    public function testCompleteAuthorizeSuccess(): void
    {
        $httpResponse = $this->getMockHttpResponse('CompleteAuthorizeSuccess.txt');
        $response = new CompleteAuthorizeResponse($this->getMockRequest(), $httpResponse);

        $this->assertTrue($response->isSuccessful());
    }

    public function testCompleteAuthorizeFailure(): void
    {
        $httpResponse = $this->getMockHttpResponse('CompleteAuthorizeFailure.txt');
        $response = new CompleteAuthorizeResponse($this->getMockRequest(), $httpResponse);

        $this->assertFalse($response->isSuccessful());
    }
}
