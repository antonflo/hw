<?php
namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * An event listener that watches for application/json requests and sets the decoded body as parameters
 */
class JsonRequestListener
{
    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->isMasterRequest()) {
            $request = $event->getRequest();
            $contentType = $request->headers->get('content-type');
            if (0 === strpos($contentType, 'application/json')) {
                $content = $request->getContent();
                $decoded = json_decode($content, true);
                if (null !== $decoded) {
                    $request->request->replace($decoded);
                }
            }
        }
    }
}
