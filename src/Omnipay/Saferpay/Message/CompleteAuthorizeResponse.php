<?php

declare(strict_types=1);

namespace simplesurance\Omnipay\Saferpay\Message;

class CompleteAuthorizeResponse extends Response
{
    private const AUTHORISED = 'AUTHORIZED';
    private const CAPTURED = 'CAPTURED';

    public function isSuccessful()
    {
        $data = $this->parseData();

        if (empty($data['Transaction']['Status'])) {
            return false;
        }

        return in_array(
            $data['Transaction']['Status'],
            [self::AUTHORISED, self::CAPTURED],
            true
        );
    }

    public function getTransactionReference()
    {
        $data = $this->parseData();

        if (empty($data['Transaction']['Id'])) {
            throw new \RuntimeException('Unable to fetch transaction reference');
        }

        return $data['Transaction']['Id'];
    }

    public function getMessage()
    {
        return $this->data;
    }
}
