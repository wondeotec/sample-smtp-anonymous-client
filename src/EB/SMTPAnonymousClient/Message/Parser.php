<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Filipe Silva <filipe.silva@emailbidding.com>
 * @copyright  2012-2015 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EB\SMTPAnonymousClient\Message;

use MimeMailParser\Parser as MimeMailParser;

class Parser
{
    /**
     * @var MimeMailParser
     */
    protected $parser;

    public function __construct($rawData)
    {
        $this->parser = new MimeMailParser();
        $this->parser->setText($rawData);
    }

    /**
     * @return RawMessage
     */
    public function buildRawMessage()
    {
        return new RawMessage(
            $this->parser->getHeaders(),
            $this->parser->getMessageBodyHeaders('html'),
            $this->parser->getMessageBodyHeaders('text'),
            $this->parser->getMessageBody('html'),
            $this->parser->getMessageBody('text'),
            $this->parser->getAttachments()
        );
    }
}
