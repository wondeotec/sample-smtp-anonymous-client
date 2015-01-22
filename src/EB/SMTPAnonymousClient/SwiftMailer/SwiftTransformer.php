<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Filipe Silva <filipe.silva@emailbidding.com>
 * @copyright  2012-2015 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EB\SMTPAnonymousClient\SwiftMailer;

use EB\SMTPAnonymousClient\Message\RawMessage;
use EB\SMTPAnonymousClient\Recipient\RecipientProviderInterface;
use Swift_Message;

class SwiftTransformer
{
    /**
     * @var RecipientProviderInterface
     */
    protected $recipientProvider;

    /**
     * @param RecipientProviderInterface $recipientProvider
     */
    public function __construct(RecipientProviderInterface $recipientProvider)
    {
        $this->recipientProvider = $recipientProvider;
    }

    public function transform(RawMessage $rawMessage)
    {
        $message = Swift_Message::newInstance();
        $realEmailAddress = $this->recipientProvider->getEmailAddressByHash($rawMessage->getTo());

        $message->setTo($realEmailAddress);
        $message->setFrom($rawMessage->getFromEmailAddress());
        $message->setSubject(self::replace($rawMessage->getTo(), $realEmailAddress, $rawMessage->getSubject()));
        $message->setBody(
            self::replace($rawMessage->getTo(), $realEmailAddress, $rawMessage->getBodyHTML()),
            'text/html'
        );
        $message->addPart(
            self::replace($rawMessage->getTo(), $realEmailAddress, $rawMessage->getBodyText()),
            'text/plain'
        );
        foreach ($rawMessage->getHeaders() as $originalHeaderName => $originalHeaderValue) {
            $headers = $message->getHeaders();
            switch ($originalHeaderName) {
                case 'return-path':
                    $message->setReturnPath($rawMessage->getReturnPathEmailAddress());
                    break;
                case 'x-ebmessageid':
                    $headers->addTextHeader('X-EBMessageID', $originalHeaderValue);
                    break;
                case 'precedence':
                    $headers->addTextHeader('Precedence', $originalHeaderValue);
                    break;
            }
        }

        //TODO: complete message building

        return $message;
    }

    /**
     * @param      $search
     * @param      $replace
     * @param      $subject
     * @param null $count
     *
     * @return mixed
     */
    protected static function replace($search, $replace, $subject, &$count = null)
    {
        return str_replace($search, $replace, $subject, $count);
    }
}
