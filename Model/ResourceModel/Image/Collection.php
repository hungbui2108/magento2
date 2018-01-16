<?php

namespace Hungbd\Slider\Model\ResourceModel\Image;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'hungbd_slider_image_collection';
    protected $_eventObject = 'image_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Hungbd\Slider\Model\Image', 'Hungbd\Slider\Model\ResourceModel\Image');
    }

}