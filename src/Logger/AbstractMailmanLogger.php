<?php

namespace Qodeboy\Mailman\Logger;

use Qodeboy\Mailman\Contracts\MailmanSwiftMessageAdapter;

abstract class AbstractMailmanLogger
{
    
    /**
     * Get basic information from Swift_Mime_Message
     * for logging purposes.
     *
     * @param MailmanSwiftMessageAdapter $message
     *
     * @return array
     */
    abstract protected function getMessageInfo(MailmanSwiftMessageAdapter $message);
    
    /**
     * Log given Swift_Mime_Message email message.
     *
     * @param MailmanSwiftMessageAdapter $message
     *
     * @return mixed
     */
    abstract public function log(MailmanSwiftMessageAdapter $message);
}