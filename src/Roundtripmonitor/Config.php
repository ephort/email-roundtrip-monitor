<?php

namespace Roundtripmonitor;

/**
 * Config
 * 
 * @author Kristian Just Iversen
 */
class Config
{
    /**
     * Receiver e-mail address
     * 
     * @var string
     */
    static $receiverEmail = '';

    /**
     * Receiver name
     * 
     * @var string
     */
    static $receiverName = '';

    /**
     * Sender e-mail address
     * 
     * @var string
     */
    static $senderEmail = '';

    /**
     * Sender name
     * 
     * @var string
     */
    static $senderName = '';

    /**
     * Alert threshold: newest mail cannot be older than this number of seconds
     * 
     * @var int
     */
    static $alertThresholdTime = 900;

    /**
     * IMAP server host
     * 
     * @var string
     */
    static $imapServerHost = '';

    /**
     * IMAP server port
     * 
     * @var int
     */
    static $imapServerPort = 143;

    /**
     * IMAP server username
     * 
     * @var string
     */
    static $imapServerUsername = '';

    /**
     * IMAP server username
     * 
     * @var string
     */
    static $imapServerPassword = '';

    /**
     * IMAP mailbox
     * 
     * @var string
     */
    static $imapMailbox = '';

    /**
     * IMAP cert option
     * 
     * @var string
     */
    static $imapCert = '/novalidate-cert';

    /**
     * Test mails will be deleted when receipt is confirmed.
     * 
     * @var string
     */
    static $deleteTestMailAfterConfirmation = true;

    /**
     * Server config function
     * 
     * @param string $host
     * @param string $port
     * @param string $username
     * @param string $password
     * @param string $mailbox
     */
    public static function server($host, $port, $username, $password, $mailbox)
    {
        self::$imapServerHost = $host;
        self::$imapServerPort = $port;
        self::$imapServerUsername = $username;
        self::$imapServerPassword = $password;
        self::$imapMailbox = $mailbox;
    }
}
