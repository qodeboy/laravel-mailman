<?php

namespace Qodeboy\Mailman\Message;

use Swift_Mime_Message;
use Qodeboy\Mailman\Contracts\MailmanSwiftMessageAdapter;

class MailmanMimeMessage implements MailmanSwiftMessageAdapter
{
    const STATUS_ALLOWED = 'allowed';
    const STATUS_DENIED = 'denied';

    /**
     * Swift_Mime_Message instance.
     *
     * @var Swift_Mime_Message
     */
    protected $message;

    /**
     * Message delivery status.
     *
     * @var
     */
    protected $status;

    /**
     * {@inheritdoc}
     */
    public function __construct(Swift_Mime_Message $message)
    {
        $this->message = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->message->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType()
    {
        return $this->message->getContentType();
    }

    /**
     * {@inheritdoc}
     */
    public function getFrom()
    {
        return $this->message->getFrom();
    }

    /**
     * {@inheritdoc}
     */
    public function getTo()
    {
        return $this->message->getTo();
    }

    /**
     * {@inheritdoc}
     */
    public function getReplyTo()
    {
        return $this->message->getReplyTo();
    }

    /**
     * {@inheritdoc}
     */
    public function getCc()
    {
        return $this->message->getCc();
    }

    /**
     * {@inheritdoc}
     */
    public function getBcc()
    {
        return $this->message->getBcc();
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->message->getSubject();
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->message->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return $this->message->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function getSwiftMessage()
    {
        return $this->message;
    }

    /**
     * Mark message as allowed for sending.
     */
    public function allow()
    {
        $this->setStatus(self::STATUS_ALLOWED);
    }

    /**
     * Mark message as denied for sending.
     */
    public function deny()
    {
        $this->setStatus(self::STATUS_DENIED);
    }

    /**
     * Check if message is allowed for delivery.
     *
     * @return bool
     */
    public function allowed()
    {
        return $this->getStatus() === self::STATUS_ALLOWED;
    }

    /**
     * Check if message is denied for delivery.
     *
     * @return bool
     */
    public function denied()
    {
        return $this->getStatus() === self::STATUS_DENIED;
    }

    /**
     * Set message status.
     *
     * @param $status
     */
    protected function setStatus($status)
    {
        if (! in_array($status, ['allowed', 'denied'])) {
            throw new \RuntimeException('Invalid message status supplied!');
        }

        $this->status = $status;
    }
}
