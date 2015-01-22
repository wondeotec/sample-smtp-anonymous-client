<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Filipe Silva <filipe.silva@emailbidding.com>
 * @copyright  2012-2015 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EB\SMTPAnonymousClient\Recipient;

class DummyRecipientProvider implements RecipientProviderInterface
{
    const DEFAULT_EMAIL_ADDRESS = 'user@domain.com';

    /**
     * @inheritdoc
     */
    public function getEmailAddressByHash($hash)
    {
        return self::DEFAULT_EMAIL_ADDRESS;
    }
}
