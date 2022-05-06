<?php

declare(strict_types=1);

namespace simplesurance\Omnipay\Interfaces;

use Omnipay\Common\Message\AbstractRequest;

interface AuthorizeDirectInterface
{
    public function authorizeDirect(array $parameters): AbstractRequest;
}
