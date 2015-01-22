Sample SMTP Anonymous Client
=============================

To use this code you need to have installed Postfix (http://www.postfix.org/) and redirect all SMTP messages
(that you want!) to this script. To achieve this you need to execute three steps:

1. First you need to edit the Postfix virtual alias map configuration file (also known as virtual_alias_maps.pcre)
and add the following line:


# /etc/postfix/virtual_alias_maps.pcre
# From REGEX    <TAB>   system alias
/^(.*)@(.*)/            sample-smtp-anonymous-client


Read more about on http://www.postfix.org/postconf.5.html#virtual_alias_maps

2. For the second step you need to edit your linux alias configuration (typically on /etc/aliases) to recognize
the new alias and redirect the Postfix to our code:


# /etc/aliases
sample-smtp-anonymous-client:   |"phpcli -q /PATH/TO/sample-smtp-anonymous-client/app/console eb:mailbox-handler"


3. Lastly you need to restart postfix:


service postfix restart


After that, all messages received from this Postfix should be redirected and handled by our code!

