<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'neve-style','neve-style' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 1000 );

// END ENQUEUE PARENT ACTION



add_shortcode('kigoplan_timline','display_kigoplan_timeline');
function display_kigoplan_timeline(){
    return do_shortcode('[pwpc_timeline_slider design="design-6" show_full_content="true" post_type="post" order="asc"  dots="false"  arrows="false"]');
}

add_filter ('neve_filter_toggle_content_parts', 'kigoplan_display_suchtitel', 10, 2);
function kigoplan_display_suchtitel ($is_true, $content_part){
    if($content_part == 'title' && is_search() ){

        echo '<div id="search-header" class="entry-header">
                    <div class="nv-title-meta-wrap">
                        <h1>Suchergebnisse</h1>
                        <ul class="searchform">' . get_search_form(array('echo'=>false)) .  '</ul>
                    </div>
              </div>';

	    return false;
    }else{
        return true;
    }
}

/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
function kigoplan_my_search_form( $form=null ) {

	if(!is_search() && $form !== null ){
	    return $form;
    }
    global $wp_query;

	$q = $wp_query->query_vars;

	$placeholder = 'Suchen nach&nbsp;…';

	$icon_dim = 40;

	if($form === null){
		$q['cat'] = 1;
		$q['post_type'] ='post';
		$icon_dim = 15;
    }

	$hidden_cat = $q['cat']? '<input type="hidden" name="cat" value="'.$q['cat'].'">' :'';
	$hidden_type = $q['post_type']? '<input type="hidden" name="post_type" value="'.$q['post_type'].'">' :'';

	$in = (! $q['category_name'] ) ? '' : ' in ' . $q['category_name'];

	$form = '
    <style>
    .nv-icon.nv-search{
        display: none;
    }
    </style>
    <div class="form-wrap ">
        <form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '" target="_self">
            ' . $hidden_cat . $hidden_type . '
            <label>
                <span class="screen-reader-text">Suchen nach&nbsp;…</span>
                <input type="search" class="search-field" placeholder="'.$placeholder.'" value="' . get_search_query() . '" name="s">
            </label>
            <input type="submit" class="search-submit" value="Search">
            <div class="nv-search-icon-wrap">
                <div class="nv-icon nv-suche">
                    <svg width="'.$icon_dim.'" height="'.$icon_dim.'" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1216 832q0-185-131.5-316.5t-316.5-131.5-316.5 131.5-131.5 316.5 131.5 316.5 316.5 131.5 316.5-131.5 131.5-316.5zm512 832q0 52-38 90t-90 38q-54 0-90-38l-343-342q-179 124-399 124-143 0-273.5-55.5t-225-150-150-225-55.5-273.5 55.5-273.5 150-225 225-150 273.5-55.5 273.5 55.5 225 150 150 225 55.5 273.5q0 220-124 399l343 343q37 37 37 90z"></path>
                    </svg>
                </div>
            </div>
        </form>			
    </div>';

	return $form;
}
add_filter( 'get_search_form', 'kigoplan_my_search_form' );



if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array(
		'key' => 'group_5d0223b1524c0',
		'title' => 'Kigoplan',
		'fields' => array(
			array(
				'key' => 'field_5d0223edd3281',
				'label' => 'Datum des ersten Sonntag',
				'name' => 'startdate',
				'type' => 'date_picker',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'display_format' => 'd.m.Y',
				'return_format' => 'd.m.Y',
				'first_day' => 1,
			),
			array(
				'key' => 'field_5d02c9bd2e975',
				'label' => 'Datum des letzten Sonntag',
				'name' => 'enddate',
				'type' => 'date_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5d0223edd3281',
							'operator' => '!=empty',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'display_format' => 'd.m.Y',
				'return_format' => 'd.m.Y',
				'first_day' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
				array(
					'param' => 'post_category',
					'operator' => '==',
					'value' => 'category:allgemein',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'seamless',
		'label_placement' => 'top',
		'instruction_placement' => 'field',
		'hide_on_screen' => array(
			0 => 'excerpt',
			1 => 'discussion',
			2 => 'comments',
			3 => 'slug',
			4 => 'author',
			5 => 'format',
			6 => 'page_attributes',
			7 => 'send-trackbacks',
		),
		'active' => true,
		'description' => '',
	));

endif;
