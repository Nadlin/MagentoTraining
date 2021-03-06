<?php

namespace Amasty\NadezhdaLinnik\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Hello extends Template
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

    public function getGreeting()
    {
        return 'Hello World';
    }

    public function getGreetingFromAdmin()
    {
        return $this->scopeConfig->getValue('linnik_config/general/greeting_text');
    }
}
