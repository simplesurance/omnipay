<?php

namespace simplesurance\Omnipay\Saferpay\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    private const BASE_URL = 'https://www.saferpay.com/hosting/';
    private const BASE_URL_TEST = 'https://test.saferpay.com/hosting/';

    protected $endpoint;

    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
    }

    public function setSpPassword($value)
    {
        $this->setParameter('spPassword', $value);
    }

    public function getSpPassword()
    {
        return $this->getParameter('spPassword');
    }

    public function send()
    {
        $url = $this->getEndpoint().'?'.http_build_query($this->getData());
        $httpResponse = $this->httpClient->request('GET', $url);

        return $this->createResponse($httpResponse);
    }

    protected function createResponse($response)
    {
        return $this->response = new Response($this, $response);
    }

    protected function getEndpoint()
    {
        return ($this->getTestMode() ? self::BASE_URL_TEST : self::BASE_URL) . $this->endpoint;
    }

    public function sendData($data)
    {
        return null;
    }
}
