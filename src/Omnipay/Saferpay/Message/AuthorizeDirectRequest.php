<?php

declare(strict_types=1);

namespace simplesurance\Omnipay\Saferpay\Message;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class AuthorizeDirectRequest extends AbstractRequest
{
    private const ENDPOINT = '/Payment/v1/Transaction/AuthorizeDirect';

    public function getTerminalId(): string
    {
        return $this->getParameter('terminalId');
    }

    public function setTerminalId(string $terminalId): self
    {
        return $this->setParameter('terminalId', $terminalId);
    }

    public function getRecurring(): bool
    {
        return $this->getParameter('recurring');
    }

    public function setRecurring(bool $value): self
    {
        return $this->setParameter('recurring', $value);
    }

    public function getCardRefId(): string
    {
        return $this->getParameter('cardRefId');
    }

    public function setCardRefId(string $value): self
    {
        return $this->setParameter('cardRefId', $value);
    }

    public function getData()
    {
        $data = [
            'Payment' => [
                'Amount' => [
                    'Value' => (string) ($this->getAmount() * (10 ** $this->getCurrencyDecimalPlaces())),
                    'CurrencyCode' => $this->getCurrency(),
                ],
            ],
            'TerminalId' => $this->getTerminalId(),
            'PaymentMeans' => [
                'Alias' => [
                    'Id' => $this->getCardRefId(),
                ],
            ],
        ];

        if ($this->getRecurring()) {
            $data['Payment']['Recurring'] = ['Initial' => true];
        }

        return $data;
    }

    protected function getEndpoint(): string
    {
        return self::ENDPOINT;
    }

    protected function createResponse(HttpResponseInterface $response): Response
    {
        return new CompleteAuthorizeResponse($this, $response);
    }
}
