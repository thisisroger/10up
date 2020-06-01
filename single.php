<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<section class="post-single">

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


			<!-- post title -->
			<h2>
				<?php the_title(); ?>
			</h2>
			<!-- /post title -->

			<!-- post details -->
			<div class="post__details">
				<span class="post__date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
				<span class="post__author"><?php _e( 'Published by', 'html5blank' ); ?> <?php the_author_posts_link(); ?></span>
			</div>
			<!-- /post details -->

			<?php the_content(); // Dynamic Content ?>

			<?php edit_post_link(); // Always handy to have Edit Post Links available ?>

		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</section>
	<!-- /section -->
	</main>

<?php get_footer(); ?>
