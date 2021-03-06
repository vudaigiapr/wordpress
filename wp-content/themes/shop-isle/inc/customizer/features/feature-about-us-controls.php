<?php
/**
 * Customizer functionality for the About Us Page controls.
 *
 * @package WordPress
 * @subpackage Shop Isle
 */

/**
 * Hook controls for the About Us Page to Customizer.
 */
function shop_isle_about_us_page_customize_register( $wp_customize ) {

	/**
	 * Class ShopIsle_Aboutus_Page_Instructions
	 */
	class ShopIsle_Aboutus_Page_Instructions extends WP_Customize_Control {

		/**
		 * Render Content Function
		 */
		public function render_content() {
			echo __( 'To customize the About us Page you need to first select the template "About us page" for the page you want to use for this purpose. Then open that page in the browser and press "Customize" in the top bar.', 'shop-isle' ) . '<br><br>' . sprintf( __( 'Need further informations? Check this %1$s', 'shop-isle' ), sprintf( '<a href="http://docs.themeisle.com/article/211-shopisle-customizing-the-contact-and-about-us-page" target="_blank">%s</a>',  __( 'doc', 'shop-isle' ) ) );
		}
	}

	/*  About us page  */

	if ( class_exists( 'WP_Customize_Panel' ) ) :

		$wp_customize->add_panel( 'panel_team', array(
			'priority'       => 98,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'About us page', 'shop-isle' ),
		) );

		$wp_customize->add_section( 'shop_isle_about_page_section', array(
			'title'    => __( 'Our team', 'shop-isle' ),
			'priority' => 1,
			'panel'    => 'panel_team',
		) );

	else :

		$wp_customize->add_section( 'shop_isle_about_page_section', array(
			'title'    => __( 'About us page - our team', 'shop-isle' ),
			'priority' => 98,
		) );

	endif;

	/* Our team title */
	$wp_customize->add_setting( 'shop_isle_our_team_title', array(
		'sanitize_callback' => 'shop_isle_sanitize_text',
		'default'           => __( 'Meet our team', 'shop-isle' ),
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'shop_isle_our_team_title', array(
		'label'           => __( 'Title', 'shop-isle' ),
		'section'         => 'shop_isle_about_page_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'        => 1,
	) );

	/* Our team subtitle */
	$wp_customize->add_setting( 'shop_isle_our_team_subtitle', array(
		'sanitize_callback' => 'shop_isle_sanitize_text',
		'default'           => __( 'An awesome way to introduce the members of your team.', 'shop-isle' ),
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'shop_isle_our_team_subtitle', array(
		'label'           => __( 'Subtitle', 'shop-isle' ),
		'section'         => 'shop_isle_about_page_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'        => 2,
	) );

	/* Team members */
	$wp_customize->add_setting( 'shop_isle_team_members', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_repeater',
		'default'           => json_encode( array(
			array(
				'image_url'   => get_template_directory_uri() . '/assets/images/team1.jpg',
				'text'        => 'Eva Bean',
				'subtext'     => 'Developer',
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.',
			),
			array(
				'image_url'   => get_template_directory_uri() . '/assets/images/team2.jpg',
				'text'        => 'Maria Woods',
				'subtext'     => 'Designer',
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.',
			),
			array(
				'image_url'   => get_template_directory_uri() . '/assets/images/team3.jpg',
				'text'        => 'Booby Stone',
				'subtext'     => 'Director',
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.',
			),
			array(
				'image_url'   => get_template_directory_uri() . '/assets/images/team4.jpg',
				'text'        => 'Anna Neaga',
				'subtext'     => 'Art Director',
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.',
			),
		) ),
	) );
	$wp_customize->add_control( new Shop_Isle_Repeater_Controler( $wp_customize, 'shop_isle_team_members', array(
		'label'                         => __( 'Add new team member', 'shop-isle' ),
		'section'                       => 'shop_isle_about_page_section',
		'active_callback'               => 'shop_isle_is_aboutus_page',
		'priority'                      => 3,
		'shop_isle_image_control'       => true,
		'shop_isle_link_control'        => false,
		'shop_isle_text_control'        => true,
		'shop_isle_subtext_control'     => true,
		'shop_isle_label_control'       => false,
		'shop_isle_icon_control'        => false,
		'shop_isle_description_control' => true,
		'shop_isle_box_label'           => __( 'Team member', 'shop-isle' ),
		'shop_isle_box_add_label'       => __( 'Add new team member', 'shop-isle' ),
	) ) );

	/* About us page - instructions for users when not on About us page */

	$wp_customize->add_section( 'shop_isle_aboutus_page_instructions', array(
		'title'    => __( 'About us page', 'shop-isle' ),
		'priority' => 98,
	) );

	$wp_customize->add_setting( 'shop_isle_aboutus_page_instructions', array(
		'sanitize_callback' => 'shop_isle_sanitize_text',
	) );

	$wp_customize->add_control( new ShopIsle_Aboutus_Page_Instructions( $wp_customize, 'shop_isle_aboutus_page_instructions', array(
		'section'         => 'shop_isle_aboutus_page_instructions',
		'active_callback' => 'shop_isle_is_not_aboutus_page',
	) ) );

	if ( class_exists( 'WP_Customize_Panel' ) ) :

		$wp_customize->add_section( 'shop_isle_about_page_video_section', array(
			'title'    => __( 'Video', 'shop-isle' ),
			'priority' => 2,
			'panel'    => 'panel_team',
		) );

	else :

		$wp_customize->add_section( 'shop_isle_about_page_video_section', array(
			'title'    => __( 'About us page - video', 'shop-isle' ),
			'priority' => 53,
		) );

	endif;

	/* Video title */
	$wp_customize->add_setting( 'shop_isle_about_page_video_title', array(
		'sanitize_callback' => 'shop_isle_sanitize_text',
		'default'           => __( 'Presentation', 'shop-isle' ),
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'shop_isle_about_page_video_title', array(
		'label'           => __( 'Title', 'shop-isle' ),
		'section'         => 'shop_isle_about_page_video_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'        => 1,
	) );

	/* Video subtitle */
	$wp_customize->add_setting( 'shop_isle_about_page_video_subtitle', array(
		'sanitize_callback' => 'shop_isle_sanitize_text',
		'default'           => __( 'What the video about our new products', 'shop-isle' ),
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'shop_isle_about_page_video_subtitle', array(
		'label'           => __( 'Subtitle', 'shop-isle' ),
		'section'         => 'shop_isle_about_page_video_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'        => 2,
	) );

	/* Video background */
	$wp_customize->add_setting( 'shop_isle_about_page_video_background', array(
		'default'           => get_template_directory_uri() . '/assets/images/background-video.jpg',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'shop_isle_about_page_video_background', array(
		'label'           => __( 'Background', 'shop-isle' ),
		'section'         => 'shop_isle_about_page_video_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'        => 3,
	) ) );

	/* Video link */
	$wp_customize->add_setting( 'shop_isle_about_page_video_link', array(
		'sanitize_callback' => 'shop_isle_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'shop_isle_about_page_video_link', array(
		'label'           => __( 'Video', 'shop-isle' ),
		'section'         => 'shop_isle_about_page_video_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'        => 4,
	) );

	if ( class_exists( 'WP_Customize_Panel' ) ) :

		$wp_customize->add_section( 'shop_isle_about_page_advantages_section', array(
			'title'    => __( 'Our advantages', 'shop-isle' ),
			'priority' => 3,
			'panel'    => 'panel_team',
		) );

	else :

		$wp_customize->add_section( 'shop_isle_about_page_advantages_section', array(
			'title'    => __( 'About us page - our advantages', 'shop-isle' ),
			'priority' => 54,
		) );

	endif;

	/* Our advantages title */
	$wp_customize->add_setting( 'shop_isle_our_advantages_title', array(
		'sanitize_callback' => 'shop_isle_sanitize_text',
		'default'           => __( 'Our advantages', 'shop-isle' ),
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'shop_isle_our_advantages_title', array(
		'label'           => __( 'Title', 'shop-isle' ),
		'section'         => 'shop_isle_about_page_advantages_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'        => 1,
	) );

	/* Advantages */
	$wp_customize->add_setting( 'shop_isle_advantages', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_repeater',
		'default'           => json_encode( array(
			array(
				'icon_value' => 'icon_lightbulb',
				'text'       => __( 'Ideas and concepts', 'shop-isle' ),
				'subtext'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'shop-isle' ),
			),
			array(
				'icon_value' => 'icon_tools',
				'text'       => __( 'Designs & interfaces', 'shop-isle' ),
				'subtext'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'shop-isle' ),
			),
			array(
				'icon_value' => 'icon_cogs',
				'text'       => __( 'Highly customizable', 'shop-isle' ),
				'subtext'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'shop-isle' ),
			),
			array(
				'icon_value' => 'icon_like',
				'text'       => __( 'Easy to use', 'shop-isle' ),
				'subtext'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'shop-isle' ),
			),
		) ),
	) );

	$wp_customize->add_control( new Shop_Isle_Repeater_Controler( $wp_customize, 'shop_isle_advantages', array(
		'label'                         => __( 'Add new advantage', 'shop-isle' ),
		'section'                       => 'shop_isle_about_page_advantages_section',
		'active_callback'               => 'shop_isle_is_aboutus_page',
		'priority'                      => 2,
		'shop_isle_image_control'       => false,
		'shop_isle_link_control'        => false,
		'shop_isle_text_control'        => true,
		'shop_isle_subtext_control'     => true,
		'shop_isle_label_control'       => false,
		'shop_isle_icon_control'        => true,
		'shop_isle_description_control' => false,
		'shop_isle_box_label'           => __( 'Advantage', 'shop-isle' ),
		'shop_isle_box_add_label'       => __( 'Add new advantage', 'shop-isle' ),
	) ) );
}

add_action( 'customize_register', 'shop_isle_about_us_page_customize_register' );

/**
 * Check if is about us page.
 *
 * @return bool
 */
function shop_isle_is_aboutus_page() {
	return is_page_template( 'template-about.php' );
};

/**
 * Check if is not about us page.
 *
 * @return bool
 */
function shop_isle_is_not_aboutus_page() {
	return ! is_page_template( 'template-about.php' );
};
