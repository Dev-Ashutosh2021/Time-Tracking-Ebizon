<div class="page-title group">
	<div class="page-title-inner group">

		<?php if (is_home()): ?>
			<h2>
				Time Tracking
			</h2>

		<?php elseif (is_single()): ?>
			<h3 class="category">
			Time Tracking
			</h3>

		<?php elseif (is_page()): ?>
			<h2>
			Time Tracking
			</h2>

		<?php elseif (is_search()): ?>
			<h1>
				<?php if (have_posts()): ?><i class="fas fa-search"></i>
				<?php endif; ?>
				<?php if (!have_posts()): ?><i class="fas fa-exclamation-circle"></i>
				<?php endif; ?>
				<?php $search_results = $wp_query->found_posts;
				if ($search_results == 1) {
					echo $search_results . ' ' . esc_html__('Search result', 'inunity');
				} else {
					echo $search_results . ' ' . esc_html__('Search results', 'inunity');
				}
				?>
			</h1>
			<div class="notebox">
				<?php esc_html_e('For the term', 'inunity'); ?> "<span>
					<?php echo get_search_query(); ?>
				</span>".
				<?php if (!have_posts()): ?>
					<?php esc_html_e('Please try another search:', 'inunity'); ?>
				<?php endif; ?>
				<div class="search-again">
					<?php get_search_form(); ?>
				</div>
			</div>

		<?php elseif (is_404()): ?>
			<h1><i class="fas fa-exclamation-circle"></i>
				<?php esc_html_e('Error 404.', 'inunity'); ?> <span>
					<?php esc_html_e('Page not found!', 'inunity'); ?>
				</span>
			</h1>
			<div class="notebox">
				<p>
					<?php esc_html_e('The page you are trying to reach does not exist, or has been moved. Please use the menus or the search box to find what you are looking for.', 'inunity'); ?>
				</p>
				<?php get_search_form(); ?>
			</div>

		<?php elseif (is_author()): ?>
			<?php $author = get_userdata(get_query_var('author')); ?>
			<h1><i class="far fa-user"></i>
				<?php echo $author->display_name; ?>
			</h1>

		<?php elseif (is_category()): ?>
			<h1><i class="far fa-folder"></i>
				<?php echo single_cat_title('', false); ?>
			</h1>

		<?php elseif (is_tag()): ?>
			<h1><i class="fas fa-tags"></i>
				<?php echo single_tag_title('', false); ?>
			</h1>

		<?php elseif (is_day()): ?>
			<h1><i class="far fa-calendar"></i>
				<?php echo esc_html(get_the_time('F j, Y')); ?>
			</h1>

		<?php elseif (is_month()): ?>
			<h1><i class="far fa-calendar"></i>
				<?php echo esc_html(get_the_time('F Y')); ?>
			</h1>

		<?php elseif (is_year()): ?>
			<h1><i class="far fa-calendar"></i>
				<?php echo esc_html(get_the_time('Y')); ?>
			</h1>

		<?php else: ?>
			<h2>
				<?php the_title(); ?>
			</h2>

		<?php endif; ?>

		<?php if (!is_paged()): ?>
			<?php the_archive_description('<div class="notebox">', '</div>'); ?>
		<?php endif; ?>

		<!-- Add My Account Navigation Menu -->
		<div class="dropdown" id="account-info">
			<p class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
				<?php $current_user = wp_get_current_user();
				echo 'Hello, ' . esc_html($current_user->first_name . ' ' . $current_user->last_name); ?>
			</p>
			<ul class="dropdown-menu">
				<li><a href="https://timetracking.ebizonstaging.com/account/"><button class="dropdown-item" type="button">Account</button></a></li>
				<li><a href="https://timetracking.ebizonstaging.com/logout/"><button class="dropdown-item" type="button">Log Out</button></a></li>
			</ul>
		</div>

	</div><!--/.page-title-inner-->
</div><!--/.page-title-->