<?php get_header(); ?>
	
	<main class="site-main">
		
		
		<div class="site-content">

			<?php get_template_part('library/banner','maker'); ?>

			<section class="layout">
				
				<div class="primary">

			

				
						
					<?php if(have_posts()){ ?>
						<?php while(have_posts()) { the_post(); ?>
						
							<article class="hentry">

								<header class="article-title">
									<a href="<?php the_permalink(); ?>">
										<h3><?php the_title(); ?></h3>
									</a>
								</header>
								<main class="article-body">
									<div class="featured-image single-image">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail(); ?>
										</a>
									</div>
									<?php the_excerpt(); ?>
									<?php get_template_part('library/post','meta'); ?>
								</main>
							</article>
						<?php } ?>
					<?php } ?>		
					<nav class="pagination">
						<?php truck_pagination(); ?>
					</nav>		
				</div><!-- primary -->

				<div class="secondary">
					<?php get_sidebar(); ?>
				</div><!-- secondary -->
			</section>
		</div>
		
	</main>

<?php get_footer(); ?>