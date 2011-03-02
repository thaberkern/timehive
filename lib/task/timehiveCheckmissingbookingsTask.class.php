<?php

class timehiveCheckmissingbookingsTask extends sfBaseTask
{

    protected function configure()
    {
        // // add your own arguments here
        // $this->addArguments(array(
        //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
        // ));

        $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
                // add your own options here
        ));

        $this->namespace = 'timehive';
        $this->name = 'check-missing-bookings';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [timehive:check-missing-bookings|INFO] task does things.
Call it with:

  [php symfony timehive:check-missing-bookings|INFO]
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

        $users = UserTable::getInstance()->findAllUnlocked();

        foreach($users as $user) {
            
            if (false == TimeLogItemTable::getInstance()->updateMissedBookings(time(), $user)) {
                if ($user->Setting->reminder == true) {
                    $mailer = $this->getMailer();

                    $mailserver = sfConfig::get('app_system_email');
                    $context = sfContext::createInstance($this->configuration);
                    $this->configuration->loadHelpers('Partial');

                    $i18n = $this->getI18N($user->Setting->culture);
                    $subject = 'TimeHive - '.$i18n->__('Missing Booking');

                    $body = get_partial('global/missingBookings', array('user'=>$user, 'i18n'=>$i18n));

                    $message = $mailer->compose($mailserver['from'],
                                                $user->email,
                                                $subject);

                    $message->setBody($body, 'text/html');

                    try {
                        $mailer->send($message);
                    }
                    catch (Exception $e) {
                        $this->log($e->getMessage());
                    }
                }
            }            
        }
    }

    protected function getI18N($culture = 'en')
    {
        if (!$this->i18n) {
            $config = sfFactoryConfigHandler::getConfiguration($this->configuration->getConfigPaths('config/factories.yml'));
            $class = $config['i18n']['class'];
            $this->i18n = new $class($this->configuration, null, $config['i18n']['param']);
        }

        $this->i18n->setCulture($culture);
        return $this->i18n;
    }

    protected $i18n = null;
}
