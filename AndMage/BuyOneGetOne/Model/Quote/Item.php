<?php
namespace AndMage\BuyOneGetOne\Model\Quote;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ObjectManager;
use Magento\Quote\Model\Quote\Item\Option\ComparatorInterface;
use Magento\Quote\Model\Quote\ItemRepository;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Sales\Model\Status\ListFactory;
use Magento\Framework\Locale\FormatInterface;
use Magento\Quote\Model\Quote\Item\OptionFactory;
use Magento\Quote\Model\Quote\Item\Compare;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Serialize\Serializer\Json;
use AndMage\BuyOneGetOne\Helper\Data as Helper;

/**
 * AndMage\BuyOneGetOne\Model\Quote\Item
 *
 * Class Item
 * @package AndMage\BuyOneGetOne\Model\Quote\
 */

class Item extends \Magento\Quote\Model\Quote\Item
{
    /**
     * @var Helper
     */
    protected Helper $helper;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param ProductRepositoryInterface $productRepository
     * @param PriceCurrencyInterface $priceCurrency
     * @param ListFactory $statusListFactory
     * @param FormatInterface $localeFormat
     * @param OptionFactory $itemOptionFactory
     * @param Compare $quoteItemCompare
     * @param StockRegistryInterface $stockRegistry
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @param Json|null $serializer
     * @param ComparatorInterface|null $itemOptionComparator
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface $priceCurrency,
        ListFactory $statusListFactory,
        FormatInterface $localeFormat,
        OptionFactory $itemOptionFactory,
        Compare $quoteItemCompare,
        StockRegistryInterface $stockRegistry,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Helper   $helper,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = [],
        Json $serializer = null,
        ?ComparatorInterface $itemOptionComparator = null
    ) {
        $this->_localeFormat = $localeFormat;
        $this->_itemOptionFactory = $itemOptionFactory;
        $this->quoteItemCompare = $quoteItemCompare;
        $this->stockRegistry = $stockRegistry;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->helper = $helper;
        $this->serializer = $serializer ?: ObjectManager::getInstance()
            ->get(Json::class);
        $this->itemOptionComparator = $itemOptionComparator
            ?: ObjectManager::getInstance()->get(ComparatorInterface::class);
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $productRepository,
            $priceCurrency,
            $statusListFactory,
            $localeFormat,
            $itemOptionFactory,
            $quoteItemCompare,
            $stockRegistry,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * @return float|mixed|null
     */
    public function getPrice()
    {
        if (!$this->helper->getDiscountProductExist($this->getProduct()->getId())) return parent::getPrice();
        $this->getProduct()->setPrice(0);
        return parent::getPrice();
    }
}
