<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Sender Name <filipe.silva@emailbidding.com>
 * @copyright  2012-2014 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EB\SMTPAnonymousClient\Tests;

use EB\SMTPAnonymousClient\Message\Parser;

class ParserTest extends TestCase
{
    /**
     * @dataProvider messageProvider
     */
    public function testBuildRawMessage($rawData)
    {
        $p = new Parser($rawData);
        $rawMessage = $p->buildRawMessage();

        $this->assertEquals('testing4@proxy.eb', $rawMessage->getTo());
        $this->assertEquals('Sender Name <sender@emailbidding.com>', $rawMessage->getFrom());
        $this->assertEquals('subject4', $rawMessage->getSubject());
    }


    /**
     * Message Provider
     */
    public function messageProvider()
    {
        return array(
            array(
<<<EOT
From sender@emailbidding.com  Wed Feb 19 04:23:38 2014
Return-Path: <sender@emailbidding.com>
X-Original-To: testing4@proxy.eb
Delivered-To: proxyhandler@amx.ebidtech.com
Received: from [10.0.0.25] (a89-152-225-228.cpe.netcabo.pt [89.152.225.228])
	by amx.ebidtech.com (Postfix) with ESMTP id 857AE2017F
	for <testing4@proxy.eb>; Wed, 19 Feb 2014 04:23:38 +0000 (UTC)
Message-ID: <530431C9.3080502@adclick.pt>
Date: Wed, 19 Feb 2014 04:23:37 +0000
From: Sender Name <sender@emailbidding.com>
User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:24.0) Gecko/20100101 Thunderbird/24.2.0
MIME-Version: 1.0
To: testing4@proxy.eb
Subject: subject4
Content-Type: multipart/alternative;
 boundary="------------060808030907010200000404"

This is a multi-part message in MIME format.
--------------060808030907010200000404
Content-Type: text/plain; charset=ISO-8859-1; format=flowed
Content-Transfer-Encoding: 7bit

testing4

--------------060808030907010200000404
Content-Type: text/html; charset=ISO-8859-1
Content-Transfer-Encoding: 7bit

<html>
  <head>

    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>
  <body text="#000000" bgcolor="#FFFFFF">
    <small>testing4</small>
  </body>
</html>

--------------060808030907010200000404--
EOT
            )
        );
    }

} 