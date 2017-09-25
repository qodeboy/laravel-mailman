<?php

namespace Qodeboy\Mailman\Logger;

use Qodeboy\Mailman\Models\MailmanMessageModel;
use Qodeboy\Mailman\Contracts\MailmanSwiftMessageAdapter;

/**
 * Class MailmanDatabaseLogger.
 */
class MailmanDatabaseLogger extends AbstractMailmanLogger
{
    /**
     * Log given Swift_Mime_Message email message.
     *
     * @param MailmanSwiftMessageAdapter $message
     *
     * @return mixed
     */
    public function log(MailmanSwiftMessageAdapter $message)
    {
        $messageInfo = $this->getMessageInfo($message);
        MailmanMessageModel::create($messageInfo);
    }

    /**
     * Get basic information from Swift_Mime_Message
     * for logging purposes.
     *
     * @param MailmanSwiftMessageAdapter $message
     *
     * @return array
     */
    protected function getMessageInfo(MailmanSwiftMessageAdapter $message)
    {
        return [
            'message_id'   => $message->getId(),
            'content_type' => $message->getContentType(),
            'status'       => $message->getStatus(),
            'from'         => $message->getFrom(),
            'to'           => $message->getTo(),
            'reply_to'     => $message->getReplyTo(),
            'cc'           => $message->getCc(),
            'bcc'          => $message->getBcc(),
            'subject'      => $message->getSubject(),
            'body'         => $message->getBody(),
            'instance'     => $message,
        ];
    }
}
