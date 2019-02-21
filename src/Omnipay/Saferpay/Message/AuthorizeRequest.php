<?php

namespace simplesurance\Omnipay\Saferpay\Message;

class AuthorizeRequest extends AbstractRequest
{
    protected $endpoint = 'CreatePayInit.asp';

    public function getAutoClose()
    {
        return $this->getParameter('autoClose');
    }

    public function setAutoClose($value)
    {
        return $this->setParameter('autoClose', $value);
    }

    public function getCcName()
    {
        return $this->getParameter('ccName');
    }

    public function setCcName($value)
    {
        return $this->setParameter('ccName', $value);
    }

    public function getShowLanguages()
    {
        return $this->getParameter('showLanguages');
    }

    public function setShowLanguages($value)
    {
        return $this->setParameter('showLanguages', $value);
    }

    public function getPaymentMethods()
    {
        return $this->getParameter('paymentMethods');
    }

    public function setPaymentMethods($value)
    {
        return $this->setParameter('paymentMethods', $value);
    }

    public function getDelivery()
    {
        return $this->getParameter('delivery');
    }

    public function setDelivery($value)
    {
        return $this->setParameter('delivery', $value);
    }

    public function getAppearance()
    {
        return $this->getParameter('appearance');
    }

    public function setAppearance($value)
    {
        return $this->setParameter('appearance', $value);
    }

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    public function getVtConfig()
    {
        return $this->getParameter('vtConfig');
    }

    public function setVtConfig($value)
    {
        return $this->setParameter('vtConfig', $value);
    }

    public function getNotifyAddress()
    {
        return $this->getParameter('notifyAddress');
    }

    public function setNotifyAddress($value)
    {
        return $this->setParameter('notifyAddress', $value);
    }

    public function getUserNotify()
    {
        return $this->getParameter('userNotify');
    }

    public function setUserNotify($value)
    {
        return $this->setParameter('userNotify', $value);
    }

    public function getLangId()
    {
        return $this->getParameter('langId');
    }

    public function setLangId($value)
    {
        return $this->setParameter('langId', $value);
    }

    public function getDuration()
    {
        return $this->getParameter('duration');
    }

    public function setDuration($value)
    {
        return $this->setParameter('duration', $value);
    }

    public function getCardRefId()
    {
        return $this->getParameter('cardRefId');
    }

    public function setCardRefId($value)
    {
        return $this->setParameter('cardRefId', $value);
    }

    public function getRecurring()
    {
        return $this->getParameter('recurring');
    }

    public function setRecurring($value)
    {
        return $this->setParameter('recurring', $value);
    }

    public function getCustomerEmail()
    {
        return $this->getParameter('customerEmail');
    }

    public function setCustomerEmail($value)
    {
        return $this->setParameter('customerEmail', $value);
    }

    public function getData()
    {
        $data = array(
            'ACCOUNTID' => $this->getAccountId(),
            'AMOUNT' => $this->getAmount() * 100,
            'CURRENCY' => $this->getCurrency(),
            'ORDERID' => $this->getOrderId(),
            'SUCCESSLINK' => $this->getReturnUrl(),
            'FAILLINK' => $this->getCancelUrl(),
            'BACKLINK' => $this->getCancelUrl(),
            'NOTIFYURL' => $this->getNotifyUrl(),
            'AUTOCLOSE' => $this->getAutoClose(),
            'CCNAME' => $this->getCcName(),
            'SHOWLANGUAGES' => $this->getShowLanguages(),
            'PAYMENTMETHODS' => $this->getPaymentMethods(),
            'DELIVERY' =>   $this->getDelivery(),
            'APPEARANCE' => $this->getAppearance(),
            'VTCONFIG' => $this->getVtConfig(),
            'NOTIFYADDRESS' => $this->getNotifyAddress(),
            'USERNOTIFY' => $this->getUserNotify(),
            'LANGID' => $this->getLangId(),
            'DURATION' => $this->getDuration(),
            'EMAIL' => $this->getCustomerEmail()
        );

        if (extension_loaded('mbstring')) {
            $data['DESCRIPTION'] = mb_convert_encoding($this->getDescription(), 'HTML-ENTITIES', 'UTF-8');
        } else {
            $data['DESCRIPTION'] = $this->getDescription();
        }

        if ('yes' === $this->getRecurring()) {
            $data['CARDREFID'] = $this->getCardRefId();
            $data['RECURRING'] = $this->getRecurring();
        }

        return $data;
    }

    protected function createResponse($response)
    {
        return $this->response = new AuthorizeResponse($this, $response);
    }
}