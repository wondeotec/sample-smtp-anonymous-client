<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Filipe Silva <filipe.silva@emailbidding.com>
 * @copyright  2012-2015 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EB\SMTPAnonymousClient\Recipient;

class DatabaseFactory extends FactoryMethod
{
    /**
     * @inheritdoc
     */
    protected function createProvider($type)
    {
        switch ($type) {
            case parent::DUMMY;
                return new DummyRecipientProvider();
                break;

            /**
             * CHANGE ME HERE
             */

            default:
                throw new \InvalidArgumentException("$type is not a valid provider");
        }
    }
}
