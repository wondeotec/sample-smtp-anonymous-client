Sample SMTP Anonymous Client
=============================

To use this code you need to have installed Postfix (http://www.postfix.org/) and redirect all SMTP messages
(that you want!) to this script. To achieve this you need to execute three steps:

* First you need to edit the Postfix virtual alias map configuration file (also known as virtual_alias_maps.pcre)
and add the following line:

```sh
# /etc/postfix/virtual_alias_maps.pcre&nbsp
# From REGEX    <TAB>   system alias
/^(.*)@(.*)/            sample-smtp-anonymous-client
```

Read more about on http://www.postfix.org/postconf.5.html#virtual_alias_maps

* For the second step you need to edit your linux alias configuration (typically on /etc/aliases) to recognize
the new alias and redirect the Postfix to our code:


```sh
# /etc/aliases
sample-smtp-anonymous-client:   |"php -q /PATH/TO/sample-smtp-anonymous-client/app/console eb:mailbox-handler"
```

* Lastly you need to restart postfix:


```sh
service postfix restart
```

After that, all messages received from this Postfix should be redirected and handled by our code!

