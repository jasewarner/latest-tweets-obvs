<?php
/**
 * Provides the markup for any text field.
 *
 * @link       https://jase.io/
 * @since      1.0.0
 *
 * @package    Latest_Tweets_Obvs
 * @subpackage Latest_Tweets_Obvs/admin/partials
 */

?>

<span class="description"><?php echo esc_attr( $atts['before'] ); ?></span>
<label for="<?php echo esc_attr( $atts['id'] ); ?>">
	<span><?php echo esc_attr( $atts['label'] ); ?></span>
	<input class="<?php echo esc_attr( $atts['class'] ); ?>"
	       id="<?php echo esc_attr( $atts['id'] ); ?>"
	       min="<?php echo esc_attr( $atts['min'] ); ?>"
	       max="<?php echo esc_attr( $atts['max'] ); ?>"
	       name="<?php echo esc_attr( $atts['name'] ); ?>"
	       type="<?php echo esc_attr( $atts['type'] ); ?>"
	       placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"
	       value="<?php echo esc_attr( $atts['value'] ); ?>"
			<?php echo esc_attr( $atts['required'] ); ?>/>
</label>
<span class="description"><?php _e( $atts['description'], 'latest-tweets-obvs' ); ?></span>
