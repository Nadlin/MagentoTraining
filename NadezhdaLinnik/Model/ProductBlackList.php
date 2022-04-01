<?php

namespace Amasty\NadezhdaLinnik\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Amasty ProductBlackList Model
 *
 * @method int getId()
 * @method string getSku()
 * @method int getQty()
 */
class ProductBlackList extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Amasty\NadezhdaLinnik\Model\ResourceModel\ProductBlackList::class);
    }
}
