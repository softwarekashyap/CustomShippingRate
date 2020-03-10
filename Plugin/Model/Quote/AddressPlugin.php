<?php

/**
 * @author Kashyap Team
 * @copyright Copyright (c) 2018 Kashyap (softwarekashyap@gmail.com)
 * @package Kashyap_CustomShippingRate
*/

namespace Kashyap\CustomShippingRate\Plugin\Model\Quote;

use Magento\Quote\Api\Data\AddressInterface;

/**
 * Class AddressPlugin
 * @package Kashyap\CustomShippingRate\Plugin\Model\Quote
 */
class AddressPlugin
{

    /**
     * @param AddressInterface $subject
     * @param callable $proceed
     * @return mixed
     */
    public function aroundCollectShippingRates(AddressInterface $subject, callable $proceed)
    {
        $price = null;
        $description = null;

        //get custom shipping rate set by admin
        foreach ($subject->getAllShippingRates() as $rate) {
            if ($rate->getCode() == $subject->getShippingMethod()) {
                $price = $rate->getPrice();
                $description = $rate->getMethodTitle();
                break;
            }
        }

        $return = $proceed();

        if ($price !== null) {
            //reset custom shipping rate
            foreach ($subject->getAllShippingRates() as $rate) {
                if ($rate->getCode() == $subject->getShippingMethod()) {
                    $rate->setPrice($price);
                    $rate->setCost($price);
                    $rate->setMethodTitle($description);
                    break;
                }
            }
        }

        return $return;
    }
}
