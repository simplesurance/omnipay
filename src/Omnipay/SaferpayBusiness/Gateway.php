<?php

namespace simplesurance\Omnipay\SaferpayBusiness;

use Omnipay\Common\AbstractGateway;
use simplesurance\Omnipay\SaferpayBusiness\Message\AuthorizeRequest;
use simplesurance\Omnipay\SaferpayBusiness\Message\CompleteAuthorizeRequest;
use simplesurance\Omnipay\SaferpayBusiness\Message\CompleteRegisterCardRequest;
use simplesurance\Omnipay\SaferpayBusiness\Message\RegisterCardRequest;

class Gateway extends AbstractGateway
{
    use Parameters;

    public function getName()
    {
        return 'Saferpay Business';
    }

    public function getDefaultParameters()
    {
        return array(
            'testMode' => false,
        );
    }

    public function authorize(array $options = array())
    {
        return $this->createRequest(AuthorizeRequest::class, $options);
    }

    public function completeAuthorize(array $options = array())
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $options);
    }

    public function registerCard(array $parameters = array())
    {
        return $this->createRequest(RegisterCardRequest::class, $parameters);
    }

    public function completeRegisterCard(array $parameters = array())
    {
        return $this->createRequest(CompleteRegisterCardRequest::class, $parameters);
    }
}
