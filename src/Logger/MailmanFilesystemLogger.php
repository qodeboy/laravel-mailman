<?php

namespace Qodeboy\Mailman\Logger;

use Illuminate\Filesystem\Filesystem;
use Qodeboy\Mailman\Contracts\MailmanSwiftMessageAdapter;

/**
 * Class MailmanFilesystemLogger
 *
 * @package Qodeboy\Mailman\Logger
 */
class MailmanFilesystemLogger extends AbstractMailmanLogger
{
    /**
     * Base path where email logs are stored.
     *
     * @var string
     */
    protected $storagePath;
    
    /**
     * FileSystem adapter.
     *
     * @var Filesystem
     */
    protected $fileSystem;
    
    /**
     * MailmanFilesystemLogger constructor.
     */
    public function __construct()
    {
        $this->storagePath = config('mailman.storage.filesystem.path');
        $this->fileSystem = app(Filesystem::class);
    }
    
    /**
     * Log given Swift_Mime_Message email message.
     *
     * @param MailmanSwiftMessageAdapter $message
     *
     * @return mixed
     */
    public function log(MailmanSwiftMessageAdapter $message)
    {
        $this->prepareStorage($message);
        
        $this->fileSystem->put(
            $this->getMessageLogFilePath($message) . '.html',
            $this->getMessageHTMLContent($message)
        );
        
        $this->fileSystem->put(
            $this->getMessageLogFilePath($message) . '.eml',
            $this->getMessageEMLContent($message)
        );
    }
    
    /**
     * Generate a human readable HTML comment with message info.
     *
     * @param MailmanSwiftMessageAdapter $message
     *
     * @return string
     */
    protected function getMessageInfo(MailmanSwiftMessageAdapter $message)
    {
        return sprintf(
            "<!--\nStatus: %s, \nMessageID: %s, \nContent-Type: %s, \nFrom:%s, \nTo:%s, \nReply-To:%s, \nCC:%s, \nBCC:%s, \nSubject:%s\n-->\n",
            $message->getStatus(),
            $message->getId(),
            $message->getContentType(),
            json_encode($message->getFrom()),
            json_encode($message->getTo()),
            json_encode($message->getReplyTo()),
            json_encode($message->getCc()),
            json_encode($message->getBcc()),
            $message->getSubject()
        );
    }
    
    /**
     * Get the HTML content for the log file.
     *
     * @param  MailmanSwiftMessageAdapter $message
     *
     * @return string
     */
    protected function getMessageHTMLContent(MailmanSwiftMessageAdapter $message)
    {
        $messageInfo = $this->getMessageInfo($message);
        
        return $messageInfo . $message->getBody();
    }
    
    /**
     * Get the EML content for the log file.
     *
     * @param  MailmanSwiftMessageAdapter $message
     *
     * @return string
     */
    protected function getMessageEMLContent(MailmanSwiftMessageAdapter $message)
    {
        return $message->toString();
    }
    
    /**
     * Get the path to the email log file.
     *
     * @param  MailmanSwiftMessageAdapter $message
     *
     * @return string
     */
    protected function getMessageLogFilePath(MailmanSwiftMessageAdapter $message)
    {
        $messageLogDirectory = $this->getMessageLogDirectoryPath($message);
        $messageLogFileName = str_replace(['@', '.'], ['_at_', '_'], $message->getId());
        
        return $messageLogDirectory . '/' . str_slug($messageLogFileName);
    }
    
    /**
     * Get the path to the email log directory.
     *
     * @param MailmanSwiftMessageAdapter $message
     *
     * @return string
     */
    protected function getMessageLogDirectoryPath(MailmanSwiftMessageAdapter $message)
    {
        list($messageId) = explode('@', $message->getId());
        
        return storage_path($this->storagePath . '/' . $messageId);
    }
    
    /**
     * Create required directories for logging.
     *
     * @param MailmanSwiftMessageAdapter $message
     */
    protected function prepareStorage(MailmanSwiftMessageAdapter $message)
    {
        $messageLogStorageDirectory = storage_path($this->storagePath);
        if(!$this->fileSystem->exists($messageLogStorageDirectory))
        {
            $this->fileSystem->makeDirectory($messageLogStorageDirectory);
            $this->fileSystem->put($messageLogStorageDirectory . '/.gitignore', "*\n!.gitignore");
        }
        
        $messageLogDirectory = $this->getMessageLogDirectoryPath($message);
        if(!$this->fileSystem->exists($messageLogDirectory))
        {
            $this->fileSystem->makeDirectory($messageLogDirectory);
        }
    }
}