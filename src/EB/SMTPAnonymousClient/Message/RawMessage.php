<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Filipe Silva <filipe.silva@emailbidding.com>
 * @copyright  2012-2015 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EB\SMTPAnonymousClient\Message;

class RawMessage
{
    /**
     * @var array
     */
    protected $messageHeaders;

    /**
     * @var array
     */
    protected $bodyHeadersHtml;

    /**
     * @var string
     */
    protected $bodyHtml;

    /**
     * @var array
     */
    protected $bodyHeadersText;

    /**
     * @var Attachment[]
     */
    protected $attachments;

    /**
     * @var string
     */
    protected $bodyText;


    /**
     * @param array         $messageHeaders
     * @param array         $bodyHeadersHtml
     * @param array         $bodyHeadersText
     * @param string        $bodyHtml
     * @param string        $bodyText
     * @param Attachment[]  $attachments
     */
    public function __construct(
        array $messageHeaders,
        array $bodyHeadersHtml,
        array $bodyHeadersText,
        $bodyHtml,
        $bodyText,
        array $attachments
    ) {
        $this->messageHeaders  = $messageHeaders;
        $this->bodyHeadersHtml = $bodyHeadersHtml;
        $this->bodyHeadersText = $bodyHeadersText;
        $this->bodyHtml        = $bodyHtml;
        $this->bodyText        = $bodyText;
        $this->attachments     = $attachments;
    }

    /**
     * @return String
     */
    public function getTo()
    {
        return $this->messageHeaders['to'];
    }

    /**
     * @return string
     */
    public function getToEmailAddress()
    {
        preg_match('/.*<(.*)>/', $this->messageHeaders['to'], $emailAddress);
        if (isset($emailAddress[1])) {
            return trim($emailAddress[1]);
        }

        return trim($this->messageHeaders['to'], ' \"\"');
    }

    /**
     * @return string
     */
    public function getToName()
    {
        preg_match('/(.*)<.*>/', $this->messageHeaders['to'], $toName);
        if (isset($toName[1])) {
            return trim($toName[1], ' \"\"');
        }

        return '';
    }

    /**
     * @return String
     */
    public function getFrom()
    {
        return $this->messageHeaders['from'];
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        preg_match('/(.*)<.*>/', $this->messageHeaders['from'], $fromName);
        if (isset($fromName[1])) {
            return trim($fromName[1], ' \"\"');
        }

        return '';
    }

    /**
     * @return string
     */
    public function getFromEmailAddress()
    {
        preg_match('/.*<(.*)>/', $this->messageHeaders['from'], $emailAddress);
        if (isset($emailAddress[1])) {
            return trim($emailAddress[1]);
        }

        return trim($this->messageHeaders['from'], ' \"\"');
    }

    /**
     * @return String
     */
    public function getSubject()
    {
        return $this->messageHeaders['subject'];
    }

    /**
     * @return Array
     */
    public function getHeaders()
    {
        return $this->messageHeaders;
    }

    /**
     * @return Array
     */
    public function getBodyHTML()
    {
        return $this->bodyHtml;
    }

    /**
     * @return Array
     */
    public function getBodyText()
    {
        return $this->bodyText;
    }

    /**
     * @return Attachment[]
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @return Array
     */
    public function getBodyHtmlHeaders()
    {
        return $this->bodyHeadersHtml;
    }

    /**
     * @return Array
     */
    public function getBodyTextHeaders()
    {
        return $this->bodyHeadersText;
    }

    /**
     * @param string $headerName The header name
     * @param string $default The returned value in case of header is not defined
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getHeader($headerName, $default)
    {
        if (!isset($this->messageHeaders[$headerName])) {
            if ($default) {
                return $default;
            } else {
                throw new \InvalidArgumentException();
            }
        }

        return $this->messageHeaders[$headerName];
    }

    /**
     * @return string
     */
    public function getReturnPathEmailAddress()
    {
        preg_match('/.*<(.*)>/', $this->messageHeaders['return-path'], $emailAddress);
        if (isset($emailAddress[1])) {
            return trim($emailAddress[1]);
        }

        return trim($this->messageHeaders['return-path'], ' \"\"');
    }

    /**
     * Retrieves and returns the user of the Return-Path Header address
     *
     * @return string
     */
    public function getReturnPathUser()
    {
        /* The return path has the following format '<emailUser@your.domain>'*/
        preg_match('/<(.*)@.*>/', $this->messageHeaders['return-path'], $returnPathEmailUser);

        $emailUser = $this->messageHeaders['return-path'];
        if (isset($returnPathEmailUser[1])) {
            $emailUser =  $returnPathEmailUser[1];
        }

        return $emailUser;
    }
}
