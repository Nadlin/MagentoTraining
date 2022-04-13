<?php

namespace Amasty\NadezhdaLinnik\Model;

class ProductBlackListRepository
{
    /**
     * @var ProductBlackListFactory
     */
    private $blackListFactory;

    /**
     * @var ResourceModel\ProductBlackList
     */
    private $blackListResource;

    public function __construct(
        \Amasty\NadezhdaLinnik\Model\ProductBlackListFactory $blackListFactory,
        \Amasty\NadezhdaLinnik\Model\ResourceModel\ProductBlackList $blackListResource
    ) {
        $this->blackListFactory = $blackListFactory;
        $this->blackListResource = $blackListResource;
    }

    public function getBySku($sku)
    {
        /** @var \Amasty\NadezhdaLinnik\Model\ProductBlackList $blackListItem */
        $blackListItem = $this->blackListFactory->create();
        $this->blackListResource->load(
            $blackListItem,
            $sku,
            'sku'
        );

        return $blackListItem;
    }

    public function addEmailBody($blackListItem, $emailBody)
    {
        /** @var \Amasty\NadezhdaLinnik\Model\ProductBlackList $blackListItem */
        $blackListItem->setEmailBody($emailBody);
        $this->blackListResource->save($blackListItem);
    }
}
