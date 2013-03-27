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
First and foremost, you need a web server with PHP and MySQL.  Once you have that, you will need to setup a database
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