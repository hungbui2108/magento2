<?php

namespace Hungbd\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Hungbd\Slider\Model\Slider;
use Hungbd\Slider\Model\SliderImage;
use Magento\Backend\Helper\Js;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var Slider
     */
    protected $_slider;

    /**
     * @var SliderImage
     */
    protected $_list;

    /**
     * @var Js
     */
    protected $_jsHelper;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param Slider $slider
     * @param SliderImage $list
     * @param Js $jsHelper
     */
    public function __construct(Action\Context $context, Slider $slider, SliderImage $list, Js $jsHelper)
    {
        $this->_list = $list;
        $this->_slider = $slider;
        $this->_jsHelper = $jsHelper;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Hungbd\Slider\Model\Slider $model */
            $model = $this->_slider;
            $Listmodel = $this->_list;
            $category = $this->getRequest()->getParam('category');
            $image = $this->_jsHelper->decodeGridSerializedInput($this->getRequest()->getParam('images'));
            $id = $this->getRequest()->getParam('id');
            $imageCollection = $Listmodel->getCollection()->addFilter('slider_id', $id);
            $listImage = [];
            foreach ($imageCollection as $item) {
                $listImage[] = $item->getImage_id();
                if (!in_array($item->getImage_id(), $image)) {
                    $item->delete();
                }
            }
            foreach ($image as $item) {
                if (!in_array($item, $listImage)) {
                    $newImage[] = $item;
                }
            }
            $listCate = '';
            foreach ($category as $item) {
                $listCate = $listCate . $item . ',';
            }
            $listCate = rtrim($listCate, ',');
            if ($id) {
                $model->load($id);
            }
            $model->setName($this->getRequest()->getParam('name'))->setCategory_id($listCate);
            try {
                $model->save();
                if (!empty($newImage)) {
                    foreach ($newImage as $item) {
                        $Listmodel->setSlider_id($model->getId())->setImage_id($item)->save();
                        $Listmodel->unsetData();
                    }
                }
                $this->messageManager->addSuccess(__('You saved this Slider.'));
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Slider.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}