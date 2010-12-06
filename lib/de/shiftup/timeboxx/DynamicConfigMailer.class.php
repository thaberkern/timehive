<?php

class DynamicConfigMailer extends sfMailer
{

    public function __construct(sfEventDispatcher $dispatcher, $options)
    {
        // Load client based configuration
        $cfg = EmailConfiguration::getCurrent();

        // Update settings for the current client
        $options["transport"]["param"]["host"] = $cfg['host'];
        $options["transport"]["param"]["port"] = $cfg['port'];
        $options["transport"]["param"]["username"] = $cfg['username'];
        $options["transport"]["param"]["password"] = $cfg['password'];
        
        parent::__construct($dispatcher, $options);
    }

}