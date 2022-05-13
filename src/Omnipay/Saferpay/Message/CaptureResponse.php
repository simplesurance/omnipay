<?php

namespace simplesurance\Omnipay\Saferpay\Message;

class CaptureResponse extends Response
{
    private const CAPTURED = 'CAPTURED';

    public function isSuccessful()
    {
        $data = $this->parseData();

        $status = $data['Status'] ?? '';

        return self::CAPTURED === $status;
    }

    public function getMessage()
    {
        return $this->data;
    }
}
