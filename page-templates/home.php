<?php /* Template name: Front Page */ get_header();?>

<div id="content" class="cf w">

  <main id="main" class="">

    <?php do_action( 'drivdigital_archive_before' ); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class( 'article' ); ?>>

        <div class="article--inner cf w">
          <header class="article--header">
            <h1 class="article--title"><?php the_title(); ?></h1>
          </header>

          <div class="article--content cf">
            <?php the_content(); ?>
          </div>
        </div>

      </article>
    <?php endwhile; endif; ?>

    <?php do_action( 'drivdigital_archive_after' ); ?>

  </main>

</div>

<?php get_footer(); ?>
