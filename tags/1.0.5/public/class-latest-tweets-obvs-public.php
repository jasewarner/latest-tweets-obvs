<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://jase.io/
 * @since      1.0.0
 *
 * @package    Latest_Tweets_Obvs
 * @subpackage Latest_Tweets_Obvs/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Latest_Tweets_Obvs
 * @subpackage Latest_Tweets_Obvs/public
 * @author     Jase Warner <jase@jase.io>
 */
class Latest_Tweets_Obvs_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// Get plugin options.
		$options = get_option( $this->plugin_name . '-options' );
		$use_plugin_css = false;

		// Get value of plugin CSS option.
		if ( isset( $options['use_plugin_css'] ) ) {
			$use_plugin_css = $options['use_plugin_css'];
		}

		if ( '1' === $use_plugin_css ) {

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/latest-tweets-obvs-public.min.css', array(), $this->version, 'all' );

		}

	}

	/**
	 * Get keys and access token.
	 *
	 * @since   1.0.0
	 */
	public function plugin_output() {

		ob_start();

		require plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/latest-tweets-obvs-public-display.php';

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	}

	/**
	 * Register short code.
	 *
	 * @since   1.0.0
	 */
	public function register_shortcode() {

		add_shortcode( 'latest_tweets_obvs', array( $this, 'plugin_output' ) );

	}

	/**
	 * Enable shortcodes in text widgets.
	 *
	 * @since   1.0.0
	 */
	public function enable_widget_shortcodes() {

		add_filter( 'widget_text', 'do_shortcode' );

	}
}
