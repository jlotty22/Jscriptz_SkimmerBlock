<?php namespace Jscriptz\SkimmerBlock\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Checkout\Model\Cart as CartSession;
use Magento\Framework\App\Response\RedirectInterface as RedirectInterface;
use Magento\Framework\App\RequestInterface as RequestInterface;
use Magento\Framework\Filesystem\DirectoryList as DirectoryList;
use Magento\Framework\App\ProductMetadataInterface as MetadataInterface;
class ValidateCheckOutObserver implements ObserverInterface{

    protected $cartSession;
    protected $customerSession;
    protected $checkoutSession;  
    protected $redirect;
    protected $request;
    protected $directoryList;
    protected $productMetadata;
    
    public function __construct(
        CartSession $cartSession,
        CustomerSession $customerSession,
        CheckoutSession $checkoutSession,
        RedirectInterface $redirect,
        RequestInterface $request,
        DirectoryList $directoryList,
        MetadataInterface $productMetadata
    ){
     
        $this->cartSession = $cartSession;
        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
        $this->redirect = $redirect;
        $this->request = $request;
        $this->directoryList = $directoryList;
        $this->productMetadata = $productMetadata;
        
    }
    
    public function execute(\Magento\Framework\Event\Observer $observer){

	$version = $this->productMetadata->getVersion();
	
	$version = preg_replace("#\.|\-p.*#", "", $version);
	
	if($version < 242){
		$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/skimmerblock.log');
		$logger = new \Zend\Log\Logger(); 
	}
	elseif($version > 242 && $version < 243){
		$writer = new \Laminas\Log\Writer\Stream(BP . '/var/log/skimmerblock.log');
		$logger = new  \Laminas\Log\Logger();
	}
	else{   
		$writer = new \Zend_Log_Writer_Stream(BP . '/var/log/skimmerblock.log');
		$logger = new \Zend_Log();
	}
	
	$logger->addWriter($writer);	  
        
        $logger->info("Magento Version: ".$version);
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        //$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        //$connection = $resource->getConnection();
	$responseFactory = $objectManager->create('\Magento\Framework\App\ResponseFactory');
	$url = $objectManager->get('\Magento\Framework\UrlInterface');
 
        $quoteId = $this->checkoutSession->getQuote()->getId();
        /*
 	$varPath  =  $this->directoryList->getPath('var');       
	
	if(!is_dir($varPath.'/skimmers'))mkdir($varPath.'/skimmers');
	
	$file = $varPath."/skimmers/".$quoteId.".txt";
	
	$count = @file_get_contents($file);
	
	if(!$count){
		$user["session_id"]["session_count"] = 1;
		file_put_contents($file, $user["session_id"]["session_count"]);
	}
	else{
		$user["session_id"]["session_count"] = file_get_contents($file);
		$user["session_id"]["session_count"]++;
		file_put_contents($file, $user["session_id"]["session_count"]);
	}
	        
	if($user["session_id"]["session_count"] >= 5){
		$url = $objectManager->get('\Magento\Framework\UrlInterface');
		$customRedirectionUrl = $url->getUrl('skimmer/page/view'); //Get url of cms page
		$responseFactory->create()->setRedirect($customRedirectionUrl)->sendResponse(); 
		//die();
	}
	*/
	return $quoteId;
    }
}