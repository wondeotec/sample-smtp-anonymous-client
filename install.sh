#!/bin/sh

echo 'Downloading and installing composer'
curl -sS https://getcomposer.org/installer | php

echo 'Resolving and installing dependencies'
php composer.phar install

echo 'Done'
