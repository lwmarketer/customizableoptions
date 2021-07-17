<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Lovevox\CustomizableOptions\Block\Product\View\Options\Type\Select;

use Magento\Catalog\Block\Product\View\Options\AbstractOptions;
use Magento\Catalog\Model\Product\Option;
use Magento\Framework\View\Element\Html\Select;

/**
 * Represent needed logic for dropdown and multi-select
 */
class Multiple extends \Magento\Catalog\Block\Product\View\Options\Type\Select\Multiple
{
    /**
     * @inheritdoc
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _toHtml()
    {
        $option = $this->getOption();

        if ($option->getTitle() == 'Color' &&
            $this->getRequest()->getFullActionName() != 'sales_order_create_configureProductToAdd') {
            $item = [];
            $store = $this->getProduct()->getStore();
            $div = '<div class="custom-swatches-block">';
            foreach ($option->getValues() as $_value) {
                $price = $this->pricingHelper->currencyByStore(
                    $_value->getPrice(true),
                    $store,
                    false
                );
                $swatch = $_value->getData('swatch') ?? '';
                $sku = $_value->getSku() ?? '';
                $class = ($_value->getTitle() == 'White') ? 'white' : '';
                $item[] = '<div class="swatch-color ' . $class . '" style="background: ' . $swatch . ' no-repeat center;background-size: initial;"
            data-option-id="' . $option->getId() . '"
            data-index="' . $_value->getOptionTypeId() . '"
            data-price="' . $price . '"
            data-sku="' . $sku . '"
            data-name="' . $_value->getTitle() . '"
            data-color="' . $swatch . '"></div>';
            }
            $item_div = implode('', $item);
            $div .= $item_div;
            $div .= '<input class="swatch-input super-attribute-select" name="super_attribute[' . $option->getId() . ']" type="text" value="" data-selector="super_attribute[' . $option->getId() . ']" data-validate="{required: true}" aria-required="true" aria-invalid="false">';
            $div .= '</div>';
            return $div;
        } else {
            $optionType = $option->getType();
            $configValue = $this->getProduct()->getPreconfiguredValues()->getData('options/' . $option->getId());
            $require = $option->getIsRequire() ? ' required' : '';
            $extraParams = '';
            /** @var Select $select */
            $select = $this->getLayout()->createBlock(
                Select::class
            )->setData(
                [
                    'id' => 'select_' . $option->getId(),
                    'class' => $require . ' product-custom-option admin__control-select',

                ]
            );
            $select = $this->insertSelectOption($select, $option);
            $select = $this->processSelectOption($select, $option);
            if ($optionType === Option::OPTION_TYPE_MULTIPLE) {
                $extraParams = ' multiple="multiple"';
            }
            if (!$this->getSkipJsReloadPrice()) {
                $extraParams .= ' onchange="opConfig.reloadPrice()"';
            }
            $extraParams .= ' data-selector="' . $select->getName() . '"';
            $select->setExtraParams($extraParams);
            if ($configValue) {
                $select->setValue($configValue);
            }
            return $select->getHtml();
        }
    }

    /**
     * Returns select with inserted option give as a parameter
     *
     * @param Select $select
     * @param Option $option
     * @return Select
     */
    private function insertSelectOption(Select $select, Option $option): Select
    {
        $require = $option->getIsRequire() ? ' required' : '';
        if ($option->getType() === Option::OPTION_TYPE_DROP_DOWN) {
            $select->setName('options[' . $option->getId() . ']')->addOption('', __('-- Please Select --'));
        } else {
            $select->setName('options[' . $option->getId() . '][]');
            $select->setClass('multiselect admin__control-multiselect' . $require . ' product-custom-option');
        }

        return $select;
    }

    /**
     * Returns select with formated option prices
     *
     * @param Select $select
     * @param Option $option
     * @return Select
     */
    private function processSelectOption(Select $select, Option $option): Select
    {
        $store = $this->getProduct()->getStore();
        foreach ($option->getValues() as $_value) {
            $isPercentPriceType = $_value->getPriceType() === 'percent';
            $priceStr = $this->_formatPrice(
                [
                    'is_percent' => $isPercentPriceType,
                    'pricing_value' => $_value->getPrice($isPercentPriceType)
                ],
                false
            );
            $select->addOption(
                $_value->getOptionTypeId(),
                $_value->getTitle() . ' ' . strip_tags($priceStr) . '',
                [
                    'price' => $this->pricingHelper->currencyByStore(
                        $_value->getPrice(true),
                        $store,
                        false
                    ),
//                    //2020.11.23 荣发强 展示swatch值
//                    'data-swatch' => $_value->getData('swatch') ?? '',
//                    'data-sku' => $_value->getSku() ?? ''
                ]
            );
        }
        return $select;
    }
}
