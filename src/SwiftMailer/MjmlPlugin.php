<?php

namespace NotFloran\MjmlBundle\SwiftMailer;

use NotFloran\MjmlBundle\Renderer\RendererInterface;
use Swift_Events_SendEvent;
use Swift_Events_SendListener;

/**
 * @deprecated since MjmlBundle 3.4 and will be removed in the next major version.
 */
class MjmlPlugin implements Swift_Events_SendListener
{
    /**
     * @var RendererInterface
     */
    private $mjml;

    /**
     * @var bool
     */
    private $ignoreSpoolTransport;

    public function __construct(RendererInterface $mjml, bool $ignoreSpoolTransport = true)
    {
        $this->mjml = $mjml;
        $this->ignoreSpoolTransport = $ignoreSpoolTransport;
    }

    public function beforeSendPerformed(Swift_Events_SendEvent $event)
    {
        if ($this->ignoreSpoolTransport && $event->getSource() instanceof \Swift_Transport_SpoolTransport) {
            return;
        }

        $message = $event->getMessage();

        if ('text/mjml' === $message->getContentType()) {
            $message->setBody($this->mjml->render($message->getBody()), 'text/html');
        }

        foreach ($message->getChildren() as $part) {
            if (0 === strpos($part->getContentType(), 'text/mjml')) {
                $part->setBody($this->mjml->render($part->getBody()), 'text/html');
            }
        }
    }

    public function sendPerformed(Swift_Events_SendEvent $event)
    {
    }
}
