<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fataniestate.com
 */

get_header();
?>

	<section id="primary">
		<main id="main">

		<?php
		if ( have_posts() ) {

			if ( is_home() && ! is_front_page() ) :
				?>
				<header class="entry-header">
					<h1 class="entry-title"><?php single_post_title(); ?></h1>
				</header><!-- .entry-header -->
				<?php
			endif;

			// Load posts loop.
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content/content' );
			}

			// Previous/next page navigation.
			fataniestate_com_the_posts_navigation();

		} else {

			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/content/content', 'none' );

		}
		?>

<?php
// WP_Query to get properties
$args = array(
  'post_type' => 'property',
  'posts_per_page' => -1,
);
$properties = new WP_Query( $args );

// Check if there are any properties
if ( $properties->have_posts() ) {
  // Start looping through properties
  while ( $properties->have_posts() ) {
    $properties->the_post();
    ?>
    <div class="property-item">
      <h2><?php the_title(); ?></h2>
      <p><?php the_excerpt(); ?></p>
      <a href="<?php the_permalink(); ?>">View Property</a>
    </div>
    <?php
  }
  // Reset post data
  wp_reset_postdata();
} else {
  echo 'No properties found';
}
?><br/>
	<?php
		$propertiesData = new WP_Query(array(
			'post_per_page' => 2,
			'post_type' => 'properties'
		));
		while($propertiesData->have_posts()){
			$propertiesData->the_post();?>
			<li><?php the_title();?></li>
	<?php	}
		
	?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php

get_footer();
