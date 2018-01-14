<?php
namespace Hungbd\Slider\Helper;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var UrlInterface
     */
    protected $_backendUrl;

    /**
     * @var StoreManagerInterface $storeManager
     */
    protected $storeManager;

    /**
     * Data constructor.
     * @param Context               $context
     * @param UrlInterface          $backendUrl
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(Context $context, UrlInterface $backendUrl, StoreManagerInterface $storeManager)
    {
        parent::__construct($context);
        $this->_backendUrl = $backendUrl;
        $this->storeManager = $storeManager;
    }

    /**
     * get products tab Url in admin
     * @return string
     */
    public function getImageGridUrl()
    {
        return $this->_backendUrl->getUrl('slider/slider/image', ['_current' => true]);
    }
}