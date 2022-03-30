<?php

namespace Amasty\NadezhdaLinnik\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Checkout\Model\Session;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Event\ManagerInterface;

class Add extends Action implements HttpPostActionInterface
{
    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ManagerInterface
     */
    private $eventManager;

    public function __construct(
        Context $context,
        Session $checkoutSession,
        ProductRepositoryInterface $productRepository,
        ManagerInterface $eventManager
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->eventManager = $eventManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $quote = $this->checkoutSession->getQuote();
        if (!$quote->getId()) {
           $quote->save();
        }

        $params = $this->getRequest()->getParams();


        if (!isset($params['sku']) || !isset($params['qty'])) {
            $this->messageManager->addErrorMessage(
                __('Something went wrong.')
            );
        } else {
            $requestedProductSku = $params['sku'];
            $requestedProductQty = $params['qty'];

            try {
                $product = $this->productRepository->get($requestedProductSku);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e){
                $product = false;
            }

            if ($product) {
                $productType = $product->getTypeId();
                $stockQty = $product->getQuantityAndStockStatus()['qty'];
                $productName = $product->getName();

                if ($productType != 'simple') {
                    $this->messageManager->addErrorMessage(
                        __('The Product with sku \'%1\' isn\'t a simple product', $requestedProductSku)
                    );
                } else if (is_numeric($requestedProductQty) && $requestedProductQty > 0 && intval(abs($requestedProductQty)) == $requestedProductQty) {
                    if ($requestedProductQty > $stockQty) {
                        $this->messageManager->addErrorMessage(
                            __('There are no enough products \'%1\'', $productName)
                        );
                    } else {
                        $quote->addProduct($product, $requestedProductQty);
                        $quote->save();
                        $this->eventManager->dispatch(
                            'linnik_add_to_cart',
                            ['sku' => $requestedProductSku]
                        );
                        $this->messageManager->addSuccessMessage(
                            __('You successfully added \'%1\' to your shopping cart', $productName)
                        );
                    }
                } else {
                    $this->messageManager->addErrorMessage(
                        __('Something is wrong with qty. It should be integer number above zero. Please try again.')
                    );
                }
            } else {
                $this->messageManager->addErrorMessage(
                    __('The Product with sku \'%1\' doesn\'t exist', $requestedProductSku)
                );
            }
        }
        return $this->resultRedirectFactory->create()->setPath('linnik');
    }
}
