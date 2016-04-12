<?php

namespace Qodeboy\Mailman\Transport;

use Illuminate\Foundation\Application;
use Illuminate\Mail\Transport\Transport;
use Illuminate\Mail\TransportManager;
use Qodeboy\Mailman\Message\MailmanMimeMessage;
use Swift_Mime_Message;

class MailmanTransport extends Transport
{
    /**
     * Laravel application container.
     *
     * @var \Illuminate\Foundation\Application
     */
    private $app;

    /**
     * Create a new Mailman transport instance.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    
    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $mailmanMessage = new MailmanMimeMessage($message);
        $this->beforeSendPerformed($message);

        // Deny email delivery if environment is not allowed in the config
        if(!in_array($this->app->environment(), config('mailman.delivery.environments')))
        {
            $mailmanMessage->deny();

            $recipients = array_keys($mailmanMessage->getTo());
            $allowedRecipients = config('mailman.delivery.recipients');

            $recipientsDiff = array_diff($recipients, $allowedRecipients);

            // If all recipients are allowed to receive emails
            // from denied environments - allow email delivery.
            if(count($recipientsDiff) === 0)
            {
                $mailmanMessage->allow();
            }
        }

        if(config('mailman.log.enabled'))
        {
            $logger = app('mailman.logger');
            $logger->log($mailmanMessage);
        }
        
        if($mailmanMessage->allowed())
        {
            $transportManager = new TransportManager($this->app);
            $transport = $transportManager->driver(config('mailman.delivery.driver'));

            $transport->send($mailmanMessage->getSwiftMessage());
        }
    }
}