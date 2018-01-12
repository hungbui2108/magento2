<?php

namespace Hungbd\Slider\Model\Source;

use Hungbd\Slider\Model\Slider;

class SliderWidgetValues implements \Magento\Framework\Option\ArrayInterface
{
    protected $_slider;

    public function __construct(Slider $slider)
    {
        $this->_slider = $slider;
    }

    public function toOptionArray()
    {
        $collection = $this->_slider->getCollection();
        $data = array();
        foreach ($collection as $key => $item){
            $data[$key]['value'] = $item['id'];
            $data[$key]['label'] = $item['name'];
        }
        return $data;
    }
}