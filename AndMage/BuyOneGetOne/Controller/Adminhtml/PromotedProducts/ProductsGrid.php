<?php

namespace AndMage\BuyOneGetOne\Controller\Adminhtml\PromotedProducts;

use Magento\Backend\App\Action;

/**
 * Class ProductsGrid
 * @package AndMage\BuyOneGetOne\Controller\Adminhtml\PromotedProducts
 */

class ProductsGrid extends Action
{
    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param Action\Context $context
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    ) {
        parent::__construct($context);
        $this->_resultLayoutFactory = $resultLayoutFactory;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('promoted_products.edit.tab.products')
                     ->setInBanner($this->getRequest()->getPost('promoted_products', null));
        return $resultLayout;
    }

}
