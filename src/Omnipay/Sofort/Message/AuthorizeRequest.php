<?php

namespace simplesurance\Omnipay\Sofort\Message;

use SimpleXMLElement;

class AuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><multipay/>');

        $data->addChild('project_id', $this->getProjectId());
        $data->addChild('amount', $this->getAmount());
        $data->addChild('currency_code', $this->getCurrency());
        $data->addChild('success_url', str_replace('&', '&amp;', (string) $this->getReturnUrl()));
        $data->addChild('abort_url', str_replace('&', '&amp;', (string) $this->getCancelUrl()));
        $data->addChild('notification_urls')->addChild(
            'notification_url',
            str_replace('&', '&amp;', (string) $this->getNotifyUrl())
        );

        $reasons = $data->addChild('reasons');

        if (is_string($this->getDescription())) {
            $reasons->addChild('reason', $this->translit($this->getDescription()));
        } elseif (is_array($this->getDescription())) {
            foreach ($this->getDescription() as $reason) {
                $reasons->addChild('reason', $this->translit($reason));
            }
        }

        $su = $data->addChild('su');
        $su->addChild('customer_protection', 1);

        $sender = $data->addChild('sender');
        $sender->addChild('country_code', $this->getCountry());

        return $data;
    }

    protected function createResponse($response)
    {
        return $this->response = new AuthorizeResponse($this, $response);
    }

    protected function translit($content)
    {
        return extension_loaded('intl') ? transliterator_transliterate('Any-Latin; Latin-ASCII', $content) : $content;
    }
}
