<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Filipe Silva <filipe.silva@emailbidding.com>
 * @copyright  2012-2015 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EB\SMTPAnonymousClient\Recipient;

abstract class FactoryMethod
{
    const DUMMY = 'dummy';

    /**
     * @param string $type a generic type
     *
     * @return RecipientProviderInterface a new provider
     */
    abstract protected function createProvider($type);

    /**
     * Creates a new provider
     *
     * @param string $type
     *
     * @return RecipientProviderInterface a new provider
     */
    public function create($type)
    {
        $obj = $this->createProvider($type);

        return $obj;
    }
}
