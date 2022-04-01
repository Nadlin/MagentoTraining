<?php

namespace Amasty\NadezhdaLinnik\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProductBlackList extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(
            'amasty_nadezhdalinnik_blacklist',
            'id'
        );
    }
}
