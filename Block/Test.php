<?php
/**
 * Created by PhpStorm.
 * User: hungbd
 * Date: 27/12/2017
 * Time: 11:13
 */
namespace Hungbd\Slider\Block;

use Magento\Store\Model\StoreManagerInterface;

    class Test extends \Magento\Framework\View\Element\Template
{
    protected $_listCollection;
    protected $_slider;
    protected $_storeManager;
    protected $_resgistry;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
                                \Hungbd\Slider\Model\SliderImage $list,
                                \Hungbd\Slider\Model\Slider $slider,
                                \Magento\Framework\Registry $registry,
                                StoreManagerInterface $storeManager)
    {
        $this->_storeManager = $storeManager;
        $this->_slider = $slider;
        $this->_resgistry = $registry;
        $this->_listCollection= $list->getCollection();
        parent::__construct($context);
    }

    public function getListImage($slider_id)
    {
        $imageListCollection = $this->_listCollection;
        $imageListCollection->getSelect()->join(['image' =>'hungbd_image'], 'main_table.image_id = image.id')->where('main_table.slider_id = '.$slider_id);
        return $imageListCollection;
    }

    public function getStoreUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function checkVisableCategory($slider_id)
    {
        $currentCategoryId = $this->_resgistry->registry('current_category')->getId();
        $slider = $this->_slider->load($slider_id);
        $categoryList = explode(',',$slider->getCategory_id());
        if (in_array($currentCategoryId,$categoryList)){
            return true;
        }
        return false;
    }
}