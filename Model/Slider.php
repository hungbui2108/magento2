<?php
namespace Hungbd\Slider\Model;
class Slider extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'hungbd_slider_slider';

    protected $_cacheTag = 'hungbd_slider_slider';

    protected $_eventPrefix = 'hungbd_slider_slider';

    protected function _construct()
    {
        $this->_init('Hungbd\Slider\Model\ResourceModel\Slider');
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