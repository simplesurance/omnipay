<?php

namespace simplesurance\Tests\Omnipay\Sofort\Message;

use Omnipay\Tests\TestCase;
use simplesurance\Omnipay\Sofort\Message\CompleteAuthorizeRequest;

class CompleteAuthorizeRequestTest extends TestCase
{
    public function testGetData(): void
    {
        $request = new CompleteAuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array('transactionId' => '55742-165747-52441DAF-3596'));

        $data = $request->getData();

        $this->assertInstanceOf('SimpleXMLElement', $data);
        $this->assertSame('55742-165747-52441DAF-3596', (string) $data->transaction);
    }
}
