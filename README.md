Purpose
==========
My PHP Link Tracker project is a statistics collection tool
for links.  Essentially, if a proper link (see usage instructions)
is distributed to a person, when that person visits the link is logged, and
the person is redirected to the desired location. It was originally intended to
track QR Code effectiveness on printed materials.  However, it is not limited to that purpose.


Technical Requirements
=============
*  A functioning web server with recent versions of PHP and MySQL installed and functioning.
*  A URL which points to the document root of this script's install location.


Installation
==============
1.  Download all the files in this repository to your local computer
2.  Copy or rename the file "config_sample.php" to "config.php"
3.  Open the "config.php" file in any text editor
4.  Fill in the database connection info under the "Datase Connection Settings" heading
5.  Upload the files to your web server ("config_sample.php", "README.md", "LICENSE", ".gitattributes", ".gitignore", and ".git/" are not required)
6.  Navigate to the "/install.php" page in your web browser (e.g. "http://example.com/install.php")
7.  If installation completes succesfully, you are ready to begin using this
     If installation fails, check your configuration settings, and follow any onscreen instructions

Usage
=======
*You will need a URL pointing to this script's install location. For examples below, the URL http://go.example.com/ will be
a placeholder for that URL.  Substitute in yours when using.*

Creating a Basic Tracked Link
------------------------------
There are multiple options that can be set in a link.  However, the bare minimum is the destination website address.
This is provided in the "goto" url parameter.  So, for example, if you wish to give a link to your Facebook page while collecting
usage statistics, install this script, and give the following link.

```
http://go.example.com/?goto=http://www.facebook.com/mypage
```

When followed, this will silently log any visits to the database, and then redirect the user to the "goto" URL.


Creating a Tracked Link with Contextual Information
----------------------------------------------------
The basic tracked link is all well and good.  Particularly if you are only tracking one particular link.
However, if used for tracking multiple links, it is generally helpful to provide some basic contextual information.

So, let's say we wanted to create the same link as above, but provide a contextual description of "Example Link
to Facebook Page".  We can then construct the following link.

```
http://go.example.com?goto=http://www.facebook.com/mypage&context=Example%20Link%20to%20Facebook%20Page
```

Notice the addition of the context URL parameter and its value.  Also notice that the spaces in the context
parameter have been replace with "%20".  See the WARNINGS & CAUTIONS section for more information about that.


WARNINGS & CAUTIONS
---------------------
URLs are very limited regarding what characters they can contain, and where.  It is important to check that your link
works as desired BEFORE using it in the real world.  Some very easy to make mistakes are listed below.

*  Spaces in your URL parameters.  Spaces are not allowed.  While most modern web browsers will correct this mistake
automatically, it is bad form to leave them there and depend on the browser.  Spaces should be replaced with "%20".

*  Unencoded URL parameters present in the URL you are forwarding the user to.  Many, many, many websites in this day
and age use URL parameters to convey information with the web server.  This script included.  However, this script
cannot differentiate between what URL parameters are intended for it, and which are part of the URL you want to direct
the user to.  As such, it is important to encode the URL you wish to direct people to, and replace any question marks (?) with
"%3F", and ampersands (&) with "%26".

As this is a pain to do manually, and is very easy to mess up, I recommend you use an online URL encoding tool on the values
you put into the URL parameters.  An easy to use one can be found at http://www.url-encode-decode.com/.  Simply type in your
desired, normal, human readable URL parameter values and click URL Encode.  Then, copy and paste the results into your constructed
URL.


Viewing Tracking Statistics
----------------------------
So now that you have some links out in the world, it's time to see who has been using them.  For that,
you can use the simple built-in statistics viewing page.  To do so, visit the "stats.php" page:
http://go.example.com/stats.php.


Questions, Bugs, Feature Requests, Patches, et cetera
===========================================
Feel free to use GitHub's excellent tools for communication and collaboration.  Or, visit http://php-plt.jtmorris.net,
and leave a comment.  I will gladly help out as my schedule permits, and welcome help or feedback.


Licensing
==========
This project is licensed under the MIT License (see LICENSE file for details). You are free to use or 
modify this in any way you like. Please feel free to share any modifications or use cases you make.  I'd
love to hear them.  You can fork this repository and submit pull requests, or simply let me know at 
http://php-plt.jtmorris.net.