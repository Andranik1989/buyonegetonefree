<?php

namespace AndMage\BuyOneGetOne\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Checkout\Model\SessionFactory;
use AndMage\BuyOneGetOne\Helper\Data as Helper;
use Magento\Framework\Message\ManagerInterface;


/**
 * AndMage\BuyOneGetOne\Observer\AddFreeProduct
 *
 * Class AddFreeProduct
 * @package AndMage\BuyOneGetOne\Observer
 */
class AddFreeProduct implements ObserverInterface
{
    /**
     * @var SerializerInterface $serializer
     */
    protected SerializerInterface $serializer;

    /**
     * @var SessionFactory
     */
    protected SessionFactory $checkoutSession;

    /**
     * @var CartRepositoryInterface
     */
    protected CartRepositoryInterface $cartRepository;

    /**
     * @var ProductRepository
     */
    protected ProductRepository $productRepository;

    /**
     * @var Helper
     */
    protected Helper $helper;
    /**
     * @var ManagerInterface
     */
    protected ManagerInterface $messageManager;

    /**
     * @param SessionFactory $checkoutSession
     * @param CartRepositoryInterface $cartRepository
     * @param ProductRepository $productRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SessionFactory          $checkoutSession,
        CartRepositoryInterface $cartRepository,
        ProductRepository       $productRepository,
        SerializerInterface     $serializer,
        Helper                  $helper,
        ManagerInterface        $messageManager
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->serializer = $serializer;
        $this->helper = $helper;
        $this->messageManager = $messageManager;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer): void
    {
        $productId = $observer->getProduct()->getId();

        if ($this->helper->getDiscountProductExist($productId)) {
            $addedQty = $observer->getProduct()->getQty();
            $quote = $this->checkoutSession->create()->getQuote();
            $productFree = $this->productRepository->getById($productId);
           // $additionalOptions['productStatus'] = ['label' => $observer->getProduct()->getPrice()];
            $additionalOptions['productStatus'] = ['label' => 'Original price', 'value' => $productFree->getFinalPrice()];
            $productFree->addCustomOption('additional_options', $this->serializer->serialize($additionalOptions));
            $productFree->setPrice(0);
            $productFree->setIsSuperMode(true);
            $quote->addProduct($productFree, $addedQty);
            $this->cartRepository->save($quote);
            $addedQty > 1 ? $message = __('More items of same product added with 100% discount') : $message = __('One More Item added with 100% discount');
            $this->messageManager->addSuccessMessage($message);
        }
    }
}
