<?php
/**
 * Created by PhpStorm.
 * User: hungbd
 * Date: 03/01/2018
 * Time: 09:53
 */

namespace Hungbd\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $_image;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Hungbd\Slider\Model\Image $image
    )
    {
        $this->_image = $image;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Edit Image post
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->getRequest()->getParam('id')) {
            /** @var \Hungbd\Slider\Model\Image $model */
            $model = $this->_image;

            $id = $this->getRequest()->getParam('id');

            try {
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('You delete this Image.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while delete the Image.'));
            }

            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}