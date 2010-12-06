<?php
/**
 *
 * @author thaberkern
 */
class MailSender {

    /**
     * Factory method, creating an instance of the current class
     * Useful for chaining method calls
     *
     * Notification 
     *
     * @return <type>
     */
    public static function createInstance() {
        return new MailSender();
    }

    /**
     * Sending a email to the given email address
     *
     * @param array $to_addresses Recipient E-Mail
     * @param String $subject Message subject
     * @param String $message_body Message Body
     */
    public function send($to_addresses, $subject, $message_body) {
        $mailserver = sfConfig::get('app_system_email');

        $mailer = sfContext::getInstance()->getMailer();
        $message = $mailer->compose($mailserver['from'], $to_addresses, $subject);
        $message->setBody($message_body, 'text/html');
        $mailer->send($message);
    }
}