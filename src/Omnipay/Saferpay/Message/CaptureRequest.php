<?php

namespace simplesurance\Omnipay\Saferpay\Message;

class CaptureRequest extends AbstractRequest
{
    protected $endpoint = 'PayCompleteV2.asp';

    public function getData()
    {
        $this->validate('accountId', 'spPassword', 'amount');

        $data = [
            'ACCOUNTID' => $this->getAccountId(),
            'ID' => $this->getTransactionReference(),
            'spPassword' => $this->getSpPassword()
        ];

        return $data;
    }

    protected function createResponse($response)
    {
        return $this->response = new CaptureResponse($this, $response);
    }
}
