<?php

namespace simplesurance\Omnipay\Saferpay\Message;

use Http\Client\Exception\HttpException;
use Omnipay\Common\Http\Exception\RequestException;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    private const API_VERSION = '1.19';
    private const BASE_URL = 'https://www.saferpay.com/api';
    private const BASE_URL_TEST = 'https://test.saferpay.com/api';

    public function getUsername(): string
    {
        return $this->getParameter('username');
    }

    public function setUsername(string $username): self
    {
        return $this->setParameter('username', $username);
    }

    public function getPassword(): string
    {
        return $this->getParameter('password');
    }

    public function setPassword(string $password): self
    {
        return $this->setParameter('password', $password);
    }

    public function getCustomerId(): string
    {
        return $this->getParameter('customerId');
    }

    public function setCustomerId(string $customerId): self
    {
        return $this->setParameter('customerId', $customerId);
    }

    public function sendData($data)
    {
        if (!is_array($data)) {
            throw new \RuntimeException('Unexpected data format');
        }

        $data += [
            'RequestHeader' => [
                'SpecVersion' => self::API_VERSION,
                'CustomerId' => $this->getCustomerId(),
                'RequestId' => uniqid(),
                'RetryIndicator' => 0,
            ],
        ];

        try {
            $httpResponse = $this->httpClient->request(
                'POST',
                $this->getUrl(),
                [
                    'Authorization' => sprintf(
                        'Basic %s',
                        base64_encode(sprintf('%s:%s', $this->getUsername(), $this->getPassword()))
                    ),
                    'Content-Type' => 'application/json; charset=utf-8',
                    'Accept' => 'application/json',
                ],
                json_encode($data)
            );
        } catch (RequestException $e) {
            $pe = $e->getPrevious();
            if (!$pe instanceof HttpException) {
                throw $e;
            }

            throw new RequestException((string) $pe->getResponse()->getBody(), $e->getRequest(), $e);
        }

        return $this->createResponse($httpResponse);
    }

    abstract protected function getEndpoint(): string;

    abstract protected function createResponse(HttpResponseInterface $response): Response;

    protected function getUrl()
    {
        return ($this->getTestMode() ? self::BASE_URL_TEST : self::BASE_URL) . $this->getEndpoint();
    }
}
