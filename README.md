TimeHive
===========
TimeHive is a open-source webbased timesheet/time tracking software developed with PHP (Symfony Framework).
You can follow TimeHive on Twitter if you want to keep up to date: [TimeHive on Twitter](http://www.twitter.com/timehive)

You can find the Issue-Tracker on [Lighthouse](http://timehive.lighthouseapp.com/projects/71615-timehive)

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

1. Get your copy of TimeHive via [GitHub](https://github.com/thaberkern/timehive). 
  
  * Please use the official download-package for this. Only these package including the needed Symfony-Libraries! The current release package is [V.1.3.0](https://github.com/downloads/thaberkern/timehive/timehive-1.3.0.zip)

2. Copy the sourcecode to one of your Webservers.
3. Create a virtual host with the web-directory as the root-folder. If you have an existing Webserver with a given file structure rename the webfolder with the root folder of your webserver. Do not (!!) copy the entire timehive folder to the root folder!
4. Start running the commanline-installer with the following command. This installer will guide you through some questions to complete you installation

    php symfony timehive:install --env=prod

5. If you want to use automatic reminder E-Mails you need to add the following command to a cronjob (Once a day, for example at 22:00 o'clock)

    php symfony timehive:check-missing-bookings --env=prod --application=frontend

6. You are done! Open your browser and log in :)



