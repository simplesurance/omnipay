<?php

declare(strict_types=1);

namespace simplesurance\Omnipay\Saferpay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use simplesurance\Omnipay\Interfaces\AuthorizeDirectInterface;
use simplesurance\Omnipay\Saferpay\Message\AuthorizeDirectRequest;
use simplesurance\Omnipay\Saferpay\Message\AuthorizeRequest;
use simplesurance\Omnipay\Saferpay\Message\CaptureRequest;
use simplesurance\Omnipay\Saferpay\Message\CompleteAuthorizeRequest;

class Gateway extends AbstractGateway implements AuthorizeDirectInterface
{
    public function getName()
    {
        return 'SaferPay';
    }

    public function getLangId(): string
    {
        return $this->getParameter('langId');
    }

    public function setLangId(string $langId): self
    {
        return $this->setParameter('langId', $langId);
    }

    public function getUsername(): string
    {
        return $this->getParameter('username');
    }

    public function setUsername(string $username): self
    {
        return $this->setParameter('username', $username);
    }

    public function getPassword(): string
    {
        return $this->getParameter('password');
    }

    public function setPassword(string $password): self
    {
        return $this->setParameter('password', $password);
    }

    public function getCustomerId(): string
    {
        return $this->getParameter('customerId');
    }

    public function setCustomerId(string $customerId): self
    {
        return $this->setParameter('customerId', $customerId);
    }

    public function getTerminalId(): string
    {
        return $this->getParameter('terminalId');
    }

    public function setTerminalId(string $terminalId): self
    {
        return $this->setParameter('terminalId', $terminalId);
    }

    public function getDefaultParameters()
    {
        return [
            'testMode' => false,
        ];
    }

    public function authorizeDirect(array $parameters): AbstractRequest
    {
        return $this->createRequest(AuthorizeDirectRequest::class, $parameters);
    }

    public function authorize(array $parameters = [])
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    public function completeAuthorize(array $parameters = [])
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $parameters);
    }

    public function capture(array $parameters = [])
    {
        return $this->createRequest(CaptureRequest::class, $parameters);
    }
}
