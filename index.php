<?php get_header(); ?>

<div id="content">
  <div id="inner-content" class="wrap cf">
    <main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class( 'article cf' ); ?> role="article">
    <div class="article--inner w">
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
  </div>
</div>

<?php get_footer(); ?>
