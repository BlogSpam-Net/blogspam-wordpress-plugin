Blogspam Wordpress Plugin
-------------------------

This directory contains the source code to a plugin for Wordpress, which tests incoming comments against the [BlogSpam.net](http://blogspam.net/) comment-testing service.  (The source code for the service itself is [available upon github](https://github.com/skx/blogspam.js/))

The plugin is designed to test incoming comments on your blog, in real-time, and automatically mark spam comments as spam.


Installation
------------

To install the plugin you need to download it beneath the wordpress `wp-content/plugins` directory,
as you would for any plugin.

You can do that via a git checkout:

      $ cd /var/www/wordpress/wp-content/plugins/
      $ git clone https://github.com/skx/blogspam-wordpress-plugin.git blogspam/

Or if you prefer you can download the state of the repository as a `.zip` file:

      $ cd /var/www/wordpress/wp-content/plugins/
      $ wget https://github.com/skx/blogspam-wordpress-plugin/archive/master.zip
      $ unzip master.zip

Either approach will work, but the second solution doesn't require you to have git installed upon your webserver.

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


Bugs?
-----

If you have any problem with this plugin please report a bug in the github
tracker:

 * https://github.com/skx/blogspam-wordpress-plugin/issues


Steve
---
