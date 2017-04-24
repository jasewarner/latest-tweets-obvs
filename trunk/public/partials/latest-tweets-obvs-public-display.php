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

// Set plugin field vars.
$tweets_heading = false;
$tweet_count = false;
$exclude_replies = false;
$include_retweets = false;
$show_profile_image = false;
$show_display_name = false;
$show_username = false;
$show_description = false;
$show_location = false;
$use_plugin_css = false;

// Check for heading to be placed above tweets.
if ( isset( $options[ 'tweets_heading' ] ) ) {
	$tweets_heading = $options[ 'tweets_heading' ];
}

// Check how many tweets to display.
if ( isset( $options[ 'number_of_tweets' ] ) ) {
	$tweet_count = $options[ 'number_of_tweets' ];
	// If field empty, at least set to numerical value.
	if ( '' === $tweet_count ) {
		$tweet_count = 0;
	}
}

// Check for including replies.
if ( isset( $options[ 'exclude_replies' ] ) ) {
	$exclude_replies = $options[ 'exclude_replies' ];
	// Set to true or false string.
	if ( '1' === $exclude_replies ) {
		$exclude_replies = 'true';
	}
} else {
	$exclude_replies = 'false';
}

// Check for including retweets.
if ( isset( $options[ 'include_retweets' ] ) ) {
	$include_retweets = $options[ 'include_retweets' ];
	// Set to true or false string.
	if ( '1' === $include_retweets ) {
		$include_retweets = 'true';
	}
} else {
	$include_retweets = 'false';
}

// Check for profile image.
if ( isset( $options[ 'show_profile_image' ] ) ) {
	$show_profile_image = $options[ 'show_profile_image' ];
}

// Check for display name.
if ( isset( $options[ 'show_display_name' ] ) ) {
	$show_display_name = $options[ 'show_display_name' ];
}

// Check for username.
if ( isset( $options[ 'show_username' ] ) ) {
	$show_username = $options[ 'show_username' ];
}

// Check for description.
if ( isset( $options[ 'show_description' ] ) ) {
	$show_description = $options[ 'show_description' ];
}

// Check for location.
if ( isset( $options[ 'show_location' ] ) ) {
	$show_location = $options[ 'show_location' ];
}

// Check for plugin CSS.
if ( isset( $options[ 'use_plugin_css' ] ) ) {
	$use_plugin_css = $options[ 'use_plugin_css' ];
}

// Prep connection.
$connection = new TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );

// Verify credentials.
$response = $connection->get( 'account/verify_credentials', [ 'include_entities' => false, 'skip_status' => true ] );

// Get tweets.
$tweets = $connection->get( 'statuses/user_timeline', [ 'screen_name' => $username, 'count' => $tweet_count, 'exclude_replies' => $exclude_replies, 'include_rts' => $include_retweets ] );

// Get user information.
$user = $connection->get( 'users/show', [ 'screen_name' => $username ] );

$user_search = $connection->get( 'users/search', [ 'q' => $username, 'include_entities', false ] );

// Set $tweet var.
$tweet = false;

// Add links to tweet entities, such as hashtags, user mentions and links.
if ( ! function_exists( 'rich_tweet' ) ) {

	function rich_tweet( $tweet ) {

		// Convert urls to <a> links.
		$tweet = preg_replace( '/([\w]+\:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/', '<a target="_blank" href="$1">$1</a>', $tweet );

		// Convert hashtags to twitter searches in <a> links.
		$tweet = preg_replace( '/#([A-Za-z0-9\/\.]*)/', '<a target="_new" href="http://twitter.com/search?q=$1">#$1</a>', $tweet );

		// Convert attags to twitter profiles in <a> links.
		$tweet = preg_replace( '/@([A-Za-z0-9\/\.\_]*)/', '<a href="http://www.twitter.com/$1">@$1</a>', $tweet );

		return $tweet;

	}

};

// Check if verified successfully.
if ( $connection->getLastHttpCode() == 200 ) {
	?>

	<div class="lto--container">

		<?php
		// Check that user exists.
		if ( ! empty( $user_search ) ) {

			// Check if profile image should be displayed.
			if ( '1' === $show_profile_image ) {

				// Get bigger profile image.
				$profile_image = str_replace( 'normal', 'bigger', $user->profile_image_url );
				?>

				<img class="lto--profile" src="<?php esc_html_e( $profile_image ); ?>" border="0"
				     alt="<?php esc_html_e( $user->screen_name ); ?>" width="73" height="73"/>

				<?php
			}
			// Check if display name should be displayed.
			if ( '1' === $show_display_name ) {
				?>

				<h4 class="lto--display-name"><?php esc_html_e( $user->name ); ?></h4>

				<?php
			}
			// Check if display name should be displayed.
			if ( '1' === $show_username ) {
				?>

				<p class="lto--username"><a href="https://twitter.com/<?php esc_html_e( $user->screen_name ); ?>"><?php esc_html_e( '@' . $user->screen_name ); ?></a>
				</p>

				<?php
			}
			// Check if user description should be displayed.
			if ( '1' === $show_description ) {
				?>

				<p class="lto--description">
					<small><em><?php esc_html_e( $user->description ); ?></em></small>
				</p>

				<?php
			}
			// Check if user description should be displayed.
			if ( '1' === $show_location ) {
				?>

				<p class="lto--location">
					<small><?php esc_html_e( $user->location ); ?></small>
				</p>

				<?php
			}
			// Check for heading to be placed above tweets.
			if ( $tweets_heading ) {
				?>

				<h5 class="lto--tweets-heading"><?php esc_html_e( $tweets_heading ); ?></h5>

				<?php
			}
			?>

			<ul class="lto--tweets" role="list">

				<?php
				foreach ( $tweets as $tweet ) {

					$tweet = $tweet->text;

					echo '<li role="listitem">' . rich_tweet( $tweet ) . '</li>';

				}
				?>

			</ul>

			<?php
		} else {
			?>

			<h4><?php _e( 'Oops!', 'latest-tweets-obvs' ); ?></h4>
			<p><?php _e( 'It looks like the Latest Tweets Obvs plugin has encountered an issue.') ?>
				<br><?php _e( 'This user does not seem to exist.') ?></p>

			<?php
		}
		?>

	</div>

	<?php
} else {
	// Display errors.
	$errors = $response->errors;

	foreach ( $errors as $error ) {
		?>

		<h4><?php _e( 'Oops!', 'latest-tweets-obvs' ); ?></h4>
		<p><?php _e( 'It looks like the Latest Tweets Obvs plugin has encountered an issue.') ?></p>
		<p><?php esc_html_e( 'Error: HTTP Code ' . $error->code ); ?>
			<br><?php esc_html_e( $error->message ); ?></p>
		<p><?php _e( 'Try checking out the error code ') ?><a href="https://dev.twitter.com/overview/api/response-codes" target="_blank"><?php _e( 'here', 'latest-tweets-obvs' ); ?></a></p>

		<?php
	}
}
