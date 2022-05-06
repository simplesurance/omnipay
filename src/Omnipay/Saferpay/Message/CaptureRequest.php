<?php

declare(strict_types=1);

namespace simplesurance\Omnipay\Saferpay\Message;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class CaptureRequest extends AbstractRequest
{
    private const ENDPOINT = '/Payment/v1/Transaction/Capture';

    public function getData()
    {
        return [
            'TransactionReference' => [
                'TransactionId' => $this->getTransactionReference(),
            ],
        ];
    }

    protected function getEndpoint(): string
    {
        return self::ENDPOINT;
    }

    protected function createResponse(HttpResponseInterface $response): Response
    {
        return $this->response = new CaptureResponse($this, $response);
    }
}
