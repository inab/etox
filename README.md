Limtox overview
========================

The LiMTox system is the first text mining approach that tries to extract associations between compounds and a particular toxicological end point at various levels of granularity and evidence types, all inspired by the content of toxicology reports. It integrates direct ranking of associations between compounds and hepatotoxicity through combination of heterogeneous complementary strategies from term co-mention, rules, and patterns to machine learning based text classification.  It also provides indirect associations to hepatotoxicity through the extraction of relations reflecting the effect of compounds at the level of metabolism and liver enzymes

Limtox installation
========================

1.- Clone this repository inside your webserver

    $ git clone https://github.com/inab/etox.git

2.- Copy app/config/parameters.yml.dist to app/config/parameters.yml and modify it.

3.- Download vendors using Composer

    $ composer.phar update

4.- Create app/cache and app/logs and give permissions

    4.1.- Linux
        4.1.1.- $ mkdir app/cache
        4.1.2.- $ mkdir app/logs
        4.1.3.- $ sudo chmod +a "www-data allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs  (if +a doesn't work, jump to 4.1.5)
        4.1.4.- $ sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
        4.1.5.- (only if +a doesn't work)$ sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs (if it doesn't work, jump to 4.3)
        4.1.6.- (only if +a doesn't work)$ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs


    4.2.- Mac OS X
        4.2.1.- $ mkdir app/cache
        4.2.2.- $ mkdir app/logs
        4.2.3.- $ sudo chmod +a "www-data allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs (if it doesn't work, jump to 4.3)
        4.2.4.- $ sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs




    4.3.- If permissions cannot be changed in previous steps

        Modify app/console, web/app.php and web/app_dev.php
        Uncomment line with umask() function

         // if you don't want to setup permissions the proper way,
         // just uncomment the following PHP line and read
         // http://symfony.com/doc/current/book/installation.html#configuration-and-setup
         // for more information
         umask(0000);//Or you can use umask(0002)