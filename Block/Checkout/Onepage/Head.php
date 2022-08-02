<?php

namespace Jscriptz\SkimmerBlock\Block\Checkout\Onepage;

use Magento\Framework\View\Element\Template;

class Head extends Template
{
    public function __construct(
        Template\Context $context,
        array $data
    ) {
        parent::__construct($context, $data);
    }
    
    public function sayHello()
    {
	return __('Hello World');
    }
}