<?php

namespace Qodeboy\Mailman\Contracts;

use Swift_Mime_Message;

/**
 * Interface MailmanSwiftMessageAdapter
 *
 * @package Qodeboy\Mailman\Contracts
 */
interface MailmanSwiftMessageAdapter
{
    /**
     * MailmanSwiftMessageAdapter constructor.
     *
     * @param \Swift_Mime_Message $message
     */
    function __construct(Swift_Mime_Message $message);
    
    /**
     * Get message status (dropped/allowed).
     * 
     * @return mixed
     */
    function getStatus();
    
    /**
     * Get Swift_Mime_Message ID.
     * 
     * @return mixed
     */
    function getId();
    
    /**
     * Get Swift_Mime_Message Content-Type.
     * 
     * @return mixed
     */
    function getContentType();
    
    /**
     * Swift_Mime_Message From.
     * 
     * @return mixed
     */
    function getFrom();
    
    /**
     * Get Swift_Mime_Message To.
     * @return mixed
     */
    function getTo();
    
    /**
     * Get Swift_Mime_Message Reply-To.
     * 
     * @return mixed
     */
    function getReplyTo();
    
    /**
     * Get Swift_Mime_Message CC.
     * 
     * @return mixed
     */
    function getCc();
    
    /**
     * Get Swift_Mime_Message BCC.
     * 
     * @return mixed
     */
    function getBcc();
    
    /**
     * Get Swift_Mime_Message Subject.
     * 
     * @return mixed
     */
    function getSubject();
    
    /**
     * Get Swift_Mime_Message Body.
     * 
     * @return mixed
     */
    function getBody();
    
    /**
     * Get Swift_Mime_Message Contents.
     * 
     * @return mixed
     */
    function toString();
    
    /**
     * Get original Swift_Mime_Message.
     * 
     * @return Swift_Mime_Message
     */
    function getSwiftMessage();
    
}