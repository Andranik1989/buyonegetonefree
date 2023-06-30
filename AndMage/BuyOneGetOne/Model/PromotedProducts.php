<?php

namespace AndMage\BuyOneGetOne\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class PromotedProducts
 * @package AndMage\BuyOneGetOne\Model
 */
class PromotedProducts extends AbstractModel
{

    protected function _construct()
    {
        $this->_init('AndMage\BuyOneGetOne\Model\ResourceModel\PromotedProducts');
    }

}
