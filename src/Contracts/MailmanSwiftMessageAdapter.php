<?php

namespace Qodeboy\Mailman\Contracts;

use Swift_Mime_Message;

/**
 * Interface MailmanSwiftMessageAdapter.
 */
interface MailmanSwiftMessageAdapter
{
    /**
     * MailmanSwiftMessageAdapter constructor.
     *
     * @param \Swift_Mime_Message $message
     */
    public function __construct(Swift_Mime_Message $message);

    /**
     * Get message status (dropped/allowed).
     *
     * @return mixed
     */
    public function getStatus();

    /**
     * Get Swift_Mime_Message ID.
     *
     * @return mixed
     */
    public function getId();

    /**
     * Get Swift_Mime_Message Content-Type.
     *
     * @return mixed
     */
    public function getContentType();

    /**
     * Swift_Mime_Message From.
     *
     * @return mixed
     */
    public function getFrom();

    /**
     * Get Swift_Mime_Message To.
     * @return mixed
     */
    public function getTo();

    /**
     * Get Swift_Mime_Message Reply-To.
     *
     * @return mixed
     */
    public function getReplyTo();

    /**
     * Get Swift_Mime_Message CC.
     *
     * @return mixed
     */
    public function getCc();

    /**
     * Get Swift_Mime_Message BCC.
     *
     * @return mixed
     */
    public function getBcc();

    /**
     * Get Swift_Mime_Message Subject.
     *
     * @return mixed
     */
    public function getSubject();

    /**
     * Get Swift_Mime_Message Body.
     *
     * @return mixed
     */
    public function getBody();

    /**
     * Get Swift_Mime_Message Contents.
     *
     * @return mixed
     */
    public function toString();

    /**
     * Get original Swift_Mime_Message.
     *
     * @return Swift_Mime_Message
     */
    public function getSwiftMessage();
}
