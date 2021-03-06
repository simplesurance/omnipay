<?php

namespace simplesurance\Omnipay\SaferpayBusiness\Message;

use Omnipay\Common\Message\AbstractResponse;

class RegisterCardResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return false !== filter_var($this->data, FILTER_VALIDATE_URL);
    }
}
