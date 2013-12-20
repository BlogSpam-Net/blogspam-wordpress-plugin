Blogspam Wordpress Plugin
-------------------------

This plugin is designed to test incoming comments on your blog, in real-time, and automatically mark SPAM comments as SPAM.

The testing is achieved via a central server, hosted at [BlogSpam.net](http://blogspam.net/).

This plugin is developed and hosted on Github, however it is listed and mirrored on the Wordpress plugin directory:

* http://wordpress.org/plugins/blogspam/



Installation
------------

To install the plugin you need to download it beneath the wordpress
`wp-content/plugins` directory, as you would for any plugin.

You can do that via a git checkout:

      $ cd /var/www/wordpress/wp-content/plugins/
      $ git clone https://github.com/skx/blogspam-wordpress-plugin.git blogspam/

Or if you prefer you can download the state of the repository as a `.zip` file:

      $ cd /var/www/wordpress/wp-content/plugins/
      $ wget https://github.com/skx/blogspam-wordpress-plugin/archive/master.zip
      $ unzip master.zip

Either approach will work, but the first is preferred as it will allow you to update to more recent versions of the plugin easily:

      $ cd /var/www/wordpress/wp-content/plugins/blogspam/
      $ git pull


**NOTE**: If you're running the Debian GNU/Linux package of Wordpress, on Wheezy, you'll want to install beneath the directory `/usr/share/wordpress/wp-content/plugins/`.


Usage
-----

Enable the plugin via the administrative interface, and that should be all you
need to do.

You'll see the count of rejected/approved comments if you visit the
plugin-configuration page, but it should be fire and forget.


Tested Versions
---------------

This plugin has been successfully tested against the following versions
of Wordpress:

* 3.6.1
   * The latest stable release.
* 3.5.2
   * The version of Wordpress included in the Wheezy release of Debian GNU/Linux.
* 3.8
   * The current version at the time of last update.

Bugs?
-----

If you have any problem with this plugin please report a bug in the github
tracker:

 * https://github.com/skx/blogspam-wordpress-plugin/issues

You can also leave comments on the wordpress site:

   * http://wordpress.org/plugins/blogspam/

Steve
---
