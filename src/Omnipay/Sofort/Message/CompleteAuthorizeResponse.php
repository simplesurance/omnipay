<?php

namespace simplesurance\Omnipay\Sofort\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

class CompleteAuthorizeResponse extends Response implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return isset($this->data->transaction_details) &&
            false === in_array($this->data->transaction_details->status, ['loss', 'refunded'], true);
    }

    public function getTransactionReference()
    {
        return $this->data->transaction_details->transaction;
    }
}
