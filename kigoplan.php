<?php
/**
 * Template Name: Kigoplan Index
 *
 * @package Neve
 * @since   1.0.0
 */
$container_class = apply_filters( 'neve_container_class_filter', 'container', 'single-page' );

get_header();


?>
<div class="<?php echo esc_attr( $container_class ); ?> single-page-container">
	<div class="row">
		<?php do_action( 'neve_do_sidebar', 'single-page', 'left' ); ?>
		<div class="nv-single-page-wrap col">
			<?php
			do_action( 'neve_before_page_header' );
			do_action( 'neve_page_header', 'single-page' );
			do_action( 'neve_before_content', 'single-page' );
			
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content', 'page' );
				}
			} else {
				get_template_part( 'template-parts/content', 'none' );
			}
			
			do_action( 'neve_after_content', 'single-page' );
			
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


			$args = array(
				'post_type' => 'post',
				'posts_per_page' => '-1',
				'cat' => '1',
				'meta_key' => 'startdate',
				'orderby' => 'meta_value_num',
				'order' => 'ASC'
			);
			$posts = get_posts($args);
			$startyear = array();

			foreach($posts as $post){

				$p = array();

				$id = $post->ID;
				//$p['post']=$post;

				$p['feat_image']  	= pwpc_get_post_featured_image( $post->ID, 'thumbnail', true );
				$p['post_link'] 	= pwpc_hs_get_post_link( $post->ID );
				$p['post_title'] 	= get_the_title();

				$startdate = get_post_meta( $post->ID, $key = 'startdate', $single = true );
				$enddate = get_post_meta( $post->ID, $key = 'enddate', $single = true );

				if(!$startdate){
					continue;
				}

				$y = substr($startdate,0,4);
				$m = substr($startdate,4,2);
				$d = substr($startdate,6,2);


				if(! isset($startyear[$y])){
					$startyear[$y] = array();
				}


				$startdate = intVal($d). ". " . $monate[intVal($m)] . " $y";

				$y = substr($enddate,0,4);
				$m = substr($enddate,4,2);
				$d = substr($enddate,6,2);

				$enddate = intVal($d). ". ".  $monate[intVal($m)] . " $y";

				$p['startdate']= $startdate;
				$p['enddate']= $enddate;
				$p['year']= $y;


				$startyear[$y][$id] = $p;



			}


            foreach ($startyear as $year=>$ps):
                echo '<h3>'.$year.'</h3>';
                foreach ($ps as $k=>$p):?>
                    <article class="nv-non-grid-article">
                        <div style="margin:10px 30px;">
                            <div class="excerpt-wrap entry-summary">
                                <span class="dae"><?php echo  $p['startdate'];?> - <?php echo  $p['enddate'];?></span>
                                <h4>
                                    <a href="<?php echo  $p['post_link'];?>"><?php echo  $p['post_title'];?></a>
                                </h4>

                            </div>
                        </div>
                    </article>
                <?php
                endforeach;
            endforeach;

			do_action( 'neve_after_content', 'single-page' );
			?>
		</div>
		<?php do_action( 'neve_do_sidebar', 'single-page', 'right' ); ?>
	</div>
</div>
<?php get_footer(); ?>
