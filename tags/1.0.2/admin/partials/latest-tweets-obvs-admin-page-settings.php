<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://jase.io/
 * @since      1.0.0
 *
 * @package    Latest_Tweets_Obvs
 * @subpackage Latest_Tweets_Obvs/admin/partials
 */

?>

<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<form method="post" action="options.php">

		<?php settings_fields( $this->plugin_name . '-options' ); ?>

		<p><?php _e( 'Latest Tweets Obvs is a simple plugin that displays, well, latest tweets (obvs).', 'latest-tweets-obvs' ); ?></p>
		<p><?php _e( 'The plugin comes with optional CSS, albeit minimal, and is intended to fall back on your base theme styles.', 'latest-tweets-obvs' ); ?>
			<br><?php _e( 'When you are done tweaking the settings below, display your tweets by pasting this shortcode anywhere in your site: ', 'latest-tweets-obvs' ); ?><code><?php esc_html_e( '[latest_tweets_obvs]' ); ?></code></p>
		<p><?php _e( 'Lastly, if you find this plugin useful and are feeling uber generous, feel free to <a href="https://www.paypal.me/jmwarnerltd" target="_blank">kindly buy me a coffee</a> ツ', 'latest-tweets-obvs' ); ?></p>

		<section class="lto--section">
			<?php do_settings_sections( $this->plugin_name . '-account' ); ?>
		</section>

		<section class="lto--section">
			<?php do_settings_sections( $this->plugin_name . '-api' ); ?>
		</section>

		<section class="lto--section">
			<?php do_settings_sections( $this->plugin_name . '-display' ); ?>
		</section>

		<p><?php _e( 'Great! You’re done. Save your changes and paste this shortcode anywhere in your site: ', 'latest-tweets-obvs' ); ?><code><?php esc_html_e( '[latest_tweets_obvs]' ); ?></code></p>

		<?php submit_button( 'Save Changes' ); ?>

	</form>
</div>
