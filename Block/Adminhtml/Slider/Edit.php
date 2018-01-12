<?php

namespace Hungbd\Slider\Block\Adminhtml\Slider;

use Magento\Backend\Block\Widget\Form\Container;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Department edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'entity_id';
        $this->_blockGroup = 'Hungbd_Slider';
        $this->_controller = 'adminhtml_slider';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save'));
//        $this->buttonList->add(
//            'saveandcontinue',
//            [
//                'label' => __('Salva e continua modifica'),
//                'class' => 'save',
//                'data_attribute' => [
//                    'mage-init' => [
//                        'button' => [
//                            'event' => 'saveAndContinueEdit',
//                            'target' => '#edit_form'
//                        ],
//                    ],
//                ]
//            ],
//            -100
//        );

    }

    /**
     * Get header with Department name
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('slider_slider')->getId()) {
            return __("Edit slider " . $this->_coreRegistry->registry('slider_slider')->getId());
        } else {
            return __('New Slider');
        }
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('slider/slider/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }

}