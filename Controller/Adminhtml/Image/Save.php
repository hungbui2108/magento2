<?php
namespace Hungbd\Slider\Controller\Adminhtml\Image;

use Magento\Backend\App\Action;
use Hungbd\Slider\Model\Image;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;

class Save extends \Magento\Backend\App\Action
{

    protected $_image;
    protected $_fileUploaderFactory;
    protected $_fileSystem;
    protected $_storeManager;
    /**
     * @param Action\Context $context
     */
    public function __construct(Action\Context $context,Image $image,UploaderFactory $fileUploader,Filesystem $fileSystem, StoreManagerInterface  $storeManager)
    {
        $this->_fileUploaderFactory = $fileUploader;
        $this->_image = $image;
        $this->_fileSystem = $fileSystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
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
        $uploadInfo = $this->getRequest()->getParam('upload');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Hungbd\Slider\Model\Image $model */
            $model = $this->_image;

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }
            if (!empty($uploadInfo[0]['db_file'])){
                $model->setLink($uploadInfo[0]['db_file']);
            }
            $model->setName($this->getRequest()->getParam('name'));

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this Image.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Image.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}