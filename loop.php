<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="post__media">
			<!-- post thumbnail -->
			<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail(); ?>
				</a>
			<?php endif; ?>
			<!-- /post thumbnail -->
		</div>

		<div class="post__content">
			<!-- post details -->
			<span class="post__date"><?php the_time('F j, Y'); ?></span>
			<!-- /post details -->

			<!-- post title -->
			<h2 class="post__title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h2>
			<!-- /post title -->

			<?php html5wp_excerpt('html5wp_index'); ?>
			<a class="post__link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read More <?php tenUpSvgSystem( 'chevron-right' ); ?> </a>

			<?php edit_post_link(); ?>
		</div>

	</article>
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2>
		<?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?>
		</h2>
	</article>
	<!-- /article -->

<?php endif; ?>
