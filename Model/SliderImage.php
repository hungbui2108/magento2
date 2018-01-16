<?php
/**
 * Created by PhpStorm.
 * User: hungbd
 * Date: 28/12/2017
 * Time: 11:19
 */

namespace Hungbd\Slider\Model;

class SliderImage extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'hungbd_slider_sliderimage';

    protected $_cacheTag = 'hungbd_slider_sliderimage';

    protected $_eventPrefix = 'hungbd_slider_sliderimage';

    protected function _construct()
    {
        $this->_init('Hungbd\Slider\Model\ResourceModel\SliderImage');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}