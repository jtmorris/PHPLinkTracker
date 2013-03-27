This project is licensed under the MIT License (see the LICENSE file for details).

Purpose
==========
This simple PHP script will turn whatever URL that points at it into a link passthrough page with stat tracking.  
Basically, by placing this script on a web server, and visiting its document root with some specific URL parameters
(see below) will forward the user's web browser to another desired web page after logging the visit.

I use this for QR codes in print media.  I have the QR code point to a copy of this PHP script which forwards
the user to the desired website, after logging that the user followed the link from the QR code.  This allows
me to assess the effectiveness and utilization of QR codes.

However, this is not limited to QR codes.  If you wish to send people to a website and see how often, and when,
people comply, this is a quick and dirty method of doing so.


Installation
=============
First and foremost, you need a web server with recent versions of PHP and MySQL.  Once you have that, you will need to setup a database
in which logging data will be stored.  Eventually, I will write an install script which will populate the database with
the necessary tables.  For the time being, this must be done manually.  You will need to execute the following SQL query
on your database to create the necessary tables with the proper configuration.

```sql
CREATE TABLE IF NOT EXISTS `plt_linkinfo` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`visitor` int(11) NOT NULL
	`time` datetime NOT NULL,
	`useragent` varchar(1000) NOT NULL,
	`referer` varchar(1000) NOT NULL,
	`goto` varchar(1000) NOT NULL,
	`context` varchar(1000) DEFAULT NULL,
	PRIMARY KEY (`id`)
)

CREATE TABLE IF NOT EXISTS `plt_visitorinfo` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`ip` varchar(45) NOT NULL,
	`visits` int(11) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `ip` (`ip`)
)
```

Now that the environment is setup, we need a configuration file.  A sample configuration file is provided.  Create a copy of the
config_sample.php file and name it config.php.  Open the configuration file in a text editor of some sort, and fill in the database
connection information.

Now, copy the files to your web server, and visit the site.  You should receive a message stating that no passthrough link was provided.
Assuming your database and web server were properly configured and the configuration file properly filled out, installation is complete.

Usage
==========
Providing Links to Track
-------------------------
First, you will need a URL pointing to this script on your web server.  I will use <i>http://go.jtmorris.net</i> as the URL for the examples
below.

<b>Lengthy Explanation</b>

Once you have your URL, to make this script work, simply place a URL parameter named "goto" at the end of your URL with the value of the 
URL you wish to forward to.  So, if I wanted to create a link to my GitHub profile using this script, and the example URL above, the link
I would provide to others would be "http://go.jtmorris.net?goto=http://github.com/jtmorris".  Visiting that link should add an entry in
the database.

It is wise to provide some identifying information to help with sorting out data in your database.  You can provide a short description of
what this link is by adding another URL parameter, called "context".  If I were to add this to the example above, my new URL would look like
"http://go.jtmorris.net?goto=http://github.com/jtmorris&context=github".  Now, all visits to this link will be logged with this new identifying
string added to the database.

<b>Short Examples</b>

http://go.jtmorris.net?goto=http://www.mywebsite.com
- OR -
http://go.jtmorris.net?goto=http://www.myotherwebsite.com&context=my_identification_string


Viewing Basic Statistics
-------------------------
This script includes a <i><u>very</u></i> basic statistics viewing page.  To view the statistics, visit the stats.php page.  So, for the example
URL, this would be http://go.jtmorris.net/stats.php.  