<?php if (!defined('ABSPATH')) exit; get_header(); the_post(); ?>
<section class="sd-section">
  <div class="container">
    <article class="single">
      <h1><?php the_title(); ?></h1>
      <p class="meta"><?php echo esc_html(get_the_date()); ?></p>
      <?php if (has_post_thumbnail()) the_post_thumbnail('large'); ?>
      <div class="content"><?php the_content(); ?></div>
    </article>
  </div>
</section>
<?php get_footer(); ?>
