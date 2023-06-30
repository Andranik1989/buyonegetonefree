<?php
namespace AndMage\BuyOneGetOne\Controller\Adminhtml\PromotedProducts;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\LayoutFactory;

class Products extends Action
{
    /**
     * @var LayoutFactory
     */
    protected LayoutFactory $_resultLayoutFactory;

    /**
     * @param Action\Context $context
     * @param LayoutFactory $resultLayoutFactory
     */
    public function __construct(
        Action\Context $context,
        LayoutFactory $resultLayoutFactory
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
                     ->setInProducts($this->getRequest()->getPost('promoted_products', null));
        return $resultLayout;
    }
}
