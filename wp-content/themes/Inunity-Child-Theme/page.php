<?php get_header(); ?>

<div class="content">

	<?php if (get_theme_mod('heading-enable', 'on') == 'on'): ?>
		<div id="page-title-sticky">
			<?php get_template_part('inc/page-title'); ?>
		</div>
	<?php endif; ?>

	<?php while (have_posts()):
		the_post(); ?>

		<div class="content-wrap">
			<div class="content-wrap-inner group">

				<article <?php post_class(); ?>>

					<header class="entry-header group">
						<h1 class="entry-title">
							<?php the_title(); ?>
						</h1>
					</header>
					<div class="entry-content">
						<div class="entry themeform">
							<?php the_content(); ?>
							<div class="clear"></div>
						</div><!--/.entry-->
					</div>
					<div class="entry-footer group">
						<?php if (comments_open() || get_comments_number()):
							comments_template('/comments.php', true); endif; ?>
					</div>

				</article><!--/.post-->

			</div>
		</div>
	<?php endwhile; ?>

</div><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>