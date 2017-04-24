<?php
/**
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://jase.io/
 * @since      1.0.0
 *
 * @package    Latest_Tweets_Obvs
 * @subpackage Latest_Tweets_Obvs/public/partials
 */

// Require Twitter OAuth.
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/twitteroauth/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

// Get plugin options.
$options = get_option( $this->plugin_name . '-options' );

// Username.
$username = $options[ 'username' ];

// Keys and access tokens.
$consumer_key = $options[ 'consumer_key' ];
$consumer_secret = $options[ 'consumer_secret' ];
$access_token = $options[ 'access_token' ];
$access_token_secret = $options[ 'access_token_secret' ];

// Set vars.
$tweet_count = false;
$exclude_replies = false;
$include_retweets = false;
$show_profile_image = false;
$show_display_name = false;
$show_username = false;
$show_description = false;
$show_location = false;
$use_plugin_css = false;

// Check how many tweets to display.
if ( isset( $options[ 'number_of_tweets'] ) ) {
	$tweet_count = $options[ 'number_of_tweets' ];
	// If field empty, at least set to numerical value.
	if ( '' === $tweet_count ) {
		$tweet_count = 0;
	}
}

// Check for including replies.
if ( isset( $options[ 'exclude_replies'] ) ) {
	$exclude_replies = $options[ 'exclude_replies' ];
	// Set to true or false string.
	if ( '1' === $exclude_replies ) {
		$exclude_replies = 'true';
	}
} else {
	$exclude_replies = 'false';
}

// Check for including retweets.
if ( isset( $options[ 'include_retweets'] ) ) {
	$include_retweets = $options[ 'include_retweets' ];
	// Set to true or false string.
	if ( '1' === $include_retweets ) {
		$include_retweets = 'true';
	}
} else {
	$include_retweets = 'false';
}

// Check for profile image.
if ( isset( $options[ 'show_profile_image'] ) ) {
	$show_profile_image = $options[ 'show_profile_image'];
}

// Check for display name.
if ( isset( $options[ 'show_display_name'] ) ) {
	$show_display_name = $options[ 'show_display_name'];
}

// Check for username.
if ( isset( $options[ 'show_username'] ) ) {
	$show_username = $options[ 'show_username'];
}

// Check for description.
if ( isset( $options[ 'show_description'] ) ) {
	$show_description = $options[ 'show_description'];
}

// Check for location.
if ( isset( $options[ 'show_location'] ) ) {
	$show_location = $options[ 'show_location'];
}

// Check for plugin CSS.
if ( isset( $options[ 'use_plugin_css'] ) ) {
	$use_plugin_css = $options[ 'use_plugin_css'];
}

// Prep connection.
$connection = new TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );

// Get tweets.
$tweets = $connection->get( 'statuses/user_timeline', [ 'screen_name' => $username, 'count' => $tweet_count, 'exclude_replies' => $exclude_replies, 'include_rts' => $include_retweets ] );

// Get user information.
$user = $connection->get( 'users/show', [ 'screen_name' => $username ] );

// Get bigger profile image.
$profile_image = str_replace( 'normal', 'bigger', $user->profile_image_url );
?>

<div class="lto--container">

	<?php
	// Check if profile image should be displayed.
	if ( '1' === $show_profile_image ) {
		?>

		<img class="lto--profile" src="<?php esc_html_e( $profile_image ); ?>" border="0"
		     alt="<?php esc_html_e( $user->screen_name ); ?>" width="73" height="73"/>

		<?php
	}
	// Check if display name should be displayed.
	if ( '1' === $show_display_name ) {
		?>

		<h4><?php esc_html_e( $user->name ); ?></h4>

		<?php
	}
	// Check if display name should be displayed.
	if ( '1' === $show_username ) {
		?>

		<p><a href="https://twitter.com/<?php esc_html_e( $user->screen_name ); ?>"><?php esc_html_e( '@' . $user->screen_name ); ?></a></p>

		<?php
	}
	// Check if user description should be displayed.
	if ( '1' === $show_description ) {
		?>

		<p><?php esc_html_e( $user->description ); ?></p>

		<?php
	}
	// Check if user description should be displayed.
	if ( '1' === $show_location ) {
		?>

		<p><?php esc_html_e( $user->location ); ?></p>

		<?php
	}
	?>

	<ul class="lto--tweets" role="list">

		<?php
		foreach ( $tweets as $tweet ) {

			echo '<li role="listitem">' . $tweet->text . '</li>';

		}
		?>

	</ul>
</div>
