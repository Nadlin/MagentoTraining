<?php

namespace Amasty\SecondLinnik\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session;
use Magento\Catalog\Api\ProductRepositoryInterface;

class checkSkuForPromoObserver implements ObserverInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Session $checkoutSession,
        ProductRepositoryInterface $productRepository
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
    }

    public function execute(Observer $observer)
    {
        $sku = $observer->getData('sku');
        $promoSku = $this->scopeConfig->getValue('secondlinnik_config/general/promo_sku');
        $promoSku = trim($promoSku);
        $allowedSkuForPromo = $this->scopeConfig->getValue('secondlinnik_config/general/for_sku');
        $allowedSkuForPromo = trim($allowedSkuForPromo);
        if ($promoSku != '' && $allowedSkuForPromo != '') {
            $allowedSkuArr = explode(', ', $allowedSkuForPromo);
            if (in_array($sku, $allowedSkuArr)) {
                $quote = $this->checkoutSession->getQuote();
                if (!$quote->getId()) {
                    $quote->save();
                }
                try {
                    $product = $this->productRepository->get($promoSku);
                } catch (\Magento\Framework\Exception\NoSuchEntityException $e){
                    $product = false;
                }
                if ($product) {
                    $quote->addProduct($product, 1);
                    $quote->save();
                }
            }
        }
    }
}
