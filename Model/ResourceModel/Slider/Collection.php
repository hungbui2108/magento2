<?php
namespace Hungbd\Slider\Model\ResourceModel\Slider;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'hungbd_slider_slider_collection';
    protected $_eventObject = 'slider_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Hungbd\Slider\Model\Slider', 'Hungbd\Slider\Model\ResourceModel\Slider');
    }

}
