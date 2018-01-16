<?php
/**
 * Created by PhpStorm.
 * User: hungbd
 * Date: 28/12/2017
 * Time: 13:53
 */

namespace Hungbd\Slider\Model\ResourceModel;


class SliderImage extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('hungbd_list', 'id');
    }

}