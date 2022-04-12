<?php

namespace Amasty\NadezhdaLinnik\Cron;

class SendEmail
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function execute()
    {
        $this->logger->debug('Amasty_Linnik job is done');
    }
}
