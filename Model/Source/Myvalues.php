<?php

namespace Hungbd\Slider\Model\Source;

use Hungbd\Slider\Model\Image;

class Myvalues implements \Magento\Framework\Option\ArrayInterface
{
    protected $_image;

    public function __construct(Image $image)
    {
        $this->_image = $image;
    }

    public function toOptionArray()
    {
        $collection = $this->_image->getCollection();
        $data = array();
        foreach ($collection as $key => $item){
            $data[$key]['value'] = $item['id'];
            $data[$key]['label'] = $item['name'];
        }
        return $data;
    }
}