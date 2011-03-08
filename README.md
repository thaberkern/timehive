TimeHive
===========
TimeHive is a open-source webbased timesheet/time tracking software developed with PHP (Symfony Framework).
You can follow TimeHive on Twitter if you want to keep up to date: [TimeHive on Twitter](http://www.twitter.com/timehive)

System requirements
-------------------
Client: The current development version of TimeHive is only tested with Firefox browsers. There is no guarantee that it work with other browsers at the moment.
Server: Every webserver with PHP 5.2.x or higher should be capable to run TimeHive.

There will be a hosted version of TimeHive in the future.

Language versions
-------------------
TimeHive is only available in english and german at the moment. Let me know if you want to help with translating to other languages.

Installation
------------
At the moment there is no installation automatic process to help you doing a proper installation of Timehive. For now you have to do the following steps manually

1. Get your copy of TimeHive via [GitHub](https://github.com/thaberkern/timehive)
2. Copy the sourcecode to one of your Webservers.
3. Create a virtual host with the web-directory as the root-folder
4. Rename the config/databases.yml.dist to config/databases.yml. Open the file and change the database-settings under *prod:* to fit your needs
5. Rename the config/app.yml.dist to config/app.yml. Open the file an change the e-mail-settings (smtp)
6. Fire up a console window to setup the database structure. For that run the following command

    $> php symfony doctrine:build --all-classes --and-migrate --env=prod

7. Edit the following database tables
    * tb_account:
        * type: unlimited
        * name: Your organisation name
        * workdays: 31
    * tb_user:
        * first_name
        * last_name
        * email
        * account_id: 1
        * username
        * password: MD5!
        * administrator: 1

8. If you want to use automatic reminder E-Mails you need to add the following command to a cronjob (Once a day, for example at 22:00 o'clock)

    php symfony timehive:check-missing-bookings --env=prod --application=frontend

9. You are done! Open your browser and log in :)



