<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Lovevox\CustomizableOptions\Model\Product;

use Magento\Catalog\Api\Data\ProductCustomOptionValuesInterfaceFactory;


/**
 * Class Option
 * @package Lovevox\CustomizableOptions\Model\Product
 */
class Option extends \Magento\Catalog\Model\Product\Option
{

    const KEY_SWATCH = 'swatch';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory
     * @param \Magento\Catalog\Model\Product\Option\Value $productOptionValue
     * @param \Magento\Catalog\Model\Product\Option\Type\Factory $optionFactory
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Catalog\Model\Product\Option\Validator\Pool $validatorPool
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     * @param ProductCustomOptionValuesInterfaceFactory|null $customOptionValuesFactory
     * @param array $optionGroups
     * @param array $optionTypesToGroups
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Catalog\Model\Product\Option\Value $productOptionValue,
        \Magento\Catalog\Model\Product\Option\Type\Factory $optionFactory,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Model\Product\Option\Validator\Pool $validatorPool,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [],
        ProductCustomOptionValuesInterfaceFactory $customOptionValuesFactory = null,
        array $optionGroups = [],
        array $optionTypesToGroups = []
    )
    {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $productOptionValue,
            $optionFactory,
            $string,
            $validatorPool,
            $resource,
            $resourceCollection,
            $data,
            $customOptionValuesFactory,
            $optionGroups,
            $optionTypesToGroups
        );
    }

    /**
     * Set Sku
     * 2020.11.23 荣发强 增加swatch属性
     * @param string $sku
     * @return $this
     */
    public function setSwatch($swatch)
    {
        return $this->setData(self::KEY_SWATCH, $swatch);
    }

    /**
     * Get Sku
     * 2020.11.23 荣发强 增加swatch属性
     * @return string|null
     */
    public function getSwatch()
    {
        return $this->_getData(self::KEY_SWATCH);
    }

}
