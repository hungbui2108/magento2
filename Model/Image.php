<?php

namespace Hungbd\Slider\Model;

class Image extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'hungbd_slider_image';

    protected $_cacheTag = 'hungbd_slider_image';

    protected $_eventPrefix = 'hungbd_slider_image';

    protected function _construct()
    {
        $this->_init('Hungbd\Slider\Model\ResourceModel\Image');
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