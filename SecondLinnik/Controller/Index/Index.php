<?php

namespace Amasty\SecondLinnik\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Customer\Model\Session as CustomerModelSession;

class Index extends Action
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var CustomerModelSession
     */
    private $customerSession;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        CustomerModelSession $customerSession
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($this->customerSession->isLoggedIn()) {
            if ($this->scopeConfig->isSetFlag('linnik_config/general/enabled')) {
                return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            } else {
                die('Module Amasty_NadezhdaLinnik is disabled');
            }
        } else {
            echo '<h2>This page is only for logged in users</h2>';
        }
    }
}
