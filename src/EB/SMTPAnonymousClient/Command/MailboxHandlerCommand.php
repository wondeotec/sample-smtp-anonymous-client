<?php
/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Filipe Silva <filipe.silva@emailbidding.com>
 * @copyright  2012-2015 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EB\SMTPAnonymousClient\Command;

use EB\SMTPAnonymousClient\Message\Parser;
use EB\SMTPAnonymousClient\Recipient\DatabaseFactory;
use EB\SMTPAnonymousClient\SwiftMailer\SwiftTransformer;
use Swift_Mailer;
use Swift_SmtpTransport;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MailboxHandlerCommand extends Command
{

    /**
     * Change this credentials to use your SMTP
     */
    const DEFAULT_SMTP_HOSTNAME = '127.0.0.1';
    const DEFAULT_SMTP_PORT = 25;
    const DEFAULT_SMTP_USERNAME = 'DUMMY_USER';
    const DEFAULT_SMTP_PASSWORD = 'DUMMY_PASSWORD';

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this
            ->setName('eb:mailbox-handler')
            ->setDescription('Mailbox Handler')
            ->setHelp(
                <<<EOT
                The <info>%command.name%</info> receives bounce blocks.

    <info>php %command.full_name%</info>
EOT
            );
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Reading the message from standard input (injected by postfix)
        $rawData = '';
        while (!feof(STDIN)) {
            $rawData .= fread(STDIN, 8192);
        }

        $parseMessage = new Parser($rawData);
        $recipientProvider = (new DatabaseFactory())->create(DatabaseFactory::DUMMY);

        $swiftTransformer = new SwiftTransformer($recipientProvider);

        $message = $swiftTransformer->transform($parseMessage->buildRawMessage());

        /*
         * Setting the SMTP credentials
         */
        $transport = Swift_SmtpTransport::newInstance(self::DEFAULT_SMTP_HOSTNAME, self::DEFAULT_SMTP_PORT)
            ->setUsername(self::DEFAULT_SMTP_USERNAME)
            ->setPassword(self::DEFAULT_SMTP_PASSWORD)
        ;

        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);

        // Send the message
        $failures = array();
        $mailer->send($message, $failures);

        if (count($failures) > 0) {
            $output->writeln('Can not send message!');
        }
    }
}
