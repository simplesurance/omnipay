<?php

namespace simplesurance\Omnipay\Saferpay\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

class AuthorizeResponse extends Response implements RedirectResponseInterface
{
    public function isRedirect()
    {
        $data = $this->parseData();

        return !empty($data['RedirectUrl']);
    }

    public function getRedirectUrl()
    {
        $data = $this->parseData();

        if (empty($data['RedirectUrl'])) {
            throw new \RuntimeException('RedirectUrl is not defined');
        }

        return $data['RedirectUrl'];
    }

    public function getMessage()
    {
        return $this->data;
    }

    public function getTransactionReference()
    {
        $data = $this->parseData();

        return $data['Token'] ?? null;
    }
}
