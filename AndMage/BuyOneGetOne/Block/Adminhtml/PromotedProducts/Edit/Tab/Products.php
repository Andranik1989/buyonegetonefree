<?php

namespace AndMage\BuyOneGetOne\Block\Adminhtml\PromotedProducts\Edit\Tab;

use AndMage\BuyOneGetOne\Model\PromotedProductsFactory;
use AndMage\BuyOneGetOne\Model\ResourceModel\PromotedProducts\Grid\Collection;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

/**
 * Class Products
 * @package AndMage\BuyOneGetOne\Block\Adminhtml\PromotedProducts\Edit\Tab
 */
class Products extends Extended
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $productCollectionFactory;

    /**
     * @var PromotedProductsFactory $promotedProductsFactory
     */
    protected PromotedProductsFactory $promotedProductsFactory;

    /**
     * @var Registry
     */
    protected Registry $registry;

    /**
     * @var Collection
     */
    protected Collection $collection;


    /**
     * @param Context $context
     * @param Data $backendHelper
     * @param Registry $registry
     * @param PromotedProductsFactory $promotedProductsFactory
     * @param CollectionFactory $productCollectionFactory
     * @param Collection $collection
     * @param array $data
     */
    public function __construct(
        Context                 $context,
        Data                    $backendHelper,
        Registry                $registry,
        PromotedProductsFactory $promotedProductsFactory,
        CollectionFactory       $productCollectionFactory,
        Collection              $collection,
        array                   $data = []
    )
    {
        $this->promotedProductsFactory = $promotedProductsFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->registry = $registry;
        $this->collection = $collection;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * _construct
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('productsGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('entity_id')) {
            $this->setDefaultFilter(array('in_product' => 1));
        }
    }

    /**
     * @return Products
     */
    protected function _prepareCollection()
    {
        $productCollection = $this->collection->load()->getData();
        $excludedIds = [];
        if (count($productCollection) > 0) {
            foreach ($productCollection as $item) {
                $excludedIds[] = $item['product_id'];
            }
        }
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('sku');
        $collection->addAttributeToSelect('price');
        if (!empty($excludedIds)) {
            $collection->addAttributeToFilter('entity_id', ['nin' => $excludedIds]);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_product',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_product',
                'align' => 'center',
                'index' => 'entity_id'
            ]
        );

        $this->addColumn(
            'entity_id',
            [
                'header' => __('Product ID'),
                'type' => 'number',
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'sku',
            [
                'header' => __('Sku'),
                'index' => 'sku',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'index' => 'price',
                'width' => '50px',
            ]
        );
        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/productsgrid', ['_current' => true]);
    }

    /**
     * @param object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return '';
    }
}
