<?php

namespace simplesurance\Omnipay\Sofort;

use LogicException;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\RequestInterface;
use simplesurance\Omnipay\Sofort\Message\AuthorizeRequest;
use simplesurance\Omnipay\Sofort\Message\CompleteAuthorizeRequest;

class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'Sofort';
    }

    public function getDefaultParameters(): array
    {
        return [
            'username' => '',
            'password' => '',
            'projectId' => '',
            'testMode' => true,
        ];
    }

    public function getUsername(): mixed
    {
        return $this->getParameter('username');
    }

    public function setUsername($value): self
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword(): mixed
    {
        return $this->getParameter('password');
    }

    public function setPassword($value): self
    {
        return $this->setParameter('password', $value);
    }

    public function getProjectId(): mixed
    {
        return $this->getParameter('projectId');
    }

    public function setProjectId($value): self
    {
        return $this->setParameter('projectId', $value);
    }

    public function getCountry(): mixed
    {
        return $this->getParameter('country');
    }

    public function setCountry($value): self
    {
        return $this->setParameter('country', $value);
    }

    public function authorize(array $options = []): RequestInterface
    {
        return $this->createRequest(AuthorizeRequest::class, $options);
    }

    public function completeAuthorize(array $options = []): RequestInterface
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $options);
    }

    public function purchase(array $options = []): RequestInterface
    {
        return $this->authorize($options);
    }
}
