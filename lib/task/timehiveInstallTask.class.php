<?php

class timehiveInstallTask extends sfBaseTask
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
                // add your own options here
        ));

        $this->namespace = 'timehive';
        $this->name = 'install';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [timehive:install|INFO] task is a commandline installer for timehive.
Call it with:

  [php symfony timehive:install|INFO]
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        $this->log('--------------------------------------------------');
        $this->log('--------------------------------------------------');
        $this->log('The TimeHive installer will ask you some questions');
        $this->log('about your server configuration');
        $this->log('--------------------------------------------------');
        $this->log('--------------------------------------------------');
        
        //--- Database settings
        $this->logSection('Database', 'Your database settings');
        $database['type'] = $this->ask('Type [mysql, postgresql] (default is mysql)', 'QUESTION', 'mysql');
        $database['hostname'] = $this->ask('Hostname (default is localhost)', 'QUESTION', 'localhost');
        $database['database'] = $this->ask('Databasename (default is timehive)', 'QUESTION', 'timehive');
        $database['username'] = $this->ask('username', 'QUESTION');
        $database['password'] = $this->ask('password', 'QUESTION');
        
        $this->log('--------------------------------------------------');
        
        //--- EMail-Settings
        $this->logSection('E-Mail', 'Your SMTP settings');
        $smtp['hostname'] = $this->ask('Hostname (default is localhost)', 'QUESTION', 'localhost');
        $smtp['port'] = $this->ask('Port (default is 25)', 'QUESTION', '25');
        $smtp['username'] = $this->ask('username', 'QUESTION');
        $smtp['password'] = $this->ask('password', 'QUESTION');
        $smtp['from'] = $this->ask('From-Address', 'QUESTION');
        
        $this->log('--------------------------------------------------');
        
        //--- Server-Settings
        $this->logSection('Server', 'Your Server settings');
        $server['web_dir'] = $this->ask('The vhost-public directory (default is httpdocs)', 'QUESTION', 'htttpdocs');
        $server['url'] = $this->ask('The URL with that the software can be accessed (with http://)');
        
        $this->log('--------------------------------------------------');
        
        //--- Account-Settings
        $this->logSection('Account', 'Your account settings');
        $account['name'] = $this->ask('Accountname (i.e. your company or department name)', 'QUESTION');
        $account['username'] = $this->ask('Admin username', 'QUESTION');
        $account['password'] = $this->ask('Admin password', 'QUESTION');
        
        $this->log('--------------------------------------------------');
        
        $filesystem = $this->getFilesystem();
                
        //--- write database settings
        $dsn = $database['type'].":host=".$database['hostname'].";dbname=".$database['database'];
        $this->runTask('configure:database', array($dsn, $database['username'], $database['password']));
        $this->log('Write config/databases.yml:             x');
        
        //--- write app.yml settings
        $filesystem->remove(sfConfig::get('sf_config_dir').'/app.yml');
        $filesystem->copy(sfConfig::get('sf_config_dir').'/app.yml.dist', sfConfig::get('sf_config_dir').'/app.yml');
        $filesystem->replaceTokens(sfConfig::get('sf_config_dir').'/app.yml', '##', '##', 
                array('EMAIL_HOST'=>$smtp['hostname'],
                      'EMAIL_PORT'=>$smtp['port'],
                      'EMAIL_USER'=>$smtp['username'],
                      'EMAIL_PWD'=>$smtp['password'],
                      'EMAIL_FROM'=>$smtp['from'],
                      'URL'=>$server['url']));
        $this->log('Write config/app.yml:                   x');
        
        //--- write ProjectConfiguration
        $filesystem->remove(sfConfig::get('sf_config_dir').'/ProjectConfiguration.class.php');
        $filesystem->copy(sfConfig::get('sf_config_dir').'/ProjectConfiguration.class.php.dist', sfConfig::get('sf_config_dir').'/ProjectConfiguration.class.php');
        $filesystem->replaceTokens(sfConfig::get('sf_config_dir').'/ProjectConfiguration.class.php', '##', '##', array('WEBDIR'=>$server['web_dir']));
        $this->log('Write ProjectConfiguration.class.php:   x');
        
        // create database structure
        $this->runTask('doctrine:build', array('--all-classes', '--and-migrate'));
        $this->log('Create database structure:              x');
        
        // Write Account default config
        AccountConfigWriter::getInstance()->writeDefaultConfig($account);
        $this->log('Create account in database:             x');
        
        $this->log('Installation completed. Please login with your admin user');
        $this->log('Please setup your user, roles and projects in the administration');
        $this->log('interface after login');
    }

}
