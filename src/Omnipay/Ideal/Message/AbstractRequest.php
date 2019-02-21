<?php

namespace simplesurance\Omnipay\Ideal\Message;

use simplesurance\Omnipay\Ideal\Parameters;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    use Parameters;

    public function getData()
    {
        return null;
    }
}
