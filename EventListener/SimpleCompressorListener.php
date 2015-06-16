<?php
namespace Acilia\Bundle\CoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class SimpleCompressorListener
{
    protected $isProduction;

    public function __construct($isProduction)
    {
        $this->isProduction = $isProduction;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        // compress html output
        $response = $event->getResponse();
        $responseContent = $response->getContent();
        foreach (["~>\s+<~" => "><", "/\n+/" => "\n"] as $pattern => $replacement) {
            $responseContent = preg_replace($pattern, $replacement, $responseContent);
        }
        $response->setContent($responseContent);
    }
}
