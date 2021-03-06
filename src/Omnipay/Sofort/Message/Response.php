<?php

namespace simplesurance\Omnipay\Sofort\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{
    public function __construct(RequestInterface $request, $response)
    {
        $this->request = $request;
        $this->data = simplexml_load_string((string) $response->getBody());
    }

    public function isSuccessful()
    {
        return false;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectData()
    {
        return null;
    }

    public function getRedirectUrl()
    {
        return null;
    }
}
