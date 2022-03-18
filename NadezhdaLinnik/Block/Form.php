<?php

namespace Amasty\NadezhdaLinnik\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Form extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = [])
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function isQtyFieldAllowed()
    {
        return $this->scopeConfig->isSetFlag('linnik_config/general/show_qty');
    }

    public function getDefaultQty()
    {
        return $this->scopeConfig->getValue('linnik_config/general/default_qty') ?: '';
    }
}
