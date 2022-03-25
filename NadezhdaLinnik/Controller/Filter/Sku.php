<?php

namespace Amasty\NadezhdaLinnik\Controller\Filter;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Sku extends Action implements HttpPostActionInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $searchText = $params['q'];

        $collection = $this->collectionFactory->create();
        $collection->addAttributeToFilter('sku', ['like' => "%$searchText%" ]);
        $collection->addAttributeToSelect('*');
        $arrCollection = [];
        foreach ($collection as $index => $product) {
           array_push($arrCollection, array('sku'=>$product->getSku(), 'name'=>$product->getName()));
        }
        header("Content-type: application/json; charset=utf-8");
        $answer = json_encode($arrCollection);
        echo $answer;
    }
}
