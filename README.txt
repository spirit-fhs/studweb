This is another application for the Spirit project from the Faculty of Computer Science
 of the University of Applied Sciences Schmalkalden. In GitHub it is called "studweb" because 
 it will be the new front end for the students.

Feature list and more details coming soon!

Programming hints:
* PHP with Zend Framework
* HTML5
* MySQL (later there will be the chance to change that)


INSTALLATION:

In the sub-directory data are the actual db-structure and testing data stored.
Import these files to your MySQL database.

Than change the db connection information in the (studweb/application/configs/) application.ini.
Normally you have to change only the user name and the password.

	resources.db.params.host = "localhost"
	resources.db.params.username = "spiritUser"
	resources.db.params.password = "spirit"
	resources.db.params.dbname = "spirit"

You will also need to point your web server to the
application. Using apache, you could add a vhost as follows:

    <VirtualHost *:80>
        ServerAdmin spirit@fh-schmalkalden.de
        DocumentRoot <PATH_TO_STUDWEB>/public
        ServerName studweb

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
