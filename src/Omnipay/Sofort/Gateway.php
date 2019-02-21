<?php

namespace simplesurance\Omnipay\Sofort;

use Omnipay\Common\AbstractGateway;
use simplesurance\Omnipay\Sofort\Message\AuthorizeRequest;
use simplesurance\Omnipay\Sofort\Message\CompleteAuthorizeRequest;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Sofort';
    }

    public function getDefaultParameters()
    {
        return array(
            'username' => '',
            'password' => '',
            'projectId' => '',
            'testMode' => true,
        );
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getProjectId()
    {
        return $this->getParameter('projectId');
    }

    public function setProjectId($value)
    {
        return $this->setParameter('projectId', $value);
    }

    public function getCountry()
    {
        return $this->getParameter('country');
    }

    public function setCountry($value)
    {
        return $this->setParameter('country', $value);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->authorize($parameters);
    }
}
