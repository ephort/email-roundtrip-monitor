<?php

use Roundtripmonitor\Send;
use Roundtripmonitor\Config;
use Roundtripmonitor\Confirm;

class RoundtripmonitorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Config::$receiverEmail = 'testmailbox@receiver.com';
    }

    /**
     * Test that the send function calls the callback function
     * 
     * Does not actually send an email.
     */
    public function testSend()
    {
        list($constructedSubject, $constructedBody) = Send::email(function ($toName, $toEmail, $fromName, $fromEmail, $subject, $body) {
            return array(
                $subject,
                $body
            );
        });

        $this->assertTrue(strpos($constructedSubject, 'Round-trip Monitor Test Mail') !== false);
        $this->assertTrue(strpos($constructedBody, 'Sent unix timestamp') !== false);
    }

    /**
     * Test that the connection can be established to the receiving mailbox
     * and that no round-trip messages were found.
     * 
     * @expectedException Exception
     * @expectedExceptionMessage No round-trip monitor e-mails found.
     */
    public function testReceiveFail()
    {
        Config::server('imap.host.com', 143, 'imapUsername', 'imapPassword', 'INBOX');
        Confirm::email();
    }

    /**
     * Server config function without all arguments
     */
    public function testServerConfigFail()
    {
        try {
            Config::server('imap.host.com', 143, 'imapUsername', 'imapPassword');
        } catch (\Exception $e) {
            $this->assertEquals(2, $e->getCode());
        }
    }

    /**
     * Server config function all arguments filled in
     */
    public function testServerConfig()
    {
        $this->assertEquals(NULL, Config::server('imap.host.com', 143, 'imapUsername', 'imapPassword', 'INBOX'));
    }
}
