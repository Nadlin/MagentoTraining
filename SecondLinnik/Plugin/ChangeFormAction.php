<?php

namespace Amasty\SecondLinnik\Plugin;

use Magento\Framework\View\Element\AbstractBlock;

class ChangeFormAction extends AbstractBlock
{
    public function afterGetFormAction(
        \Amasty\NadezhdaLinnik\Block\Form $subject,
        $result
    ) {
        return $this->getUrl('checkout/cart/add');
    }
}
