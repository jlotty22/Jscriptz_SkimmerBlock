<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Jscriptz\SkimmerBlock\Controller\Page;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class View extends Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * View  page action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $data = ['message' => 'Too many checkout attempts, please call '.$this->scopeConfig->getValue('general/store_information/phone',ScopeInterface::SCOPE_STORE).' to order'];

        return $result->setData($data);
    }
}