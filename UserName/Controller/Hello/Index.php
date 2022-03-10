<?php

namespace Amasty\UserName\Controller\Hello;

use Magento\Framework\App\Action\Action;

class Index extends Action
{
    public function execute()
    {
        echo '<h2>Привет Magento. Привет Amasty. Я готов тебя покорить!</h2>';
    }
}
