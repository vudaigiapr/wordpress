<?php
/**
 * Frontend class
 *
 * @author  Yithemes
 * @package YITH WooCommerce Badge Management
 */

if ( !defined( 'YITH_WCBM' ) ) {
    exit;
} // Exit if accessed directly

if ( !class_exists( 'YITH_WCBM_Frontend' ) ) {
    /**
     * Frontend class.
     * The class manage all the Frontend behaviors.
     *
     * @since 1.0.0
     */
    class YITH_WCBM_Frontend {

        /**
         * Single instance of the class
         *
         * @var YITH_WCBM_Frontend
         * @since 1.0.0
         */
        protected static $_instance;

        /**
         * @type bool
         */
        private $is_in_sidebar = false;

        /**
         * @type bool
         * @since 1.2.7
         */
        private $is_in_minicart = false;

        /**
         * Returns single instance of the class
         *
         * @return YITH_WCBM_Frontend|YITH_WCBM_Frontend_Premium
         * @since 1.0.0
         */
        public static function get_instance() {
            $self = __CLASS__ . ( class_exists( __CLASS__ . '_Premium' ) ? '_Premium' : '' );

            return !is_null( $self::$_instance ) ? $self::$_instance : $self::$_instance = new $self;
        }

        /**
         * Constructor
         *
         * @access public
         * @since  1.0.0
         */
        public function __construct() {
            // Action to add custom badge in single product page
            add_filter( 'woocommerce_single_product_image_html', array( $this, 'show_badge_on_product' ), 10, 2 );

            // POST Thumbnail [to add custom badge in shop page]
            add_filter( 'post_thumbnail_html', array( $this, 'show_badge_on_product' ), 999, 2 );
            add_filter( 'yith_wcbm_product_thumbnail_container', array( $this, 'show_badge_on_product' ), 999, 2 );

            // edit sale flash badge
            add_filter( 'woocommerce_sale_flash', array( $this, 'sale_flash' ), 10, 2 );


            // action to set this->is_in_sidebar
            add_action( 'dynamic_sidebar_before', array( $this, 'set_is_in_sidebar' ) );
            add_action( 'dynamic_sidebar_after', array( $this, 'unset_is_in_sidebar' ) );

            // action to set this->is_in_minicart
            add_action( 'woocommerce_before_mini_cart', array( $this, 'set_is_in_minicart' ) );
            add_action( 'woocommerce_after_mini_cart', array( $this, 'unset_is_in_minicart' ) );

            // add frontend css
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

            /**
             * Theme support
             */
            add_action( 'yith_wcbm_theme_badge_container_start', array( $this, 'theme_badge_container_start' ) );
            add_action( 'yith_wcbm_theme_badge_container_end', array( $this, 'theme_badge_container_end' ) );
        }

        /**
         * THEME SUPPORT
         * start the container and start an OB
         */
        public function theme_badge_container_start() {
            if ( !apply_filters( 'yith_wcbm_theme_badge_container_start_check', true ) )
                return;

            remove_filter( 'post_thumbnail_html', array( $this, 'show_badge_on_product' ), 999 );
            remove_filter( 'woocommerce_single_product_image_html', array( $this, 'show_badge_on_product' ), 10 );

            $this->badge_container_start();
        }

        /**
         * THEME SUPPORT
         * print the OB saved with the badges
         */
        public function theme_badge_container_end() {
            if ( !apply_filters( 'yith_wcbm_theme_badge_container_end_check', true ) )
                return;

            $this->badge_container_end();

            add_filter( 'post_thumbnail_html', array( $this, 'show_badge_on_product' ), 999, 2 );
            add_filter( 'woocommerce_single_product_image_html', array( $this, 'show_badge_on_product' ), 10, 2 );
        }

        /**
         * start the container and start an OB
         */
        public function badge_container_start() {
            ob_start();
        }

        /**
         * print the OB saved with the badges
         */
        public function badge_container_end() {
            global $post;
            $post_id = !!$post ? $post->ID : 0;

            echo apply_filters( 'yith_wcbm_product_thumbnail_container', ob_get_clean(), $post_id );
        }


        /**
         * Show the badge on product
         *
         * @param $thumb
         * @param $post_id
         *
         * @return string
         * @deprecated 1.2.12 free | 1.2.27 premium Use 'show_badge_on_product' instead.
         */
        public function add_box_thumb( $thumb, $post_id ) {
            return $this->show_badge_on_product( $thumb, $post_id );
        }

        /**
         * Set this->is in minicart to true
         *
         * @access public
         * @since  1.2.7
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function set_is_in_minicart() {
            $this->is_in_minicart = true;
        }

        /**
         * Set this->is in minicart to false
         *
         * @access public
         * @since  1.2.7
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function unset_is_in_minicart() {
            $this->is_in_minicart = false;
        }

        /**
         * Set this->is in sidebar to true
         *
         * @access public
         * @since  1.1.4
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function set_is_in_sidebar() {
            $this->is_in_sidebar = true;
        }

        /**
         * Set this->is in sidebar to false
         *
         * @access public
         * @since  1.1.4
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function unset_is_in_sidebar() {
            $this->is_in_sidebar = false;
        }

        /**
         * Return true if is in sidebar
         *
         * @access public
         * @return bool
         * @since  1.1.4
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function is_in_sidebar() {
            return $this->is_in_sidebar;
        }

        /**
         * Return true if is in email
         *
         * @access public
         * @return bool
         * @since  1.2.15 [premium]
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function is_in_email() {
            return !!did_action( 'woocommerce_email_header' );
        }

        /**
         * Return true if is allowed badge showing
         * for example prevent badge showing in Wishilist Emails
         *
         * @access public
         * @return bool
         * @since  1.2.16 [premium]
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function is_allowed_badge_showing() {
            $hide_in_sidebar = get_option( 'yith-wcbm-hide-in-sidebar', 'yes' ) == 'yes';
            $show_in_sidebar = !$hide_in_sidebar;

            $allowed = ( !$this->is_in_sidebar() || $show_in_sidebar );
            $allowed = $allowed && !$this->is_in_minicart;
            $allowed = $allowed && ( !is_cart() || ( apply_filters( 'yith_wcbm_allow_badges_in_cart_page', false ) ) );
            $allowed = $allowed && ( !is_checkout() || ( apply_filters( 'yith_wcbm_allow_badges_in_checkout_page', false ) ) );
            $allowed = $allowed && !$this->is_in_email();
            $allowed = $allowed && !is_feed();

            // ---- YITH WooCommerce Waiting list
            $allowed = $allowed && !did_action( 'send_yith_waitlist_mail_instock' );
            $allowed = $allowed && !did_action( 'send_yith_waitlist_mail_subscribe' );

            // ---- YITH WooCommerce Recently Viewed Products
            $allowed = $allowed && !did_action( 'send_yith_wrvp_mail' );

            // ---- YITH WooCommerce Question & Answer
            $allowed = $allowed && !did_action( 'yith_questions_answers_after_new_answer' );
            $allowed = $allowed && !did_action( 'yith_questions_answers_after_new_question' );

            // ---- YITH WooCommerce Wishlist
            if ( function_exists( 'yith_wcwl_is_wishlist_page' ) && function_exists( 'yith_wcwl_is_wishlist' ) ) {
                $allowed = $allowed && !yith_wcwl_is_wishlist_page() && !yith_wcwl_is_wishlist();
            }

            return apply_filters( 'yith_wcbm_is_allowed_badge_showing', $allowed );
        }

        /**
         * Hide or show default sale flash badge
         *
         * @access public
         * @return string
         *
         * @param $val string value of filter woocommerce_sale_flash
         *
         * @since  1.0.0
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function sale_flash( $val, $post ) {
            $hide_on_sale_default = get_option( 'yith-wcbm-hide-on-sale-default' ) == 'yes' ? true : false;

            $product_id = $post->ID;
            $product_id = $this->get_wpml_parent_id( $product_id );

            $badge_overrides_default_on_sale = get_option( 'yith-wcbm-product-badge-overrides-default-on-sale', 'yes' ) == 'yes';

            $product  = wc_get_product( $product_id );
            $bm_meta  = yit_get_prop( $product, '_yith_wcbm_product_meta', true );
            $id_badge = ( isset( $bm_meta[ 'id_badge' ] ) ) ? $bm_meta[ 'id_badge' ] : '';

            if ( $hide_on_sale_default || ( $id_badge != '' && $badge_overrides_default_on_sale ) ) {
                return '';
            }

            return $val;
        }


        /**
         * Get the badge Id based on current language
         *
         * @access public
         * @return int
         *
         * @param $id_badge string id of badge
         *
         * @since  1.0.0
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function get_wmpl_badge_id( $id_badge ) {
            return $id_badge;
        }

        /**
         * Edit image in products
         *
         * @access public
         * @return string
         *
         * @param $val string product image
         *
         * @since  1.0.0
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function show_badge_on_product( $val, $product_id ) {
            // prevent multiple badge copies
            if ( strpos( $val, 'container-image-and-badge' ) > 0 || !$this->is_allowed_badge_showing() )
                return $val;

            $product_id = $this->get_wpml_parent_id( $product_id );
            $product    = wc_get_product( $product_id );
            if ( !$product )
                return $val;

            $bm_meta  = yit_get_prop( $product, '_yith_wcbm_product_meta', true );
            $id_badge = ( isset( $bm_meta[ 'id_badge' ] ) ) ? $bm_meta[ 'id_badge' ] : '';

            $badge_container = "<div class='container-image-and-badge'>" . $val;
            $badge_content   = '';

            if ( !defined( 'YITH_WCBM_PREMIUM' ) ) {
                $badge_content .= yith_wcbm_get_badge( $id_badge, $product_id );
            } else {
                $badge_content .= yith_wcbm_get_badges_premium( $id_badge, $product_id );
            }

            if ( empty( $badge_content ) )
                return $val;

            $badge_container .= $badge_content . "</div><!--container-image-and-badge-->";

            return $badge_container;

        }

        public function enqueue_scripts() {
            wp_enqueue_style( 'yith_wcbm_badge_style', YITH_WCBM_ASSETS_URL . '/css/frontend.css' );
            wp_add_inline_style( 'yith_wcbm_badge_style', $this->get_inline_css() );
            wp_enqueue_style( 'googleFontsOpenSans', '//fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' );
        }

        /**
         * @return string
         */
        public function get_inline_css() {
            $badges = yith_wcbm_get_badges();
            ob_start();
            if ( $badges ) {
                foreach ( $badges as $id_badge ) {
                    $bm_meta = get_post_meta( $id_badge, '_badge_meta', true );
                    $default = array(
                        'type'                        => 'text',
                        'text'                        => '',
                        'txt_color_default'           => '#000000',
                        'txt_color'                   => '#000000',
                        'bg_color_default'            => '#2470FF',
                        'bg_color'                    => '#2470FF',
                        'advanced_bg_color'           => '',
                        'advanced_bg_color_default'   => '',
                        'advanced_text_color'         => '',
                        'advanced_text_color_default' => '',
                        'advanced_badge'              => 1,
                        'css_badge'                   => 1,
                        'css_bg_color'                => '',
                        'css_bg_color_default'        => '',
                        'css_text_color'              => '',
                        'css_text_color_default'      => '',
                        'css_text'                    => '',
                        'width'                       => '100',
                        'height'                      => '50',
                        'position'                    => 'top-left',
                        'image_url'                   => '',
                        'pos_top'                     => 0,
                        'pos_bottom'                  => 0,
                        'pos_left'                    => 0,
                        'pos_right'                   => 0,
                        'border_top_left_radius'      => 0,
                        'border_top_right_radius'     => 0,
                        'border_bottom_right_radius'  => 0,
                        'border_bottom_left_radius'   => 0,
                        'padding_top'                 => 0,
                        'padding_bottom'              => 0,
                        'padding_left'                => 0,
                        'padding_right'               => 0,
                        'font_size'                   => 13,
                        'line_height'                 => -1,
                        'opacity'                     => 100,
                        'id_badge'                    => $id_badge
                    );

                    if ( !isset( $bm_meta[ 'pos_top' ] ) ) {
                        $position = isset( $bm_meta[ 'position' ] ) ? $bm_meta[ 'position' ] : 'top-left';
                        if ( $position == 'top-right' ) {
                            $default[ 'pos_bottom' ] = 'auto';
                            $default[ 'pos_left' ]   = 'auto';
                        } else if ( $position == 'bottom-left' ) {
                            $default[ 'pos_top' ]   = 'auto';
                            $default[ 'pos_right' ] = 'auto';
                        } else if ( $position == 'bottom-right' ) {
                            $default[ 'pos_top' ]  = 'auto';
                            $default[ 'pos_left' ] = 'auto';
                        } else {
                            $default[ 'pos_bottom' ] = 'auto';
                            $default[ 'pos_right' ]  = 'auto';
                        }
                    }

                    $args = wp_parse_args( $bm_meta, $default );
                    $args = apply_filters( 'yith_wcbm_badge_content_args', $args );

                    $badge_style = !defined( 'YITH_WCBM_PREMIUM' ) ? 'badge_styles.php' : 'badge_styles_premium.php';
                    yith_wcbm_get_template( $badge_style, $args );
                }
            }

            return ob_get_clean();
        }

        public function get_wpml_parent_id( $id, $post_type = 'product' ) {

            global $sitepress;
            if ( isset( $sitepress ) ) {

                $default_language = $sitepress->get_default_language();

                if ( function_exists( 'icl_object_id' ) ) {
                    $id = icl_object_id( $id, $post_type, true, $default_language );
                } else {
                    if ( function_exists( 'wpml_object_id_filter' ) ) {
                        $id = wpml_object_id_filter( $id, $post_type, true, $default_language );
                    }
                }
            }

            return $id;
        }
    }
}
/**
 * Unique access to instance of YITH_WCBM_Frontend class
 *
 * @return YITH_WCBM_Frontend|YITH_WCBM_Frontend_Premium
 * @since 1.0.0
 */
function YITH_WCBM_Frontend() {
    return YITH_WCBM_Frontend::get_instance();
}
