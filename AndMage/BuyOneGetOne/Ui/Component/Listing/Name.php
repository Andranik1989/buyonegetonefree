<?php

namespace AndMage\BuyOneGetOne\Ui\Component\Listing;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Model\ProductRepository;

/**
 * Class Name
 * @package AndMage\BuyOneGetOne\Ui\Component\Listing
 */
class Name extends Column
{

    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;
    /**
     * @var ProductRepository $productRepository
     */
    protected $productRepository;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface       $urlBuilder,
        ProductRepository $productRepository,
        array              $components = [],
        array              $data = []

    )
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->productRepository = $productRepository;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
         if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {

                if (isset($item['entity_id'])) {
                    $productname = $this->productRepository->getById($item['product_id'])->getName();
                    $item['product_name'] = $productname;
                    $item['sku'] = $this->productRepository->getById($item['product_id'])->getSku();
                }
            }
        }
        return $dataSource;
    }
}
