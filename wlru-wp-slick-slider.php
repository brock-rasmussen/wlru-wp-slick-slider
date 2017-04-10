<?php
/*
Plugin Name: Slick Slider Shortcode by Wallaroo Media
Description: Easily add sliders anywhere on your site with this easy-to-use shortcode.
Author: Brock Rasmussen, Wallaroo Media
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
add_shortcode( 'wlru_slick', 'wlru_slick' );
function wlru_slick( $atts, $content = null ) {
  $defaults = array(
    'autoplay'          => false,
    'autoplay_speed'    => 3000,
    'arrows'            => true,
    'as_nav_for'        => null,
    'center_mode'       => false,
    'center_padding'    => '50px',
    'dots'              => false,
    'fade'              => false,
    'responsive'        => null,
    'rows'              => 1,
    'slides_per_row'    => 1,
    'slides_to_show'    => 1,
    'slides_to_scroll'  => 1,
    'speed'             => 300,
  );

  $atts = shortcode_atts( $defaults, $atts, 'wlru_slick' );

  $props = array();

  foreach ( $defaults as $key => $value ) {
    if ( $atts[$key] != $value ) {
      $prop = lcfirst( str_replace( '_', '', ucwords( $key, '_' ) ) );
      $props[] = '&quot;' . $prop . '&quot;: ' . $atts[$key];
    }
  }
  return '<div data-slick="{' . implode( ', ', $props ) . '}">' . do_shortcode( $content ) . '</div>';
}

add_action( 'wp_enqueue_scripts', 'wlru_slick_scripts' );
function wlru_slick_scripts() {
  wp_enqueue_style( 'wlru-slick', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css' );
  wp_enqueue_script( 'wlru-slick', 'https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array( 'jquery' ), '1.6.0', true );
}

add_action( 'customize_register', 'wlru_slick_customize_register' );
function wlru_slick_customize_register( $wp_customize ) {
  $wp_customize->add_section( 'wlru_slick', array(
    'title'       => __( 'Slider', 'wlru-slick' ),
    'description' => '<p>' . __( 'See <a href="http://kenwheeler.github.io/slick/">Slick Slider documentation</a> for the full attribute list and explanation. Supported attributes on the shortcode include:', 'wlru-slick' ) . '</p><ul><li><code>autoplay</code></li><li><code>autoplay_speed</code></li><li><code>arrows</code></li><li><code>as_nav_for</code></li><li><code>center_mode</code></li><li><code>center_padding</code></li><li><code>dots</code></li><li><code>fade</code></li><li><code>responsive</code></li><li><code>rows</code></li><li><code>slides_per_row</code></li><li><code>slides_to_show</code></li><li><code>slides_to_scroll</code></li><li><code>speed</code></li></ul><p>' . __( 'Further attribute support will need to be requested from the developers.', 'wlru-slick' ),
  ) );

  $wp_customize->add_setting( 'wlru_slick_arrow_color', array(
    'type'    => 'option',
    'default' => '#ffffff',
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wlru_slick_arrow_color', array(
    'label'       => __( 'Arrow Color', 'wlru-slick' ),
    'section'     => 'wlru_slick',
    'settings'    => 'wlru_slick_arrow_color',
  ) ) );

  $wp_customize->add_setting( 'wlru_slick_dot_color', array(
    'type'    => 'option',
    'default' => '#000000',
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wlru_slick_dot_color', array(
    'label'       => __( 'Dot Color', 'wlru-slick' ),
    'section'     => 'wlru_slick',
    'settings'    => 'wlru_slick_dot_color',
  ) ) );

  $wp_customize->add_setting( 'wlru_slick_dot_color_active', array(
    'type'    => 'option',
    'default' => '#000000',
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wlru_slick_dot_color_active', array(
    'label'       => __( 'Active Dot Color', 'wlru-slick' ),
    'section'     => 'wlru_slick',
    'settings'    => 'wlru_slick_dot_color_active',
  ) ) );

  $wp_customize->add_setting( 'wlru_slick_prev_character', array(
    'type'    => 'option',
    'default' => '\f053',
  ) );
  $wp_customize->add_control( 'wlru_slick_prev_character', array(
    'label'       => __( 'Previous Character', 'wlru-slick' ),
    'section'     => 'wlru_slick',
    'settings'    => 'wlru_slick_prev_character',
  ) );

  $wp_customize->add_setting( 'wlru_slick_next_character', array(
    'type'    => 'option',
    'default' => '\f054',
  ) );
  $wp_customize->add_control( 'wlru_slick_next_character', array(
    'label'       => __( 'Next Character', 'wlru-slick' ),
    'section'     => 'wlru_slick',
    'settings'    => 'wlru_slick_next_character',
  ) );

  $wp_customize->add_setting( 'wlru_slick_dot_character', array(
    'type'    => 'option',
    'default' => '\f111',
  ) );
  $wp_customize->add_control( 'wlru_slick_dot_character', array(
    'label'       => __( 'Dot Character', 'wlru-slick' ),
    'section'     => 'wlru_slick',
    'settings'    => 'wlru_slick_dot_character',
  ) );

  $wp_customize->add_setting( 'wlru_slick_dot_size', array(
    'type'    => 'option',
    'default' => 6,
  ) );
  $wp_customize->add_control( 'wlru_slick_dot_size', array(
    'label'       => __( 'Dot Size', 'wlru-slick' ),
    'description' => __( 'In pixels.', 'wlru-slick' ),
    'section'     => 'wlru_slick',
    'settings'    => 'wlru_slick_dot_size',
    'type'        => 'number',
  ) );

  $wp_customize->add_setting( 'wlru_slick_opacity_default', array(
    'type'    => 'option',
    'default' => 0.75,
  ) );
  $wp_customize->add_control( 'wlru_slick_opacity_default', array(
    'label'       => __( 'Default Opacity', 'wlru-slick' ),
    'section'     => 'wlru_slick',
    'settings'    => 'wlru_slick_opacity_default',
    'type'        => 'number',
    'input_attrs' => array(
      'min'       => 0,
      'max'       => 1,
      'step'      => 0.05,
    ),
  ) );

  $wp_customize->add_setting( 'wlru_slick_opacity_on_hover', array(
    'type'    => 'option',
    'default' => 1,
  ) );
  $wp_customize->add_control( 'wlru_slick_opacity_on_hover', array(
    'label'       => __( 'Hover Opacity', 'wlru-slick' ),
    'section'     => 'wlru_slick',
    'settings'    => 'wlru_slick_opacity_on_hover',
    'type'        => 'number',
    'input_attrs' => array(
      'min'       => 0,
      'max'       => 1,
      'step'      => 0.05,
    ),
  ) );

  $wp_customize->add_setting( 'wlru_slick_opacity_not_active', array(
    'type'    => 'option',
    'default' => 0.25,
  ) );
  $wp_customize->add_control( 'wlru_slick_opacity_not_active', array(
    'label'       => __( 'Inactive Opacity', 'wlru-slick' ),
    'section'     => 'wlru_slick',
    'settings'    => 'wlru_slick_opacity_not_active',
    'type'        => 'number',
    'input_attrs' => array(
      'min'       => 0,
      'max'       => 1,
      'step'      => 0.05,
    ),
  ) );
}

add_action( 'wp_head', 'wlru_slick_css' );
function wlru_slick_css() {
$slick_arrow_color        = get_option( 'wlru_slick_arrow_color', '#ffffff' );
$slick_dot_color          = get_option( 'wlru_slick_dot_color', '#000000' );
$slick_dot_color_active   = get_option( 'wlru_slick_dot_color_active', '#000000' );
$slick_prev_character     = get_option( 'wlru_slick_prev_character', '\f053' );
$slick_next_character     = get_option( 'wlru_slick_next_character', '\f054' );
$slick_dot_character      = get_option( 'wlru_slick_dot_character', '\f111' );
$slick_dot_size           = get_option( 'wlru_slick_dot_size', 6 );
$slick_opacity_default    = get_option( 'wlru_slick_opacity_default', 0.75 );
$slick_opacity_on_hover   = get_option( 'wlru_slick_opacity_on_hover', 1 );
$slick_opacity_not_active = get_option( 'wlru_slick_opacity_not_active', 0.25 );
?>
<style type="text/css" id="wlru-slick">
.slick-prev:hover:before,
.slick-next:hover:before,
.slick-prev:focus:before,
.slick-next:focus:before {
  opacity: <?php echo $slick_opacity_on_hover; ?>;
}
.slick-prev.slick-disabled:before,
.slick-next.slick-disabled:before {
  opacity: <?php echo $slick_opacity_not_active; ?>;
}
.slick-prev:before,
.slick-next:before {
  color: <?php echo $slick_arrow_color; ?>;
  opacity: <?php echo $slick_opacity_default; ?>;
}
.slick-prev:before,
[dir="rtl"] .slick-next:before {
  content: "<?php echo $slick_prev_character; ?>";
}
.slick-next:before,
[dir="rtl"] .slick-prev:before {
  content: "<?php echo $slick_next_character; ?>";
}
.slick-dots li button:hover:before,
.slick-dots li button:focus:before {
  opacity: <?php echo $slick_opacity_on_hover; ?>;
}
.slick-dots li button:before {
  content: "<?php echo $slick_dot_character; ?>";
  font-size: <?php echo $slick_dot_size; ?>px;
  color: <?php echo $slick_dot_color; ?>;
  opacity: <?php echo $slick_opacity_not_active; ?>;
}
.slick-dots li.slick-active button:before {
  color: <?php echo $slick_dot_color_active; ?>;
  opacity: <?php echo $slick_opacity_default; ?>;
}
</style>
<?php }

remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop', 99 );
add_filter( 'wlru_slick', 'shortcode_unautop', 100 );
