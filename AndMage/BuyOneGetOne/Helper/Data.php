<?php

namespace AndMage\BuyOneGetOne\Helper;

use AndMage\BuyOneGetOne\Model\ResourceModel\PromotedProducts\Grid\CollectionFactory;
use Magento\Framework\App\Helper\Context;
use Magento\Backend\Model\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Data
 * @package AndMage\BuyOneGetOne\Helper
 */
class Data extends AbstractHelper
{

    /**
     * @var UrlInterface
     */
    protected UrlInterface $_backendUrl;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param UrlInterface $backendUrl
     * @param StoreManagerInterface $storeManager
     * @param Collection $collection
     */
    public function __construct(
        Context               $context,
        UrlInterface          $backendUrl,
        StoreManagerInterface $storeManager,
        CollectionFactory            $collectionFactory
    )
    {
        parent::__construct($context);
        $this->_backendUrl = $backendUrl;
        $this->storeManager = $storeManager;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return string
     */
    public function getProductsGridUrl(): string
    {
        return $this->_backendUrl->getUrl('buyonegetone/promotedproducts/products', ['_current' => true]);
    }

    /**
     * @param $productId
     * @return bool
     */
    public function getDiscountProductExist($productId): bool
    {
        $productCollection = $this->collectionFactory->create()->addFieldToFilter('product_id', ['eq' => $productId])->load()->getData();
        if (count($productCollection) !== 0) return true;
        return false;
    }
}
