<?php
/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Filipe Silva <filipe.silva@emailbidding.com>
 * @copyright  2012-2014 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */
$errorDependencies = 'Missing dependencies';

$file = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($file)) {
    throw new \RuntimeException($errorDependencies);
}

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require($file);