<?php

declare(strict_types=1);

namespace simplesurance\Omnipay\Saferpay\Message;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class CompleteAuthorizeRequest extends AbstractRequest
{
    public function getTransactionId()
    {
        return $this->getParameter('transactionId');
    }

    public function setTransactionId($value)
    {
        return $this->setParameter('transactionId', $value);
    }

    public function getData()
    {
        return [
            'Token' => $this->getTransactionId(),
        ];
    }

    protected function getEndpoint(): string
    {
        return '/Payment/v1/PaymentPage/Assert';
    }

    protected function createResponse(HttpResponseInterface $response): Response
    {
        return $this->response = new CompleteAuthorizeResponse($this, $response);
    }
}
