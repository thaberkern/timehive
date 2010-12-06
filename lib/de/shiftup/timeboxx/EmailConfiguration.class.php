<?php
/**
 * Description of EmailConfiguration
 *
 * @author thaberkern
 */
class EmailConfiguration {

    public static function getCurrent()
    {
        $mailserver = sfConfig::get('app_system_email');
        return $mailserver;
    }
}