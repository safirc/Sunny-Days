<?php
/**
 * Generic Page template (fallback for all regular pages)
 * Theme: Stichting Sunny Days
 */
if (!defined('ABSPATH')) exit;
get_header(); ?>

<main id="main" class="sd-main" role="main">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <section class="sd-section">
      <div class="container">
        <header class="sd-header">
          <h1 class="sd-title"><?php the_title(); ?></h1>
          <?php if (has_excerpt()) : ?>
            <p class="sd-blurb"><?php echo esc_html(get_the_excerpt()); ?></p>
          <?php endif; ?>
        </header>

        <article <?php post_class('sd-article'); ?>>
          <div class="sd-content">
            <?php the_content(); ?>
          </div>
        </article>
      </div>
    </section>
  <?php endwhile; endif; ?>
</main>

<?php get_footer();
