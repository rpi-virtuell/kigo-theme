<?php
/**
 * Template for Timeline Design Loop - design-6
 *
 * This template can be overridden by copying it to yourtheme/powerpack/timeline/slider/design-6.php
 *
 * @package PowerPack
 * @subpackage Timeline
 * @version 1.3
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


//echo '<pre>';var_dump($query->query);die();

$heute = date('Ymd');

$monate = array(1=>"Januar",
                2=>"Februar",
                3=>"M&auml;rz",
                4=>"April",
                5=>"Mai",
                6=>"Juni",
                7=>"Juli",
                8=>"August",
                9=>"September",
                10=>"Oktober",
                11=>"November",
                12=>"Dezember");

$date = new DateTime();
date_add($date, date_interval_create_from_date_string('-900 days'));
$startdate = date_format($date, 'Ymd');
$enddate = $heute + 1;

$args = array(
	'post_type' => 'post',
	'posts_per_page' => '-1',
	'cat' => '1',
    'meta_key' => 'startdate',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => array(
	    array(
            'key' => 'startdate',
            'value' => array( $startdate , $enddate ),
            'type' => 'numeric',
            'compare' => 'BETWEEN'
	    )
    ),
	//'offset' => 5
);

$gotopost = count(get_posts($args))-1;


date_add($date, date_interval_create_from_date_string('+1800 days'));
$enddate = date_format($date, 'Ymd');

$args['meta_query'][0]['value']= array( $startdate , $enddate );

$query = new WP_Query($args);

global $post; ?>



<div id="pwpc-hs-slider-nav-<?php echo $unique; ?>" class="pwpc-hs-slider-nav-<?php echo $unique; ?> pwpc-hs-slider-nav pwpc-slick-slider pwpc-hs-slick-slider" <?php echo $slider_as_nav_for; ?>>
	<?php while ( $query->have_posts() ) : $query->the_post();
		$tl_post_title 	= get_the_title();
	?>
		<div class="pwpc-hs-slider-nav-title">
			<?php if( $tl_post_title ){ ?>
				<div class="pwpc-hs-title"><span><?php echo $tl_post_title; ?></span></div>
			<?php } ?>
			<div class="pwpc-hs-main-title"><button></button></div>
		</div>
	<?php endwhile; ?>
</div>

<div class="pwpc-hs-slider-for-<?php echo $unique; ?> pwpc-hs-slider-for pwpc-hs-slick-slider">
	<?php while ( $query->have_posts() ) : $query->the_post();
		$feat_image 	= pwpc_get_post_featured_image( $post->ID, $image_size, true );
		$post_link 		= pwpc_hs_get_post_link( $post->ID );
		$tl_post_title 	= get_the_title();

		$startdate = get_post_meta( $post->ID, $key = 'startdate', $single = true );
		$enddate = get_post_meta( $post->ID, $key = 'enddate', $single = true );

		$y = substr($startdate,0,4);
		$m = substr($startdate,4,2);
		$d = substr($startdate,6,2);

		//$startdate = "$d.$m.$y";

		$startdate = intVal($d). ". " . $monate[intVal($m)] . " $y";

		$y = substr($enddate,0,4);
		$m = substr($enddate,4,2);
		$d = substr($enddate,6,2);

		//$enddate = "$d.$m.$y";

		$enddate = intVal($d). ". " . $monate[intVal($m)] . " $y";

		?>
		<div class="pwpc-hs-slider-nav-content">
			<div class="pwpc-hs-slider-nav-wrapper <?php echo 'pwpc-hs-img-'.$image_position; ?>" <?php echo $background_style; ?>>
			<?php if($image_position == 'bottom') { ?>
				<div class="pwpc-hs-content-wrapper">
					<?php if( $show_title && $tl_post_title) { ?>
					<h2 class="pwpc-hs-content-title">
						<?php if( $link ) { ?>
						<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_target; ?>" <?php echo $font_style; ?>><?php echo $tl_post_title; ?></a>
						<?php } else { ?>
						<span <?php echo $font_style; ?>><?php echo $tl_post_title; ?></span>
						<?php } ?>
					</h2>
					<?php } ?>

					<?php if ($show_date == 'true') { ?>
						<div class="pwpc-hs-post-date">
                            <span <?php echo $font_style; ?>>
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <a href="<?php echo esc_url( $post_link ); ?>"><?php echo $startdate; ?> - <?php echo $enddate; ?></a>
                            </span>
                        </div>
					<?php }

					if($show_content) { ?>
					<div class="pwpc-hs-content">
						<?php if(empty($show_full_content)) { ?>
						<div class="pwpc-hs-tl-content" <?php echo $font_style; ?>><?php echo pwpc_get_post_excerpt( $post->ID, get_the_content(), $words_limit, $content_tail ); ?></div>
							<?php if($show_read_more) { ?>
								<a class="pwpc-hs-read-more" href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_target; ?>" <?php echo $font_style; ?>><?php echo esc_html($read_more_text); ?></a>
							<?php }
						} else { ?>
								<div class="pwpc-hs-tl-content pwpc-hs-fullcontent" <?php echo $font_style; ?>><?php the_content(); ?></div>
						<?php } ?>
					</div>
					<?php } ?>
				</div>
				<div class="pwpc-hs-timeline-img">
					<?php if(!empty($feat_image)) { ?>
						<?php if( $link ) { ?>
						<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_target; ?>"><img src="<?php echo esc_url( $feat_image ); ?>" alt="<?php the_title_attribute(); ?>" /></a>
						<?php } else { ?>
						<img src="<?php echo esc_url( $feat_image ); ?>" alt="<?php the_title_attribute(); ?>" />
						<?php } ?>
					<?php } ?>
				</div>
			<?php } else { ?>
					<div class="pwpc-hs-timeline-img">
						<?php if(!empty($feat_image)) { ?>
							<?php if( $link ) { ?>
							<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_target; ?>"><img src="<?php echo esc_url( $feat_image ); ?>" alt="<?php the_title_attribute(); ?>" /></a>
							<?php } else { ?>
							<img src="<?php echo esc_url( $feat_image ); ?>" alt="<?php the_title_attribute(); ?>" />
							<?php } ?>
						<?php } ?>
					</div>

					<div class="pwpc-hs-content-wrapper <?php if(empty($feat_image)) { echo 'pwpc-hs-no-image';} ?>">
						<?php if( $show_title && $tl_post_title ) { ?>
						<h2 class="pwpc-hs-content-title">
							<?php if( $link ) { ?>
							<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_target; ?>" <?php echo $font_style; ?>><?php echo $tl_post_title; ?></a>
							<?php } else { ?>
							<span <?php echo $font_style; ?>><?php echo $tl_post_title; ?></span>
							<?php } ?>
						</h2>
						<?php } ?>

						<?php if ($show_date == 'true') { ?>
                            <div class="pwpc-hs-post-date">
                                <span <?php echo $font_style; ?>>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <a href="<?php echo esc_url( $post_link ); ?>"><?php echo $startdate; ?> - <?php echo $enddate; ?></a>
                                </span>
                            </div>
						<?php }

						if($show_content) { ?>
						<div class="pwpc-hs-content">
							<?php if(empty($show_full_content)) { ?>
								<div class="pwpc-hs-tl-content" <?php echo $font_style; ?>><?php echo pwpc_get_post_excerpt( $post->ID, get_the_content(), $words_limit, $content_tail ); ?></div>
								<?php if($show_read_more) { ?>
									<a class="pwpc-hs-read-more" href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_target; ?>" <?php echo $font_style; ?>><?php echo esc_html($read_more_text); ?></a>
								<?php }
							} else { ?>
								<div class="pwpc-hs-fullcontent pwpc-hs-tl-content" <?php echo $font_style; ?>><?php the_content(); ?></div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php endwhile; ?>

</div>
<script>


        setTimeout(function(){
            jQuery('.pwpc-hs-slider-nav').slick('slickGoTo',<?php echo $gotopost; ?>);
        },2000);


        function geheZumAktuellenKigoplanBeitrag(){
            jQuery('.pwpc-hs-slider-nav').slick('slickGoTo',<?php echo $gotopost; ?>);
        };

</script>
<style>
    .kadence-info-box-image-intrisic{height:0}.kt-blocks-info-box-link-wrap{margin-left:auto;margin-right:auto}.kt-info-halign-center{text-align:center}.kt-info-halign-center .kadence-info-box-image-inner-intrisic-container{margin:0 auto}.kt-info-halign-right{text-align:right}.kt-info-halign-right .kadence-info-box-image-inner-intrisic-container{margin:0 0 0 auto}.kt-info-halign-left{text-align:left}.kt-info-halign-left .kadence-info-box-image-inner-intrisic-container{margin:0 auto 0 0}.kt-blocks-info-box-media-align-top .kt-blocks-info-box-media{display:inline-block;max-width:100%}.kt-blocks-info-box-media-align-top .kt-infobox-textcontent{display:block}.kt-blocks-info-box-text{color:#555555}.wp-block-kadence-infobox .kt-blocks-info-box-text{margin-bottom:0}.kt-blocks-info-box-link-wrap:hover{background:#f2f2f2;border-color:#eeeeee}.kt-blocks-info-box-media,.kt-blocks-info-box-link-wrap{border:0 solid transparent;transition:all 0.3s cubic-bezier(0.17, 0.67, 0.35, 0.95)}.kt-blocks-info-box-title,.kt-blocks-info-box-text,.kt-blocks-info-box-learnmore,.kt-info-svg-image{transition:all 0.3s cubic-bezier(0.17, 0.67, 0.35, 0.95)}.kt-blocks-info-box-media{border-color:#444444;color:#444444;padding:10px;margin:0 15px 0 15px}.kt-blocks-info-box-media img{padding:0;margin:0;max-width:100%;height:auto}.kadence-info-box-number-container{text-align:center}.kt-blocks-info-box-media-align-top .kt-blocks-info-box-media{margin:0}.kt-blocks-info-box-media-align-top .kt-blocks-info-box-media-container{margin:0 15px 0 15px;max-width:inherit}.kt-blocks-info-box-link-wrap:hover .kt-blocks-info-box-media{border-color:#444444}.kt-blocks-info-box-link-wrap{display:block;padding:20px;border-color:#eeeeee}.kt-blocks-info-box-learnmore{border:0 solid transparent;display:block;text-decoration:none}.wp-block-kadence-infobox .kt-blocks-info-box-learnmore-wrap{display:inline-block;width:auto}.kt-blocks-info-box-media-align-left{display:-webkit-flex;display:flex;-webkit-align-items:center;align-items:center;-webkit-justify-content:flex-start;justify-content:flex-start}.kt-blocks-info-box-media-align-right{display:-webkit-flex;display:flex;-webkit-align-items:center;align-items:center;-webkit-justify-content:flex-start;justify-content:flex-start;-webkit-flex-direction:row-reverse;flex-direction:row-reverse}@media (min-width: 768px) and (max-width: 1024px){.kb-info-tablet-halign-center{text-align:center}.kb-info-tablet-halign-center .kadence-info-box-image-inner-intrisic-container{margin:0 auto}.kb-info-tablet-halign-right{text-align:right}.kb-info-tablet-halign-right .kadence-info-box-image-inner-intrisic-container{margin:0 0 0 auto}.kb-info-tablet-halign-left{text-align:left}.kb-info-tablet-halign-left .kadence-info-box-image-inner-intrisic-container{margin:0 auto 0 0}}@media (max-width: 767px){.kb-info-mobile-halign-center{text-align:center}.kb-info-mobile-halign-center .kadence-info-box-image-inner-intrisic-container{margin:0 auto}.kb-info-mobile-halign-right{text-align:right}.kb-info-mobile-halign-right .kadence-info-box-image-inner-intrisic-container{margin:0 0 0 auto}.kb-info-mobile-halign-left{text-align:left}.kb-info-mobile-halign-left .kadence-info-box-image-inner-intrisic-container{margin:0 auto 0 0}}.kt-blocks-info-box-media-align-right.kb-info-box-vertical-media-align-top,.kt-blocks-info-box-media-align-left.kb-info-box-vertical-media-align-top{-webkit-align-items:flex-start;align-items:flex-start}.kt-blocks-info-box-media-align-right.kb-info-box-vertical-media-align-bottom,.kt-blocks-info-box-media-align-left.kb-info-box-vertical-media-align-bottom{-webkit-align-items:flex-end;align-items:flex-end}.kt-blocks-info-box-media .kt-info-box-image,.kt-blocks-info-box-media-container{max-width:100%}.kadence-info-box-image-intrisic.kb-info-box-image-type-svg{height:auto;padding-bottom:0}.kt-info-animate-grayscale img,.kt-info-animate-grayscale-border-draw img{-webkit-filter:grayscale(100%);filter:grayscale(100%);transition:0.3s cubic-bezier(0.17, 0.67, 0.35, 0.95)}.kt-blocks-info-box-link-wrap:hover .kt-info-animate-grayscale img,.kt-blocks-info-box-link-wrap:hover .kt-info-animate-grayscale-border-draw img{-webkit-filter:grayscale(0);filter:grayscale(0)}.kt-info-animate-flip,.kt-info-icon-animate-flip{-webkit-perspective:1000;perspective:1000}.kt-blocks-info-box-link-wrap:hover .kt-info-animate-flip .kadence-info-box-image-inner-intrisic,.kt-blocks-info-box-link-wrap:hover .kt-info-icon-animate-flip .kadence-info-box-icon-inner-container{-webkit-transform:rotateY(180deg);transform:rotateY(180deg)}.kt-info-animate-flip .kadence-info-box-image-inner-intrisic,.kt-info-icon-animate-flip .kadence-info-box-icon-inner-container{transition:0.6s;-webkit-transform-style:preserve-3d;transform-style:preserve-3d;position:relative}.kt-info-animate-flip .kt-info-box-image-flip,.kt-info-icon-animate-flip .kt-info-svg-icon-flip{-webkit-backface-visibility:hidden;backface-visibility:hidden;-webkit-transform-style:preserve-3d;transform-style:preserve-3d;position:absolute;top:0;left:0}.kt-info-animate-flip .kt-info-box-image,.kt-info-icon-animate-flip .kt-info-svg-icon{-webkit-backface-visibility:hidden;backface-visibility:hidden}.kt-info-animate-flip .kt-info-box-image,.kt-info-icon-animate-flip .kt-info-svg-icon{z-index:2}.kt-info-animate-flip .kt-info-box-image-flip,.kt-info-icon-animate-flip .kt-info-svg-icon-flip{-webkit-transform:rotateY(180deg);transform:rotateY(180deg)}.kt-info-media-animate-drawborder,.kt-info-media-animate-grayscale-border-draw{position:relative;box-sizing:border-box}.kt-info-media-animate-drawborder::before,.kt-info-media-animate-drawborder::after,.kt-info-media-animate-grayscale-border-draw::before,.kt-info-media-animate-grayscale-border-draw::after{box-sizing:border-box;content:'';position:absolute;border:0px solid transparent;width:0;height:0}.kt-info-media-animate-drawborder::before,.kt-info-media-animate-drawborder::after,.kt-info-media-animate-grayscale-border-draw::before,.kt-info-media-animate-grayscale-border-draw::after{top:0;left:0}.kt-info-media-animate-drawborder:after,.kt-info-media-animate-grayscale-border-draw:after{-webkit-transform:rotate(-90deg);transform:rotate(-90deg)}.kt-blocks-info-box-link-wrap:hover .kt-info-media-animate-drawborder:before,.kt-blocks-info-box-link-wrap:hover .kt-info-media-animate-grayscale-border-draw:before{width:100%;height:100%;transition:border-top-color 0.15s linear,border-right-color 0.15s linear 0.1s,border-bottom-color 0.15s linear 0.2s}.kt-blocks-info-box-link-wrap:hover .kt-info-media-animate-drawborder:after,.kt-blocks-info-box-link-wrap:hover .kt-info-media-animate-grayscale-border-draw:after{width:100%;height:100%;-webkit-transform:rotate(180deg);transform:rotate(180deg);transition:border-bottom-width 0s linear 0.35s,-webkit-transform 0.4s linear 0s;transition:transform 0.4s linear 0s,border-bottom-width 0s linear 0.35s;transition:transform 0.4s linear 0s,border-bottom-width 0s linear 0.35s,-webkit-transform 0.4s linear 0s}.wp-block-kadence-infobox a.kt-blocks-info-box-link-wrap{text-decoration:none !important}.kt-info-icon-animate-flip .kadence-info-box-icon-inner-container{-webkit-backface-visibility:hidden;backface-visibility:hidden}.wp-block-kadence-infobox .kt-info-svg-icon,.wp-block-kadence-infobox .kt-blocks-info-box-number{font-size:50px;line-height:1em;min-width:1em}.wp-block-kadence-infobox .kt-info-svg-icon svg,.wp-block-kadence-infobox .kt-blocks-info-box-number svg{display:block !important;width:1em !important;height:1em !important}
    #suchblock {
        max-width:800px;
        margin: 10px 0;
        border-top: 3px solid white;

    }
    @media only screen and (min-width: 1500px) {
        #suchblock {
            margin: 0px auto;
        }
    }
    @media only screen and (max-width: 600px) {
        .kt-blocks-info-box-media-container {
            display: none;
        }


    }
</style>
<div id="suchblock">
    <div id="kt-info-box_3daf60-7d" class="wp-block-kadence-infobox">
        <div class="kt-blocks-info-box-link-wrap info-box-link kt-blocks-info-box-media-align-left kt-info-halign-left">
            <div class="kt-blocks-info-box-media-container">
                <div class="kt-blocks-info-box-media kt-info-media-animate-none">
                    <div class="kadence-info-box-icon-container kt-info-icon-animate-none">
                        <div class="kadence-info-box-icon-inner-container"><span
                                    style="display:block;justify-content:center;align-items:center"
                                    class="kt-info-svg-icon kt-info-svg-icon-fe_search"><svg
                                        style="display:inline-block;vertical-align:middle" viewBox="0 0 24 24"
                                        height="50" width="50" fill="none" stroke="currentColor"
                                        xmlns="http://www.w3.org/2000/svg" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21"
                                                                                                             y1="21"
                                                                                                             x2="16.65"
                                                                                                             y2="16.65"></line></svg></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-infobox-textcontent">
                <h2 class="kt-blocks-info-box-title">In allen Gottesdienstthemen suchen</h2>
                <p>
                    <?php
                    echo kigoplan_my_search_form();
                    ?>
                </p>
            </div>
        </div>

    </div>
</div>
