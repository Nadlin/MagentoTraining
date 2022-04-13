<?php

namespace Amasty\NadezhdaLinnik\Cron;

class SendEmail
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var \Magento\Framework\Mail\Template\Factory
     */
    private $templateFactory;

    /**
     * @var \Amasty\NadezhdaLinnik\Model\ProductBlackListRepository
     */
    private $blackListRepository;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Mail\Template\Factory $templateFactory,
        \Amasty\NadezhdaLinnik\Model\ProductBlackListRepository $blackListRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->logger = $logger;
        $this->transportBuilder = $transportBuilder;
        $this->templateFactory = $templateFactory;
        $this->blackListRepository = $blackListRepository;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute()
    {
        $blackListItem = $this->blackListRepository->getBySku('24-MB03');

        $templateId = $this->scopeConfig->getValue('linnik_config/cron/email_template');
        $emailAddress = $this->scopeConfig->getValue('linnik_config/cron/email');

        $templateVars = [
            'blackListItem' => $blackListItem,
            'qty' => $blackListItem->getQty(),
            'sku' => $blackListItem->getSku()
        ];

        $templateOptions = [
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => 0
        ];

        $template = $this->templateFactory->get($templateId);
        $template->setVars($templateVars)
            ->setOptions($templateOptions);

        $messageBody = $template->processTemplate();
        $this->blackListRepository->addEmailBody($blackListItem, $messageBody);

        $transport = $this->transportBuilder->setTemplateIdentifier($templateId)
            ->setTemplateOptions($templateOptions)
            ->setFrom([
                'name' => 'Amasty NadezhdaLinnik Module',
                'email' => 'linniknadezhdavasil@gmail.com'
            ])
            ->addTo(
                $emailAddress,
                'Nadya'
            )
            ->getTransport();

        $transport->sendMessage();

        $this->logger->debug('Amasty_Linnik job is done');
    }
}
