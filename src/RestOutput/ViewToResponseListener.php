<?php

namespace SiRest\RestOutput;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Converts views to responses by processing them to the output service
 *
 * Note: This should be used sparingly, as it does not transmit any useful
 * information about HTTP status codes
 * 
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class ViewToResponseListener implements EventSubscriberInterface
{
    /**
     * @var \SiRest\RestOutput\OutputService
     */
    private $outputService;
    
    // --------------------------------------------------------------
    
    /**
     * 
     * @param \SiRest\RestOutput\OutputService $outputService
     */
    public function __construct(OutputService $outputService)
    {
        $this->outputService = $outputService;
    }
    
    // --------------------------------------------------------------
    
    /**
     * Handles string responses.
     *
     * @param GetResponseForControllerResultEvent $event The event to handle
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $response = $event->getControllerResult();
        
        if ($response instanceOf ViewInterface) {
            $event->setResponse($this->outputService->render($response));            
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::VIEW => array('onKernelView', 0)
        );
    }
}

/* EOF: ViewToResponseListerner.php */