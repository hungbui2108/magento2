<?php
/**
 * Created by PhpStorm.
 * User: hungbd
 * Date: 04/01/2018
 * Time: 11:15
 */
namespace Hungbd\Slider\Model;

use Hungbd\Slider\Model\Slider;
use Hungbd\Slider\Model\SliderImage;

class SliderProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $_loadedData;
    protected $_list;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Slider $slider,
        SliderImage $list,
        array $meta = [],
        array $data = []
    ) {
        $this->_list = $list;
        $this->collection = $slider->getCollection();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $listImage = $this->_list->getCollection();
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $slider) {
            $array = array();
            foreach ($listImage as $value){
                if ($slider->getId() == $value['slider_id']){
                    $array[] = $value['image_id'];
                }
            }
            $category_id = $slider->getCategory_id();
            $category_id = explode(',',$category_id);
            $this->_loadedData[$slider->getId()] = $slider->getData();
            $this->_loadedData[$slider->getId()]['image'] = $array;
            $this->_loadedData[$slider->getId()]['category'] = $category_id;
        }
        return $this->_loadedData;
    }
}