<?php get_header(); ?>

<div id="content" class="cf w">
  <main id="main" class="t-8" role="main">
    <?php /* @TODO: itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog"> */ ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class( 'article' ); ?> role="article">
        <div class="article--inner cf w">
          <header class="article--header">
            <?php the_post_thumbnail( 'large' ); ?>
            <h1 class="article--title"><?php the_title(); ?></h1>
            <?php do_action( 'pneumatic-theme-time', 'updated article-time' ); ?>
          </header>
          <div class="article--content cf">
            <?php the_content(); ?>
          </div>
        </div>
      </article>
    <?php endwhile; endif; ?>

  </main>
  <div class="wrapper-sidebar t-4">
    <?php get_sidebar(); ?>
  </div>

</div>

<?php get_footer(); ?>
