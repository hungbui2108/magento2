<?php
/**
 * Created by PhpStorm.
 * User: hungbd
 * Date: 03/01/2018
 * Time: 09:53
 */

namespace Hungbd\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
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

    /**
     * @var \Hungbd\Slider\Model\Slider
     */
    protected $_slider;

    /**
     * @var \Hungbd\Slider\Model\SliderImage
     */
    protected $_sliderImage;

    /**
     * Edit constructor.
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Hungbd\Slider\Model\Slider $slider
     * @param \Hungbd\Slider\Model\SliderImage $sliderImage
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Hungbd\Slider\Model\Slider $slider,
        \Hungbd\Slider\Model\SliderImage $sliderImage
    ) {
        $this->_slider = $slider;
        $this->_sliderImage = $sliderImage;
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hungbd_Slider::hungbd')
            ->addBreadcrumb(__('Slider'), __('Slider'))
            ->addBreadcrumb(__('Manage Slider'), __('Manage Slider'));
        return $resultPage;
    }

    /**
     * Edit Image post
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_slider;
        $sliderImageModel = $this->_sliderImage;
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Image no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('slider_slider', $model);
        $this->_coreRegistry->register('sliderImage', $sliderImageModel);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Slider') : __('Edit Slider'),
            $id ? __('Edit Slider') : __('Edit Slider')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Slider'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('Edit Slider'));

        return $resultPage;
    }
}