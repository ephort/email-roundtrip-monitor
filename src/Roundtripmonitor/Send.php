<?php

namespace Roundtripmonitor;

/**
 * Send test mail
 *
 * @author Kristian Just Iversen
 */
class Send {
    
    /**
     * Send test email using a local email function
     * 
     * @param function $callback
     * @return mixed
     */
    public static function email($callback)
    {
        return $callback(Config::$receiverName, Config::$receiverEmail, Config::$senderName, Config::$senderEmail, self::createSubject(), self::createBody());
    }
    
    /********** PROTECTED METHODS **********/
    
    /**
     * Create subject
     * 
     * @return string
     */
    protected static function createSubject()
    {
        return 'Round-trip Monitor Test Mail';
    }
    
    /**
     * Create body
     * 
     * @return string
     */
    protected static function createBody()
    {
        return <<<EOT
Round-trip monitor e-mail.
Sent unix timestamp: {time()}
Sent date GMT: {gmdate('Y-m-d H:i:s')}
EOT;
    }
    
}