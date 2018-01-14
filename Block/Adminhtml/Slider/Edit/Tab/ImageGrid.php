<?php
/**
 * User: vothanhphong
 * Date: 12/24/17
 * Time: 2:34 PM
 */

namespace Hungbd\Slider\Block\Adminhtml\Slider\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Hungbd\Slider\Model\ResourceModel\Image\CollectionFactory;
use Magento\Framework\Registry;
use Hungbd\Slider\Model\ImageFactory;
use Hungbd\Slider\Model\SliderImage;

class ImageGrid extends Extended
{
    /**
     * @var CollectionFactory
     */
    protected $_imageCollectionFactory;

    /**
     * @var LabelFactory
     */
    protected $_imageFactoty;
    /**
     * @var  Registry
     */
    protected $registry;
    /**
     * @var SliderFactory
     */
    protected $_sliderFactory;

    /**
     * @var SliderImage
     */
    protected $_listFactory;
    /**
     *
     * @param Context           $context
     * @param Data              $backendHelper
     * @param Registry          $registry
     * @param ImageFactory      $imageFactory
     * @param SliderImage      $listFactory
     * @param CollectionFactory $imageCollectionFactory
     * @param array             $data
     */
    public function __construct(Context $context, Data $backendHelper, Registry $registry, ImageFactory $imageFactory,
                                CollectionFactory $imageCollectionFactory, SliderImage $listFactory, array $data = [])
    {
        $this->_listFactory = $listFactory;
        $this->_imageFactoty = $imageFactory;
        $this->_imageCollectionFactory = $imageCollectionFactory;
        $this->registry = $registry;

        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * _construct
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('imageGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(array('id_image' => 1));
        }
    }

    /**
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'id_image') {
            $imageIds = $this->_getSelectedImages();

            if (empty($imageIds)) {
                $imageIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('id', array('in' => $imageIds));
            } else {
                if ($imageIds) {
                    $this->getCollection()->addFieldToFilter('id', array('nin' => $imageIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    /**
     * prepare collection
     */
    protected function _prepareCollection()
    {
        $collection = $this->_imageCollectionFactory->create();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     * @throws \Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_image',
            [
                'header_css_class' => 'a-center',
                'type'             => 'checkbox',
                'name'             => 'in_image',
                'align'            => 'center',
                'index'            => 'id',
                'values'           => $this->_getSelectedImages(),
            ]
        );

        $this->addColumn(
            'id',
            [
                'header'           => __('image ID'),
                'type'             => 'number',
                'name'             => 'id',
                'index'            => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index'  => 'name',
            ]
        );
        $this->addColumn(
            'link',
            [
                'header' => __('Type'),
                'index'  => 'link',
                'renderer'  => '\Hungbd\Slider\Block\Adminhtml\Slider\Helper\Image',
            ]
        );
        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/imageGrid', ['_current' => true]);
    }

    /**
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return '';
    }

    /**
     * @return mixed
     */
    protected function _getSelectedImages()
    {
        $collection = $this->_listFactory->getCollection();
        $collection->getSelect()
            ->join(['image' =>'hungbd_image'], 'main_table.image_id = image.id')
            ->where('main_table.slider_id = '.$this->getRequest()->getParam('id'));
        $listImage= [];
        foreach ($collection as $item){
            $listImage[] = $item->getImage_id();
        }
        $test = $listImage;
        return $listImage;
    }

    /**
     * Retrieve selected images
     *
     * @return array
     */
    public function getSelectedImages()
    {
        $selected = $this->_getSelectedImages();

        if (!is_array($selected)) {
            $selected = [];
        }

        return $selected;
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return true;
    }
}