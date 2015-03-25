

<div id="content">
  <div id="inner-content" class="wrap cf">
    <main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class( 'article cf' ); ?> role="article">
    <section class="article-inner">
      <h1 class="entry-title article-title"><?php the_title(); ?></h1>
      <?php do_action( 'pneumatic-theme-time', 'updated entry-time' ); ?>
      <div class="entry-content article-content cf">
      <?php the_content(); ?>
      </div>
    </section>
  </article>
<?php endwhile; endif; ?>

    </main>
  </div>
</div>
