<?php

namespace Hungbd\Slider\Model;

use Hungbd\Slider\Model\Image;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $_loadedData;
    protected $_storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Image $image,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    )
    {
        $this->_storeManager = $storeManager;
        $this->collection = $image->getCollection();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $image) {
            $this->_loadedData[$image->getId()] = $image->getData();
            $img = [];
            $img[0]['name'] = $image->getName();
            $img[0]['url'] = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $image->getLink();
            $this->_loadedData[$image->getId()]['upload'] = $img;
        }
        return $this->_loadedData;
    }
}