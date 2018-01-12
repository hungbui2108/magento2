<?php
namespace Hungbd\Slider\Controller\Index;
use Magento\Framework\App\ObjectManager;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $_sliderFactory;

    protected $_imageFactory;


    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Hungbd\Slider\Model\ImageFactory $sliderFactory,
        \Hungbd\Slider\Model\SliderFactory $imageFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_sliderFactory = $sliderFactory;
        $this->_imageFactory = $imageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $post = $this->_sliderFactory->create();
        $collection = $post->getCollection();
        foreach($collection as $item){
            echo "<pre>";
            var_dump($item->getData());
            echo "</pre>";
        }
        $test = $this->_imageFactory->create();
        $collection = $test->getCollection();
        foreach($collection as $item){
            echo "<pre>";
            print_r($item->getData());
            echo "</pre>";
        }

        $object =  ObjectManager::getInstance();
        $collection = $object->create('Hungbd\Slider\Model\SliderImage')->getCollection();
        foreach($collection as $item){
            echo "<pre> test";
            print_r($item->getData());
            echo "</pre>";
        }

        exit();
        return $this->_pageFactory->create();
//    echo 'helllo world';
    }
}