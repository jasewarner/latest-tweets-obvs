<?php
/**
 * Provides the markup for any checkbox field.
 *
 * @link       https://jase.io/
 * @since      1.0.0
 *
 * @package    Latest_Tweets_Obvs
 * @subpackage Latest_Tweets_Obvs/admin/partials
 */

?>

<label class="lto--switch" for="<?php echo esc_attr( $atts['id'] ); ?>">
	<input aria-role="checkbox"
		<?php checked( 1, $atts['value'], true ); ?>
		   class="<?php echo esc_attr( $atts['class'] ); ?>"
		   id="<?php echo esc_attr( $atts['id'] ); ?>"
		   name="<?php echo esc_attr( $atts['name'] ); ?>"
		   type="checkbox"
		   value="1" />
	<span class="lto--slider"></span>
</label>
<span class="description"><?php _e( $atts['description'], 'latest-tweets-obvs' ); ?></span>
