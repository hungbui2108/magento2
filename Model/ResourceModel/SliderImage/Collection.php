<?php
/**
 * Created by PhpStorm.
 * User: hungbd
 * Date: 28/12/2017
 * Time: 13:52
 */
namespace Hungbd\Slider\Model\ResourceModel\SliderImage;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'hungbd_slider_sliderimage_collection';
    protected $_eventObject = 'sliderimage_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Hungbd\Slider\Model\SliderImage', 'Hungbd\Slider\Model\ResourceModel\SliderImage');
    }

}