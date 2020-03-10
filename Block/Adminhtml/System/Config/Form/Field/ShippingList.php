<?php

/**
 * @author Kashyap Team
 * @copyright Copyright (c) 2018 Kashyap (softwarekashyap@gmail.com)
 * @package Kashyap_CustomShippingRate
*/

namespace Kashyap\CustomShippingRate\Block\Adminhtml\System\Config\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Kashyap\CustomShippingRate\Helper\Data;

/**
 * Class ShippingList
 * @package Kashyap\CustomShippingRate\Block\Adminhtml\System\Config\Form\Field
 */
class ShippingList extends AbstractFieldArray
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * ShippingList constructor.
     * @param Context $context
     * @param Data $helperData
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $helperData,
        array $data = []
    ) {
        $this->helper = $helperData;
        parent::__construct($context, $data);
    }

    /**
     * Initialise columns for 'Store Locations'
     * Label is name of field
     * Class is storefront validation action for field
     *
     * @return void
     */
    protected function _construct()
    {
        foreach ($this->helper->getHeaderColumns() as $key => $column) {
            $this->addColumn(
                $key,
                [
                    'label' => __($column['label']),
                    'class' => $column['class']
                ]
            );
        }

        $this->_addAfter = false;
        parent::_construct();
    }
}
