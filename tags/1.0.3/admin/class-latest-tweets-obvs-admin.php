<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://jase.io/
 * @since      1.0.0
 *
 * @package    Latest_Tweets_Obvs
 * @subpackage Latest_Tweets_Obvs/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Latest_Tweets_Obvs
 * @subpackage Latest_Tweets_Obvs/admin
 * @author     Jase Warner <jase@jase.io>
 */
class Latest_Tweets_Obvs_Admin {

	/**
	 * The plugin options.
	 *
	 * @since   1.0.0
	 * @access    private
	 * @var    string $options The plugin options.
	 */
	private $options;

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
	 * Option page suffix.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string
	 */
	private $option_page_hook_suffix;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->set_options();

	}

	/**
	 * Create settings link in plugin admin area.
	 *
	 * @since   1.0.0
	 */
	public function settings_link( $links ) {

		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			admin_url( 'options-general.php?page=' . $this->plugin_name . '-settings' ),
			__( 'Settings' )
		);

		array_unshift( $links, $settings_link );

		return $links;

	}

	/**
	 * Adds a settings page link to a menu.
	 *
	 * @since   1.0.0
	 */
	public function add_menu() {

		$this->option_page_hook_suffix = add_submenu_page(
			'options-general.php',
			'Latest Tweets Obvs',
			'Latest Tweets Obvs',
			'manage_options',
			$this->plugin_name . '-settings',
			array( $this, 'page_options' )
		);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook_suffix ) {

		if ( $hook_suffix == $this->option_page_hook_suffix ) {

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/latest-tweets-obvs-admin.min.css', array(), $this->version, 'all' );

		}

	}

	/**
	 * Creates text field.
	 *
	 * @since   1.0.0
	 */
	public function field_text( $args ) {

		$defaults['id'] = '';
		$defaults['class'] = '';
		$defaults['description'] = '';
		$defaults['label'] = '';
		$defaults['name'] = $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] = '';
		$defaults['type'] = '';
		$defaults['value'] = '';
		$defaults['max'] = '';
		$defaults['min'] = '';
		$defaults['pattern'] = '';
		$defaults['before'] = '';
		$defaults['required'] = '';

		apply_filters( $this->plugin_name . '-field-text-options-defaults', $defaults );
		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[ $atts['id'] ] ) ) {

			$atts['value'] = $this->options[ $atts['id'] ];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-text.php' );

	}

	/**
	 * Creates a checkbox field.
	 *
	 * @param       array
	 * @return      string
	 */
	public function field_checkbox( $args ) {

		$defaults['class'] = '';
		$defaults['description'] = '';
		$defaults['label'] = '';
		$defaults['name'] = $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['value'] = 0;

		apply_filters( $this->plugin_name . '-field-checkbox-options-defaults', $defaults );
		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[ $atts['id'] ] ) ) {
			$atts['value'] = $this->options[ $atts['id'] ];
		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-checkbox.php' );

	}

	/**
	 * Creates the options page.
	 *
	 * @since   1.0.0
	 */
	public function page_options() {
		include( plugin_dir_path( __FILE__ ) . 'partials/latest-tweets-obvs-admin-page-settings.php' );
	}

	/**
	 * Register the fields.
	 *
	 * @since   1.0.0
	 */
	public function register_fields() {

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );

		add_settings_field(
			'username',
			'Username',
			array( $this, 'field_text' ),
			$this->plugin_name . '-account',
			$this->plugin_name . '-account',
			array(
				'id' => 'username',
				'type' => 'text',
				'before' => '@',
				'required' => 'required',
				//				'pattern' => '/^[a-zA-Z0-9]*$/'
			)
		);

		add_settings_field(
			'consumer_key',
			'Consumer Key',
			array( $this, 'field_text' ),
			$this->plugin_name . '-api',
			$this->plugin_name . '-api',
			array(
				'id' => 'consumer_key',
				'type' => 'text',
				'required' => 'required',
			)
		);

		add_settings_field(
			'consumer_secret',
			'Consumer Secret',
			array( $this, 'field_text' ),
			$this->plugin_name . '-api',
			$this->plugin_name . '-api',
			array(
				'id' => 'consumer_secret',
				'type' => 'text',
				'required' => 'required',
			)
		);

		add_settings_field(
			'access_token',
			'Access Token',
			array( $this, 'field_text' ),
			$this->plugin_name . '-api',
			$this->plugin_name . '-api',
			array(
				'id' => 'access_token',
				'type' => 'text',
				'required' => 'required',
			)
		);

		add_settings_field(
			'access_token_secret',
			'Access Token Secret',
			array( $this, 'field_text' ),
			$this->plugin_name . '-api',
			$this->plugin_name . '-api',
			array(
				'id' => 'access_token_secret',
				'type' => 'text',
				'required' => 'required',
			)
		);

		add_settings_field(
			'tweets_heading',
			'Tweets Heading',
			array( $this, 'field_text' ),
			$this->plugin_name . '-display',
			$this->plugin_name . '-display',
			array(
				'id' => 'tweets_heading',
				'type' => 'text',
				'placeholder' => 'e.g. Latest Tweets',
			)
		);

		add_settings_field(
			'number_of_tweets',
			'Number of Tweets',
			array( $this, 'field_text' ),
			$this->plugin_name . '-display',
			$this->plugin_name . '-display',
			array(
				'id' => 'number_of_tweets',
				'max' => 200,
				'min' => 0,
				'type' => 'number',
			)
		);

		add_settings_field(
			'exclude_replies',
			'Exclude Replies',
			array( $this, 'field_checkbox' ),
			$this->plugin_name . '-display',
			$this->plugin_name . '-display',
			array(
				'id' => 'exclude_replies',
			)
		);

		add_settings_field(
			'include_retweets',
			'Include Retweets',
			array( $this, 'field_checkbox' ),
			$this->plugin_name . '-display',
			$this->plugin_name . '-display',
			array(
				'id' => 'include_retweets',
			)
		);

		add_settings_field(
			'show_profile_image',
			'Show Profile Image',
			array( $this, 'field_checkbox' ),
			$this->plugin_name . '-display',
			$this->plugin_name . '-display',
			array(
				'id' => 'show_profile_image',
			)
		);

		add_settings_field(
			'show_display_name',
			'Show Display Name',
			array( $this, 'field_checkbox' ),
			$this->plugin_name . '-display',
			$this->plugin_name . '-display',
			array(
				'id' => 'show_display_name',
			)
		);

		add_settings_field(
			'show_username',
			'Show Username',
			array( $this, 'field_checkbox' ),
			$this->plugin_name . '-display',
			$this->plugin_name . '-display',
			array(
				'id' => 'show_username',
			)
		);

		add_settings_field(
			'show_description',
			'Show Description (Bio)',
			array( $this, 'field_checkbox' ),
			$this->plugin_name . '-display',
			$this->plugin_name . '-display',
			array(
				'id' => 'show_description',
			)
		);

		add_settings_field(
			'show_location',
			'Show Location',
			array( $this, 'field_checkbox' ),
			$this->plugin_name . '-display',
			$this->plugin_name . '-display',
			array(
				'id' => 'show_location',
			)
		);

		add_settings_field(
			'show_tweet_time',
			'Show Tweet Time',
			array( $this, 'field_checkbox' ),
			$this->plugin_name . '-display',
			$this->plugin_name . '-display',
			array(
				'id' => 'show_tweet_time',
			)
		);

		add_settings_field(
			'use_plugin_css',
			'Use Plugin CSS',
			array( $this, 'field_checkbox' ),
			$this->plugin_name . '-display',
			$this->plugin_name . '-display',
			array(
				'id' => 'use_plugin_css',
			)
		);

	}

	/**
	 * Register settings section.
	 *
	 * @since   1.0.0
	 */
	public function register_sections() {

		// add_settings_section( $id, $title, $callback, $menu_slug );

		add_settings_section(
			$this->plugin_name . '-account',
			apply_filters( $this->plugin_name . 'section-title-account', esc_html__( 'Your Account', $this->plugin_name ) ),
			array( $this, 'section_account' ),
			$this->plugin_name . '-account'
		);

		add_settings_section(
			$this->plugin_name . '-api',
			apply_filters( $this->plugin_name . 'section-title-api', esc_html__( 'API Credentials', $this->plugin_name ) ),
			array( $this, 'section_api' ),
			$this->plugin_name . '-api'
		);

		add_settings_section(
			$this->plugin_name . '-display',
			apply_filters( $this->plugin_name . 'section-title-display', esc_html__( 'Display Options', $this->plugin_name ) ),
			array( $this, 'section_display' ),
			$this->plugin_name . '-display'
		);

	}

	/**
	 * Register plugin settings.
	 *
	 * @since   1.0.0
	 */
	public function register_settings() {

		// register_setting( $option_group, $option_name, $sanitize_callback );

		register_setting(
			$this->plugin_name . '-options',
			$this->plugin_name . '-options',
			array( $this, 'validate_options' )
		);

	}

	/**
	 * Create account settings section.
	 *
	 * @since   1.0.0
	 */
	public function section_account( $params ) {

		include( plugin_dir_path( __FILE__ ) . 'partials/latest-tweets-obvs-admin-section-account.php' );

	}

	/**
	 * Create Customise settings section.
	 *
	 * @since   1.0.0
	 */
	public function section_api( $params ) {

		include( plugin_dir_path( __FILE__ ) . 'partials/latest-tweets-obvs-admin-section-api.php' );

	}

	/**
	 * Create Display settings section.
	 *
	 * @since   1.0.0
	 */
	public function section_display( $params ) {

		include( plugin_dir_path( __FILE__ ) . 'partials/latest-tweets-obvs-admin-section-display.php' );

	}

	/**
	 * Sanitzer.
	 *
	 * @since   1.0.0
	 */
	private function sanitizer( $type, $data ) {

		if ( empty( $type ) ) {
			return;
		}
		if ( empty( $data ) ) {
			return;
		}

		$return = '';
		$sanitizer = new Latest_Tweets_Obvs_Sanitize();
		$sanitizer->set_data( $data );
		$sanitizer->set_type( $type );
		$return = $sanitizer->clean();

		unset( $sanitizer );
		return $return;

	}

	/**
	 * Sets the class variable $options.
	 *
	 * @since   1.0.0
	 */
	private function set_options() {
		$this->options = get_option( $this->plugin_name . '-options' );
	}

	/**
	 * Validates saved options.
	 *
	 * @since   1.0.0
	 */
	private function validate_options( $input ) {

		$valid = array();
		$options = $this->get_options_list();

		foreach ( $options as $option ) {

			$name = $option[0];
			$type = $option[1];

			if ( 'repeater' === $type && is_array( $option[2] ) ) {

				$clean = array();

				foreach ( $option[2] as $field ) {

					foreach ( $input[ $field[0] ] as $data ) {

						if ( empty( $data ) ) {
							continue;
						}

						$clean[ $field[0] ][] = $this->sanitizer( $field[1], $data );

					}
				}

				$count = social_icons_obvs_get_max( $clean );

				for ( $i = 0; $i < $count; $i++ ) {

					foreach ( $clean as $field_name => $field ) {

						$valid[ $option[0] ][ $i ][ $field_name ] = $field[ $i ];

					}
				}
			} else {

				$valid[ $option[0] ] = $this->sanitizer( $type, $input[ $name ] );

			}
		}

		return $valid;

	}
}
