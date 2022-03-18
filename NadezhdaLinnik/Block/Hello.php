<?php

namespace Amasty\NadezhdaLinnik\Block;

use Magento\Framework\View\Element\Template;

class Hello extends Template
{
    public function getGreeting()
    {
        return 'Hello World';
    }
}
