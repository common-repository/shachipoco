<?php
defined('ABSPATH') or die();
/**
 * ShaChiPoCo Theme Customizer
 *
 * @package ShaChiPoCo
 */
if( class_exists( 'WP_Customize_Control' ) ):
    class EX_Customize_Textarea_Control extends WP_Customize_Control {
        public $type = 'textarea';
        public function render_content() {
            ?>
            <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
            </label>
            <?php
        }
    }
endif;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function _wpscpc_customize_register( $wp_customize ) {
    /* Color set
     *********************************************************/
    $wp_customize->add_section( 'wpscpc_color', array(
        'title'       => __( 'Theme color settings', WPSCPC_TEXTDOMAIN ),
        'description' => __( 'Change the theme color.', WPSCPC_TEXTDOMAIN ),
        'priority'    => 99999,
    ));
    $wp_customize->add_setting( 'wpscpc_theme_options[main_color]', array(
        'default'           => '000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_color', array(
        'label'    => __( 'Main color', WPSCPC_TEXTDOMAIN ),
        'section'  => 'wpscpc_color',
        'settings' => 'wpscpc_theme_options[main_color]',
    )));
    $wp_customize->add_setting( 'wpscpc_theme_options[main_font_color]', array(
        'default'           => 'ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_font_color', array(
        'label'    => __( 'Main color (Font)', WPSCPC_TEXTDOMAIN ),
        'section'  => 'wpscpc_color',
        'settings' => 'wpscpc_theme_options[main_font_color]',
    )));
    $wp_customize->add_setting( 'wpscpc_theme_options[accent_color]', array(
        'default'           => '24890d',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
        'label'    => __( 'Accent color', WPSCPC_TEXTDOMAIN ),
        'section'  => 'wpscpc_color',
        'settings' => 'wpscpc_theme_options[accent_color]',
    )));
    $wp_customize->add_setting( 'wpscpc_theme_options[accent_hover_color]', array(
        'default'           => '41a62a',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_hover_color', array(
        'label'    => __( 'Accent color (:hover)', WPSCPC_TEXTDOMAIN ),
        'section'  => 'wpscpc_color',
        'settings' => 'wpscpc_theme_options[accent_hover_color]',
    )));
    $wp_customize->add_setting( 'wpscpc_theme_options[accent_active_color]', array(
        'default'           => '55d737',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_active_color', array(
        'label'    => __( 'Accent color (:active)', WPSCPC_TEXTDOMAIN ),
        'section'  => 'wpscpc_color',
        'settings' => 'wpscpc_theme_options[accent_active_color]',
    )));
}
add_action( 'customize_register', '_wpscpc_customize_register' );

/**
 * Add a stylesheet to the header.
 * @return string
 */
function _wpscpc_wp_head() {
    $wpscpc_options      = get_option( 'wpscpc_theme_options' );
    $main_color          = ( isset( $wpscpc_options['main_color'] ) ) ? $wpscpc_options['main_color'] : false ;
    $main_font_color     = ( isset( $wpscpc_options['main_font_color'] ) ) ? $wpscpc_options['main_font_color'] : false ;
    $accent_color        = ( isset( $wpscpc_options['accent_color'] ) ) ? $wpscpc_options['accent_color'] : false ;
    $accent_hover_color  = ( isset( $wpscpc_options['accent_hover_color'] ) ) ? $wpscpc_options['accent_hover_color'] : false ;
    $accent_active_color = ( isset( $wpscpc_options['accent_active_color'] ) ) ? $wpscpc_options['accent_active_color'] : false ;

    if ( $main_color ) :
        $main_color_rgb = wpscpc_hex2RGB( $main_color, true );
        wp_add_inline_style( 'twentyfourteen-style', "
            .hentry .mejs-mediaelement,
            .hentry .mejs-container .mejs-controls {
                background: {$main_color};
            }
            .site-header,
            #secondary,
            .content-sidebar .widget_twentyfourteen_ephemera .widget-title:before,
            .site-footer,
            .menu-toggle {
                background-color: {$main_color};
            }
            #secondary,
            .content-sidebar .widget .widget-title,
            .paging-navigation {
                border-top-color: {$main_color};
            }
            .menu-toggle:active,
            .menu-toggle:focus,
            .menu-toggle:hover {
                background-color: #fff;
            }
            .menu-toggle:active::before,
            .menu-toggle:focus::before,
            .menu-toggle:hover::before {
                background-color: rgba({$main_color_rgb},.7);
            }
        ");
    endif;

    if ( $main_font_color ) :
        wp_add_inline_style( 'twentyfourteen-style', "
            ::selection {
                color: {$main_font_color};
            }
            ::-moz-selection {
                color: {$main_font_color};
            }
            button,
            .contributor-posts-link,
            input[type='button'],
            input[type='reset'],
            input[type='submit'],
            button:hover,
            button:focus,
            .contributor-posts-link:hover,
            input[type='button']:hover,
            input[type='button']:focus,
            input[type='reset']:hover,
            input[type='reset']:focus,
            input[type='submit']:hover,
            input[type='submit']:focus,
            .site-title a,
            .site-title a:hover,
            .search-toggle:before,
            .site-navigation a,
            .menu-toggle:before,
            .page-links a,
            .page-links a:hover,
            .widget a,
            .widget blockquote cite,
            .widget input,
            .widget textarea,
            .widget-title,
            .widget-title a,
            .widget_calendar caption,
            .widget_calendar tbody a,
            .widget_calendar tbody a:hover,
            .content-sidebar .widget input[type='button'],
            .content-sidebar .widget input[type='reset'],
            .content-sidebar .widget input[type='submit'],
            .content-sidebar .widget_calendar tbody a,
            .content-sidebar .widget_calendar tbody a:hover,
            .content-sidebar .widget_twentyfourteen_ephemera .widget-title:before {
                color: {$main_font_color};
            }
        ");
    endif;

    if ( $accent_color ) :
        wp_add_inline_style( 'twentyfourteen-style', "
            a, .content-sidebar .widget a {
                color: {$accent_color};
            }
            ::selection {
                background: {$accent_color};
            }
            ::-moz-selection {
                background: {$accent_color};
            }
            .hentry .mejs-controls .mejs-time-rail .mejs-time-current {
                background: {$accent_color};
            }
            button,
            .contributor-posts-link,
            input[type='button'],
            input[type='reset'],
            input[type='submit'],
            .search-toggle,
            .widget button,
            .widget input[type='button'],
            .widget input[type='reset'],
            .widget input[type='submit'],
            .widget_calendar tbody a,
            .content-sidebar .widget input[type='button'],
            .content-sidebar .widget input[type='reset'],
            .content-sidebar .widget input[type='submit'],
            .slider-control-paging .slider-active:before,
            .slider-control-paging .slider-active:hover:before,
            .slider-direction-nav a:hover,
            .widget input[type='button']:hover,
            .widget input[type='button']:focus,
            .widget input[type='reset']:hover,
            .widget input[type='reset']:focus,
            .widget input[type='submit']:hover,
            .widget input[type='submit']:focus,
            .widget_calendar tbody a:hover,
            .content-sidebar .widget input[type='button']:hover,
            .content-sidebar .widget input[type='button']:focus,
            .content-sidebar .widget input[type='reset']:hover,
            .content-sidebar .widget input[type='reset']:focus,
            .content-sidebar .widget input[type='submit']:hover,
            .content-sidebar .widget input[type='submit']:focus {
                background-color: {$accent_color};
            }
            .paging-navigation .page-numbers.current {
                border-top-color: {$accent_color};
            }
        ");
    endif;

    if ( $accent_hover_color ) :
        wp_add_inline_style( 'twentyfourteen-style', "
            a:active,
            a:hover,
            .site-navigation a:hover,
            .entry-title a:hover,
            .entry-meta a:hover,
            .cat-links a:hover,
            .entry-content .edit-link a:hover,
            .page-links a:hover,
            .post-navigation a:hover,
            .image-navigation a:hover,
            .comment-author a:hover,
            .comment-list .pingback a:hover,
            .comment-list .trackback a:hover,
            .comment-metadata a:hover,
            .comment-reply-title small a:hover,
            .widget a:hover,
            .widget-title a:hover,
            .widget_twentyfourteen_ephemera .entry-meta a:hover,
            .content-sidebar .widget a:hover,
            .content-sidebar .widget .widget-title a:hover,
            .content-sidebar .widget_twentyfourteen_ephemera .entry-meta a:hover,
            .site-info a:hover,
            .featured-content a:hover {
                color: {$accent_hover_color};
            }
            button:hover,
            button:focus,
            .contributor-posts-link:hover,
            input[type='button']:hover,
            input[type='button']:focus,
            input[type='reset']:hover,
            input[type='reset']:focus,
            input[type='submit']:hover,
            input[type='submit']:focus,
            .entry-meta .tag-links a:hover,
            .page-links a:hover,
            .search-toggle:hover,
            .search-toggle.active,
            .search-box,
            .slider-control-paging a:hover:before {
            background-color: {$accent_hover_color};
            }
            .paging-navigation a:hover {
                border-top-color: {$accent_hover_color};
            }
            .page-links a:hover {
                border-color: {$accent_hover_color};
            }
            .entry-meta .tag-links a:hover:before {
                border-right-color: {$accent_hover_color};
            }
        ");
    endif;

    if ( $accent_active_color ) :
        wp_add_inline_style( 'twentyfourteen-style', "
            .site-navigation .current_page_item > a,
            .site-navigation .current_page_ancestor > a,
            .site-navigation .current-menu-item > a,
            .site-navigation .current-menu-ancestor > a {
                color: {$accent_active_color};
            }
            button:active,
            .contributor-posts-link:active,
            input[type='button']:active,
            input[type='reset']:active,
            input[type='submit']:active,
            .widget input[type='button']:active,
            .widget input[type='reset']:active,
            .widget input[type='submit']:active,
            .content-sidebar .widget input[type='button']:active,
            .content-sidebar .widget input[type='reset']:active,
            .content-sidebar .widget input[type='submit']:active {
                background-color: {$accent_active_color};
            }
        ");
    endif;

    if ( $main_font_color OR $accent_color OR $accent_hover_color ) :
        if ( $main_font_color ) :
            wp_add_inline_style( 'twentyfourteen-style', "
                @media screen and (min-width: 783px) {
                    .site-navigation li .current_page_item > a,
                    .site-navigation li .current_page_ancestor > a,
                    .site-navigation li .current-menu-item > a,
                    .site-navigation li .current-menu-ancestor > a,
                    .primary-navigation li:hover > a,
                    .primary-navigation li.focus > a {
                        color: {$main_font_color};
                    }
                }
            ");
        endif;

        if ( $accent_color ) :
            wp_add_inline_style( 'twentyfourteen-style', "
                @media screen and (min-width: 783px) {
                    .primary-navigation ul ul,
                    .primary-navigation li:hover > a,
                    .primary-navigation li.focus > a {
                        background-color: {$accent_color};
                    }
                }
            ");
        endif;

        if ( $accent_hover_color ) :
            wp_add_inline_style( 'twentyfourteen-style', "
                @media screen and (min-width: 783px) {
                    .primary-navigation ul ul a:hover,
                    .primary-navigation ul ul li.focus > a {
                        background-color: {$accent_hover_color};
                    }
                }
            ");
        endif;
    endif;

    if ( $main_color OR $main_font_color OR $accent_color OR $accent_hover_color ) :
        if ( $main_font_color ) :
            wp_add_inline_style( 'twentyfourteen-style', "
                @media screen and (min-width: 1008px) {
                    .secondary-navigation li:hover > a,
                    .secondary-navigation li.focus > a {
                        color: {$main_font_color};
                    }
                }
            ");
        endif;

        if ( $main_color ) :
            wp_add_inline_style( 'twentyfourteen-style', "
                @media screen and (min-width: 1008px) {
                    .site:before {
                        background-color: {$main_color};
                    }
                }
            ");
        endif;

        if ( $accent_color ) :
            wp_add_inline_style( 'twentyfourteen-style', "
                @media screen and (min-width: 1008px) {
                    .secondary-navigation ul ul,
                    .secondary-navigation li:hover > a,
                    .secondary-navigation li.focus > a {
                        background-color: {$accent_color};
                    }
                }
            ");
        endif;

        if ( $accent_hover_color ) :
            wp_add_inline_style( 'twentyfourteen-style', "
                @media screen and (min-width: 1008px) {
                    .secondary-navigation ul ul a:hover,
                    .secondary-navigation ul ul li.focus > a {
                        background-color: {$accent_hover_color};
                    }
                }
            ");
        endif;
    endif;
}
add_action( 'wp_enqueue_scripts', '_wpscpc_wp_head', 99999 );

/**
* Convert a hexa decimal color code to its RGB equivalent
*
* @link   http://php.net/manual/ja/function.hexdec.php
* @param  string $hexStr (hexadecimal color value)
* @param  boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
* @param  string $seperator (to separate RGB values. Applicable only if second parameter is true.)
* @return array or string (depending on second parameter. Returns False if invalid hex color value)
*/
function wpscpc_hex2RGB( $hexStr, $returnAsString = false, $seperator = ',' ) {
    $hexStr   = preg_replace( "/[^0-9A-Fa-f]/", '', $hexStr ); // Gets a proper hex string
    $rgbArray = array();
    if ( strlen( $hexStr ) == 6 ) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal          = hexdec( $hexStr );
        $rgbArray['red']   = 0xFF & ( $colorVal >> 0x10 );
        $rgbArray['green'] = 0xFF & ( $colorVal >> 0x8 );
        $rgbArray['blue']  = 0xFF & $colorVal;
    } elseif ( strlen( $hexStr ) == 3 ) { //if shorthand notation, need some string manipulations
        $rgbArray['red']   = hexdec( str_repeat( substr( $hexStr, 0, 1 ), 2 ) );
        $rgbArray['green'] = hexdec( str_repeat( substr( $hexStr, 1, 1 ), 2 ) );
        $rgbArray['blue']  = hexdec( str_repeat( substr( $hexStr, 2, 1 ), 2 ) );
    } else {
        return false; //Invalid hex color code
    }

    return $returnAsString ? implode( $seperator, $rgbArray ) : $rgbArray; // returns the rgb string or the associative array
}
