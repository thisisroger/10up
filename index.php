<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section class="container post-list">

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
