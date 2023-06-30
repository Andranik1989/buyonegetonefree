<?php

namespace AndMage\BuyOneGetOne\Controller\Adminhtml\PromotedProducts;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Js;
use AndMage\BuyOneGetOne\Model\ResourceModel\PromotedProducts\CollectionFactory;
use AndMage\BuyOneGetOne\Model\PromotedProductsFactory;
use AndMage\BuyOneGetOne\Model\ResourceModel\PromotedProducts as PromotedProductsResource;
use Magento\Backend\Model\Session;

/**
 * Class Save
 * @package AndMage\BuyOneGetOne\Controller\Adminhtml\PromotedProducts
 */
class Save extends Action
{
    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected Js $_jsHelper;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $promotedProducts;

    /**
     * @var PromotedProductsFactory
     */
    protected PromotedProductsFactory $promotedProductsFactory;
    /**
     * @var PromotedProductsResource
     */
    protected PromotedProductsResource $promotedProductsResource;
    /**
     * @var Session
     */
    protected Session $backendSession;

    /**
     * @param Context $context
     * @param Js $jsHelper
     * @param CollectionFactory $promotedProductsCollectionFactory
     * @param PromotedProductsFactory $promotedProductsFactory
     * @param PromotedProductsResource $promotedProductsResource
     */
    public function __construct(
        Context           $context,
        Js                $jsHelper,
        CollectionFactory $promotedProductsCollectionFactory,
        PromotedProductsFactory $promotedProductsFactory,
        PromotedProductsResource $promotedProductsResource,
        Session $backendSession
    )
    {
        $this->_jsHelper = $jsHelper;
        $this->promotedProducts = $promotedProductsCollectionFactory;
        $this->promotedProductsFactory = $promotedProductsFactory;
        $this->promotedProductsResource = $promotedProductsResource;
        $this->backendSession = $backendSession;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $productIdsFromRequest = $this->getRequest()->getParam('products');
        if ($productIdsFromRequest) {
            $productIds = $this->_jsHelper->decodeGridSerializedInput($productIdsFromRequest);
            $model = $this->promotedProductsFactory->create();
            foreach ($productIds as $productId) {
                $model->setData(['product_id' => $productId]);
                $model->save();
            }
            $this->messageManager->addSuccess(__('You saved products'));
            $this->backendSession->setFormData(false);
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId(), '_current' => true]);
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
