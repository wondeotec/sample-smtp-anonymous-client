<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Filipe Silva <filipe.silva@emailbidding.com>
 * @copyright  2012-2015 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EB\SMTPAnonymousClient\Recipient;

interface RecipientProviderInterface
{
    /**
     * @param string $hash
     *
     * @return string
     */
    public function getEmailAddressByHash($hash);
}
