<?php

declare(strict_types=1);

namespace simplesurance\Omnipay\Saferpay;

use LogicException;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\RequestInterface;
use simplesurance\Omnipay\Interfaces\AuthorizeDirectInterface;
use simplesurance\Omnipay\Saferpay\Message\AuthorizeDirectRequest;
use simplesurance\Omnipay\Saferpay\Message\AuthorizeRequest;
use simplesurance\Omnipay\Saferpay\Message\CaptureRequest;
use simplesurance\Omnipay\Saferpay\Message\CompleteAuthorizeRequest;

class Gateway extends AbstractGateway implements AuthorizeDirectInterface
{
    public function getName(): string
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

    public function getDefaultParameters(): array
    {
        return [
            'testMode' => false,
        ];
    }

    public function authorizeDirect(array $parameters): AbstractRequest
    {
        return $this->createRequest(AuthorizeDirectRequest::class, $parameters);
    }

    public function authorize(array $options = []): RequestInterface
    {
        return $this->createRequest(AuthorizeRequest::class, $options);
    }

    public function completeAuthorize(array $options = []): RequestInterface
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $options);
    }

    public function capture(array $options = []): RequestInterface
    {
        return $this->createRequest(CaptureRequest::class, $options);
    }

    public function acceptNotification(array $options = array()): NotificationInterface
    {
        throw new LogicException('Not implemented');
    }

    public function purchase(array $options = array()): RequestInterface
    {
        throw new LogicException('Not implemented');
    }

    public function completePurchase(array $options = array()): RequestInterface
    {
        throw new LogicException('Not implemented');
    }

    public function refund(array $options = array()): RequestInterface
    {
        throw new LogicException('Not implemented');
    }

    public function fetchTransaction(array $options = []): RequestInterface
    {
        throw new LogicException('Not implemented');
    }

    public function void(array $options = array()): RequestInterface
    {
        throw new LogicException('Not implemented');
    }

    public function createCard(array $options = array()): RequestInterface
    {
        throw new LogicException('Not implemented');
    }

    public function updateCard(array $options = array()): RequestInterface
    {
        throw new LogicException('Not implemented');
    }

    public function deleteCard(array $options = array()): RequestInterface
    {
        throw new LogicException('Not implemented');
    }
}
