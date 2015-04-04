<?php get_header(); ?>

<div id="content">
  <main id="main" class="cf" role="main">
    <?php /* @TODO: itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog"> */ ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class( 'article' ); ?> role="article">
    <div class="article--inner cf w">
      <header class="article--header">
        <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail( 'large' ); ?>
        <h1 class="article--title"><?php the_title(); ?></h1>
        </a>
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

<?php get_footer(); ?>
