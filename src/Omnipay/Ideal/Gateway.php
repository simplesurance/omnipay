<?php

namespace simplesurance\Omnipay\Ideal;

use simplesurance\Omnipay\Ideal\Message\CompleteAuthorizeRequest;
use simplesurance\Omnipay\Ideal\Message\FetchIssuersRequest;
use simplesurance\Omnipay\Ideal\Message\PurchaseRequest;
use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    use Parameters;

    public function getName()
    {
        return 'iDeal';
    }

    public function getDefaultParameters()
    {
        return array(
            'testMode' => false,
        );
    }

    public function fetchIssuers(array $parameters = array())
    {
        return $this->createRequest(FetchIssuersRequest::class, $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->purchase($parameters);
    }

    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $parameters);
    }
}
