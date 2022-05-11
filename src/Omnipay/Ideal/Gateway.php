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

    public function purchase(array $options = array())
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    public function authorize(array $options = array())
    {
        return $this->purchase($options);
    }

    public function completeAuthorize(array $options = array())
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $options);
    }
}
