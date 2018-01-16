<?php

namespace Hungbd\Slider\Controller\Adminhtml\Image;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Hungbd\Slider\Model\Image;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class MassDisable
 */
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $_image;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, Image $image)
    {
        $this->_image = $image;
        $this->filter = $filter;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->_image->getCollection());
        $collectionSize = $collection->getSize();

        foreach ($collection as $item) {
            $this->_image->setId($item->getId())->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}