<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lovevox\CustomizableOptions\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ProductOptions\ConfigInterface;
use Magento\Catalog\Model\Config\Source\Product\Options\Price as ProductOptionsPrice;
use Magento\Framework\UrlInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Swatches\Model\Swatch;
use Magento\Ui\Component\Form\Element\Hidden;
use Magento\Ui\Component\Modal;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Element\ActionDelete;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\DataType\Number;
use Magento\Framework\Locale\CurrencyInterface;

/**
 * Data provider for "Customizable Options" panel
 *
 * @api
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 101.0.0
 */
class CustomOptions  extends \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\CustomOptions
{
    const FIELD_SWATCHES_NAME = 'swatch';

    /**
     * Get config for grid for "select" types
     *
     * @param int $sortOrder
     * @return array
     * @since 101.0.0
     */
    protected function getSelectTypeGridConfig($sortOrder)
    {
        $config = parent::getSelectTypeGridConfig($sortOrder);
//        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//        /** @var \Psr\Log\LoggerInterface $logger */
//        $logger = $objectManager->get('\Psr\Log\LoggerInterface');
//        $logger->info("getSelectTypeGridConfig ==> info: ". json_encode($config));
        //2020.11.23 rfq 增加swatch颜色选择
        $config['children']['record']['children'][static::FIELD_SWATCHES_NAME] = $this->getSwatchFieldConfig(15);
        return $config;
    }

    /**
     * 2020.11.23 rfq 增加swatch颜色选择
     * Get config for "Swatch" field
     *
     * @param int $sortOrder
     * @return array
     * @since 101.0.0
     */
    protected function getSwatchFieldConfig($sortOrder)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Swatches\Helper\Media  $mediaHelper */
        $mediaHelper = $objectManager->get(\Magento\Swatches\Helper\Media::class);
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Swatch'),
                        'component' => 'Lovevox_CustomizableOptions/js/components/swatch-extend',
                        'template' => 'Lovevox_CustomizableOptions/swatch-visual',
                        'componentType' => Select::NAME,
                        'formElement' => Select::NAME,
                        'dataScope' => static::FIELD_SWATCHES_NAME,
                        'dataType' => Text::NAME,
                        'prefixName' => 'swatchvisual.value',
                        'prefixElementName' => 'option_',
                        'swatchPath' => $mediaHelper->getSwatchMediaUrl(),
                        'uploadUrl' => $this->urlBuilder->getUrl('swatches/iframe/show'),
                        'additionalClasses' => [
                            'swatches-visual-col' => true,
                            'amprot-swatches-visual' => true,
                        ],
                        'imports' => [
                            'visible' => '${ $.name.replace(/container_option(.*)/,'
                                . '"container_option.container_additional.use_swatches") }:checked'
                        ],
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
        ];
    }
}
