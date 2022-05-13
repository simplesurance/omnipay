<?php

namespace simplesurance\Omnipay\Saferpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class Response extends AbstractResponse
{
    public function __construct(RequestInterface $request, HttpResponseInterface $response)
    {
        $this->request = $request;
        $this->data = (string) $response->getBody();
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

    public function getMessage()
    {
        return null;
    }

    protected function parseData(): array
    {
        $data = json_decode($this->data, true);
        if (!is_array($data)) {
            throw new \RuntimeException('Unable to parse data');
        }

        return $data;
    }
}
