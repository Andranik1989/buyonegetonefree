<?php

namespace AndMage\BuyOneGetOne\Controller\Adminhtml\PromotedProducts;

use Magento\Backend\App\Action;
use AndMage\BuyOneGetOne\Model\PromotedProductsFactory;
use AndMage\BuyOneGetOne\Model\ResourceModel\PromotedProducts as PromotedProductsResource;

/**
 * Class Delete
 * @package AndMage\BuyOneGetOne\Controller\Adminhtml\PromotedProducts
 */
class Delete extends Action
{
    /**
     * @var PromotedProductsFactory
     */
    protected PromotedProductsFactory $promotedProductsFactory;
    /**
     * @var PromotedProductsResource
     */
    protected PromotedProductsResource $promotedProductsResource;

    /**
     * @param Action\Context $context
     * @param PromotedProductsFactory $promotedProductsFactory
     * @param PromotedProductsResource $promotedProductsResource
     */
    public function __construct(
        Action\Context $context,
        PromotedProductsFactory $promotedProductsFactory,
        PromotedProductsResource $promotedProductsResource
    ){
        $this->promotedProductsFactory = $promotedProductsFactory;
        $this->promotedProductsResource = $promotedProductsResource;
        parent::__construct($context);
    }
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->promotedProductsFactory->create();
                $this->promotedProductsResource->load($model, $id);
                $this->promotedProductsResource->delete($model);
                $this->messageManager->addSuccess(__('The product has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['product_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a product to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
