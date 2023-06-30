<?php

namespace AndMage\BuyOneGetOne\Controller\Adminhtml\PromotedProducts;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use AndMage\BuyOneGetOne\Model\PromotedProductsFactory;
use AndMage\BuyOneGetOne\Model\ResourceModel\PromotedProducts as PromotedProductsResource;
use Magento\Backend\Model\Session;

/**
 * Class Edit
 * @package AndMage\BuyOneGetOne\Controller\Adminhtml\PromotedProducts
 */
class Edit extends Action
{
    /**
     * @var Registry|null
     */
    protected $_coreRegistry = null;

    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

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
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     * @param PromotedProductsFactory $promotedProductsFactory
     * @param PromotedProductsResource $promotedProductsResource
     * @param Session $backendSession
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        PromotedProductsFactory $promotedProductsFactory,
        PromotedProductsResource $promotedProductsResource,
        Session $backendSession
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->promotedProductsFactory = $promotedProductsFactory;
        $this->promotedProductsResource = $promotedProductsResource;
        $this->backendSession = $backendSession;
        parent::__construct($context);
    }


    /**
     * @return \Magento\Framework\View\Result\Page
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }

/**
 * @return \Magento\Framework\Controller\Result\Redirect|\Magento\Framework\View\Result\Page
 */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->promotedProductsFactory->create();

        if ($id) {
            $this->promotedProductsResource->load($model, $id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This product no longer exists.'));

                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->backendSession->getFormData(true);
        if (!empty($data)) {

            $model->setData($data);
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Promoted Product') : __('Promoted Product'),
            $id ? __('Promoted Product') : __('Promoted Product')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Products'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Promoted Product'));

        return $resultPage;
    }
}
