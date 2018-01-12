<?php
/**
 * Created by PhpStorm.
 * User: hungbd
 * Date: 02/01/2018
 * Time: 14:52
 */
namespace Hungbd\Slider\Controller\Adminhtml\Slider;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Sliders')));

        return $resultPage;
    }


}