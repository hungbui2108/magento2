<?php

namespace Hungbd\Slider\Block\Adminhtml\Slider\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class Main extends Generic implements TabInterface
{
    protected $_descriptionModel;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Contenuto Store Locator'),
                'class' => 'fieldset-wide'
            ]
        );

        $fieldset->addField(
            'id',
            'hidden',
            [
                'name' => 'id'
            ]
        );

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'class' => 'txt-type',
                'title' => __('Name'),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'category_id',
            'Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Category',
            [
                'name' => 'category_id',
                'label' => __('Category'),
                'title' => __('Category'),
                'required' => true
            ]
        );

        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Return Tab label
     *
     * @return string
     * @api
     */
    public function getTabLabel()
    {
        return __('Slider');
    }

    /**
     * Return Tab title
     *
     * @return string
     * @api
     */
    public function getTabTitle()
    {
        return __('Slider');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     * @api
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     * @api
     */
    public function isHidden()
    {
        return false;
    }
}