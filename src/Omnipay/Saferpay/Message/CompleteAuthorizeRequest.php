<?php

namespace simplesurance\Omnipay\Saferpay\Message;

class CompleteAuthorizeRequest extends AbstractRequest
{
    protected $endpoint = 'VerifyPayConfirm.asp';

    public function getData()
    {
        return $this->httpRequest->query->all();
    }

    protected function createResponse($response)
    {
        return $this->response = new CompleteAuthorizeResponse($this, $response);
    }
}
