<?php

namespace Amasty\SecondLinnik\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;

class ChangeExecute
{
    /**
     * @var ProductRepositoryInterface
     */
    public $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function beforeExecute(
        \Magento\Checkout\Controller\Cart\Add $subject
    ) {
        $params = $subject->getRequest()->getParams();
        if (!isset($params['product']) && isset($params['sku'])) {
            $sku = $params['sku'];
            $product = $this->productRepository->get($sku);
            $productId = $product->getId();
            $subject->getRequest()->setParams(['product'=>$productId]);
        }
    }
}
