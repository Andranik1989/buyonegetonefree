<?php

namespace AndMage\BuyOneGetOne\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class PromotedProducts
 * @package AndMage\BuyOneGetOne\Model\ResourceModel
 */
class PromotedProducts extends AbstractDb
{
/**
 * Initialize resource
 */
    protected function _construct()
    {
        $this->_init('promoted_products', 'entity_id');
    }

}
