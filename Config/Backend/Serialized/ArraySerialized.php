<?php

/**
 * @author Kashyap Team
 * @copyright Copyright (c) 2018 Kashyap (softwarekashyap@gmail.com)
 * @package Kashyap_CustomShippingRate
*/

namespace Kashyap\CustomShippingRate\Config\Backend\Serialized;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Kashyap\CustomShippingRate\Helper\Data;

/**
 * Class ArraySerialized
 * @package Kashyap\CustomShippingRate\Config\Backend\Serialized
 */
class ArraySerialized extends \Magento\Config\Model\Config\Backend\Serialized\ArraySerialized
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * ArraySerialized constructor.
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param Data $helperData
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        Data $helperData,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data
        );

        $this->helper = $helperData;
    }

    /**
     * @return void
     */
    protected function _afterLoad()
    {
        parent::_afterLoad();

        $this->setValue($this->helper->shippingArrayObject($this->getValue()));
    }
}
