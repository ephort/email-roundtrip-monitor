<?php

namespace Roundtripmonitor;

use Ddeboer\Imap\Server;
use Roundtripmonitor\Config;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Text\Body;
use Ddeboer\Imap\Search\Text\Subject;

/**
 * Confirm receipt
 *
 * @author Kristian Just Iversen
 */
class Confirm
{
    /**
     * Confirm email receipt
     * 
     * @return boolean|void True or exception on failure.
     */
    public static function email()
    {
        $messages = self::getRoundtripMonitorEmailsInMailbox();

        if (count($messages) === 0) {
            throw new \Exception('No round-trip monitor e-mails found.');
        }

        $thresholdDateTime = new \DateTime();
        $thresholdDateTime->setTimestamp(time() - Config::$alertThresholdTime);

        foreach ($messages as $message) {
            if ($message->getDate() > $thresholdDateTime) {
                return true;
            }
        }

        throw new \Exception('No e-mails within acceptable time interval found.');
    }

    /**
     * Confirm receipt of email or fail with status code 500.
     * 
     * @return void
     */
    public static function emailOrFail()
    {
        try {
            self::email();
        } catch (\Exception $ex) {
            self::failed($ex->getMessage());
            die;
        }

        self::ok();
    }

    /**
     * Ok response
     * 
     * @return int
     */
    protected static function ok()
    {
        return http_response_code(200);
    }

    /**
     * Failed response
     * 
     * @param string $message
     * @return int
     */
    protected static function failed($message)
    {
        echo $message;
        return http_response_code(500);
    }

    /**
     * Create IMAP connection
     * 
     * @return \Ddeboer\Imap\Connection
     */
    protected static function createImapConnection()
    {
        $server = new Server(Config::$imapServerHost, Config::$imapServerPort, Config::$imapCert);

        return $server->authenticate(Config::$imapServerUsername, Config::$imapServerPassword);
    }

    /**
     * Get mailbox
     * 
     * @return
     */
    protected static function getMailbox()
    {
        $connection = self::createImapConnection();

        return $connection->getMailbox(Config::$imapMailbox);
    }

    /**
     * Get round-trip monitor emails in mailbox
     * 
     * @return array of \Ddeboer\Imap\Message
     */
    protected static function getRoundtripMonitorEmailsInMailbox()
    {
        $mailbox = self::getMailbox();

        $search = new SearchExpression();
        $search->addCondition(new Subject('Round-trip Monitor Test Mail'));

        return $mailbox->getMessages($search);
    }
}
