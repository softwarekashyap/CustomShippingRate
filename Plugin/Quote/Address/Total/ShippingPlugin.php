<?php

/**
 * @author Kashyap Team
 * @copyright Copyright (c) 2018 Kashyap (softwarekashyap@gmail.com)
 * @package Kashyap_CustomShippingRate
*/

namespace Kashyap\CustomShippingRate\Plugin\Quote\Address\Total;

use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Address\Rate;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\Shipping;
use Kashyap\CustomShippingRate\Helper\Data;
use Kashyap\CustomShippingRate\Model\Carrier;

/**
 * Class ShippingPlugin
 * @package Kashyap\CustomShippingRate\Plugin\Quote\Address\Total
 */
class ShippingPlugin
{
    /**
     * @var Data
     */
    protected $customShippingRateHelper;

    /**
     * @param Data $customShippingRateHelper
     */
    public function __construct(
        Data $customShippingRateHelper
    ) {
        $this->customShippingRateHelper = $customShippingRateHelper;
    }

    /**
     * @param Shipping $subject
     * @param callable $proceed
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total $total
     * @return mixed
     */
    public function aroundCollect(
        Shipping $subject,
        callable $proceed,
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        $shipping = $shippingAssignment->getShipping();
        $address = $shipping->getAddress();
        $method = $address->getShippingMethod();

        if (!$this->customShippingRateHelper->isEnabled($quote->getStore()->getStoreId())
            || $address->getAddressType() != Address::ADDRESS_TYPE_SHIPPING
            || strpos($method, Carrier::CODE) === false
        ) {
            return $proceed($quote, $shippingAssignment, $total);
        }

        $customShippingOption = $this->getCustomShippingJsonToArray($method, $address);

        if ($customShippingOption && strpos($method, $customShippingOption['code']) !== false) {
            //update shipping code
            $shipping->setMethod($customShippingOption['code']);
            $address->setShippingMethod($customShippingOption['code']);
            $this->updateCustomRate($address, $customShippingOption);
        }

        return $proceed($quote, $shippingAssignment, $total);
    }

    /**
     * @param $address
     * @param $customShippingOption
     */
    protected function updateCustomRate($address, $customShippingOption)
    {
        if ($selectedRate = $this->getSelectedShippingRate($address, $customShippingOption['code'])) {
            $cost = (float) $customShippingOption['rate'];
            $description = trim($customShippingOption['description']);

            $selectedRate->setPrice($cost);
            $selectedRate->setCost($cost);
            //Empty by default. Use in third-party modules
            if (!empty($description) || strlen($description) > 2) {
                $selectedRate->setMethodTitle($description);
            }
        }
    }

    /**
     * @param $json
     * @param $address
     * @return array|bool
     */
    private function getCustomShippingJsonToArray($json, $address)
    {
        $isJson = $this->customShippingRateHelper->isJson($json);

        //reload exist shipping cost if custom shipping method
        if ($json && !$isJson) {
            $rate = 0;
            if ($selectedRate = $this->getSelectedShippingRate($address, $json)) {
                $rate = $selectedRate->getPrice();
            }

            $jsonToArray = [
                'code' => $json,
                'type' => $this->customShippingRateHelper->getShippingCodeFromMethod($json),
                'rate' => $rate
            ];

            return $this->formatShippingArray($jsonToArray);
        }

        $jsonToArray = (array)json_decode($json, true);

        if (is_array($jsonToArray) && count($jsonToArray) == 4) {
            return $this->formatShippingArray($jsonToArray);
        }

        return false;
    }

    /**
     * @param $address
     * @param $code
     * @return null | Rate
     */
    protected function getSelectedShippingRate($address, $code)
    {
        $selectedRate = null;

        if ($code) {
            foreach ($address->getAllShippingRates() as $rate) {
                if ($rate->getCode() == $code) {
                    $selectedRate = $rate;
                    break;
                }
            }
        }

        return $selectedRate;
    }

    /**
     * @param $jsonToArray array
     * @return array
     */
    protected function formatShippingArray($jsonToArray)
    {
        $customShippingOption = [
            'code' => '',
            'rate' => 0,
            'type' => '',
            'description' => ''
        ];

        foreach ((array) $jsonToArray as $key => $value) {
            $customShippingOption[$key] = $value;
        }

        return $customShippingOption;
    }
}
