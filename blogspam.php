<?php

/*
Plugin Name: Blogspam
Plugin URI: http://blogspam.net/plugins/
Description: This plugin allows you to test submitted comments against a centralised service that will filter out a lot of junk.  No manual intervention required.
Author: Steve Kemp
Version: 2.2
Author URI: http://www.steve.org.uk/
*/




/*  Copyright 2008-2013  Steve Kemp  (email : http://www.steve.org.uk/contact/ )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/




//
//  Find the version number of our plugin.
//
function skx_self_version()
{
  if ( !function_exists( 'get_plugins' ) )
  {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  }

  $plugins = get_plugins();
  $version = "v0.0";
  foreach ( $plugins  as $p )
  {
    if ( $p['Name'] == "Blogspam" )
    {
      $version = $p['Version'];
    }
  }
  return $version;
}



//
// Check the content of a comment, by submitting the body
// via HTTP to the JSON server.
//
function skx_check_comment( $author, $email,
	 $url, $comment,
	 $user_ip, $user_agent)
{
  //
  // Make the structure
  //
  $struct = array(
                   'ip'      => $_SERVER['REMOTE_ADDR'],
                   'name'    => $author,
                   'mail'    => $email,
                   'comment' => $comment,
                   'site'    => get_bloginfo('url'),
                   'version' => "Blogspam.php " . skx_self_version() . " on wordpress " . get_bloginfo('version')
                   );

  //
  //  Find the server to use.
  //
  $opt_name = 'skx_blogspam_server';
  $opt_val  = get_option( $opt_name );
  if ( !$opt_val )
  {
    $opt_val = "http://test.blogspam.net:9999/" ;
  }

  //
  // Send the JSON result.
  //
  $result = wp_remote_post( $opt_val, array( 'body' => json_encode(  $struct ) ) );

  $obj = json_decode( $result['body'], true );


  if ( $obj['result'] == "SPAM" )
  {
      //
      // Mark the result as spam.
      //
      add_filter('pre_comment_approved',
                 create_function('$a', 'return \'spam\';'), 99);

      return 1;
   }

  return 0;
}


//
//  Add a new action page underneath "settings".
//
function skx_add_pages()
{
  add_options_page('Blogspam', 'Blogspam', 8, 'blogspam', 'skx_options_page');
}



//
//  This is called when the admin page is loaded.
//
function skx_options_page()
{
  // variables for the field and option names
  $hidden_field_name = 'skx_blogspam_submit_hidden';
  $data_field_name   = 'skx_blogspam_server';
  $opt_name          = 'skx_blogspam_server';

  //
  // Read in existing option value from database
  // fall back to the default if it isn't present.
  //
  $opt_val = get_option( $opt_name );
  if ( !$opt_val )
  {
    $opt_val = "http://test.blogspam.net:9999/" ;
  }

  // See if the user has posted us some information
  // If they did, this hidden field will be set to 'Y'
  if( $_POST[ $hidden_field_name ] == 'Y' )
  {
    // Read the server name
    $opt_val = $_POST[ $data_field_name ];

    // Save the posted value in the database
    update_option( $opt_name, $opt_val );

    // Put an options updated message on the screen
?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

                                                                                  }

  // Now display the options editing screen
  echo '<div class="wrap">';

  // header
  $version = skx_self_version();
  echo "<h2>Blogspam v$version Options </h2>";
  ?>


  <form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
  <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

  <p><?php _e("Blogspam Server:", 'mt_trans_domain' ); ?>
  <input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="40">
  </p><hr />

  <p class="submit">
  <input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
  </p>

  </form>
  </div>

<?php

  //
  // Stats
  //
  $stats_url  = get_option( 'skx_blogspam_server' );
  $stats_data = array( 'site' => get_bloginfo('url') );

  if ( !$stats_url ) {
      $stats_url = "http://test.blogspam.net:9999/stats" ;
  } else {
      $stats_url = $stats_url . "stats";
  }

  $stats = wp_remote_post( $stats_url , array( 'body' => json_encode(  $stats_data ) ) );
  $obj = json_decode( $stats['body'], true );

  if ( $obj && array_key_exists( "spam", $obj ) ) {
      echo "<p>Dropped " . $obj['spam'] . " comment(s).</p>";
  }
  if ( $obj && array_key_exists( "ok", $obj ) ) {
        echo "<p>Permitted " . $obj['ok'] . " comment(s)</p>";
  }

}



//
//  Add the hooks
//
add_action( 'wp_blacklist_check', 'skx_check_comment', 10, 6);
add_action( 'admin_menu', 'skx_add_pages' );



?>
