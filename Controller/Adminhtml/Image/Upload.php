<?php
namespace Hungbd\Slider\Controller\Adminhtml\Image;
use Magento\Framework\Controller\ResultFactory;
class Upload extends \Magento\Backend\App\Action {
    protected $imageUploader;

    protected $_fileSystem;

    protected $_storeManager;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem $filesystem
    ) {
        parent::__construct($context);
        $this->imageUploader = $fileUploaderFactory;
        $this->_storeManager = $storeManager;
        $this->_fileSystem = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
    }

    public function execute()
    {
        try {
            $result = array();
            $uploader = $this->imageUploader->create(['fileId' => 'upload']);
            $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
            $uploader->setAllowCreateFolders(true);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $path = $this->_fileSystem->getAbsolutePath('hungbd_slider/image');
            $result = $uploader->save($path,$_FILES['upload']['name']);
            $result['db_file'] = $this->_fileSystem->getRelativePath('hungbd_slider/image').$uploader->getUploadedFileName();
            $result['url'] = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).$this->_fileSystem->getRelativePath('hungbd_slider/image').$uploader->getUploadedFileName();
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}