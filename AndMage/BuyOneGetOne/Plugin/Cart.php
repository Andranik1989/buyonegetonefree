<?php

namespace AndMage\BuyOneGetOne\Plugin;

use Magento\Checkout\Model\Cart as CartInfo;
use AndMage\BuyOneGetOne\Helper\Data as Helper;

/**
 * AndMage\BuyOneGetOne\Plugin\Cart
 *
 * Class Cart
 * @package AndMage\BuyOneGetOne\Plugin\Cart
 */
class Cart
{
    /**
     * @var CartInfo
     */
    protected CartInfo $cart;

    /**
     * @var bool
     */
    protected bool $removed = false;

    /**
     * @var Helper
     */
    protected Helper $helper;

    /**
     * @param CartInfo $cart
     */
    public function __construct(
        CartInfo $cart,
        Helper   $helper
    )
    {
        $this->cart = $cart;
        $this->helper = $helper;
    }

    /**
     * @param CartInfo $cart
     * @param $result
     * @param $productInfo
     * @return mixed
     */
    public function afterRemoveItem(
        $quote,
        $result,
        $itemId
    ): mixed
    {
        $allItems = $quote->getItems()->getItems();
        $currentProductId = $allItems[$itemId]->getProductId();
        if (!$this->helper->getDiscountProductExist($currentProductId)) return $result;
        foreach ($allItems as $item) {
            if ($item->getProductId() == $currentProductId
                && ($item->getoptionbycode('additional_options') != null)) {
                if (!$this->removed) {
                    $this->removed = true;
                    $this->cart->removeItem($item->getId())->save();
                    $this->cart->save();
                }
            }
        }
        return $result;
    }


    /**
     * @param CartInfo $cart
     * @param $result
     * @param $data
     * @return mixed
     */
    public function afterUpdateItems(
        CartInfo $cart,
                 $result,
                 $data
    ): mixed
    {

        foreach ($data as $itemId => $itemInfo) {
            $item = $cart->getQuote()->getItemById($itemId);
            if ($item && $this->helper->getDiscountProductExist($item->getProduct()->getId())) {
                $updatedProductId = $item->getProduct()->getId();
                $result = $this->updateResult($result, $updatedProductId, $itemInfo['qty']);
            }
        }
        return $result;
    }

    /**
     * @param $result
     * @param $updatedProductId
     * @param $itemInfo
     * @return mixed
     */
    private function updateResult($result, $updatedProductId, $itemInfo): mixed
    {
        foreach ($result->getItems() as $item) {
            $productId = $item->getProductId();
            if ($productId == $updatedProductId) {
                $item->setQty($itemInfo);
            }
        }
        return $result;
    }
}
