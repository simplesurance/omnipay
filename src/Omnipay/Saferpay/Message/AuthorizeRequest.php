<?php

namespace simplesurance\Omnipay\Saferpay\Message;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class AuthorizeRequest extends AbstractRequest
{
    private const ENDPOINT = '/Payment/v1/PaymentPage/Initialize';

    public function getTerminalId(): string
    {
        return $this->getParameter('terminalId');
    }

    public function setTerminalId(string $terminalId): self
    {
        return $this->setParameter('terminalId', $terminalId);
    }

    public function getPaymentMethods()
    {
        return $this->getParameter('paymentMethods');
    }

    public function setPaymentMethods($value)
    {
        return $this->setParameter('paymentMethods', $value);
    }

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    public function getLangId()
    {
        return $this->getParameter('langId');
    }

    public function setLangId($value)
    {
        return $this->setParameter('langId', $value);
    }

    public function getRecurring(): bool
    {
        return (bool) $this->getParameter('recurring');
    }

    public function setRecurring(bool $value): self
    {
        return $this->setParameter('recurring', $value);
    }

    public function getData()
    {
        $data = [
            'Payment' => [
                'Amount' => [
                    'Value' => (string) ($this->getAmount() * (10 ** $this->getCurrencyDecimalPlaces())),
                    'CurrencyCode' => $this->getCurrency(),
                ],
                'OrderId' => $this->getOrderId(),
                'Description' => mb_convert_encoding($this->getDescription(), 'HTML-ENTITIES', 'UTF-8'),
            ],
            'TerminalId' => $this->getTerminalId(),
            'Payer' => [
                'LanguageCode' => $this->getLangId(),
            ],
            'ReturnUrls' => [
                'Success' => $this->getReturnUrl(),
                'Fail' => $this->getCancelUrl(),
            ],
            'Notification' => [
                'NotifyUrl' => $this->getNotifyUrl(),
            ],
            'PaymentMethods' => [$this->getPaymentMethods()],
            'Authentication' => [
                'ThreeDsChallenge' => 'FORCE',
            ],
        ];

        if ($this->getRecurring()) {
            $data['Payment']['Recurring'] = ['Initial' => true];
            $data['RegisterAlias'] = [
                'IdGenerator' => 'MANUAL',
                'Id' => $this->getOrderId(),
                'Lifetime' => 1600,
            ];
        }

        return $data;
    }

    protected function getEndpoint(): string
    {
        return self::ENDPOINT;
    }

    protected function createResponse(HttpResponseInterface $response): Response
    {
        return new AuthorizeResponse($this, $response);
    }
}
