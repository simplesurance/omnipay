<?php

namespace simplesurance\Omnipay\Interfaces;

use Omnipay\Common\Message\AbstractRequest;

interface ChargeInterface
{
    public function charge(array $parameters): AbstractRequest;
}
