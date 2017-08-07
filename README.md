# email-roundtrip-monitor

Simple PHP email round trip monitoring tool.

Has IMAP support for validating that e-mails are received.

The test e-mails should be sent through the e-mail method that is usual
used in your project (passed as a callback function).

## Installation

`composer require kristiani/email-roundtrip-monitor`

## Usage

You would like your set-up to consist of two cron jobs

1. The cron that sends a test e-mail. The cron can be run e.g. every 15 minutes.

2. The cron that checks the test e-mail is received within an tolerated interval. 
The cron can be run e.g. every 5 minutes. It's convenient to let a 3rd party 
service (e.g. uptimerobot.com) pull this check instead of a local cron.

### Sending cron

```php
\Roundtripmonitor\Config::$receiverEmail = 'testmailbox@receiver.com';

\Roundtripmonitor\Send::email(function($toName, $toEmail, $fromName, $fromEmail, $subject, $body) {
    yourEmailFunction($toName, $toEmail, $fromName, $fromEmail, $subject, $body);
});
```

### Receiving cron

If you would like your receiving cron to return status code 500 on failure:

```php
\Roundtripmonitor\Config::server('imap.host.com', 143, 'imapUsername', 'imapPassword', 'INBOX');
\Roundtripmonitor\Confirm::emailOrFail();
```

If you prefer to handle your exceptions by yourself:

```php
try {
    \Roundtripmonitor\Config::server('imap.host.com', 143, 'imapUsername', 'imapPassword', 'INBOX');
    \Roundtripmonitor\Confirm::email();
} catch (\Exception $ex) {
    // do something about it
}
```

### Change settings

You can change all settings in Config.php individually, e.g.

```php
\Roundtripmonitor\Config::$alertThresholdTime = 900;
```
