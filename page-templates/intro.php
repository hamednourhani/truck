<?php
/**
 * Template Name: Intro Page
 *
 */?>
<div class="intro-page-wrapper">
<?php get_header(); ?>

    <main class="site-main">
        <?php if(have_posts()){ ?>
            <?php while(have_posts()) { the_post(); ?>



                <div class="site-content full-page">
                    <section class="layout">
                        <?php get_template_part('library/banner','maker'); ?>

                        <div class="primary">



                            <article class="hentry">
                                <?php if( get_post_meta(get_the_ID(),'_truck_title',1 ) !== 'no'){ ?>
                                    <header class="article-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <h3><?php the_title(); ?></h3>
                                        </a>
                                    </header>
                                <?php } ?>
                                <main class="article-body">
                                    <?php the_content(); ?>

                                </main>
                            </article>

                        </div><!-- primary -->



                    </section>
                </div>
            <?php } ?>

        <?php } else { ?>

            <div class="site-content">
                <section class="layout">
                    <div class="secondary">
                        <?php get_sidebar(); ?>
                    </div><!-- secondary -->
                </section>
            </div>

        <?php } ?>

    </main>

<?php get_footer(); ?>