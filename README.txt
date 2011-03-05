This is another application for the Spirit project from the Faculty of Computer Science
 of the University of Applied Sciences Schmalkalden. In GitHub it is called "studweb" because 
 it will be the new front end for the students.

Feature list and more details coming soon!

Programming hints:
* PHP with Zend Framework
* HTML5
* SQLite (for development - later it will be REST for productional usage)


INSTALLATION:

In the sub-directory "scripts/" are the load scripts for the actual db-structure and testing data stored.
You have to execute this script from a terminal or the DOS command line with the following command:
	% php scripts/load.sqlite.php --withdata

Now you have a running SQLite database.

You will also need to point your web server to the
application. Using apache, you could add a vhost as follows:

    <VirtualHost *:80>
        ServerAdmin spirit@fh-schmalkalden.de
        DocumentRoot <PATH_TO_STUDWEB>/public
        ServerName studweb
        SetEnv APPLICATION_ENV "development"

        <Directory <PATH_TO_STUDWEB>/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>

You **must** substitute the correct path to this directory for
<PATH_TO_STUDWEB>. Feel free to substitute any value for the
ServerName directive; make sure that name and the associated IP address
are in your hosts file or in your DNS.

You have to write the following line in your hosts file:
127.0.0.1 studweb


Finally, point your browser to http://studweb/ to see the
application in action.
