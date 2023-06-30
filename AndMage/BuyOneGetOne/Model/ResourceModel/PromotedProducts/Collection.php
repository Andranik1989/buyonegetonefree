<?php
namespace AndMage\BuyOneGetOne\Model\ResourceModel\PromotedProducts;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('AndMage\BuyOneGetOne\Model\PromotedProducts', 'AndMage\BuyOneGetOne\Model\ResourceModel\PromotedProducts');
    }
}
