<?php

declare(strict_types=1);

namespace simplesurance\Omnipay\Interfaces;

use Omnipay\Common\Message\AbstractRequest;

interface ChargeInterface
{
    public function charge(array $parameters): AbstractRequest;
}
